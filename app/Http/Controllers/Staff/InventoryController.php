<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        $products = Product::with('supplier')
            ->latest()
            ->get();

        $purchaseOrders = PurchaseOrder::with(['supplier', 'items.product'])
            ->latest()
            ->get();

        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'min_threshold')
            ->get();

        $transactions = InventoryTransaction::with('product')
            ->latest()
            ->take(20)
            ->get();

        return view('staff.inventory.index', compact(
            'suppliers',
            'products',
            'purchaseOrders',
            'lowStockProducts',
            'transactions'
        ));
    }

    public function storeSupplier(Request $request)
    {
        $data = $request->validate([
            'supplier_name' => ['required', 'string', 'max:100'],
            'contact_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string'],
        ]);

        Supplier::create($data);

        return back()->with('success', 'supplier added successfully.');
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'product_name' => ['required', 'string', 'max:100'],
            'sku' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'min_threshold' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);



        Product::create($data);

        return back()->with('success', 'product added successfully.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'product_name' => ['required', 'string', 'max:100'],
            'sku' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'min_threshold' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);
        if (empty($data['image'])) {
            unset($data['image']);
        }
        $product->update($data);

        return back()->with('success', 'product updated successfully.');
    }

    public function destroyProduct(Product $product)
    {
        $product->update([
            'status' => 'inactive',
        ]);

        return back()->with('success', 'product disabled successfully.');
    }

    public function storePurchaseOrder(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'import_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($data) {
            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $data['supplier_id'],
                'order_date' => now()->toDateString(),
                'total_cost' => ($data['import_price'] ?? 0) * $data['quantity'],
                'status' => 'received',
            ]);

            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'import_price' => $data['import_price'] ?? 0,
            ]);

            Product::findOrFail($data['product_id'])
                ->increment('stock_quantity', $data['quantity']);
        });

        return back()->with('success', 'purchase order created and stock updated successfully.');
    }

    public function useProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        if ($data['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'quantity used exceeds stock');
        }

        DB::transaction(function () use ($product, $data) {
            $product->decrement('stock_quantity', $data['quantity']);

            InventoryTransaction::create([
                'product_id' => $product->id,
                'type' => 'used',
                'quantity' => $data['quantity'],
                'note' => $data['note'] ?? 'product used',
                'transaction_date' => now()->toDateString(),
            ]);
        });

        return back()->with('success', 'product used successfully.');
    }

    public function wasteProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        if ($data['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'quantity waste exceeds stock');
        }

        DB::transaction(function () use ($product, $data) {
            $product->decrement('stock_quantity', $data['quantity']);

            InventoryTransaction::create([
                'product_id' => $product->id,
                'type' => 'waste',
                'quantity' => $data['quantity'],
                'note' => $data['note'] ?? 'Hao hụt / hỏng / mất hàng',
                'transaction_date' => now()->toDateString(),
            ]);
        });

        return back()->with('success', 'product waste successfully.');
    }
}

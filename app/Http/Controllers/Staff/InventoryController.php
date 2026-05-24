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

        return back()->with('success', 'Đã thêm nhà cung cấp.');
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'product_name' => ['required', 'string', 'max:100'],
            'sku' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'min_threshold' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Product::create($data);

        return back()->with('success', 'Đã thêm sản phẩm/vật tư.');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'product_name' => ['required', 'string', 'max:100'],
            'sku' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'min_threshold' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $product->update($data);

        return back()->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroyProduct(Product $product)
    {
        $product->update([
            'status' => 'inactive',
        ]);

        return back()->with('success', 'Đã ngừng hoạt động sản phẩm.');
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

        return back()->with('success', 'Đã tạo đơn nhập hàng và cập nhật tồn kho.');
    }

    public function useProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        if ($data['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'Số lượng sử dụng vượt quá tồn kho.');
        }

        DB::transaction(function () use ($product, $data) {
            $product->decrement('stock_quantity', $data['quantity']);

            InventoryTransaction::create([
                'product_id' => $product->id,
                'type' => 'used',
                'quantity' => $data['quantity'],
                'note' => $data['note'] ?? 'Sử dụng vật tư salon',
                'transaction_date' => now()->toDateString(),
            ]);
        });

        return back()->with('success', 'Đã ghi nhận sử dụng vật tư.');
    }

    public function wasteProduct(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        if ($data['quantity'] > $product->stock_quantity) {
            return back()->with('error', 'Số lượng hao hụt vượt quá tồn kho.');
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

        return back()->with('success', 'Đã ghi nhận hao hụt.');
    }
}

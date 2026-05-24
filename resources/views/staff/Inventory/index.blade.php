<x-staff.layout title="Inventory" page-name="InventoryManagement">
  <div x-data="{ pageName: `Inventory` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Inventory</h3>
          <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Manage salon supplies, suppliers, purchase orders and stock usage.
          </p>
        </div>

        <div class="flex flex-wrap gap-2">
          <button onclick="toggleForm('supplier-form')" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
            + Supplier
          </button>

          <button onclick="toggleForm('product-form')" class="inline-flex items-center gap-2 rounded-lg bg-success-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-success-600">
            + Product
          </button>

          <button onclick="toggleForm('purchase-form')" class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-purple-700">
            + Purchase Order
          </button>
        </div>
      </div>
    </div>

    <div class="p-5 sm:p-6">
      @if(session('success'))
        <div class="mb-5 rounded-lg bg-success-50 px-4 py-3 text-success-600 dark:bg-success-500/15 dark:text-success-500">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="mb-5 rounded-lg bg-error-50 px-4 py-3 text-error-600 dark:bg-error-500/15 dark:text-error-500">
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-5 rounded-lg bg-error-50 px-4 py-3 text-error-600 dark:bg-error-500/15 dark:text-error-500">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
          <p class="text-sm text-gray-500 dark:text-gray-400">Products</p>
          <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">{{ $products->count() }}</h4>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
          <p class="text-sm text-gray-500 dark:text-gray-400">Low Stock</p>
          <h4 class="mt-2 text-title-sm font-bold text-error-600">{{ $lowStockProducts->count() }}</h4>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
          <p class="text-sm text-gray-500 dark:text-gray-400">Suppliers</p>
          <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">{{ $suppliers->count() }}</h4>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
          <p class="text-sm text-gray-500 dark:text-gray-400">Purchase Orders</p>
          <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">{{ $purchaseOrders->count() }}</h4>
        </div>
      </div>

      @if($lowStockProducts->count())
        <div class="mb-5 rounded-2xl border border-warning-200 bg-warning-50 p-5 dark:bg-warning-500/15">
          <h4 class="mb-3 text-base font-medium text-warning-700 dark:text-warning-500">Low stock warning</h4>

          <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
            @foreach($lowStockProducts as $item)
              <div class="rounded-xl bg-white p-4 dark:bg-gray-900">
                <p class="font-medium text-gray-800 dark:text-white/90">{{ $item->product_name }}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                  Stock: {{ $item->stock_quantity }} / Min: {{ $item->min_threshold }}
                </p>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <div id="supplier-form" class="mb-5 hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Create Supplier</h4>

        <form method="POST" action="{{ route('staff.inventory.supplier.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
          @csrf

          <input name="supplier_name" placeholder="Supplier name" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="contact_name" placeholder="Contact name" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="phone" placeholder="Phone" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="email" placeholder="Email" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <textarea name="address" placeholder="Address" class="rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 md:col-span-2"></textarea>

          <div class="md:col-span-2">
            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-5 text-sm font-medium text-white hover:bg-brand-600">
              Save Supplier
            </button>
          </div>
        </form>
      </div>

      <div id="product-form" class="mb-5 hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Create Product / Supply</h4>

        <form method="POST" action="{{ route('staff.inventory.product.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-3">
          @csrf

          <select name="supplier_id" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
            <option value="">No supplier</option>
            @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
            @endforeach
          </select>

          <input name="product_name" placeholder="Product name" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="sku" placeholder="SKU" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="price" type="number" step="0.01" placeholder="Price" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="stock_quantity" type="number" placeholder="Stock quantity" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="min_threshold" type="number" placeholder="Min threshold" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <select name="status" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>

          <textarea name="description" placeholder="Description" class="rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 md:col-span-2"></textarea>

          <div class="md:col-span-3">
            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-success-500 px-5 text-sm font-medium text-white hover:bg-success-600">
              Save Product
            </button>
          </div>
        </form>
      </div>

      <div id="purchase-form" class="mb-5 hidden rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <h4 class="mb-4 text-base font-medium text-gray-800 dark:text-white/90">Create Purchase Order</h4>

        <form method="POST" action="{{ route('staff.inventory.purchase-order.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
          @csrf

          <select name="supplier_id" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
            <option value="">Select supplier</option>
            @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
            @endforeach
          </select>

          <select name="product_id" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
            <option value="">Select product</option>
            @foreach($products as $product)
              <option value="{{ $product->id }}">{{ $product->product_name }}</option>
            @endforeach
          </select>

          <input name="quantity" type="number" placeholder="Quantity" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <input name="import_price" type="number" step="0.01" placeholder="Import price" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

          <div class="md:col-span-4">
            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-purple-600 px-5 text-sm font-medium text-white hover:bg-purple-700">
              Save Purchase Order
            </button>
          </div>
        </form>
      </div>

      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="w-full overflow-x-auto">
          <table class="min-w-full table-fixed">
            <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800">
              <th class="w-20 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">ID</p>
              </th>
              <th class="w-72 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Product</p>
              </th>
              <th class="w-56 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Supplier</p>
              </th>
              <th class="w-28 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Stock</p>
              </th>
              <th class="w-28 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Min</p>
              </th>
              <th class="w-32 px-4 pb-3 pt-4 text-left sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
              </th>
              <th class="w-56 px-4 pb-3 pt-4 text-right sm:px-6">
                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</p>
              </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($products as $product)
              @php
                $statusClass = $product->status === 'active'
                  ? 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500'
                  : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300';

                $stockClass = $product->stock_quantity <= $product->min_threshold
                  ? 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
                  : 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500';
              @endphp

              <tr class="align-top">
                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400">#{{ $product->id }}</p>
                </td>

                <td class="px-4 py-4 sm:px-6">
                  <div class="min-w-0">
                    <p class="truncate font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $product->product_name }}</p>
                    <p class="mt-0.5 truncate text-theme-xs text-gray-500 dark:text-gray-400">SKU: {{ $product->sku ?? 'N/A' }}</p>
                  </div>
                </td>

                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $product->supplier?->supplier_name ?? 'No supplier' }}</p>
                </td>

                <td class="px-4 py-4 sm:px-6">
                  <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $stockClass }}">
                    {{ $product->stock_quantity }}
                  </span>
                </td>

                <td class="px-4 py-4 sm:px-6">
                  <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $product->min_threshold }}</p>
                </td>

                <td class="px-4 py-4 sm:px-6">
                  <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusClass }}">
                    {{ ucfirst($product->status) }}
                  </span>
                </td>

                <td class="px-4 py-4 sm:px-6">
                  <div class="flex items-center justify-end gap-2">
                    <button onclick="toggleForm('edit-product-{{ $product->id }}')" title="Edit product" class="text-gray-500 hover:text-blue-600 dark:text-gray-400">
                      Edit
                    </button>

                    <form action="{{ route('staff.inventory.product.destroy', $product) }}" method="POST" onsubmit="return confirm('Disable this product?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" title="Delete product" class="text-gray-500 hover:text-error-600 dark:text-gray-400">
                        Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <tr id="edit-product-{{ $product->id }}" class="hidden bg-gray-50 dark:bg-gray-900">
                <td colspan="7" class="px-4 py-4 sm:px-6">
                  <form method="POST" action="{{ route('staff.inventory.product.update', $product) }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    @csrf
                    @method('PUT')

                    <input name="product_name" value="{{ $product->product_name }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="sku" value="{{ $product->sku }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="price" type="number" step="0.01" value="{{ $product->price }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="stock_quantity" type="number" value="{{ $product->stock_quantity }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="min_threshold" type="number" value="{{ $product->min_threshold }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <select name="supplier_id" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">
                      <option value="">No supplier</option>
                      @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected($product->supplier_id == $supplier->id)>
                          {{ $supplier->supplier_name }}
                        </option>
                      @endforeach
                    </select>

                    <select name="status" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">
                      <option value="active" @selected($product->status === 'active')>Active</option>
                      <option value="inactive" @selected($product->status === 'inactive')>Inactive</option>
                    </select>

                    <textarea name="description" class="rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm dark:border-gray-700 dark:text-white/90">{{ $product->description }}</textarea>

                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-success-500 px-5 text-sm font-medium text-white hover:bg-success-600 md:col-span-4">
                      Update Product
                    </button>
                  </form>

                  <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <form method="POST" action="{{ route('staff.inventory.use', $product) }}" class="flex gap-2">
                      @csrf
                      <input name="quantity" type="number" min="1" placeholder="Used quantity" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">
                      <input name="note" placeholder="Note" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">
                      <button type="submit" class="rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600">Use</button>
                    </form>

                    <form method="POST" action="{{ route('staff.inventory.waste', $product) }}" class="flex gap-2">
                      @csrf
                      <input name="quantity" type="number" min="1" placeholder="Waste quantity" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">
                      <input name="note" placeholder="Note" class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">
                      <button type="submit" class="rounded-lg bg-error-500 px-4 text-sm font-medium text-white hover:bg-error-600">Waste</button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No inventory products found.</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleForm(id) {
      const element = document.getElementById(id);

      if (element) {
        element.classList.toggle('hidden');
      }
    }
  </script>
</x-staff.layout>

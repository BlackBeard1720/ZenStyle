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
          <table class="min-w-full">

            <thead>

            <tr class="border-gray-100 border-y dark:border-gray-800">

              <th class="py-3">
                <div class="flex items-center">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Product
                  </p>
                </div>
              </th>

              <th class="py-3">
                <div class="flex items-center">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Supplier
                  </p>
                </div>
              </th>

              <th class="py-3">
                <div class="flex items-center">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Price
                  </p>
                </div>
              </th>

              <th class="py-3">
                <div class="flex items-center">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Stock
                  </p>
                </div>
              </th>

              <th class="py-3">
                <div class="flex items-center">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Status
                  </p>
                </div>
              </th>

              <th class="py-3 text-right">
                <div class="flex items-center justify-end">
                  <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Actions
                  </p>
                </div>
              </th>

            </tr>

            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

            @forelse($products as $product)

              <tr>

                <td class="py-3">

                  <div class="flex items-center">

                    <div class="flex items-center gap-3">

                      <div class="h-[50px] w-[50px] overflow-hidden rounded-md bg-gray-100">

                        <img
                          src="{{ asset('images/product-default.png') }}"
                          alt="Product"
                          class="h-full w-full object-cover">

                      </div>

                      <div>

                        <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                          {{ $product->product_name }}
                        </p>

                        <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                  SKU: {{ $product->sku ?? 'N/A' }}
                </span>

                      </div>

                    </div>

                  </div>

                </td>

                <td class="py-3">

                  <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                    {{ $product->supplier?->supplier_name ?? 'No supplier' }}
                  </p>

                </td>

                <td class="py-3">

                  <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                    ${{ number_format($product->price ?? 0, 2) }}
                  </p>

                </td>

                <td class="py-3">

                  @if($product->stock_quantity <= $product->min_threshold)

                    <p class="inline-flex rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                      {{ $product->stock_quantity }}
                    </p>

                  @else

                    <p class="inline-flex rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                      {{ $product->stock_quantity }}
                    </p>

                  @endif

                </td>

                <td class="py-3">

                  @if($product->status === 'active')

                    <p class="inline-flex rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                      Active
                    </p>

                  @else

                    <p class="inline-flex rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                      Inactive
                    </p>

                  @endif

                </td>

                <td class="py-3">

                  <div class="flex flex-col items-end gap-2">

                    <div class="flex items-center gap-2">

                      <button
                        onclick="toggleForm('edit-product-{{ $product->id }}')"
                        class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700">

                        Edit

                      </button>

                      <form method="POST"
                            action="{{ route('staff.inventory.product.destroy', $product) }}">

                        @csrf
                        @method('DELETE')

                        <button
                          onclick="return confirm('Delete product?')"
                          class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700">

                          Delete

                        </button>

                      </form>

                    </div>

                    {{-- use product --}}
                    <form method="POST"
                          action="{{ route('staff.inventory.use', $product) }}"
                          class="flex items-center gap-2">

                      @csrf

                      <input
                        name="quantity"
                        type="number"
                        min="1"
                        placeholder="Use"
                        class="h-9 w-20 rounded-lg border border-gray-300 bg-transparent px-3 text-xs dark:border-gray-700 dark:text-white/90">

                      <button
                        type="submit"
                        class="rounded-lg bg-brand-500 px-3 py-2 text-xs font-medium text-white hover:bg-brand-600">

                        Use

                      </button>

                    </form>

                    {{-- waste product --}}
                    <form method="POST"
                          action="{{ route('staff.inventory.waste', $product) }}"
                          class="flex items-center gap-2">

                      @csrf

                      <input
                        name="quantity"
                        type="number"
                        min="1"
                        placeholder="Waste"
                        class="h-9 w-20 rounded-lg border border-gray-300 bg-transparent px-3 text-xs dark:border-gray-700 dark:text-white/90">

                      <button
                        type="submit"
                        class="rounded-lg bg-orange-500 px-3 py-2 text-xs font-medium text-white hover:bg-orange-600">

                        Waste

                      </button>

                    </form>

                  </div>

                </td>

              </tr>

              <tr id="edit-product-{{ $product->id }}" class="hidden bg-gray-50 dark:bg-gray-900">
                <td colspan="6" class="px-4 py-4 sm:px-6">
                  <form method="POST"
                        action="{{ route('staff.inventory.product.update', $product) }}"
                        class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    @csrf
                    @method('PUT')

                    <input name="product_name" value="{{ $product->product_name }}"
                           class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="sku" value="{{ $product->sku }}"
                           class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="price" type="number" step="0.01" value="{{ $product->price }}"
                           class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="stock_quantity" type="number" value="{{ $product->stock_quantity }}"
                           class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <input name="min_threshold" type="number" value="{{ $product->min_threshold }}"
                           class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">

                    <select name="status"
                            class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 text-sm dark:border-gray-700 dark:text-white/90">
                      <option value="active" @selected($product->status === 'active')>Active</option>
                      <option value="inactive" @selected($product->status === 'inactive')>Inactive</option>
                    </select>

                    <input type="hidden" name="supplier_id" value="{{ $product->supplier_id }}">
                    <input type="hidden" name="description" value="{{ $product->description }}">

                    <div class="md:col-span-3">
                      <button type="submit"
                              class="rounded-lg bg-success-500 px-4 py-2 text-sm font-medium text-white hover:bg-success-600">
                        Update Product
                      </button>
                    </div>
                  </form>
                </td>
              </tr>

            @empty

              <tr>

                <td colspan="6" class="py-10 text-center text-gray-500">
                  No products found.
                </td>

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

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
  <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800">
    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
      Latest Products
    </h3>
  </div>

  <div class="w-full overflow-x-auto">
    <table class="min-w-full">
      <thead>
      <tr class="border-y border-gray-100 dark:border-gray-800">
        <th class="px-5 py-3 text-left sm:px-6">
          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Product</p>
        </th>

        <th class="px-5 py-3 text-left sm:px-6">
          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Supplier</p>
        </th>

        <th class="px-5 py-3 text-left sm:px-6">
          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Price</p>
        </th>

        <th class="px-5 py-3 text-left sm:px-6">
          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Stock</p>
        </th>

        <th class="px-5 py-3 text-left sm:px-6">
          <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
        </th>
      </tr>
      </thead>

      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($products as $product)
        <tr>
          <td class="px-5 py-4 sm:px-6">
            <div class="flex items-center gap-4">
              <div class="h-[60px] w-[60px] overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800">
                <img
                  src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/product-default.png') }}"
                  alt="{{ $product->product_name }}"
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
          </td>

          <td class="px-5 py-4 text-gray-500 text-theme-sm dark:text-gray-400 sm:px-6">
            {{ $product->supplier?->supplier_name ?? 'No supplier' }}
          </td>

          <td class="px-5 py-4 text-gray-500 text-theme-sm dark:text-gray-400 sm:px-6">
            ${{ number_format($product->price ?? 0, 2) }}
          </td>

          <td class="px-5 py-4 sm:px-6">
                        <span class="inline-flex rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                            {{ $product->stock_quantity }}
                        </span>
          </td>

          <td class="px-5 py-4 sm:px-6">
                        <span class="inline-flex rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                            {{ ucfirst($product->status) }}
                        </span>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400 sm:px-6">
            No products found.
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

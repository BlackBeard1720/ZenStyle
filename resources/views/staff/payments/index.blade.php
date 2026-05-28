<x-staff.layout title="Payments" page-name="PaymentManagement">
  <div x-data="{ pageName: `Payments` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
      <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Payments</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and manage payment records.</p>
    </div>

    <div class="p-5 sm:p-6">
      <form method="GET" action="{{ route('staff.payments.index') }}" class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-6">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Payment ID, appointment ID, name, phone, email, transaction" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

        <select name="payment_method" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
          <option value="">All methods</option>
          @foreach(['cash' => 'Cash', 'paypal' => 'PayPal', 'bank_transfer' => 'Bank Transfer'] as $value => $label)
            <option value="{{ $value }}" @selected(request('payment_method') === $value)>{{ $label }}</option>
          @endforeach
        </select>

        <select name="status" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
          <option value="">All statuses</option>
          @foreach(['pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed', 'refunded' => 'Refunded'] as $value => $label)
            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
          @endforeach
        </select>

        <input type="date" name="paid_from" value="{{ request('paid_from') }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
        <input type="date" name="paid_to" value="{{ request('paid_to') }}" class="h-11 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">

        <div class="flex gap-2">
          <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600">Search</button>
          <a href="{{ route('staff.payments.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">Reset</a>
        </div>
      </form>

      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="w-full overflow-x-auto">
          <table class="min-w-full table-fixed">
            <thead>
            <tr class="border-b border-gray-100 dark:border-gray-800">
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Payment ID</th>
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Appointment ID</th>
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Customer</th>
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Amount</th>
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Method</th>
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Paid at</th>
              <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Transaction code</th>
              <th class="px-4 py-3 text-right text-theme-xs font-medium text-gray-500 dark:text-gray-400">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($payments as $payment)
              <tr>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">#{{ $payment->id }}</td>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">#{{ $payment->appointment_id }}</td>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">
                  <div>{{ $payment->appointment?->client?->full_name ?? 'N/A' }}</div>
                  <div class="text-theme-xs text-gray-500 dark:text-gray-400">{{ $payment->appointment?->client?->phone ?? 'N/A' }}</div>
                </td>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">${{ number_format($payment->amount, 2) }}</td>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">{{ strtoupper($payment->payment_method) }}</td>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">{{ ucfirst($payment->status) }}</td>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">{{ $payment->paid_at?->format('d/m/Y H:i') ?? 'N/A' }}</td>
                <td class="px-4 py-3 text-theme-sm text-gray-700 dark:text-gray-300">{{ $payment->transaction_code ?: 'N/A' }}</td>
                <td class="px-4 py-3 text-right">
                  <a href="{{ route('staff.payments.show', $payment) }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 px-2.5 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800">View</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No payments found.</td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-5">{{ $payments->links() }}</div>
    </div>
  </div>
</x-staff.layout>

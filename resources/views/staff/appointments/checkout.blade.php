<x-staff.layout title="Checkout" page-name="Appointments">
  <div x-data="{ pageName: `Checkout Appointment #{{ $appointment->id }}` }">
    <x-staff.partials.breadcrumb />
  </div>

  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 sm:px-6 sm:py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
          Checkout Appointment #{{ $appointment->id }}
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Review appointment information and choose a payment method.
        </p>
      </div>

      <div class="grid grid-cols-1 gap-6 p-5 sm:p-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">
            Appointment Summary
          </h4>

          <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
            <table class="min-w-full">
              <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                  Service
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                  Staff
                </th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400">
                  Price
                </th>
              </tr>
              </thead>

              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              @foreach($appointment->appointmentServices as $appointmentService)
                <tr>
                  <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-white/90">
                    {{ $appointmentService->service?->name ?? '-' }}
                  </td>

                  <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                    {{ $appointmentService->staff?->full_name ?? 'Unassigned' }}
                  </td>

                  <td class="px-4 py-3 text-right text-sm text-gray-500 dark:text-gray-400">
                    ${{ number_format($appointmentService->price_at_booking, 2) }}
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>

          <div class="mt-6 rounded-xl border border-gray-200 p-4 dark:border-gray-800">
            <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">
              Client Information
            </h4>

            <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">
              <div>
                <dt class="text-gray-500 dark:text-gray-400">Name</dt>
                <dd class="font-medium text-gray-800 dark:text-white/90">
                  {{ $appointment->client?->full_name ?? '-' }}
                </dd>
              </div>

              <div>
                <dt class="text-gray-500 dark:text-gray-400">Phone</dt>
                <dd class="font-medium text-gray-800 dark:text-white/90">
                  {{ $appointment->client?->phone ?? '-' }}
                </dd>
              </div>

              <div>
                <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                <dd class="font-medium text-gray-800 dark:text-white/90">
                  {{ $appointment->client?->email ?: '-' }}
                </dd>
              </div>
            </dl>
          </div>
        </div>

        <div>
          <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">
            <h4 class="mb-4 text-sm font-semibold text-gray-800 dark:text-white/90">
              Payment
            </h4>

            <div class="mb-5 rounded-lg bg-gray-50 p-4 dark:bg-gray-800/50">
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Total amount
              </p>

              <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white/90">
                ${{ number_format($appointment->total_amount, 2) }}
              </p>
            </div>

            <div class="space-y-3">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Payment method
              </p>

              <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 text-sm dark:border-gray-700">
                <input type="radio"
                       name="payment_method_choice"
                       value="cash"
                       id="payment-method-cash"
                       checked
                       class="h-4 w-4">
                <span class="text-gray-700 dark:text-gray-300">Cash</span>
              </label>

              <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 text-sm dark:border-gray-700">
                <input type="radio"
                       name="payment_method_choice"
                       value="paypal"
                       id="payment-method-paypal"
                       class="h-4 w-4">
                <span class="text-gray-700 dark:text-gray-300">PayPal</span>
              </label>
            </div>

            {{-- Cash area --}}
            <div id="cash-area" class="mt-5">
              <form method="POST"
                    action="{{ route('staff.appointments.checkout.store', $appointment) }}">
                @csrf

                <input type="hidden" name="payment_method" value="cash">

                <div>
                  <label for="note" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Note
                  </label>

                  <textarea id="note"
                            name="note"
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">{{ old('note') }}</textarea>

                  @error('note')
                  <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                  @enderror
                </div>

                <button type="submit"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                  Confirm Cash Payment
                </button>
              </form>
            </div>

            {{-- PayPal area --}}
            <div id="paypal-area" class="mt-5 hidden">
              <p class="mb-3 text-sm text-gray-500 dark:text-gray-400">
                Pay securely with PayPal.
              </p>

              <div id="paypal-button-container"></div>

              <p id="paypal-error" class="mt-3 hidden text-sm text-error-500"></p>
            </div>

            <a href="{{ route('staff.appointments.show', $appointment) }}"
               class="mt-3 inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
              Back to appointment
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency={{ config('services.paypal.currency', 'USD') }}&components=buttons&disable-funding=card"></script>
    <script>
      const cashRadio = document.getElementById('payment-method-cash');
      const paypalRadio = document.getElementById('payment-method-paypal');
      const cashArea = document.getElementById('cash-area');
      const paypalArea = document.getElementById('paypal-area');
      const paypalError = document.getElementById('paypal-error');

      function togglePaymentArea() {
        if (paypalRadio.checked) {
          cashArea.classList.add('hidden');
          paypalArea.classList.remove('hidden');
        } else {
          cashArea.classList.remove('hidden');
          paypalArea.classList.add('hidden');
        }
      }

      cashRadio.addEventListener('change', togglePaymentArea);
      paypalRadio.addEventListener('change', togglePaymentArea);
      togglePaymentArea();

      paypal.Buttons({
        style: {
          layout: 'vertical',
          color: 'gold',
          shape: 'rect',
          label: 'paypal'
        },

        async createOrder() {
          paypalError.classList.add('hidden');

          const response = await fetch('{{ route('staff.appointments.paypal.create-order', $appointment) }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            }
          });

          const data = await response.json().catch(() => null);

          if (!response.ok) {
            console.error('Create PayPal order failed:', data);

            paypalError.textContent = data?.message || 'Cannot create PayPal order.';
            paypalError.classList.remove('hidden');

            throw new Error(data?.message || 'Cannot create PayPal order.');
          }

          return data.id;
        },

        async onApprove(data) {
          paypalError.classList.add('hidden');

          const response = await fetch('{{ route('staff.appointments.paypal.capture-order', $appointment) }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              order_id: data.orderID
            })
          });

          const result = await response.json().catch(() => null);

          if (!response.ok) {
            console.error('Capture PayPal order failed:', result);

            paypalError.textContent = result?.message || 'Cannot capture PayPal payment.';
            paypalError.classList.remove('hidden');

            throw new Error(result?.message || 'Cannot capture PayPal payment.');
          }

          window.location.href = result.redirect_url;
        },

        onCancel() {
          paypalError.textContent = 'PayPal payment was cancelled.';
          paypalError.classList.remove('hidden');
        },

        onError(err) {
          console.error('PayPal error:', err);
          paypalError.textContent = 'PayPal payment failed. Please check console or Laravel log.';
          paypalError.classList.remove('hidden');
        }
      }).render('#paypal-button-container');
    </script>
  @endpush
</x-staff.layout>

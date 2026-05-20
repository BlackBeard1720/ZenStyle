<x-staff.layout
    title="Dashboard"
    page-name="dashboard"
>
    <div class="mb-4">
      New appointments:
      <span data-notification-badge class="hidden rounded-full bg-red-500 px-2 py-0.5 text-xs font-bold text-white">0</span>
    </div>
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <!-- Metric Group One -->
            <x-staff.partials.metric-group.metric-group-01 />
            <!-- Metric Group One -->

            <!-- ====== Chart One Start -->
            <x-staff.partials.chart.chart-01 />
            <!-- ====== Chart One End -->
        </div>
        <div class="col-span-12 xl:col-span-5">
            <!-- ====== Chart Two Start -->
            <x-staff.partials.chart.chart-02 />
            <!-- ====== Chart Two End -->
        </div>

        <div class="col-span-12">
            <!-- ====== Chart Three Start -->
            <x-staff.partials.chart.chart-03 />
            <!-- ====== Chart Three End -->
        </div>

        <div class="col-span-12 xl:col-span-5">
            <!-- ====== Map One Start -->
            <x-staff.partials.map-01 />
            <!-- ====== Map One End -->
        </div>

        <div class="col-span-12 xl:col-span-7">
            <!-- ====== Table One Start -->
            <x-staff.partials.table.table-01 />
            <!-- ====== Table One End -->
        </div>
    </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) {
          console.error('Echo chưa được load. Kiểm tra resources/js/staff/index.js.');
          return;
        }

        window.Echo.channel('staff.appointments')
          .listen('.appointment.created', function (event) {
            console.log('New appointment event:', event);

            alert(event.message);

            const badge = document.querySelector('[data-notification-badge]');
            if (badge) {
              const current = Number(badge.textContent || 0);
              badge.textContent = current + 1;
              badge.classList.remove('hidden');
            }
          });
      });
    </script>
  @endpush
</x-staff.layout>

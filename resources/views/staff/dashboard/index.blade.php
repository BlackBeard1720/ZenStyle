<x-staff.layout title="Dashboard" page-name="dashboard">
    <script>
        window.revenueChartData = {!! json_encode($revenueData) !!};
        window.dashboardFilter = {
            from_date: {!! json_encode($from) !!},
            to_date: {!! json_encode($to) !!},
            group: {!! json_encode($group) !!},
        };
    </script>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <x-staff.partials.metric-group.metric-group-01 />
            <x-staff.partials.chart.chart-01 />
        </div>
        <div class="col-span-12 xl:col-span-5">
            <x-staff.partials.chart.chart-02 />
        </div>

        <div class="col-span-12">
            <x-staff.partials.chart.chart-03 />
        </div>

        <div class="col-span-12 xl:col-span-5">
            <x-staff.partials.map-01 />
        </div>

        <div class="col-span-12 xl:col-span-7">
            <x-staff.partials.table.table-01 />
        </div>
    </div>
</x-staff.layout>
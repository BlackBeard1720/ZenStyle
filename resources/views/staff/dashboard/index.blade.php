<x-staff.layout
    title="ZenStyle Dashboard"
    page-name="ecommerce"
>
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
</x-staff.layout>

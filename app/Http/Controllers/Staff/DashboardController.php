<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->query('from_date');
        $to = $request->query('to_date');
        $group = $request->query('group', 'month'); // day | month | year

        // Nếu user chọn range nhưng chưa chọn group, mặc định dùng day
        if ($from && $to && ! in_array($group, ['day', 'month', 'year'], true)) {
            $group = 'day';
        }

        $revenueData = $this->getRevenueData($from, $to, $group);
        $categoryUsageData = $this->getCategoryUsageData();
        $customerMetrics = $this->getCustomerMetrics($from, $to);

        return view('staff.dashboard.index', compact('revenueData', 'categoryUsageData', 'customerMetrics', 'from', 'to', 'group'));
    }

    public function data(Request $request)
    {
        $from = $request->query('from_date');
        $to = $request->query('to_date');
        $group = $request->query('group', 'month');

        if ($from && $to && ! in_array($group, ['day', 'month', 'year'], true)) {
            $group = 'day';
        }

        $revenue = $this->getRevenueData($from, $to, $group);

        // Also compute appointment counts per period (same grouping)
        $appointmentQuery = Appointment::query()->where('status', 'completed');

        if ($from && $to) {
            $appointmentQuery->whereBetween('appointment_date', [$from, $to]);
        } else {
            $appointmentQuery->whereYear('appointment_date', now()->year);
        }

        if ($group === 'day' && $from && $to) {
            $appointmentRows = $appointmentQuery
                ->selectRaw('DATE(appointment_date) as period, COUNT(*) as count')
                ->groupByRaw('DATE(appointment_date)')
                ->orderByRaw('DATE(appointment_date)')
                ->get();

            $period = CarbonPeriod::create($from, $to);
            $labels = collect($period)->map(fn (Carbon $date) => $date->format('d/m'))->toArray();

            $counts = array_fill(0, count($labels), 0);
            foreach ($appointmentRows as $row) {
                $index = array_search(Carbon::parse($row->period)->format('d/m'), $labels, true);
                if ($index !== false) {
                    $counts[$index] = (int) $row->count;
                }
            }
        } elseif ($group === 'year') {
            $appointmentRows = $appointmentQuery
                ->selectRaw('YEAR(appointment_date) as period, COUNT(*) as count')
                ->groupByRaw('YEAR(appointment_date)')
                ->orderByRaw('YEAR(appointment_date)')
                ->get();

            $labels = $appointmentRows->pluck('period')->map(fn ($year) => (string) $year)->toArray();
            $counts = $appointmentRows->pluck('count')->map(fn ($c) => (int) $c)->toArray();
        } else {
            $appointmentRows = $appointmentQuery
                ->selectRaw('MONTH(appointment_date) as period, COUNT(*) as count')
                ->groupByRaw('MONTH(appointment_date)')
                ->orderByRaw('MONTH(appointment_date)')
                ->get();

            if ($from && $to) {
                $period = CarbonPeriod::create($from, $to)->months();
                $labels = collect($period)->map(fn (Carbon $date) => $date->format('M'))->toArray();
                $monthNumbers = collect($period)->map(fn (Carbon $date) => (int) $date->format('n'))->toArray();
            } else {
                $labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                $monthNumbers = range(1, 12);
            }

            $counts = array_fill(0, count($labels), 0);
            foreach ($appointmentRows as $row) {
                $index = array_search((int) $row->period, $monthNumbers, true);
                if ($index !== false) {
                    $counts[$index] = (int) $row->count;
                }
            }
        }

        $customerMetrics = $this->getCustomerMetrics($from, $to);

        return response()->json([
            'revenue' => $revenue,
            'appointments' => [
                'labels' => $labels,
                'values' => $counts,
            ],
            'customerMetrics' => $customerMetrics,
        ]);
    }

    private function getCustomerMetrics(?string $from, ?string $to): array
    {
        $dateFilter = function ($query) use ($from, $to) {
            if ($from && $to) {
                $query->whereBetween('appointment_date', [$from, $to]);
            } else {
                $query->whereYear('appointment_date', now()->year);
            }
        };

        $completedVisitsCount = Appointment::query()
            ->whereIn('status', ['completed', 'checked-in'])
            ->where($dateFilter)
            ->count();

        $paidReceiptsCount = Payment::query()
            ->where('status', 'paid')
            ->whereHas('appointment', $dateFilter)
            ->distinct('appointment_id')
            ->count('appointment_id');

        return [
            'completed_visits' => [
                'key' => 'completed_visits',
                'label' => 'Completed & Checked-in',
                'value' => $completedVisitsCount,
                'description' => 'Visits from appointments',
            ],
            'paid_receipts' => [
                'key' => 'paid_receipts',
                'label' => 'Paid Receipts',
                'value' => $paidReceiptsCount,
                'description' => 'Successfully paid sales records',
            ],
            'registered_clients' => [
                'key' => 'registered_clients',
                'label' => 'Registered Clients',
                'value' => Client::count(),
                'description' => 'Total customer profiles registered',
            ],
        ];
    }

    private function getRevenueData(?string $from, ?string $to, string $group)
    {
        $query = Appointment::query()
            ->where('status', 'completed');

        if ($from && $to) {
            $query->whereBetween('appointment_date', [$from, $to]);
        } else {
            $query->whereYear('appointment_date', now()->year);
        }

        if ($group === 'day' && $from && $to) {
            $rows = $query
                ->selectRaw('DATE(appointment_date) as period, SUM(total_amount) as total')
                ->groupByRaw('DATE(appointment_date)')
                ->orderByRaw('DATE(appointment_date)')
                ->get();

            $period = CarbonPeriod::create($from, $to);
            $labels = collect($period)->map(fn (Carbon $date) => $date->format('d/m'))->toArray();

            $values = array_fill(0, count($labels), 0);
            foreach ($rows as $row) {
                $index = array_search(Carbon::parse($row->period)->format('d/m'), $labels, true);
                if ($index !== false) {
                    $values[$index] = (float) $row->total;
                }
            }
        } elseif ($group === 'year') {
            $rows = $query
                ->selectRaw('YEAR(appointment_date) as period, SUM(total_amount) as total')
                ->groupByRaw('YEAR(appointment_date)')
                ->orderByRaw('YEAR(appointment_date)')
                ->get();

            $labels = $rows->pluck('period')->map(fn ($year) => (string) $year)->toArray();
            $values = $rows->pluck('total')->map(fn ($total) => (float) $total)->toArray();
        } else {
            // month
            $rows = $query
                ->selectRaw('MONTH(appointment_date) as period, SUM(total_amount) as total')
                ->groupByRaw('MONTH(appointment_date)')
                ->orderByRaw('MONTH(appointment_date)')
                ->get();

            if ($from && $to) {
                $period = CarbonPeriod::create($from, $to)->months();
                $labels = collect($period)->map(fn (Carbon $date) => $date->format('M'))->toArray();
                $monthNumbers = collect($period)->map(fn (Carbon $date) => (int) $date->format('n'))->toArray();
            } else {
                $labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                $monthNumbers = range(1, 12);
            }

            $values = array_fill(0, count($labels), 0);
            foreach ($rows as $row) {
                $index = array_search((int) $row->period, $monthNumbers, true);
                if ($index !== false) {
                    $values[$index] = (float) $row->total;
                }
            }
        }

        return [
            'labels' => $labels,
            'values' => $values,
            'totalRevenue' => array_sum($values),
            'group' => $group,
            'from_date' => $from,
            'to_date' => $to,
        ];
    }

    private function getCategoryUsageData()
    {
        // Get category usage from completed appointments
        // Query: appointments -> appointment_service -> services -> categories
        $categoryUsage = Appointment::query()
            ->where('status', 'completed')
            ->with(['appointmentServices' => function ($query) {
                $query->with(['service' => function ($q) {
                    $q->with('category');
                }]);
            }])
            ->get()
            ->flatMap(function ($appointment) {
                return $appointment->appointmentServices->map(function ($appointmentService) {
                    return $appointmentService->service->category;
                });
            })
            ->groupBy('id')
            ->map(function ($items) {
                return [
                    'name' => $items->first()->name,
                    'count' => $items->count(),
                ];
            })
            ->values()
            ->sortByDesc('count')
            ->values();

        // Calculate total
        $totalCount = $categoryUsage->sum('count');

        // Format for chart
        $labels = $categoryUsage->pluck('name')->toArray();
        $values = $categoryUsage->pluck('count')->toArray();

        return [
            'labels' => $labels,
            'values' => $values,
            'total' => $totalCount,
        ];
    }
}
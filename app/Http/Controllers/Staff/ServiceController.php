<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::query()
            ->withCount('appointmentServices')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orWhere('service_name', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            })
            ->when($request->status, function ($query, $status) {
                if (in_array($status, ['active', 'inactive'], true)) {
                    $query->where('status', $status);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.services.index', compact('services'));
    }

    public function create()
    {
        return view('staff.services.create');
    }

    public function store(Request $request)
    {
        Service::create($this->validatedData($request));

        return to_route('staff.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        $service->loadCount('appointmentServices');

        return view('staff.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('staff.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($this->validatedData($request));

        return to_route('staff.services.show', $service)
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if ($service->appointmentServices()->exists()) {
            $service->update(['status' => 'inactive']);

            return to_route('staff.services.index')
                ->with('success', 'Service has appointments, so it was marked inactive instead of deleted.');
        }

        $service->delete();

        return to_route('staff.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'service_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }
}

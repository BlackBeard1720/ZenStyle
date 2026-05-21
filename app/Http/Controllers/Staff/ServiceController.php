<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('view-services');

        $services = Service::query()
            ->with('category')
            ->withCount('appointmentServices')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%')
                        ->orWhereHas('category', function ($query) use ($keyword) {
                            $query->where('name', 'like', '%' . $keyword . '%');
                        });
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->status, function ($query, $status) {
                if (in_array($status, ['active', 'inactive'], true)) {
                    $query->where('status', $status);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('staff.services.index', compact('services', 'categories'));
    }

    public function create()
    {
        Gate::authorize('manage-services');

        return view('staff.services.create', [
            'categories' => $this->activeCategories(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-services');

        Service::create($this->validatedData($request));

        return to_route('staff.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        Gate::authorize('view-services');

        $service->load('category')->loadCount('appointmentServices');

        return view('staff.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        Gate::authorize('manage-services');

        return view('staff.services.edit', [
            'service' => $service,
            'categories' => $this->activeCategories(),
        ]);
    }

    public function update(Request $request, Service $service)
    {
        Gate::authorize('manage-services');

        $service->update($this->validatedData($request));

        return to_route('staff.services.show', $service)
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        Gate::authorize('manage-services');

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
            'category_id' => ['required', 'exists:categories,id'],
            'service' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }

    private function activeCategories()
    {
        return Category::where('status', 'active')
            ->orderBy('name')
            ->get();
    }
}

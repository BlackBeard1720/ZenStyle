<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('view-categories');

        $categories = Category::query()
            ->withCount('services')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%')
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

        return view('staff.categories.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('manage-categories');

        return view('staff.categories.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-categories');

        Category::create($this->validatedData($request));

        return to_route('staff.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        Gate::authorize('view-categories');

        $category->loadCount('services');

        return view('staff.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        Gate::authorize('manage-categories');

        return view('staff.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        Gate::authorize('manage-categories');

        $category->update($this->validatedData($request, $category));

        return to_route('staff.categories.show', $category)
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('manage-categories');

        if ($category->services()->exists()) {
            $category->update(['status' => 'inactive']);

            return to_route('staff.categories.index')
                ->with('success', 'Category has services, so it was marked inactive instead of deleted.');
        }

        $category->delete();

        return to_route('staff.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    private function validatedData(Request $request, ?Category $category = null): array
    {
        $uniqueName = Rule::unique('categories', 'name');

        if ($category) {
            $uniqueName->ignore($category->id);
        }

        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                $uniqueName,
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }
}

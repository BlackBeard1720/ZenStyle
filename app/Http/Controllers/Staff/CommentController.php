<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('manage-services');

        $query = Comment::query()->with('service');

        if ($request->filled('keyword')) {
            $keyword = '%' . $request->input('keyword') . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('id', 'like', $keyword)
                  ->orWhere('name', 'like', $keyword)
                  ->orWhere('comment', 'like', $keyword)
                  ->orWhereHas('service', function ($sq) use ($keyword) {
                      $sq->where('name', 'like', $keyword);
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $comments = $query->latest()->paginate(10)->withQueryString();

        return view('staff.comments.index', compact('comments'));
    }

    public function edit(Comment $comment): View
    {
        Gate::authorize('manage-services');

        $comment->load('service');

        return view('staff.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment): RedirectResponse
    {
        Gate::authorize('manage-services');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'comment' => ['required', 'string', 'max:1000'],
            'status' => ['required', Rule::in(['pending', 'approved', 'hidden'])],
        ]);

        $comment->update($validated);

        return to_route('staff.comments.index')->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        Gate::authorize('manage-services');

        $comment->delete();

        return to_route('staff.comments.index')->with('success', 'Comment deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceCommentController extends Controller
{
    public function store(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        // Tao moi binh luan va dat trang thai cho duyet
        Comment::create([
            'service_id' => $service->id,
            'name' => $validated['name'],
            'comment' => $validated['comment'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your comment has been submitted and is waiting for approval.');
    }
}

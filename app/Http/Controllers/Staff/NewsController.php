<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $items = News::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orWhere('title', 'like', '%' . $keyword . '%')
                        ->orWhere('external_url', 'like', '%' . $keyword . '%');
                });
            })
            ->when($request->created_range, function ($query, $range) {
                $dates = array_values(array_filter(array_map('trim', explode(' - ', $range))));

                if (count($dates) === 2) {
                    $query->whereBetween('created_at', [$dates[0] . ' 00:00:00', $dates[1] . ' 23:59:59']);
                } elseif (count($dates) === 1) {
                    $query->whereDate('created_at', $dates[0]);
                }
            })
            ->when($request->status, function ($query, $status) {
                if (in_array($status, ['active', 'inactive'], true)) {
                    $query->where('status', $status);
                }
            });

        match ($request->get('sort')) {
            'created_asc' => $items->orderBy('created_at', 'asc'),
            'id_asc' => $items->orderBy('id', 'asc'),
            'id_desc' => $items->orderBy('id', 'desc'),
            default => $items->orderBy('created_at', 'desc'),
        };

        $items = $items->paginate(10)->withQueryString();

        return view('staff.news.index', compact('items'));
    }

    public function create()
    {
        return view('staff.news.create');
    }

    public function show(News $news)
    {
        if ($news->status !== 'active') {
            return redirect()->route('staff.news.edit', $news);
        }

        return redirect()->away($news->external_url);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'external_url' => 'required|url|max:2048',
            'image' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        News::create($data);

        return redirect()->route('staff.news.index')->with('success', 'News has been created.');
    }

    public function edit(News $news)
    {
        return view('staff.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'external_url' => 'required|url|max:2048',
            'image' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        $news->update($data);

        return redirect()->route('staff.news.index')->with('success', 'News has been updated.');
    }

    public function destroy(News $news)
    {
        $news->update(['status' => 'inactive']);

        return back()->with('success', 'News has been hidden.');
    }
}

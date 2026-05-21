<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $items = News::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('id', $keyword)
                        ->orWhere('title', 'like', '%' . $keyword . '%');
                });
            })
            ->when($request->created_range, function ($query, $range) {
                $dates = array_map('trim', explode(' - ', $range));

                if (count($dates) === 2) {
                    $query->whereBetween('created_at', [$dates[0] . ' 00:00:00', $dates[1] . ' 23:59:59']);
                } elseif (count($dates) === 1 && ! empty($dates[0])) {
                    $query->whereDate('created_at', $dates[0]);
                }
            });

        switch ($request->get('sort')) {
            case 'published_asc':
                $items->orderBy('published_at', 'asc');
                break;
            case 'id_asc':
                $items->orderBy('id', 'asc');
                break;
            case 'id_desc':
                $items->orderBy('id', 'desc');
                break;
            case 'published_desc':
            default:
                $items->orderBy('published_at', 'desc');
                break;
        }

        $items = $items->paginate(10)->withQueryString();

        return view('staff.news.index', compact('items'));
    }

    public function create()
    {
        return view('staff.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('staff.news.index')->with('success', 'Tin tức đã được tạo.');
    }

    public function edit(News $news)
    {
        return view('staff.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . time();

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('staff.news.index')->with('success', 'Tin tức đã được cập nhật.');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();

        return back()->with('success', 'Tin tức đã được xóa.');
    }
}

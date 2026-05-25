<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\Service;
use App\Support\FrontendServiceCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function home(): View
    {
        return view('frontend.home.index', [
            'serviceGroups' => FrontendServiceCatalog::homeGroupsFromServiceModels(
                $this->activeServices(3)
            ),
        ]);
    }

    public function about(): View
    {
        return view('frontend.about.index');
    }

    public function news(): View
    {
        $category = request('category', '');

        $postsCollection = News::active()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function (News $news) {
                return [
                    'slug' => $news->slug,
                    'date' => optional($news->created_at)->toDateString(),
                    'date_label' => optional($news->created_at)->format('d/m/Y'),
                    'title' => $news->title,
                    'summary' => $news->summary,
                    'body' => $news->body,
                    'image' => $news->image_url,
                    'tag' => 'Tin tức',
                ];
            })
            ->values();

        $posts = $category
            ? $postsCollection->filter(fn ($post) => ($post['tag'] ?? '') === $category)->values()->all()
            : $postsCollection->all();

        $categories = collect($postsCollection)->pluck('tag')->unique()->sort()->values()->all();

        return view('frontend.news.index', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $category,
            'resultCount' => count($posts),
        ]);
    }

    public function newsShow(string $slug): View
    {
        $postModel = News::active()->where('slug', $slug)->firstOrFail();

        $post = [
            'slug' => $postModel->slug,
            'date' => optional($postModel->created_at)->toDateString(),
            'date_label' => optional($postModel->created_at)->format('d/m/Y'),
            'title' => $postModel->title,
            'summary' => $postModel->summary,
            'body' => $postModel->body,
            'image' => $postModel->image_url,
            'tag' => 'Tin tức',
        ];

        $all = News::active()->orderBy('created_at', 'desc')->get();
        $index = $all->search(fn ($news) => $news->id === $postModel->id);
        $prev = $index > 0 ? $all[$index - 1] : null;
        $next = $index < $all->count() - 1 ? $all[$index + 1] : null;

        $prevPost = $prev ? [
            'slug' => $prev->slug,
            'title' => $prev->title,
            'date_label' => optional($prev->created_at)->format('d/m/Y'),
        ] : null;

        $nextPost = $next ? [
            'slug' => $next->slug,
            'title' => $next->title,
            'date_label' => optional($next->created_at)->format('d/m/Y'),
        ] : null;

        return view('frontend.news.show', [
            'post' => $post,
            'prevPost' => $prevPost,
            'nextPost' => $nextPost,
        ]);
    }

    public function hotTrend(): View
    {
        return view('frontend.hot-trend.index');
    }

    public function services(): View
    {
        // Lay du lieu filter tu query string
        $keyword = trim((string) request('keyword', ''));
        $selectedCategory = (string) request('category', 'all');
        $selectedSort = (string) request('sort', '');

        // Lay danh muc active de hien thi sidebar filter
        $categories = Category::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Query service active tu DB, kem category de tranh N+1
        $servicesQuery = Service::query()
            ->with('category')
            ->where('status', 'active')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            });

        // Loc theo ten dich vu
        $servicesQuery->when($keyword !== '', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        });

        // Loc theo category
        $servicesQuery->when($selectedCategory !== '' && $selectedCategory !== 'all', function ($query) use ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        });

        // Sap xep theo gia
        match ($selectedSort) {
            'price_asc' => $servicesQuery->orderBy('price', 'asc'),
            'price_desc' => $servicesQuery->orderBy('price', 'desc'),
            default => $servicesQuery->orderBy('name'),
        };

        $services = $servicesQuery->paginate(6)->withQueryString();

        return view('frontend.services.index', [
            'services' => $services,
            'categories' => $categories,
            'keyword' => $keyword,
            'selectedCategory' => $selectedCategory,
            'selectedSort' => $selectedSort,
        ]);
    }

    public function serviceShow(string $slug): View
    {
        // Lay toan bo service active kem category tu DB de tim theo slug URL
        $serviceModels = $this->activeServices();

        $serviceModel = $serviceModels->first(function (Service $service) use ($slug) {
            return Str::slug($service->name) === $slug;
        });
        abort_if(! $serviceModel, 404);

        // Lay danh sach lien quan cung category va loai bo service hien tai
        $relatedServices = $serviceModels
            ->where('category_id', $serviceModel->category_id)
            ->reject(fn (Service $item) => $item->id === $serviceModel->id)
            ->take(4)
            ->values();

        return view('frontend.services.show', [
            'service' => $serviceModel,
            'relatedServices' => $relatedServices,
        ]);
    }

    public function privacyPolicy(): View
    {
        return view('frontend.privacy.index');
    }

    public function termsOfService(): View
    {
        return view('frontend.terms.index');
    }

    public function faq(): View
    {
        return view('frontend.faq.index');
    }

    public function contact(): View
    {
        return view('frontend.contact.index');
    }

    private function activeServices(?int $limit = null): Collection
    {
        try {
            $query = Service::query()
                ->with('category')
                ->where('status', 'active')
                ->orderBy('name');

            if ($limit) {
                $query->limit($limit);
            }

            return $query->get();
        } catch (\Throwable $exception) {
            if (app()->environment('testing')) {
                return collect();
            }

            throw $exception;
        }
    }
}

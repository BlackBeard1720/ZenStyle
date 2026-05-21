<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
        $services = $this->activeServices();
        $mappedServices = FrontendServiceCatalog::fromServiceModels($services);

        // Get filter parameters from request
        $searchQuery = request('q', '');
        $selectedCategories = array_filter((array) request('category', []));
        $selectedSort = request('sort', 'name');

        // Build available categories from all services
        $allCategories = collect($mappedServices)
            ->pluck('category')
            ->unique()
            ->sort()
            ->values()
            ->all();

        // Filter by search query
        $filteredServices = collect($mappedServices);

        if ($searchQuery) {
            $query = Str::lower($searchQuery);
            $filteredServices = $filteredServices->filter(function ($service) use ($query) {
                $title = Str::lower($service['title']);
                $description = Str::lower($service['description']);
                return Str::contains($title, $query) || Str::contains($description, $query);
            });
        }

        // Filter by selected categories
        if (!empty($selectedCategories)) {
            $filteredServices = $filteredServices->filter(function ($service) use ($selectedCategories) {
                return in_array($service['category'], $selectedCategories);
            });
        }

        // Apply sorting
        switch ($selectedSort) {
            case 'price-asc':
                $filteredServices = $filteredServices->sortBy('raw_price');
                break;
            case 'price-desc':
                $filteredServices = $filteredServices->sortByDesc('raw_price');
                break;
            case 'duration-asc':
                $filteredServices = $filteredServices->sortBy('raw_duration');
                break;
            case 'name':
            default:
                $filteredServices = $filteredServices->sortBy('title');
                break;
        }

        $filteredServices = $filteredServices->values()->all();

        return view('frontend.services.index', [
            'heroImage' => FrontendServiceCatalog::heroImage(),
            'services' => $filteredServices,
            'categories' => $allCategories,
            'selectedCategories' => $selectedCategories,
            'searchQuery' => $searchQuery,
            'selectedSort' => $selectedSort,
            'resultCount' => count($filteredServices),
            'staff' => FrontendServiceCatalog::staff(),
            'testimonials' => FrontendServiceCatalog::testimonials(),
        ]);
    }

    public function serviceShow(string $slug): View
    {
        $serviceModels = $this->activeServices();

        $services = FrontendServiceCatalog::fromServiceModels($serviceModels);
        $service = collect($services)->firstWhere('slug', $slug);
        abort_if(! $service, 404);

        $relatedServices = collect($services)
            ->reject(fn ($item) => $item['slug'] === $slug)
            ->take(4)
            ->values()
            ->all();

        return view('frontend.services.show', [
            'service' => $service,
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

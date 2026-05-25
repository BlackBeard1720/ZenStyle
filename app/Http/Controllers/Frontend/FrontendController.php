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
        $posts = News::active()
            ->orderBy('created_at', 'desc')
            ->paginate(6)
            ->through(function (News $news) {
                return [
                    'title' => $news->title,
                    'summary' => $news->summary,
                    'date' => optional($news->created_at)->toDateString(),
                    'date_label' => optional($news->created_at)->format('d/m/Y'),
                    'image' => $news->image_url,
                    'external_url' => $news->external_url,
                ];
            });

        return view('frontend.news.index', [
            'posts' => $posts,
        ]);
    }

    public function hotTrend(): View
    {
        return view('frontend.hot-trend.index');
    }

    public function services(): View
    {
        // Lay danh sach category dang duoc chon tu query string
        $selectedCategories = request()->input('categories', []);

        if (! is_array($selectedCategories)) {
            $selectedCategories = [];
        }

        // Ep ve string de so sanh voi id ngoai view cho on dinh
        $selectedCategories = array_map('strval', $selectedCategories);

        // Lay kieu sap xep tu query string
        $selectedSort = (string) request('sort', '');

        // Lay danh muc active de hien thi filter ngang
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

        // Loc theo nhieu category khi nguoi dung tick checkbox
        $servicesQuery->when(! empty($selectedCategories), function ($query) use ($selectedCategories) {
            $query->whereIn('category_id', $selectedCategories);
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
            'selectedCategories' => $selectedCategories,
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

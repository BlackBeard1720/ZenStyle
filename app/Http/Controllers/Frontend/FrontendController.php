<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\FrontendServiceCatalog;
use App\Models\News;
use Illuminate\Contracts\View\View;

class FrontendController extends Controller
{
    public function home(): View
    {
        return view('frontend.home.index');
    }

    public function about(): View
    {
        return view('frontend.about.index');
    }

    public function news(): View
    {
        $query = News::published()->orderBy('published_at', 'desc');

        $category = request('category', '');

        $postsCollection = $query->get()->map(function (News $n) {
            // extract paragraphs from HTML body if possible
            $paragraphs = [];
            if (preg_match_all('/<p>(.*?)<\/p>/s', $n->body, $matches)) {
                $paragraphs = array_map(fn($t) => trim(strip_tags($t)), $matches[1]);
            } else {
                $paragraphs = [trim(strip_tags($n->body))];
            }

            return [
                'slug' => $n->slug,
                'date' => optional($n->published_at ?? $n->created_at)->toDateString(),
                'date_label' => optional($n->published_at ?? $n->created_at)->format('d/m/Y'),
                'title' => $n->title,
                'excerpt' => $n->excerpt,
                'image' => $n->image_url,
                'tag' => 'Tin tức',
                'paragraphs' => $paragraphs,
            ];
        })->values();

        $posts = $category
            ? $postsCollection->filter(fn($post) => ($post['tag'] ?? '') === $category)->values()->all()
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
        $postModel = News::where('slug', $slug)->firstOrFail();

        $paragraphs = [];
        if (preg_match_all('/<p>(.*?)<\/p>/s', $postModel->body, $matches)) {
            $paragraphs = array_map(fn($t) => trim(strip_tags($t)), $matches[1]);
        } else {
            $paragraphs = [trim(strip_tags($postModel->body))];
        }

        $post = [
            'slug' => $postModel->slug,
            'date' => optional($postModel->published_at ?? $postModel->created_at)->toDateString(),
            'date_label' => optional($postModel->published_at ?? $postModel->created_at)->format('d/m/Y'),
            'title' => $postModel->title,
            'excerpt' => $postModel->excerpt,
            'image' => $postModel->image_url,
            'tag' => 'Tin tức',
            'paragraphs' => $paragraphs,
        ];

        // get prev / next based on published_at ordering
        $all = News::published()->orderBy('published_at', 'desc')->get();
        $index = $all->search(fn($n) => $n->id === $postModel->id);
        $prev = $index > 0 ? $all[$index - 1] : null;
        $next = $index < $all->count() - 1 ? $all[$index + 1] : null;

        $prevPost = $prev ? [
            'slug' => $prev->slug,
            'title' => $prev->title,
            'date_label' => optional($prev->published_at ?? $prev->created_at)->format('d/m/Y'),
        ] : null;

        $nextPost = $next ? [
            'slug' => $next->slug,
            'title' => $next->title,
            'date_label' => optional($next->published_at ?? $next->created_at)->format('d/m/Y'),
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
        return view('frontend.services.index', [
            'heroImage' => FrontendServiceCatalog::heroImage(),
            'services' => FrontendServiceCatalog::all(),
            'staff' => FrontendServiceCatalog::staff(),
            'testimonials' => FrontendServiceCatalog::testimonials(),
        ]);
    }

    public function serviceShow(string $slug): View
    {
        $services = FrontendServiceCatalog::all();
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

    /**
     * Tin tức & ưu đãi demo (PHP tĩnh — sau này có thể thay bằng Model).
     *
     * @return array<int, array<string, mixed>>
     */
    protected static function demoNewsPosts(): array
    {
        return [
            [
                'slug' => 'uu-dai-thang-5-2026',
                'date' => '2026-05-01',
                'date_label' => '01/05/2026',
                'title' => 'Ưu đãi tháng 5: Combo cắt + treatment giảm 20%',
                'excerpt' => 'Áp dụng cuối tuần tại ZenStyle FPT Aptech. Đặt lịch trước 48 giờ để giữ suất stylist yêu thích.',
                'image' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=1200&q=80',
                'tag' => 'Ưu đãi',
                'paragraphs' => [
                    'Tháng 5 này, ZenStyle FPT Aptech mang đến combo cắt tạo kiểu kèm liệu trình treatment phục hồi với mức giảm 20% vào các ngày thứ 7 và chủ nhật.',
                    'Ưu đãi được áp dụng sau khi bạn đặt lịch trực tuyến hoặc qua hotline và xác nhận trước ít nhất 48 giờ để stylist sắp xếp thời gian treatment phù hợp với phác đồ của bạn.',
                    'Mọi chi tiết về các gói lựa chọn và danh mục sản phẩm kèm theo được tư vấn tại salon — không thay thể bằng tiền mặt, không ghép đồng thời với chương trình voucher khác trừ khi được ghi rõ trong thông báo.',
                ],
            ],
            [
                'slug' => 'xu-huong-layer-mullet-2026',
                'date' => '2026-04-18',
                'date_label' => '18/04/2026',
                'title' => 'Xu hướng layer & mullet: cá nhân hoá theo gương mặt',
                'excerpt' => 'Team ZenStyle gợi ý độ dài mái và layer phù hợp từng form mặt — không copy nguyên mẫu mạng.',
                'image' => 'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?auto=format&fit=crop&w=1200&q=80',
                'tag' => 'Xu hướng',
                'paragraphs' => [
                    'Layer và mullet vẫn giữ vai trò trung tâm trong các lượt tư vấn năm 2026, nhưng điều làm ZenStyle khác là chúng tôi ưu tiên “khuôn mặt bạn trong ảnh thật chứ không phải trên moodboard”.',
                    'Stylist của chúng tôi chia layer theo các lớp vừa phải, tránh một phát cắt quá cứng khiến tóc bị chồng mà không đổ; phần gáy của mullet sẽ được hạ thấp hoặc ôm mép vai tùy tổng chiều dài và độ cứng sợi tóc.',
                    'Đặt gói tư vấn “proportions” trong app hoặc tại salon để được phác họa các phương án và chụp hình tham khảo dưới ánh đèn salon trước khi nhận kem nhuộm hoặc kéo cắt.',
                ],
            ],
            [
                'slug' => 'balayage-giu-mau-lau',
                'date' => '2026-04-02',
                'date_label' => '02/04/2026',
                'title' => 'Balayage bền màu: checklist chăm sóc tại nhà',
                'excerpt' => 'Dầu gội sulfate-free, nhiệt độ nước và lịch dặm màu mà Color Specialist khuyên dùng.',
                'image' => 'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?auto=format&fit=crop&w=1200&q=80',
                'tag' => 'Mẹo làm đẹp',
                'paragraphs' => [
                    'Balayage phụ thuộc lớn vào lipid bảo vệ bề mặt sợi tóc: gội bằng nước ấm (không quá nóng) và dầu gội sulfate-free giúp màu bám nền không bị bung nhanh sau tuần đầu.',
                    'Đồng ý một lịch dặm tông (gloss hoặc demi-permanent) vào tuần thứ 4 đến 6 — Color Specialist của ZenStyle sẽ nêu lịch phù hợp trong phiếu dặn về nhà sau khi làm đầy đủ dịch vụ.',
                    'Tránh ô tô nắng nóng không mũ, hồ bơi chlorine nếu chưa bôi sản phẩm shield; team chúng tôi có bộ refill travel-size cho khách làm luôn trong tháng dịch vụ.',
                ],
            ],
            [
                'slug' => 'zenstyle-nang-cap-phong-treatment',
                'date' => '2026-03-15',
                'date_label' => '15/03/2026',
                'title' => 'ZenStyle nâng cấp phòng liệu trình phục hồi tóc',
                'excerpt' => 'Ghế massage, hấp dưỡng ozone và bộ sản phẩm Olaplex/K18 — trải nghiệm spa cho tóc ngay tại FPT Aptech.',
                'image' => 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=1200&q=80',
                'tag' => 'Tin salon',
                'paragraphs' => [
                    'Phòng phục hồi của ZenStyle vừa được mở rộng không gian, bổ sung ghế shiatsu và hệ ozone hơi ấm trong lúc đắp mặt nạ tái tạo link disulfite.',
                    'Chúng tôi chọn bộ làm nhà OLAPLEX / K18 theo chỉ định tay nghề — khách không bị ép mua chai lớn tại chỗ nếu chưa cần, nhưng vẫn được hưởng refill giá chi nhánh trung thành.',
                    'Hiệu suất chỗ/ngày không thay đổi nhằm tránh chờ chồng nhau — vui lòng đặt lịch nhánh “Treatment only” trong hệ booking online.',
                ],
            ],
            [
                'slug' => 'thanh-vien-tich-diem-2026',
                'date' => '2026-03-01',
                'date_label' => '01/03/2026',
                'title' => 'Chương trình thành viên: tích điểm đổi voucher',
                'excerpt' => 'Mỗi 500k tích 1 điểm; đổi gội dưỡng, treatment hoặc giảm giá % cho lần làm tiếp theo.',
                'image' => 'https://images.unsplash.com/photo-1519415943484-9fa1873496d4?auto=format&fit=crop&w=1200&q=80',
                'tag' => 'Ưu đãi',
                'paragraphs' => [
                    'Từ 01/03/2026, mọi chi tiêu 500.000đ tại quầy chính sẽ tích một điểm — đếm tay trên ví điện tử in-store hoặc cập nhật sau khi bạn nhận email xác nhận bill.',
                    'Điểm không hết hạn nhưng chuyển phần thưởng quý (voucher %) sẽ public mỗi quý và nhắc qua tin nhắn app.',
                    'Đổi thưởng trước 30 ngày kể từ thông báo để không bị lỡ các đợt restock voucher — không quy sang tiền mặt.',
                ],
            ],
            [
                'slug' => 'open-day-stylist-trien-khai-2026',
                'date' => '2026-02-10',
                'date_label' => '10/02/2026',
                'title' => 'Open Day: gặp stylist, tư vấn miễn phí 15 phút',
                'excerpt' => 'Sự kiện cuối tuần dành cho khách mới — book slot “tư vấn gu” trước để không phải chờ.',
                'image' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=1200&q=80',
                'tag' => 'Sự kiện',
                'paragraphs' => [
                    'Open Day các ngày 22–23/02/2026 chia slot 15 phút / khách để được stylist senior phác họa silhouette phù hợp và trả lời nhanh về các gói dịch vụ.',
                    'Số lượng giới hạn 40 slot / ngày — trước 12h không nhận thêm khách chưa book.',
                    'Mang theo ít nhất 3 ảnh tham khảo (Instagram screen ok) và tình trạng tóc thật không nhuộm tạm 24h để chúng tôi học được texture gốc.',
                ],
            ],
        ];
    }
}

<?php

namespace App\Support;

use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FrontendServiceCatalog
{
    public static function heroImage(): string
    {
        return asset('images/frontend/banner/Gemini_Generated_Image_6hfrq56hfrq56hfr.png');
    }

    public static function all(): array
    {
        $gallery = static::gallery();
        $defaultProcess = [
            'Bước 1: Tư vấn tình trạng tóc và mong muốn thay đổi.',
            'Bước 2: Thực hiện dịch vụ theo kỹ thuật phù hợp.',
            'Bước 3: Kiểm tra form, hoàn thiện styling và dặn dò chăm sóc.',
        ];

        $services = [
            [
                'slug' => 'cat-toc-nam-cao-cap',
                'title' => 'Cắt tóc nam cao cấp',
                'description' => 'Tư vấn form tóc, cắt tạo kiểu và hoàn thiện styling phù hợp khuôn mặt.',
                'longDescription' => 'Dịch vụ dành cho khách muốn mái tóc gọn, rõ form và dễ chăm sóc hằng ngày. Stylist phân tích chất tóc, khuôn mặt, thói quen tạo kiểu rồi đề xuất độ dài và đường cắt phù hợp.',
                'duration' => '45 phút',
                'price' => '150.000đ',
                'images' => $gallery['toc'],
                'badges' => ['Phổ biến', 'Phù hợp tóc nam'],
                'stylist' => 'Quách Tùng Dương - Stylist tóc',
                'process' => $defaultProcess,
                'notes' => ['Nên mang ảnh tham khảo nếu bạn muốn đổi kiểu rõ rệt.', 'Gội đầu trước hay sau khi cắt sẽ được stylist tư vấn theo tình trạng tóc.'],
                'suitableFor' => ['Khách muốn thay đổi diện mạo gọn gàng.', 'Khách cần kiểu tóc lịch sự để đi học, đi làm.', 'Khách muốn form tóc dễ tự chăm ở nhà.'],
                'expectedResults' => ['Tóc vào form rõ hơn.', 'Kiểu tóc phù hợp khuôn mặt.', 'Tổng thể gọn gàng và chuyên nghiệp hơn.'],
                'aftercare' => ['Dùng sáp hoặc pre-styling nhẹ nếu cần giữ nếp.', 'Nên quay lại chỉnh form sau 3-5 tuần tùy tốc độ mọc tóc.'],
            ],
            [
                'slug' => 'tao-kieu-su-kien',
                'title' => 'Tạo kiểu sự kiện',
                'description' => 'Sấy, vuốt, tạo texture hoặc giữ nếp cho lịch gặp gỡ, chụp hình, tiệc.',
                'longDescription' => 'Stylist tạo kiểu theo trang phục, bối cảnh và thời gian sự kiện. Mục tiêu là giữ tóc vào nếp đủ lâu nhưng vẫn tự nhiên khi lên hình hoặc gặp gỡ trực tiếp.',
                'duration' => '45-60 phút',
                'price' => 'Từ 220.000đ',
                'images' => $gallery['styling'],
                'badges' => ['Tư vấn trước khi làm', 'Giữ nếp'],
                'stylist' => 'Đinh Văn Hải - Kỹ thuật viên styling',
                'process' => ['Bước 1: Tư vấn phong cách sự kiện và trang phục.', 'Bước 2: Sấy phồng, tạo texture hoặc tạo nếp theo form.', 'Bước 3: Cố định bằng sản phẩm hoàn thiện và kiểm tra góc nhìn.'],
                'notes' => ['Nên đến trước giờ sự kiện ít nhất 2-3 tiếng.', 'Tránh đội mũ sát tóc ngay sau khi tạo kiểu.'],
                'suitableFor' => ['Khách có lịch chụp hình hoặc dự tiệc.', 'Khách muốn tóc gọn và lên hình tốt.', 'Khách cần tạo kiểu nhanh nhưng chỉn chu.'],
                'expectedResults' => ['Tóc có độ phồng và texture rõ.', 'Form tóc hợp trang phục.', 'Nếp giữ ổn trong thời gian sự kiện.'],
                'aftercare' => ['Có thể dùng tay chỉnh nhẹ, tránh chải mạnh.', 'Gội sạch sản phẩm giữ nếp sau sự kiện.'],
            ],
            [
                'slug' => 'cat-goi-thu-gian',
                'title' => 'Cắt + gội thư giãn',
                'description' => 'Kết hợp cắt tóc, gội làm sạch và massage da đầu nhẹ trước khi styling.',
                'longDescription' => 'Một buổi hẹn trọn gói cho khách muốn vừa chỉnh lại kiểu tóc vừa thư giãn. Dịch vụ kết hợp cắt, gội và massage nhẹ để tóc sạch, da đầu dễ chịu trước khi hoàn thiện styling.',
                'duration' => '75 phút',
                'price' => '250.000đ',
                'images' => $gallery['goi'],
                'badges' => ['Phổ biến', 'Thư giãn'],
                'stylist' => 'Lê Hoàng Nam - Chuyên viên gội đầu dưỡng sinh',
                'process' => ['Bước 1: Tư vấn kiểu tóc và tình trạng da đầu.', 'Bước 2: Cắt tạo form, gội sạch và massage thư giãn.', 'Bước 3: Sấy khô, styling và kiểm tra tổng thể.'],
                'notes' => ['Phù hợp khi bạn muốn làm mới nhẹ trong một buổi hẹn.', 'Thông báo với kỹ thuật viên nếu da đầu nhạy cảm.'],
                'suitableFor' => ['Khách muốn cắt tóc kèm thư giãn.', 'Khách hay đội mũ bảo hiểm hoặc dùng sản phẩm tạo kiểu.', 'Khách cần làm sạch tóc trước khi styling.'],
                'expectedResults' => ['Tóc sạch và nhẹ hơn.', 'Da đầu dễ chịu.', 'Kiểu tóc hoàn thiện tự nhiên.'],
                'aftercare' => ['Không cần gội lại trong ngày nếu tóc đã sạch.', 'Giữ da đầu khô thoáng sau dịch vụ.'],
            ],
            [
                'slug' => 'nhuom-tone-co-ban',
                'title' => 'Nhuộm tone cơ bản',
                'description' => 'Tư vấn màu theo nền tóc, màu da và lịch chăm sóc tại nhà.',
                'longDescription' => 'Dịch vụ nhuộm một tone hoặc tone cơ bản phù hợp cho khách muốn làm mới màu tóc nhưng vẫn dễ chăm. Team sẽ đánh giá nền tóc trước khi chọn công thức màu.',
                'duration' => '90-120 phút',
                'price' => 'Từ 650.000đ',
                'images' => $gallery['mau'],
                'badges' => ['Tư vấn trước khi làm', 'Cần chăm sóc sau dịch vụ'],
                'stylist' => 'Color Specialist ZenStyle',
                'process' => ['Bước 1: Kiểm tra nền tóc và lịch sử hóa chất.', 'Bước 2: Chọn tone màu, pha màu và xử lý theo nền tóc.', 'Bước 3: Xả màu, dưỡng tóc và hướng dẫn giữ màu.'],
                'notes' => ['Giá có thể thay đổi theo độ dài và nền tóc.', 'Không nên gội đầu quá sát giờ nhuộm nếu da đầu nhạy cảm.'],
                'suitableFor' => ['Khách muốn đổi màu nhẹ nhàng.', 'Khách cần màu tóc lịch sự, dễ phối đồ.', 'Khách muốn che nền tóc không đều.'],
                'expectedResults' => ['Màu tóc đều và hợp màu da hơn.', 'Tóc nhìn có chiều sâu hơn.', 'Tổng thể sáng và mới hơn.'],
                'aftercare' => ['Dùng dầu gội giữ màu.', 'Tránh nước quá nóng trong tuần đầu.', 'Dặm dưỡng định kỳ nếu tóc khô.'],
            ],
            [
                'slug' => 'uon-texture',
                'title' => 'Uốn texture',
                'description' => 'Tạo độ phồng, lọn tự nhiên và form dễ chăm cho tóc nam hoặc tóc ngắn.',
                'longDescription' => 'Uốn texture giúp tóc có độ chuyển động, phồng và dễ vào nếp hơn. Stylist chọn trục và kỹ thuật theo chất tóc để tránh cảm giác lọn quá cứng.',
                'duration' => '120 phút',
                'price' => 'Từ 720.000đ',
                'images' => $gallery['uon'],
                'badges' => ['Phù hợp tóc nam', 'Cần chăm sóc sau dịch vụ'],
                'stylist' => 'Quách Tùng Dương - Stylist tóc',
                'process' => ['Bước 1: Kiểm tra độ khỏe và hướng mọc của tóc.', 'Bước 2: Uốn texture theo vùng cần phồng hoặc tạo chuyển động.', 'Bước 3: Trung hòa, dưỡng tóc và hướng dẫn sấy tạo form.'],
                'notes' => ['Không phù hợp nếu tóc đang quá yếu hoặc mới tẩy mạnh.', 'Nên dành đủ thời gian để kỹ thuật viên kiểm tra form sau khi uốn.'],
                'suitableFor' => ['Khách có tóc thẳng khó vào nếp.', 'Khách muốn tóc phồng tự nhiên.', 'Khách muốn giảm thời gian styling mỗi sáng.'],
                'expectedResults' => ['Tóc có độ phồng tốt hơn.', 'Texture nhìn tự nhiên.', 'Dễ sấy vào form hơn.'],
                'aftercare' => ['Tránh gội đầu ngay trong 24-48 giờ đầu.', 'Dùng sản phẩm dưỡng nhẹ cho tóc uốn.', 'Sấy theo hướng stylist đã hướng dẫn.'],
            ],
            [
                'slug' => 'balayage-highlight',
                'title' => 'Balayage / Highlight',
                'description' => 'Thiết kế mảng sáng tối theo tóc thật, tránh xử lý quá tay trong một lần.',
                'longDescription' => 'Balayage và highlight tạo chiều sâu cho mái tóc bằng các mảng sáng được đặt có chủ đích. Dịch vụ cần tư vấn kỹ để cân bằng độ sáng mong muốn, nền tóc thật và khả năng chăm sóc sau đó.',
                'duration' => '150 phút+',
                'price' => 'Tư vấn tại salon',
                'images' => [$gallery['mau'][1], $gallery['mau'][0], $gallery['styling'][2]],
                'badges' => ['Tư vấn trước khi làm', 'Cần chăm sóc sau dịch vụ'],
                'stylist' => 'Color Specialist ZenStyle',
                'process' => ['Bước 1: Phân tích nền tóc và chọn vị trí mảng sáng.', 'Bước 2: Nâng sáng, cân bằng tone và xử lý màu.', 'Bước 3: Dưỡng phục hồi, sấy tạo kiểu và dặn lịch chăm sóc.'],
                'notes' => ['Có thể cần nhiều buổi nếu nền tóc tối hoặc đã nhuộm nhiều lần.', 'Nên đặt lịch tư vấn trước để ước lượng thời gian và chi phí.'],
                'suitableFor' => ['Khách muốn màu tóc có chiều sâu.', 'Khách thích hiệu ứng sáng tự nhiên.', 'Khách sẵn sàng chăm sóc tóc sau hóa chất.'],
                'expectedResults' => ['Tóc có mảng sáng rõ nhưng mềm.', 'Tổng thể nổi bật hơn.', 'Màu chuyển tự nhiên theo nền tóc.'],
                'aftercare' => ['Dùng dầu gội tím hoặc giữ màu khi được tư vấn.', 'Hạn chế nhiệt cao.', 'Dưỡng phục hồi định kỳ để giữ độ bóng.'],
            ],
            [
                'slug' => 'goi-massage-da-dau',
                'title' => 'Gội + massage da đầu',
                'description' => 'Làm sạch nhẹ, massage da đầu và cổ vai gáy ngắn để giảm căng.',
                'longDescription' => 'Dịch vụ ngắn cho khách cần làm sạch tóc và thư giãn nhanh. Kỹ thuật viên tập trung vào da đầu, vùng gáy và cổ vai để giảm cảm giác nặng đầu.',
                'duration' => '30 phút',
                'price' => '120.000đ',
                'images' => $gallery['goi'],
                'badges' => ['Thư giãn', 'Nhanh gọn'],
                'stylist' => 'Lê Hoàng Nam - Chuyên viên gội đầu dưỡng sinh',
                'process' => $defaultProcess,
                'notes' => ['Thông báo nếu bạn có vùng da đầu nhạy cảm.', 'Có thể kết hợp sau cắt tóc hoặc trước styling.'],
                'suitableFor' => ['Khách muốn làm sạch nhanh.', 'Khách căng da đầu sau ngày dài.', 'Khách chuẩn bị đi gặp gỡ hoặc sự kiện.'],
                'expectedResults' => ['Tóc sạch và nhẹ.', 'Da đầu thoải mái hơn.', 'Tinh thần thư giãn hơn.'],
                'aftercare' => ['Giữ tóc khô thoáng sau khi gội.', 'Tránh đội mũ quá lâu ngay sau dịch vụ.'],
            ],
            [
                'slug' => 'treatment-phuc-hoi',
                'title' => 'Treatment phục hồi',
                'description' => 'Bổ sung dưỡng chất cho tóc khô, xơ hoặc vừa trải qua uốn nhuộm.',
                'longDescription' => 'Treatment tập trung cải thiện cảm giác khô xơ, thiếu bóng và rối sau hóa chất hoặc tác động nhiệt. Kỹ thuật viên chọn sản phẩm theo tình trạng tóc thực tế.',
                'duration' => '60 phút',
                'price' => '320.000đ',
                'images' => [$gallery['goi'][2], $gallery['spa'][1], $gallery['mau'][0]],
                'badges' => ['Cần chăm sóc sau dịch vụ', 'Phục hồi'],
                'stylist' => 'Spa & Treatment ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Hiệu quả phụ thuộc vào mức độ hư tổn ban đầu.', 'Có thể cần liệu trình nhiều buổi với tóc tẩy hoặc tóc yếu.'],
                'suitableFor' => ['Khách có tóc khô xơ.', 'Khách vừa uốn, nhuộm hoặc tạo kiểu nhiệt nhiều.', 'Khách muốn tóc mềm và dễ chải hơn.'],
                'expectedResults' => ['Tóc mềm hơn.', 'Giảm rối và khô xơ.', 'Bề mặt tóc bóng hơn.'],
                'aftercare' => ['Dùng dầu xả hoặc mặt nạ tóc định kỳ.', 'Hạn chế kẹp, uốn nhiệt cao.', 'Dặm treatment theo tư vấn.'],
            ],
            [
                'slug' => 'goi-duong-sinh-chuyen-sau',
                'title' => 'Gội dưỡng sinh chuyên sâu',
                'description' => 'Kết hợp làm sạch da đầu, massage thư giãn và chăm sóc thân tóc.',
                'longDescription' => 'Một liệu trình thư giãn dài hơn, phù hợp khi bạn muốn phục hồi năng lượng và chăm sóc tóc nhẹ nhàng. Dịch vụ chú trọng nhịp massage và cảm giác thoải mái.',
                'duration' => '75 phút',
                'price' => 'Từ 360.000đ',
                'images' => [$gallery['goi'][1], $gallery['goi'][0], $gallery['spa'][2]],
                'badges' => ['Thư giãn', 'Phổ biến'],
                'stylist' => 'Lê Hoàng Nam - Chuyên viên gội đầu dưỡng sinh',
                'process' => $defaultProcess,
                'notes' => ['Nên báo trước nếu bạn không thích massage lực mạnh.', 'Phù hợp đặt cuối ngày hoặc cuối tuần.'],
                'suitableFor' => ['Khách căng thẳng hoặc mỏi vai gáy.', 'Khách muốn chăm sóc tóc nhẹ nhàng.', 'Khách cần một buổi thư giãn đầy đủ hơn.'],
                'expectedResults' => ['Da đầu sạch và nhẹ.', 'Cơ thể thư giãn hơn.', 'Tóc mềm và dễ vào nếp.'],
                'aftercare' => ['Uống đủ nước sau buổi massage.', 'Tránh dùng thêm nhiều sản phẩm tạo kiểu trong ngày.'],
            ],
            [
                'slug' => 'massage-co-vai-gay',
                'title' => 'Massage cổ vai gáy',
                'description' => 'Tập trung vùng cổ, vai, gáy cho khách ngồi máy tính hoặc di chuyển nhiều.',
                'longDescription' => 'Dịch vụ thư giãn ngắn giúp giải tỏa cảm giác căng vùng cổ vai gáy. Kỹ thuật viên điều chỉnh lực theo phản hồi của khách trong buổi làm.',
                'duration' => '30-45 phút',
                'price' => 'Từ 220.000đ',
                'images' => $gallery['spa'],
                'badges' => ['Thư giãn', 'Nhanh gọn'],
                'stylist' => 'Spa & Treatment ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Không thay thế tư vấn y khoa nếu bạn đang đau kéo dài.', 'Nên báo trước vùng cần tránh hoặc tiền sử chấn thương.'],
                'suitableFor' => ['Khách ngồi máy tính nhiều.', 'Khách bị căng cổ vai gáy nhẹ.', 'Khách muốn thư giãn trong thời gian ngắn.'],
                'expectedResults' => ['Vùng cổ vai nhẹ hơn.', 'Cảm giác thư giãn rõ hơn.', 'Dễ chịu hơn sau ngày dài.'],
                'aftercare' => ['Uống nước sau massage.', 'Vận động nhẹ vùng cổ vai sau buổi làm.'],
            ],
            [
                'slug' => 'cham-soc-da-co-ban',
                'title' => 'Chăm sóc da cơ bản',
                'description' => 'Làm sạch, cân bằng ẩm và tư vấn chu trình chăm sóc đơn giản tại nhà.',
                'longDescription' => 'Dịch vụ chăm sóc da nhẹ nhàng cho khách muốn làm sạch và cân bằng da. Kỹ thuật viên tư vấn sản phẩm cơ bản theo tình trạng da sau khi quan sát trực tiếp.',
                'duration' => '45 phút',
                'price' => 'Từ 300.000đ',
                'images' => [$gallery['spa'][0], $gallery['spa'][1], $gallery['goi'][0]],
                'badges' => ['Tư vấn trước khi làm', 'Chăm sóc nhẹ'],
                'stylist' => 'Spa & Treatment ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Thông báo nếu bạn đang dùng treatment da mạnh.', 'Tránh tự ý nặn mụn trước buổi chăm sóc.'],
                'suitableFor' => ['Khách muốn làm sạch và cấp ẩm nhẹ.', 'Khách mới bắt đầu chăm sóc da.', 'Khách cần tư vấn routine đơn giản.'],
                'expectedResults' => ['Da sạch và dịu hơn.', 'Bề mặt da mềm hơn.', 'Biết cách chăm sóc cơ bản tại nhà.'],
                'aftercare' => ['Dùng kem chống nắng ban ngày.', 'Tránh tẩy da chết mạnh trong 24 giờ đầu.'],
            ],
            [
                'slug' => 'combo-thu-gian-cuoi-tuan',
                'title' => 'Combo thư giãn cuối tuần',
                'description' => 'Phối hợp gội thư giãn, treatment và massage để có trải nghiệm đầy đủ hơn.',
                'longDescription' => 'Combo dành cho khách muốn dành nhiều thời gian hơn cho bản thân. Buổi hẹn kết hợp làm sạch tóc, chăm sóc thân tóc và massage thư giãn theo nhịp chậm.',
                'duration' => '120 phút',
                'price' => 'Từ 790.000đ',
                'images' => [$gallery['goi'][0], $gallery['spa'][1], $gallery['goi'][2]],
                'badges' => ['Phổ biến', 'Trọn gói'],
                'stylist' => 'Spa & Treatment ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Nên đặt lịch trước để salon chuẩn bị đủ thời gian.', 'Có thể điều chỉnh thứ tự dịch vụ theo tình trạng tóc.'],
                'suitableFor' => ['Khách muốn thư giãn cuối tuần.', 'Khách cần phục hồi tóc nhẹ.', 'Khách thích trải nghiệm chăm sóc trọn gói.'],
                'expectedResults' => ['Tóc sạch và mềm hơn.', 'Cơ thể thư giãn hơn.', 'Cảm giác được chăm sóc đầy đủ hơn.'],
                'aftercare' => ['Giữ tóc khô thoáng.', 'Duy trì lịch chăm sóc định kỳ nếu tóc khô hoặc yếu.'],
            ],
        ];

        return array_map(fn (array $service) => $service + [
            'bookingUrl' => route('booking', ['service' => $service['slug']]),
            'showUrl' => route('services.show', $service['slug']),
        ], $services);
    }

    public static function find(string $slug): ?array
    {
        foreach (static::all() as $service) {
            if ($service['slug'] === $slug) {
                return $service;
            }
        }

        return null;
    }

    public static function fromServiceModels(Collection $services): array
    {
        return $services
            ->map(fn (Service $service) => static::fromServiceModel($service))
            ->values()
            ->all();
    }

    public static function fromServiceModel(Service $service): array
    {
        $profile = static::serviceProfile($service);
        $slug = static::serviceSlug($service);

        return [
            'slug' => $slug,
            'title' => $service->service_name,
            'description' => $service->description ?: $profile['description'],
            'longDescription' => $service->description
                ? $service->description . ' Doi ngu ZenStyle se tu van them dua tren tinh trang thuc te truoc khi thuc hien.'
                : $profile['longDescription'],
            'duration' => $service->duration_minutes . ' phut',
            'price' => number_format((float) $service->price, 0, ',', '.') . 'd',
            'images' => $profile['images'],
            'badges' => $profile['badges'],
            'stylist' => $profile['stylist'],
            'process' => $profile['process'],
            'notes' => $profile['notes'],
            'suitableFor' => $profile['suitableFor'],
            'expectedResults' => $profile['expectedResults'],
            'aftercare' => $profile['aftercare'],
            'bookingUrl' => route('booking', ['service' => $slug]),
            'showUrl' => route('services.show', $slug),
        ];
    }

    public static function serviceSlug(Service $service): string
    {
        return Str::slug($service->service_name) . '-' . $service->id;
    }

    public static function homeGroupsFromServiceModels(Collection $services): array
    {
        return $services
            ->take(3)
            ->map(function (Service $service) {
                $profile = static::serviceProfile($service);

                return [
                    'title' => $service->service_name,
                    'description' => $service->description ?: $profile['description'],
                    'image' => $profile['images'][0],
                    'alt' => 'Dich vu ' . $service->service_name . ' tai ZenStyle',
                    'items' => [
                        $service->duration_minutes . ' phut',
                        number_format((float) $service->price, 0, ',', '.') . 'd',
                        ucfirst($service->status),
                    ],
                ];
            })
            ->values()
            ->all();
    }

    public static function staff(): array
    {
        return [
            [
                'name' => 'Nguyễn Minh An',
                'role' => 'Salon Director',
                'focus' => 'Tư vấn form tóc và trải nghiệm tổng thể',
                'image' => asset('images/tailadmin/user/user-01.jpg'),
            ],
            [
                'name' => 'Trần Lan Chi',
                'role' => 'Senior Stylist',
                'focus' => 'Layer, mullet và tạo kiểu cá nhân hóa',
                'image' => asset('images/tailadmin/user/user-02.jpg'),
            ],
            [
                'name' => 'Phạm Thu Hà',
                'role' => 'Spa & Treatment',
                'focus' => 'Gội thư giãn, treatment và chăm sóc da đầu',
                'image' => asset('images/tailadmin/user/user-03.jpg'),
            ],
        ];
    }

    public static function testimonials(): array
    {
        return [
            [
                'quote' => 'Tư vấn rất kỹ trước khi cắt, mình biết rõ tóc sẽ vào form thế nào sau khi về nhà.',
                'name' => 'Minh Khang',
                'service' => 'Cắt tóc nam cao cấp',
            ],
            [
                'quote' => 'Gói gội thư giãn vừa đủ lâu, không gian yên và tóc mềm hơn sau treatment.',
                'name' => 'Thu Nhi',
                'service' => 'Gội dưỡng sinh',
            ],
            [
                'quote' => 'Màu nhuộm lên vừa phải, team có dặn cách giữ màu nên sau vài tuần vẫn ổn.',
                'name' => 'Hoàng Anh',
                'service' => 'Nhuộm tone cơ bản',
            ],
        ];
    }

    private static function gallery(): array
    {
        return [
            'toc' => [
                asset('images/frontend/hottrend/hottrend-06.png'),
                asset('images/frontend/services/featured-toc.png'),
                asset('images/frontend/hottrend/hottrend-01.png'),
            ],
            'styling' => [
                asset('images/frontend/hottrend/hottrend-07.png'),
                asset('images/frontend/hottrend/hottrend-02.png'),
                asset('images/frontend/hottrend/hottrend-03.png'),
            ],
            'goi' => [
                asset('images/frontend/services/featured-spa.png'),
                asset('images/frontend/services/featured-goi.png'),
                asset('images/frontend/banner/Gemini_Generated_Image_ympfunympfunympf.png'),
            ],
            'mau' => [
                asset('images/frontend/banner/Gemini_Generated_Image_7sr4oq7sr4oq7sr4.png'),
                asset('images/frontend/banner/Gemini_Generated_Image_os1lsdos1lsdos1l.png'),
                asset('images/frontend/hottrend/hottrend-04.png'),
            ],
            'uon' => [
                asset('images/frontend/banner/Gemini_Generated_Image_7w6kln7w6kln7w6k.png'),
                asset('images/frontend/hottrend/hottrend-05.png'),
                asset('images/frontend/services/featured-toc.png'),
            ],
            'spa' => [
                asset('images/frontend/banner/Gemini_Generated_Image_kt0965kt0965kt09.png'),
                asset('images/frontend/services/featured-spa.png'),
                asset('images/frontend/services/featured-goi.png'),
            ],
        ];
    }

    private static function serviceProfile(Service $service): array
    {
        $name = Str::lower($service->service_name);
        $gallery = static::gallery();

        $defaultProcess = [
            'Buoc 1: Tu van nhu cau va tinh trang hien tai.',
            'Buoc 2: Thuc hien dich vu theo ky thuat phu hop.',
            'Buoc 3: Kiem tra ket qua va huong dan cham soc tai nha.',
        ];

        if (Str::contains($name, ['wash', 'goi', 'head massage', 'massage da dau'])) {
            return [
                'description' => 'Lam sach toc va da dau, ket hop massage nhe de thu gian.',
                'longDescription' => 'Dich vu tap trung vao cam giac sach, nhe dau va thu gian. Ky thuat vien dieu chinh luc massage theo phan hoi cua khach trong buoi lam.',
                'images' => $gallery['goi'],
                'badges' => ['Thu gian', 'Cham soc da dau'],
                'stylist' => 'Spa & Treatment ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Thong bao neu da dau nhay cam.', 'Nen giu toc kho thoang sau khi goi.'],
                'suitableFor' => ['Khach can lam sach toc nhanh.', 'Khach cang da dau hoac moi vai gay.', 'Khach muon thu gian truoc hoac sau khi cat toc.'],
                'expectedResults' => ['Toc sach va nhe hon.', 'Da dau de chiu hon.', 'Cam giac thu gian ro hon.'],
                'aftercare' => ['Han che doi mu qua lau ngay sau dich vu.', 'Dung san pham tao kieu vua du neu can giu nep.'],
            ];
        }

        if (Str::contains($name, ['color', 'nhuom', 'highlight', 'balayage'])) {
            return [
                'description' => 'Tu van mau theo nen toc, mau da va kha nang cham soc sau dich vu.',
                'longDescription' => 'Dich vu mau toc can danh gia nen toc truoc khi lam de chon cong thuc phu hop. Muc tieu la mau hai hoa voi tong the va co ke hoach giu mau tai nha.',
                'images' => $gallery['mau'],
                'badges' => ['Tu van mau', 'Can cham soc sau dich vu'],
                'stylist' => 'Color Specialist ZenStyle',
                'process' => ['Buoc 1: Kiem tra nen toc va lich su hoa chat.', 'Buoc 2: Chon tone mau, pha mau va xu ly theo nen toc.', 'Buoc 3: Xa mau, duong toc va huong dan giu mau.'],
                'notes' => ['Gia co the thay doi theo do dai va nen toc.', 'Nen bao truoc neu toc da tung tay hoac nhuom den.'],
                'suitableFor' => ['Khach muon lam moi mau toc.', 'Khach can mau toc hop mau da.', 'Khach muon che nen toc khong deu.'],
                'expectedResults' => ['Mau toc deu va sang tong hon.', 'Tong the moi me hon.', 'Toc co chieu sau hon.'],
                'aftercare' => ['Dung dau goi giu mau.', 'Han che nuoc qua nong.', 'Duong toc dinh ky neu toc kho.'],
            ];
        }

        if (Str::contains($name, ['treatment', 'phuc hoi', 'skin', 'facial', 'body scrub'])) {
            return [
                'description' => 'Cham soc phuc hoi cho toc, da hoac co the theo nhu cau thu gian.',
                'longDescription' => 'Dich vu cham soc giup cai thien cam giac kho, moi hoac thieu suc song. Ky thuat vien se tu van cach duy tri hieu qua sau buoi hen.',
                'images' => $gallery['spa'],
                'badges' => ['Phuc hoi', 'Cham soc nhe'],
                'stylist' => 'Spa & Treatment ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Thong bao neu ban dang dung treatment manh.', 'Hieu qua phu thuoc vao tinh trang ban dau.'],
                'suitableFor' => ['Khach can cham soc phuc hoi.', 'Khach muon thu gian sau ngay dai.', 'Khach moi bat dau routine cham soc.'],
                'expectedResults' => ['Cam giac mem va de chiu hon.', 'Be mat toc hoac da duoc cham soc tot hon.', 'Biet cach duy tri tai nha.'],
                'aftercare' => ['Duy tri san pham cham soc phu hop.', 'Han che tac dong nhiet hoac tay rua manh trong ngay dau.'],
            ];
        }

        if (Str::contains($name, ['nail', 'manicure', 'pedicure'])) {
            return [
                'description' => 'Cham soc mong gon gang, sach va phu hop sinh hoat hang ngay.',
                'longDescription' => 'Dich vu tap trung vao lam sach, tao dang va hoan thien mong theo phong cach gon nhe. Phu hop khi ban can mot dien mao chi tiet va chin chu hon.',
                'images' => [$gallery['spa'][1], $gallery['spa'][0], $gallery['goi'][0]],
                'badges' => ['Gon gang', 'Cham soc chi tiet'],
                'stylist' => 'Beauty Care ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Bao truoc neu mong yeu hoac da quanh mong nhay cam.', 'Nen tranh va cham manh ngay sau dich vu.'],
                'suitableFor' => ['Khach muon mong sach va gon.', 'Khach can chuan bi cho su kien.', 'Khach thich phong cach toi gian.'],
                'expectedResults' => ['Mong gon va sach hon.', 'Ban tay hoac ban chan nhin chin chu hon.', 'Cam giac thoai mai sau cham soc.'],
                'aftercare' => ['Duong am vung da quanh mong.', 'Han che tiep xuc hoa chat tay rua manh.'],
            ];
        }

        if (Str::contains($name, ['massage', 'spa'])) {
            return [
                'description' => 'Thu gian co the voi thoi luong vua du, tap trung vao cam giac nhe va de chiu.',
                'longDescription' => 'Dich vu massage giup giam cam giac cang moi nhe va tao khoang nghi ngan trong ngay. Luc massage duoc dieu chinh theo nhu cau cua khach.',
                'images' => $gallery['spa'],
                'badges' => ['Thu gian', 'Giam cang'],
                'stylist' => 'Spa & Treatment ZenStyle',
                'process' => $defaultProcess,
                'notes' => ['Khong thay the tu van y khoa neu dau keo dai.', 'Bao truoc vung can tranh hoac tien su chan thuong.'],
                'suitableFor' => ['Khach lam viec cang thang.', 'Khach can thu gian nhanh.', 'Khach thich cham soc co the nhe nhang.'],
                'expectedResults' => ['Co the nhe hon.', 'Tinh than thu gian hon.', 'Cam giac de chiu sau buoi hen.'],
                'aftercare' => ['Uong du nuoc.', 'Van dong nhe sau massage.'],
            ];
        }

        return [
            'description' => 'Tu van form toc, cat tao kieu va hoan thien styling phu hop voi khuon mat.',
            'longDescription' => 'Dich vu cat va tao kieu giup mai toc gon hon, ro form hon va de cham soc trong sinh hoat hang ngay. Stylist se tu van theo chat toc, khuon mat va thoi quen tao kieu cua ban.',
            'images' => $gallery['toc'],
            'badges' => ['Pho bien', 'Tu van form toc'],
            'stylist' => 'Senior Stylist ZenStyle',
            'process' => ['Buoc 1: Tu van khuon mat, chat toc va mong muon thay doi.', 'Buoc 2: Cat tao form va dieu chinh do dai phu hop.', 'Buoc 3: Say tao kieu, kiem tra tong the va huong dan cham soc.'],
            'notes' => ['Nen mang anh tham khao neu muon doi kieu ro ret.', 'Stylist se tu van san pham tao kieu phu hop neu can.'],
            'suitableFor' => ['Khach muon mai toc gon gang.', 'Khach can doi form toc de di hoc, di lam.', 'Khach muon kieu toc de tu cham tai nha.'],
            'expectedResults' => ['Toc vao form ro hon.', 'Tong the gon gang va sang hon.', 'De styling hang ngay hon.'],
            'aftercare' => ['Cat chinh form sau 3-6 tuan tuy toc moc.', 'Dung san pham tao kieu vua du de tranh nang toc.'],
        ];
    }
}

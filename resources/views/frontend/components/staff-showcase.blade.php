{{--
    =====================================================================
    COMPONENT: STAFF SHOWCASE
    =====================================================================
    - Hiển thị nhân viên với bố cục alternating (trái/phải)
    - Props: $staff (array), $reverse (boolean)
    =====================================================================
--}}
@php
    $staff = $staff ?? [
        [
            'name' => 'Nguyễn Thị Mai',
            'role' => 'Stylist Senior',
            'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?auto=format&fit=crop&w=400&q=80',
            'description' => 'Với 8 năm kinh nghiệm trong ngành tóc, Mai chuyên về cắt tóc hiện đại và nhuộm màu tự nhiên.',
            'specialties' => ['Cắt tóc', 'Nhuộm màu', 'Styling']
        ],
        [
            'name' => 'Trần Văn Hùng',
            'role' => 'Chuyên viên Spa',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
            'description' => 'Hùng là chuyên gia massage và trị liệu, giúp khách hàng thư giãn và tái tạo năng lượng.',
            'specialties' => ['Massage', 'Trị liệu', 'Spa']
        ]
    ];
@endphp

<section class="py-20 {{ $bg ?? 'bg-white' }}">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mb-16 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-stone-900">Đội ngũ chuyên nghiệp</h2>
            <p class="mt-4 text-lg text-stone-600 max-w-2xl mx-auto">
                Gặp gỡ những stylist và chuyên viên tận tâm của chúng tôi
            </p>
        </div>

        @foreach($staff as $index => $member)
            @php
                $isEven = $index % 2 === 0;
                $reverse = ($reverse ?? false) ? !$isEven : $isEven;
            @endphp

            <div class="mb-20 last:mb-0 {{ $reverse ? 'lg:flex-row-reverse' : 'lg:flex-row' }} flex flex-col lg:items-center gap-12 lg:gap-16">
                {{-- Ảnh nhân viên --}}
                <div class="flex-1">
                    <div class="relative">
                        <img
                            src="{{ $member['image'] }}"
                            alt="{{ $member['name'] }}"
                            class="w-full max-w-md mx-auto lg:max-w-none rounded-2xl shadow-lg object-cover aspect-[4/5]"
                            loading="lazy"
                        />
                        <div class="absolute -bottom-4 -right-4 bg-rose-400 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            {{ $member['role'] }}
                        </div>
                    </div>
                </div>

                {{-- Thông tin nhân viên --}}
                <div class="flex-1 text-center lg:text-left">
                    <h3 class="text-2xl sm:text-3xl font-bold text-stone-900 mb-4">
                        {{ $member['name'] }}
                    </h3>

                    <p class="text-stone-600 text-lg leading-relaxed mb-6">
                        {{ $member['description'] }}
                    </p>

                    {{-- Chuyên môn --}}
                    <div class="mb-8">
                        <h4 class="text-sm font-semibold text-stone-700 uppercase tracking-wide mb-3">
                            Chuyên môn
                        </h4>
                        <div class="flex flex-wrap gap-2 justify-center lg:justify-start">
                            @foreach($member['specialties'] as $specialty)
                                <span class="inline-block bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $specialty }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- CTA --}}
                    <a
                        href="#dat-lich"
                        class="inline-flex items-center rounded-full bg-stone-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-stone-800"
                    >
                        Đặt lịch với {{ explode(' ', $member['name'])[0] }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

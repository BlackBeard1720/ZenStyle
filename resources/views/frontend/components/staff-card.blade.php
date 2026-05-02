{{--
    =====================================================================
    COMPONENT: STAFF CARD (Single)
    =====================================================================
    - Component nhỏ hơn cho 1 nhân viên
    - Có thể dùng trong grid hoặc list
    =====================================================================
--}}
@php
    $name = $name ?? 'Tên nhân viên';
    $role = $role ?? 'Chức vụ';
    $image = $image ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b786?auto=format&fit=crop&w=400&q=80';
    $description = $description ?? 'Mô tả ngắn về nhân viên';
    $specialties = $specialties ?? ['Chuyên môn 1', 'Chuyên môn 2'];
@endphp

<article class="group rounded-2xl bg-white p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-stone-100">
    <div class="text-center">
        <div class="relative mb-4">
            <img
                src="{{ $image }}"
                alt="{{ $name }}"
                class="w-24 h-24 rounded-full mx-auto object-cover ring-4 ring-rose-100 group-hover:ring-rose-200 transition-colors"
                loading="lazy"
            />
            <div class="absolute -bottom-1 -right-1 bg-rose-400 text-white px-2 py-1 rounded-full text-xs font-semibold">
                {{ $role }}
            </div>
        </div>

        <h3 class="text-lg font-semibold text-stone-900 mb-2">{{ $name }}</h3>

        <p class="text-stone-600 text-sm leading-relaxed mb-4 line-clamp-3">
            {{ $description }}
        </p>

        <div class="flex flex-wrap gap-1 justify-center mb-4">
            @foreach(array_slice($specialties, 0, 2) as $specialty)
                <span class="inline-block bg-rose-50 text-rose-600 px-2 py-1 rounded text-xs font-medium">
                    {{ $specialty }}
                </span>
            @endforeach
        </div>

        <a
            href="#dat-lich"
            class="inline-block text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors"
        >
            Đặt lịch →
        </a>
    </div>
</article>

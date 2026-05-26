<x-staff.layout
    title="404 Dashboard Error Page"
    page-name="page404"
    :show-header-side="false"
>
    <!-- ===== Preloader Start ===== -->
    <x-staff.partials.preloader />
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="relative z-1 flex min-h-screen flex-col items-center justify-center overflow-hidden p-6">
        <!-- ===== Common Grid Shape Start ===== -->
        <x-staff.partials.common-grid-shape />
        <!-- ===== Common Grid Shape End ===== -->

        <!-- Centered Content -->
        <div class="mx-auto w-full max-w-[242px] text-center sm:max-w-[472px]">
            <h1 class="mb-8 text-title-md font-bold text-gray-800 dark:text-white/90 xl:text-title-2xl">
              {{ $heading ?? 'ERROR' }}
            </h1>

            @if(($code ?? 404) === 404)
              <img src="{{ asset('images/tailadmin/error/404.svg') }}" alt="404" class="dark:hidden mx-auto"/>
              <img src="{{ asset('images/tailadmin/error/404-dark.svg') }}" alt="404" class="hidden dark:block mx-auto"/>
            @else
              <div class="text-7xl font-bold text-gray-800 dark:text-white/90">
                {{ $code ?? 'Error' }}
              </div>
            @endif

            <p class="mb-6 mt-10 text-base text-gray-700 dark:text-gray-400 sm:text-lg">
              {{ $message ?? 'Something went wrong.' }}
            </p>

            <a
                    href="{{ route('staff.dashboard') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
            >
                Back to Home Page
            </a>
        </div>

        <!-- Footer -->
        <p class="absolute bottom-6 left-1/2 -translate-x-1/2 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; <span id="year"></span> - TailAdmin
        </p>
    </div>
    <!-- ===== Page Wrapper End ===== -->

    @push('scripts')
        <script>
            document.getElementById('year').textContent = new Date().getFullYear();
        </script>
    @endpush
</x-staff.layout>

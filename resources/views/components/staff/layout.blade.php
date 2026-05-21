@props([
  'title' => 'TailAdmin',
  'pageName' => 'ecommerce',
  'showHeaderSide' => true
 ])

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    @vite(['resources/css/staff.css', 'resources/js/staff/index.js'])
</head>
<body
    x-data="{ page: '{{ $pageName }}', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
>
    <!-- ===== Preloader Start ===== -->
    <x-staff.partials.preloader />
    <!-- ===== Preloader End ===== -->
    @if($showHeaderSide)
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <x-staff.partials.sidebar />
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div
                class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
        >
            <!-- Small Device Overlay Start -->
            <x-staff.partials.overlay />
            <!-- Small Device Overlay End -->

            <!-- ===== Header Start ===== -->
            <x-staff.partials.header />
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

                    <!-- Alert Messages Start -->
                    <!-- Success Message -->
                    <x-staff.partials.alert.alert-success />
                    <!-- Error Message -->
                    <x-staff.partials.alert.alert-error />
                    <!-- Alert Messages End -->
                    {{ $slot }}
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
    @else
      {{ $slot }}
    @endif
    @php
        $firebaseConfig = [
            'apiKey' => config('services.firebase.api_key'),
            'authDomain' => config('services.firebase.auth_domain'),
            'projectId' => config('services.firebase.project_id'),
            'storageBucket' => config('services.firebase.storage_bucket'),
            'messagingSenderId' => config('services.firebase.messaging_sender_id'),
            'appId' => config('services.firebase.app_id'),
        ];

        $hasFirebaseConfig = $showHeaderSide
            && config('services.firebase.vapid_key')
            && collect($firebaseConfig)->every(fn ($value) => filled($value));
    @endphp

    @if($hasFirebaseConfig)
      @once
        <script src="https://www.gstatic.com/firebasejs/10.12.4/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/10.12.4/firebase-messaging-compat.js"></script>

        <script>
          const firebaseConfig = {{ \Illuminate\Support\Js::from($firebaseConfig) }};
          const firebaseVapidKey = {{ \Illuminate\Support\Js::from(config('services.firebase.vapid_key')) }};

          firebase.initializeApp(firebaseConfig);

          const messaging = firebase.messaging();

          messaging.onMessage((payload) => {
            console.log('Foreground message:', payload);

            showFcmInfoToast(
              payload.notification?.title || 'ZenStyle Notification',
              payload.notification?.body || '',
              payload.data?.url || null
            );
          });

          async function initFcm() {
            try {
              if (!('serviceWorker' in navigator)) {
                console.log('Service Worker is not supported.');
                return;
              }

              const permission = await Notification.requestPermission();

              if (permission !== 'granted') {
                console.log('Notification permission denied.');
                return;
              }

              await navigator.serviceWorker.register('/firebase-messaging-sw.js');

              const readyRegistration = await navigator.serviceWorker.ready;

              console.log('Service Worker ready:', readyRegistration);

              const token = await messaging.getToken({
                serviceWorkerRegistration: readyRegistration,
                vapidKey: firebaseVapidKey
              });

              if (!token) {
                console.log('No FCM token received.');
                return;
              }

              await fetch("{{ route('staff.fcm-token.store') }}", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                  token: token,
                  device_type: 'web'
                })
              });

              console.log('FCM token saved.');
            } catch (error) {
              console.error('FCM error:', error);
            }
          }

          function showFcmInfoToast(title, body, url = null) {
            const oldToast = document.getElementById('fcm-info-toast');

            if (oldToast) {
              oldToast.remove();
            }

            const toast = document.createElement('div');
            toast.id = 'fcm-info-toast';
            toast.className =
              'fixed right-5 top-5 z-[999999] w-[360px] max-w-[calc(100vw-2rem)] ' +
              'rounded-xl border border-blue-light-500 bg-blue-light-50 p-4 shadow-2xl ' +
              'dark:border-blue-light-500/30 dark:bg-blue-light-500/15 ' +
              'transition-all duration-300 ease-out translate-x-full opacity-0';

            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-start gap-3';

            const iconWrap = document.createElement('div');
            iconWrap.className = '-mt-0.5 text-blue-light-500';
            iconWrap.innerHTML =
              '<svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
              '<path fill-rule="evenodd" clip-rule="evenodd" d="M3.6501 11.9996C3.6501 7.38803 7.38852 3.64961 12.0001 3.64961C16.6117 3.64961 20.3501 7.38803 20.3501 11.9996C20.3501 16.6112 16.6117 20.3496 12.0001 20.3496C7.38852 20.3496 3.6501 16.6112 3.6501 11.9996ZM12.0001 1.84961C6.39441 1.84961 1.8501 6.39392 1.8501 11.9996C1.8501 17.6053 6.39441 22.1496 12.0001 22.1496C17.6058 22.1496 22.1501 17.6053 22.1501 11.9996C22.1501 6.39392 17.6058 1.84961 12.0001 1.84961ZM10.9992 7.52468C10.9992 8.07697 11.4469 8.52468 11.9992 8.52468H12.0002C12.5525 8.52468 13.0002 8.07697 13.0002 7.52468C13.0002 6.9724 12.5525 6.52468 12.0002 6.52468H11.9992C11.4469 6.52468 10.9992 6.9724 10.9992 7.52468ZM12.0002 17.371C11.586 17.371 11.2502 17.0352 11.2502 16.621V10.9445C11.2502 10.5303 11.586 10.1945 12.0002 10.1945C12.4144 10.1945 12.7502 10.5303 12.7502 10.9445V16.621C12.7502 17.0352 12.4144 17.371 12.0002 17.371Z" fill=""></path>' +
              '</svg>';

            const content = document.createElement('div');
            content.className = 'min-w-0 flex-1';

            const heading = document.createElement('h4');
            heading.className = 'mb-1 text-sm font-semibold text-gray-800 dark:text-white/90';
            heading.textContent = title || 'ZenStyle Notification';

            const message = document.createElement('p');
            message.className = 'text-sm text-gray-500 dark:text-gray-400';
            message.textContent = body || '';

            content.appendChild(heading);
            content.appendChild(message);

            if (url) {
              const detailLink = document.createElement('a');
              detailLink.href = url;
              detailLink.className = 'mt-3 inline-block text-sm font-medium text-gray-500 underline dark:text-gray-400';
              detailLink.textContent = 'View details';
              content.appendChild(detailLink);
            }

            const closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200';
            closeButton.setAttribute('aria-label', 'Close notification');
            closeButton.textContent = 'x';

            wrapper.appendChild(iconWrap);
            wrapper.appendChild(content);
            wrapper.appendChild(closeButton);
            toast.appendChild(wrapper);

            document.body.appendChild(toast);

            requestAnimationFrame(() => {
              toast.classList.remove('translate-x-full', 'opacity-0');
            });

            closeButton.addEventListener('click', () => {
              hideFcmInfoToast(toast);
            });

            setTimeout(() => {
              hideFcmInfoToast(toast);
            }, 5000);
          }

          function hideFcmInfoToast(toast) {
            toast.classList.add('translate-x-full', 'opacity-0');

            setTimeout(() => {
              toast.remove();
            }, 300);
          }

          initFcm();
        </script>
      @endonce
    @endif
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    @stack('scripts')
</body>
</html>

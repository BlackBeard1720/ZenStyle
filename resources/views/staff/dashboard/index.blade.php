<x-staff.layout
    title="Dashboard"
    page-name="dashboard"
>
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <!-- Metric Group One -->
            <x-staff.partials.metric-group.metric-group-01 />
            <!-- Metric Group One -->

            <!-- ====== Chart One Start -->
            <x-staff.partials.chart.chart-01 />
            <!-- ====== Chart One End -->
        </div>
        <div class="col-span-12 xl:col-span-5">
            <!-- ====== Chart Two Start -->
            <x-staff.partials.chart.chart-02 />
            <!-- ====== Chart Two End -->
        </div>

        <div class="col-span-12">
            <!-- ====== Chart Three Start -->
            <x-staff.partials.chart.chart-03 />
            <!-- ====== Chart Three End -->
        </div>

        <div class="col-span-12 xl:col-span-5">
            <!-- ====== Map One Start -->
            <x-staff.partials.map-01 />
            <!-- ====== Map One End -->
        </div>

        <div class="col-span-12 xl:col-span-7">
            <!-- ====== Table One Start -->
            <x-staff.partials.table.table-01 />
            <!-- ====== Table One End -->
        </div>
    </div>

  @push('scripts')
    <script src="https://www.gstatic.com/firebasejs/10.12.4/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.12.4/firebase-messaging-compat.js"></script>

    <script>
      const firebaseConfig = {{ \Illuminate\Support\Js::from([
        'apiKey' => config('services.firebase.api_key'),
        'authDomain' => config('services.firebase.auth_domain'),
        'projectId' => config('services.firebase.project_id'),
        'storageBucket' => config('services.firebase.storage_bucket'),
        'messagingSenderId' => config('services.firebase.messaging_sender_id'),
        'appId' => config('services.firebase.app_id'),
      ]) }};
      const firebaseVapidKey = {{ \Illuminate\Support\Js::from(config('services.firebase.vapid_key')) }};

      firebase.initializeApp(firebaseConfig);

      const messaging = firebase.messaging();

      async function initFcm() {
        try {
          const permission = await Notification.requestPermission();

          if (permission !== 'granted') {
            console.log('Notification permission denied.');
            return;
          }

          const token = await messaging.getToken({
            vapidKey: firebaseVapidKey
          });

          if (!token) {
            console.log('No FCM token received.');
            return;
          }

          console.log('FCM token:', token);

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

      messaging.onMessage((payload) => {
        console.log('Foreground message:', payload);

        alert(
          (payload.notification?.title || 'ZenStyle') +
          '\n' +
          (payload.notification?.body || '')
        );
      });

      initFcm();
    </script>
  @endpush
</x-staff.layout>

importScripts('https://www.gstatic.com/firebasejs/10.12.4/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.4/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyCVNqUKc1zhBsnjTnxNcdwe8Za9st8WqZg",
    authDomain: "zenstyle-fcm.firebaseapp.com",
    projectId: "zenstyle-fcm",
    storageBucket: "zenstyle-fcm.firebasestorage.app",
    messagingSenderId: "404979883495",
    appId: "1:404979883495:web:4b9e545b1603831593b142"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    const title = payload.notification?.title || 'ZenStyle Notification';
    const options = {
        body: payload.notification?.body || '',
        icon: '/favicon.ico',
    };

    self.registration.showNotification(title, options);
});

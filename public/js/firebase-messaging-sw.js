/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyDzrxEIhsauxwVv_eiOPhOF_F5AGO2Q0Gk",
    authDomain: "web-push-notification-df81c.firebaseapp.com",
    databaseURL: "https://web-push-notification-df81c.firebaseio.com",
    projectId: "web-push-notification-df81c",
    storageBucket: "web-push-notification-df81c.appspot.com",
    messagingSenderId: "352665387852",
    appId: "1:352665387852:web:d9e2699659f543fcb885e9",
    measurementId: "G-L1T9HTS9TR"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});

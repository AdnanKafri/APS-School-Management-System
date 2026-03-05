importScripts('https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js');

const firebaseConfig = {
  apiKey: "AIzaSyBsViQf5LtwHoXguoeTnK8uh6j2QClMwug",
  authDomain: "smart-syrian-school.firebaseapp.com",
  projectId: "smart-syrian-school",
  storageBucket: "smart-syrian-school.appspot.com",
  messagingSenderId: "796754541605",
  appId: "1:796754541605:web:f7c216799d251a563f93cc",
  measurementId: "G-N5SHZKZZ4W"
};

firebase.initializeApp(firebaseConfig);
const messaging=firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(payload);
    const notification=JSON.parse(payload);
    const notificationOption={
        body:notification.body,
        icon:notification.icon
    };
    return self.registration.showNotification(payload.notification.title,notificationOption);
});
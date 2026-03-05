const serverPublicKey = "AAAAyfXR9n8:APA91bEEMRnjKp9o9TEdrdZkdke-rawX6XoVYp2TFgVLXQQo-dMvw5LmYcJr_-f42uFBjrFa_kY5ef0MUi6Rlkuq0vysZoR3KQ_Gu1kVy1PjLHBkcR2fVsPE_zMwQLw6uoUMv11nVCT6";

var firebaseConfig = {
    apiKey: "AIzaSyC41CgZFGhJYbZ8wJ_ggatj-7obsYpZQoo",
    authDomain: "wmspos-f7826.firebaseapp.com",
    databaseURL: "https://wmspos-f7826.firebaseio.com",
    projectId: "wmspos-f7826",
    storageBucket: "wmspos-f7826.appspot.com",
    messagingSenderId: "867412604543",
    appId: "1:867412604543:web:0f9e40295ab5f8a5b9314a",
    measurementId: "G-ZTMF63LKVX"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();

    const messaging = firebase.messaging();
    messaging.usePublicVapidKey("BAX19O0lz7eQl_uq86mgmlSD6Tuq5BqAITND9h4D3RvUSwzFkrZtHEV9xIcfFt7OyaaNAN2sm0z2CVwg4vLeA5k");
    
function requestPermission() {
    console.log('Requesting permission...');
    // [START request_permission]
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        console.log('Notification permission granted.');
        // TODO(developer): Retrieve an Instance ID token for use with FCM.
        // [START_EXCLUDE]
        // In many cases once an app has been granted notification permission,
        // it should update its UI reflecting this.
        resetUI();
        // [END_EXCLUDE]
      } else {
        console.log('Unable to get permission to notify.');
      }
    });
    // [END request_permission]
  }
  
firebase.messaging().getToken()
  .then(fcmToken => {
    if (fcmToken) {
        console.log(fcmToken);
        sendAJAX(fcmToken);
    } else {
      // user doesn't have a device token yet
    }
  });

// messaging.onMessage(function (payload) {
//     console.log("Message received. ", payload);
//     toastr.success( 'You have new order','Crunchys Food Resturant')
// });
messaging.onTokenRefresh(() => {
    messaging.getToken().then((refreshedToken) => {
      console.log('Token refreshed.');
      // Indicate that the new Instance ID token has not yet been sent to the
      // app server.
      setTokenSentToServer(false);
      // Send Instance ID token to app server.
      setTokenSentToServer(false);
      sendAJAX(refreshedToken);
      // [START_EXCLUDE]
      // Display new Instance ID token and clear UI of all previous messages.
      resetUI();
      // [END_EXCLUDE]
    }).catch((err) => {
      console.log('Unable to retrieve refreshed token ', err);
    });
  });
  
  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
  }
  function sendTokenToServer(currentToken) {
    if (!isTokenSentToServer()) {
      console.log('Sending token to server...');
      // TODO(developer): Send the current token to your server.
      setTokenSentToServer(true);
    } else {
      console.log('Token already sent to server so won\'t send it again ' +
          'unless it changes');
    }

  }
  function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
  }
  function isTokenSentToServer() {
    return window.localStorage.getItem('sentToServer') === '1';
  }
  function resetUI() {
    showToken('loading...');
    // [START get_token]
    // Get Instance ID token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken().then((currentToken) => {
      if (currentToken) {
        sendTokenToServer(currentToken);
        updateUIForPushEnabled(currentToken);
      } else {
        // Show permission request.
        console.log('No Instance ID token available. Request permission to generate one.');
        // Show permission UI.
        updateUIForPushPermissionRequired();
        setTokenSentToServer(false);
      }
    }).catch((err) => {
      console.log('An error occurred while retrieving token. ', err);
      showToken('Error retrieving Instance ID token. ', err);
      setTokenSentToServer(false);
    });
    // [END get_token]
  }



function sendAJAX(token) {
    $.post(fcm_update_url, {
        token: token,
        user_id: user_id
    });
}
//resetUI();

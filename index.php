<!DOCTYPE html>
<html lang="en">

<head>
     <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-analytics.js"></script>

     <?php include 'add/head.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/collapse.css">
	<link rel="stylesheet" type="text/css" href="css/grid.css"> 
    <title>UNIFOCUS - For NTU EEE Part Timers</title>
</head>
<body>
    <?php include 'add/nav.php'; ?>
    
    <div class=content>
    <h1>WELCOME TO UNIFOCUS</h1>
    <br>
    <br>
    <br>
    <br>
    <p>Select one of the features above.</p>
</div>
    <?php include 'add/footer.php'; ?>
</body>

</html>



<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyC2AbdgChOEsBC1ycSb5CGkdV0zNUpsQtw",
    authDomain: "unifocus.firebaseapp.com",
    databaseURL: "https://unifocus.firebaseio.com",
    projectId: "unifocus",
    storageBucket: "unifocus.appspot.com",
    messagingSenderId: "589648432516",
    appId: "1:589648432516:web:2afd60eae4146d8898e1d1",
    measurementId: "G-V4XF0PSBQ0"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>

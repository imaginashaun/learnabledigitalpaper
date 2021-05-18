<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="icon" href="/favicond.ico">

    <title>Learnable</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ secure_asset(mix('css/main.css')) }}">
    <link rel="stylesheet" href="{{ secure_asset(mix('css/iconfont.css')) }}">
    <link rel="stylesheet" href="{{ secure_asset(mix('css/material-icons/material-icons.css')) }}">
    <link rel="stylesheet" href="{{ secure_asset(mix('css/vuesax.css')) }}">
    <link rel="stylesheet" href="{{ secure_asset(mix('css/prism-tomorrow.css')) }}">
    <link rel="stylesheet" href="{{ secure_asset(mix('css/app.css')) }}">
    <!-- Favicon -->


      <script>
          var chat_appid = '55517';
          var chat_auth = '309381e0cf4f2cf070cef617731568a1';
          var chat_id = ''; // Intentionally left blank
          var chat_name = ''; // Intentionally left blank
          var chat_avatar = ''; // Intentionally left blank
          var chat_link = ''; // Intentionally left blank
          var chat_height = '80vh';
          var chat_width = '100%';
          var chat_iframe = {}; // Intentionally left blank
      </script>


  </head>
  <body>
    <noscript>
      <strong>We're sorry but Learnable  - Learnable doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>

    <div id="app">
    </div>

    <!-- <script src="js/app.js"></script> -->
    <script src="{{ secure_asset(mix('js/app.js')) }}"></script>

  </body>
</html>

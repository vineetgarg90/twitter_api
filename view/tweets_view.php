<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Twitter Client</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style/style.css">
  </head>
  <body>
    <div id='header'>
      <h2>Tweets with #custserv</h2>
      <img src="<?php echo $user['profile_image_url']; ?>">
      <label><?php echo $user['name']; ?> <small><a href="<?php echo "http://twitter.com/".$user['screen_name']; ?>">@<?php echo $user['screen_name']; ?></a></small></label>
      <a class='btn' href="./disconnect.php">Disconnect</a><br>
    </div>
    <div id='tweet_container'>
       <!-- tweets will be loaded via ajax -->
       <img class='loader' src="images/ajax-loader.gif"> Loading tweets...
    </div>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <!-- script to load tweets via ajax -->
  <script type="text/javascript" src='js/main.js'></script>
  </body>
</html>

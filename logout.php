<?php
 require_once __DIR__ . '/vendor/autoload.php';

  if(!session_id()) {
    session_start();
  } 

$fb = new Facebook\Facebook([
  'app_id' => '679596702193924', // Replace {app-id} with your app id
  'app_secret' => 'cdd86f172099af5d0f2376422ca444f6',
  'default_graph_version' => 'v2.2',
  ]);

  $url = 'http://www.facebook.com/logout.php?next=http://www.sheerforcestudios.com/PK/Index.php/&access_token='.$_SESSION['fb_access_token'];
  session_destroy();
  header('Location: '.$url);
?>
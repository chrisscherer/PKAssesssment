<?php 
  if(!session_id()) {
    session_start();
  }
?>

<html style="background: black;">
 <head>
  <script src="./three.min.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
  <script src="./helvetiker_regular.typeface.js"></script>
  <script src="./ThreeJS.js" type="text/javascript"></script>

  <title>PHP Test</title>
 </head>
 <body>
  <div style="background:gray; width: 100%; margin: auto;" id="Title">
    <?php 
 require_once __DIR__ . '/vendor/autoload.php';

//COPIED FROM FACEBOOK API
 $fb = new Facebook\Facebook([
  'app_id' => '679596702193924', // Replace {app-id} with your app id
  'app_secret' => 'cdd86f172099af5d0f2376422ca444f6',
  'default_graph_version' => 'v2.2',
  ]);

 $helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://www.sheerforcestudios.com/PK/fb-callback.php', $permissions);

if($_SESSION['fb_access_token']){
    try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=id,name', $_SESSION['fb_access_token']);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

  $user = $response->getGraphUser();

  echo 'Welcome ' . $user['name'] . '!';
}

  echo "\r\n";
  if($_SESSION['fb_access_token']){
    echo '<a href="logout.php">Log out of Facebook!</a> ';
  }
  else{
    echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
  }
 ?> 
//NOT COPIED FROM FACEBOOK API FROM HERE ON
  <h2 style="display: inline; margin:auto; text-align:center;">Welcome to the lottery, it's totally a responsible choice!</h2>
</div>

<?php if($user) : ?>
    <script>
      var myThreeCanvas = new THREECanvas();

      function IncrementWheel(i){
        myThreeCanvas.rotateNumberWheel(i, 1);
      }

      function DecrementWheel(i){
        myThreeCanvas.rotateNumberWheel(i, -1);
      }

      function Random(){
        myThreeCanvas.random();
      }

      function GetTicket(){
        return myThreeCanvas.getTicketNumber();
      }

      function SaveTicket(){
        var powerBallNumber = $('#PB_NUM').val();
        console.log(powerBallNumber);
        if(powerBallNumber != undefined && powerBallNumber != "")
          document.location = "TouchTicket.php?TicketNumber=" + GetTicket() + powerBallNumber;
        else
          $('#PB_NUM').css('background', 'red');
      }
  </script>
  <div id="Controls">
    <div style="display:inline; padding: 0px 50px;">
      <button onclick="IncrementWheel(0);">+</button>
      <button onclick="DecrementWheel(0);">-</button>
    </div>

    <div style="display:inline; padding: 0px 50px;">
      <button onclick="IncrementWheel(1);">+</button>
      <button onclick="DecrementWheel(1);">-</button>
    </div>

    <div style="display:inline; padding: 0px 50px;">
      <button onclick="IncrementWheel(2);">+</button>
      <button onclick="DecrementWheel(2);">-</button>
    </div>

    <div style="display:inline; padding: 0px 50px;">
      <button onclick="IncrementWheel(3);">+</button>
      <button onclick="DecrementWheel(3);">-</button>
    </div>

    <div style="display:inline; padding: 0px 50px;">
      <button onclick="IncrementWheel(4);">+</button>
      <button onclick="DecrementWheel(4);">-</button>
    </div>

    <div style="display:inline; padding: 0px 50px; color: white;">
      POWER BALL # <input id="PB_NUM" type="text" name="pb_num"><br>
    </div>
  </div>
<div>
  <button style="width: 50%" onclick="Random();">Random!</button>
  <button style="width: 50%" onclick="SaveTicket();">Submit Ticket!</button>
</div>
<?php endif; ?>
 
 </body>
</html>
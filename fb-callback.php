<?php 
  if(!session_id()) {
    session_start();
  } 
?>
<?php
 require_once __DIR__ . '/vendor/autoload.php';

//Enable error reporting to the browser
error_reporting(E_ALL);
ini_set('display_errors', 'on');


//THIS IS ALL COPIED FROM THE FACEBOOK API
$fb = new Facebook\Facebook([
  'app_id' => '679596702193924', // Replace {app-id} with your app id
  'app_secret' => 'cdd86f172099af5d0f2376422ca444f6',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);
$user_id = $tokenMetadata->getUserId();


// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('679596702193924'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }
}

$_SESSION['fb_access_token'] = (string) $accessToken;
$_SESSION['user_id'] = (string) $user_id;

$response = $fb->get('/me?fields=id,name', $_SESSION['fb_access_token']);
$user_name = $response->getGraphUser()['name'];

//REST IS NOT COPIED
include 'Data.php';

$user_exists = ResultQuery("SELECT * FROM `Users` WHERE `User_Id` = $user_id")->num_rows >= 1;

if(!$user_exists){
  Query("INSERT INTO `Users` (`User_Id`, `Username`) VALUES ($user_id, $user_name)");
}

header('Location: http://www.sheerforcestudios.com/PK/Index.php');
?>
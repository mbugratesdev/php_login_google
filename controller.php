<?php

require_once 'core/controller.Class.php';
require_once 'config.php';

if (isset($_GET['code'])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
} else {
    header('Location: index.php');
    exit();
}

// Make sure there is no error
if (!isset($token['error'])) {

    // Initialize service object
    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();

    // Show user data
    // echo '<pre>';
    // var_dump($userData);
    // echo '</pre>';

    $Controller = new Controller();
    echo $Controller->insertData(array(
        'email' => $userData['email'],
        'avatar' => $userData['picture'],
        'familyName' => $userData['familyName'],
        'givenName' => $userData['givenName'],
    ));

}else{
    header('Location: index.php');
    exit();
}
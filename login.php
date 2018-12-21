<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/vlucas/phpdotenv/src/loader.php';
 
use Auth0\SDK\Auth0;
 
$auth0 = new Auth0([
  'domain' => "earthwake.auth0.com",
    'client_id' => "QUsrbuajbeebRc8vy5oWOaow21q2CKFy",
    'client_secret' => "so3pWkP9zyteAvYyrQAyk3_hzOIU0v01AjxKm6A7PEzP-ZFyeftOTT1ZJep6YhUZ",
    'redirect_uri' => "https://localhost/progif/earthwake.php/",
    'audience' => "https://earthwake.auth0.com/userinfo/",
    'scope' => 'openid profile',
    'persist_id_token' => true,
    'persist_access_token' => true,
    'persist_refresh_token' => true,
]);
 
$auth0->login();

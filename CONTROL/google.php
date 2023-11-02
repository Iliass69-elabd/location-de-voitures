<?php
require_once '../vendor/autoload.php';


// init configuration
$clientID = '576751140860-jbtfr1bc20nckhvs73alb5e7inseikhp.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrideux = 'http://localhost/location-des-voitures/view/cars_page.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUrideux);
$client->addScope("email");
$client->addScope("profile");


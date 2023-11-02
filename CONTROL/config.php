<?php
    require_once "../vendor/stripe/stripe-php/init.php";

    $keys = $c->stripe();
    $all = $keys->fetch();
    $stripeDetails = array(
        "secretKey" => $all["secretKey"],
        "publishableKey" => $all["publishableKey"]
    );
   
    \Stripe\Stripe::setApiKey($stripeDetails["secretKey"]);
?>
<?php
ini_set('display_errors', 1);
require_once 'share/TwitterAPIExchange.php';

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'consumer_key' => "1ZtKHIhtn2ywoPZKhCFYbgW58",
    'consumer_secret' => "hzza9CUaMuZCqueeZKZ2b5eQlMC7K9SocmxeVvinFfg0PAJBzE",
    'oauth_access_token' => "251892464-U6ReW6Cepie0EgJWyDdjM8gCIOLU9x21CbARe1tM",
    'oauth_access_token_secret' => "I983GbmZJEAkfhFfcwsBQdY0XdeybUDQWUt1Vv7KCH1dq",
);


/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q="programa+sumar"+OR+"plan+nacer"+OR+"Martín+Sabignoso"-Zacatecas&count=5';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);

$response = $twitter->setGetfield($getfield)
               ->buildOauth($url, $requestMethod)
               ->performRequest();
               
//var_dump ($response);
return json_decode($response, $assoc = TRUE);



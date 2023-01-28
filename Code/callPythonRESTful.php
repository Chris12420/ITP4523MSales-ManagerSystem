<?php
// libcurl — transfer library that sends HTTP requests
// check if library curl is enabled
if (!extension_loaded("curl")) {
  die("enable library curl first");
}

// $para1 = "3001";
$url = "http://127.0.0.1:8080/api/discountCalculator/$para1";   # URL is to make GET request to Python RESTful API

// Initializes a new cURL session
$curl = curl_init($url);   # Initialize a cURL session
// to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);   # Perform a cURL session
curl_close($curl);

// Assume response data is in JSON format
$data = json_decode($response, true);
extract($data);
//var_dump($data);



/*
Output on browser is :
array (size=2)
  'para1' => string 'apple' (length=5)
  'para2' => string '30' (length=2)
*/
?>
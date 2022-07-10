<?php
$client_id ='1000.H87EAYDX4EGJBWUUCXWBKF36BCBZQM';
$client_secret = '57f5025e588e83bb14f8bf40377687de43d8f84a92';
$code = '1000.8b70b9365cf4f6098b5f51ce813228d3.edea61ee9a468c128c40c4363719a4a9';
$base_acc_url = 'https://a...content-available-to-author-only...o.in';
$service_url = 'https://c...content-available-to-author-only...o.in';
 
$refresh_token = '1000.122b3de75a9a67251ba9524ee3378440.0d4079b73da4b4597db4d253e45aad7c';
 
$token_url = $base_acc_url . '/oauth/v2/token?grant_type=authorization_code&client_id='. $client_id . '&client_secret='. $client_secret . '&redirect_uri=http://localhost&code=' . $code;
 
//generate_refresh_token($token_url);
 
function generate_access_token($url){
 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  $result = curl_exec($ch);
  curl_close($ch);
  return json_decode($result)->access_token;
}
 
$access_token_url = $base_acc_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';
 
$access_token = generate_access_token($access_token_url);
print($access_token);
create_record($access_token);
 
function create_record($access_token){
  $service_url = $GLOBALS['service_url'];
  //Authorization: Zoho-oauthtoken access_token
  if (($open = fopen("DUMMYRECORDS.csv", "r")) !== FALSE) 
  {
    while (($content = fgetcsv($open, 1000, ",")) !== FALSE) 
    {        
      $data[] = $content; 
    }
    fclose($open);
  }
  $header = array(
    'Authorization: Zoho-oauthtoken ' . $access_token,
    'Content-Type: application/json'
  );
 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $service_url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  $result = curl_exec($ch);
  curl_close($ch);
  var_dump($result);
}

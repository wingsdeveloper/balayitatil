<?php
$curl = curl_init();

$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v13.0/1757769984530411/events',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('data' => '[{"event_name": "ViewContent","event_id": "3211233","event_time": "' . time() .'","action_source": "website", "user_data": {"client_ip_address": "' . $_SERVER['REMOTE_ADDR'] . '","client_user_agent": "' . $_SERVER['HTTP_USER_AGENT'] . '"},"custom_data": {"currency": "USD","value": 0.5,"websiteurl": "megaodds.net"}}]','access_token' => 'EAAHTPiGDALEBAEcNNXC1nNAXJDI4V2r1hnaSlKvSH0TgWcoFPBzKGtKGZABzUVuszLurTdQ9qZBSunk0PZCqzVI73s07w2s5ZA2YgVaFl6ZCREl8buwcpAwC3bgZAWiVVegefRultu8o3Bx5nEJe6WYZC0RyNpZCR1ZA7bZALHsF8SDMsAL6WQQVd9JEwVSRuhx58ZD','test_event_code' => 'TEST65140'),
));

$response = curl_exec($curl);

curl_close($curl);

echo $response;


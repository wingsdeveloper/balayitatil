<?php
// ------------------------------------------------
// This is a cURL Object
// Created by: Gilberto C.
// InteractiveUtopia.com
// ------------------------------------------------

class CurlServer
{
    private $access_token;

    function __construct()
    {
        $this->access_token = 'EAAHTPiGDALEBAEcNNXC1nNAXJDI4V2r1hnaSlKvSH0TgWcoFPBzKGtKGZABzUVuszLurTdQ9qZBSunk0PZCqzVI73s07w2s5ZA2YgVaFl6ZCREl8buwcpAwC3bgZAWiVVegefRultu8o3Bx5nEJe6WYZC0RyNpZCR1ZA7bZALHsF8SDMsAL6WQQVd9JEwVSRuhx58ZD';
    }

    function post_request($url, $submitJson)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $submitJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->access_token, 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $serverReponseObject = json_decode($server_output);

        // Debug
        //print_r ( $server_output );
        print_r($serverReponseObject);
    }
    function get_request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->access_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $serverReponseObject = json_decode($server_output);

        // Debug
        //print_r ( $server_output );
        print_r($serverReponseObject);
    }
}
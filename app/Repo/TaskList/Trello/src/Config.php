<?php

namespace App\Repo\TaskList\Trello\src;
/*BOARD-ID = YBcGrsSW*/
trait Config {

    public function prepareRequest($url, $type = 'GET', $debug = false)
    {
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $ch = curl_init();

        $url = str_replace('yourApiKey', $this->get_api_key(), $url);
        $url = str_replace('yourApiToken', $this->get_api_token(), $url);
        $url = str_replace('[yourKey]', $this->get_api_key(), $url);
        $url = str_replace('[yourToken]', $this->get_api_token(), $url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }


        curl_close($ch);
        if($debug) {dd($url . ' ' . $result);}

        return json_decode($result);
    }
    public static function get_token()
    {
        return '7d25315a2650086ba32b1badb8efb8cf';
    }
    public static function get_client_id()
    {
        #return '11a967b00599f829658f';
        return 'a8bdda5f30e9e51b3716';
    }
    public static function get_api_key()
    {
        return 'fb4ad3eda0a1a30a483b1e22c8076aaa';
    }
    public static function get_api_token()
    {
        return '24774640645462319e56677711b8176fe28a2d65c61f83c1b396853172bea6b6';
    }
    public static function bugunGelenlerId()
    {
        return '5e398d6796b1c482623a7964';
    }
    public static function manuelOdemelerId()
    {
        return '5e398d6796b1c482623a7965';
    }
    public static function onRezervasyonlarId()
    {
        return '5e398e282b138b7d254a408a';
    }
    public static function allMembers()
    {
        return [
            ['id' => '5c02905fbd19db69ad1ccc30', 'fullName' => 'Alper Çelik'],
            ['id' => '5e398d41ba93930733be11b0', 'fullName' => 'Birtan Taşkın'],
            ['id' => '5e3e9ad2869cc0079a5610c9', 'fullName' => 'Doğan Durgun'],
            ['id' => '5e399917f687471b540bbd17', 'fullName' => 'UĞUR DURGUN'],
            ['id' => '5e39997e0ee90f67988ecdab', 'fullName' => 'irem'],
            ['id' => '5e3c1e15bae699297785c9de', 'fullName' => 'tamer'],
        ];
    }
    public function getMember($id)
    {
        return collect($this->allMembers())->where('id', $id)->first();
    }
    public function getAllMembers()
    {
        return collect($this->allMembers());
    }
}

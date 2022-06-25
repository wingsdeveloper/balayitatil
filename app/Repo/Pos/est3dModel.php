<?php
namespace App\Repo\Pos;

class est3dModel
{
    public function __construct()
    {
        $this->live_url = "https://sanalpos.teb.com.tr/fim/est3Dgate";
        $this->api_url = "https://sanalpos.teb.com.tr/fim/api";
        $this->client_id = "400887958";
        $this->storekey = "9z8EewwXq9dDNz";
        $this->name = "Wingsuser";
        $this->password = "9z8EewwXq9dDNz";
        $this->mode = "P";          //P olursa gerçek islem, T olursa test islemi yapar
        $this->type = "Auth";       //Auth: Satış PreAuth: Ön Otorizasyon
    }
    private function createHash($clientId, $oid, $amount, $okUrl, $failUrl, $rnd, $storekey)
    {
        $hashstr = $clientId . $oid . $amount . $okUrl . $failUrl . 'Auth' . "" . $rnd . $storekey;
        $hash = base64_encode(pack('H*', sha1($hashstr)));
        return $hash;
    }
    private function createHash2($clientId, $oid, $amount, $okUrl, $failUrl, $rnd, $storekey)
    {

        $hashstr = $clientId . $oid . $amount . $okUrl . $failUrl . 'Auth' . "3" . $rnd . $storekey;
        $hash = base64_encode(pack('H*', sha1($hashstr)));
        return $hash;
    }
    private function createForm($bank)
    {
        if ($bank['instalment'] != 0) {
            $instalment = $bank['instalment'];
        } else {
            $instalment = "";
        }
        $amount = $bank["total"];
        $rnd = microtime();    //Tarih veya her seferinde degisen bir deger güvenlik amaçli

        $hash = $this->createHash($this->client_id, $bank['order_id'],
            $amount,
            $bank['success_url'],
            $bank['fail_url'],
            $rnd,
            $this->storekey);

        $inputs = array();
        $inputs = array(
            'pan' => str_replace(" ", "", $bank['cc_number']),
            'cv2' => $bank['cc_cvv2'],
            "Ecom_Payment_Card_ExpDate_Year" => $bank["cc_expire_date_year"],
            "Ecom_Payment_Card_ExpDate_Month" => $bank["cc_expire_date_month"],
            // 'cardType' => $bank["cc_type"],
            'clientid' => $this->client_id,
            'amount' => $amount,
            'oid' => $bank['order_id'],
            'okUrl' => $bank['success_url'],
            'failUrl' => $bank['fail_url'],
            "rnd" => $rnd,
            'hash' => $hash,
            'storetype' => "3d_pay",
            "lang" => 'tr',
            'currency' => $bank['currency_code'],
            "firmaadi" => "WİNGS SEYAHAT TURİZM SANAYİ",
            "islemtipi" => "Auth",
            "taksit" => "",
            // "bank_id"=>$bank["bank_id"],
            'vendorCode' => $this->client_id,
            "cc_owner"=>$bank["cc_owner"],            
        );

        $action = $this->live_url;
        $form = '<form id="webpos_form" name="webpos_form" method="post" action="' . $action . '">';
        foreach ($inputs as $key => $value) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }
        $form .= '<script>document.getElementById("webpos_form").submit()</script>';
        $form .= '</form>';
        return $form;
    }
    private function createForm2($bank)
    {
        if ($bank['instalment'] != 0) {
            $instalment = $bank['instalment'];
        } else {
            $instalment = "";
        }
        $installment = 4;
        $amount = $bank["total"];
        $rnd = microtime();    //Tarih veya her seferinde degisen bir deger güvenlik amaçli

        $hash = $this->createHash2($this->client_id, $bank['order_id'],
            $amount,
            $bank['success_url'],
            $bank['fail_url'],
            $rnd,
            $this->storekey);

        $inputs = array();
        $inputs = array(
            'pan' => str_replace(" ", "", $bank['cc_number']),
            'cv2' => $bank['cc_cvv2'],
            "Ecom_Payment_Card_ExpDate_Year" => $bank["cc_expire_date_year"],
            "Ecom_Payment_Card_ExpDate_Month" => $bank["cc_expire_date_month"],
            // 'cardType' => $bank["cc_type"],
            'clientid' => $this->client_id,
            'amount' => $amount,
            'oid' => $bank['order_id'],
            'okUrl' => $bank['success_url'],
            'failUrl' => $bank['fail_url'],
            "rnd" => $rnd,
            'hash' => $hash,
            'storetype' => "3d_pay",
            "lang" => 'tr',
            'currency' => $bank['currency_code'],
            "firmaadi" => "WİNGS SEYAHAT TURİZM SANAYİ",
            "islemtipi" => "Auth",
            "taksit" => 4,
            // "bank_id"=>$bank["bank_id"],
            'vendorCode' => $this->client_id,
            "cc_owner"=>$bank["cc_owner"],
        );

        $action = $this->live_url;
        $form = '<form id="webpos_form" name="webpos_form" method="post" action="' . $action . '">';
        foreach ($inputs as $key => $value) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }
        $form .= '<script>document.getElementById("webpos_form").submit()</script>';
        $form .= '</form>';
        return $form;
    }
    public function methodResponse($bank)
    {

        $response = array();
        $response['form'] = $this->createForm($bank);

        //$response['redirect']=;
        //$response['error']=;
        return $response;
    }
    public function methodResponse2($bank)
    {

        $response = array();
        $response['form'] = $this->createForm2($bank);

        //$response['redirect']=;
        //$response['error']=;
        return $response;
    }
    public function bankResponse($bank_response, $bank = NULL)
    {        
        $hashparams = $bank_response["HASHPARAMS"];
        $hashparamsval = $bank_response["HASHPARAMSVAL"];
        $hashparam = $bank_response["HASH"];
        $paramsval = "";
        $index1 = 0;
        $index2 = 0;

        while ($index1 < strlen($hashparams)) {
            $index2 = strpos($hashparams, ":", $index1);
            $vl = $bank_response[substr($hashparams, $index1, $index2 - $index1)];
            if ($vl == null)
                $vl = "";
            $paramsval = $paramsval . $vl;
            $index1 = $index2 + 1;
        }
        $storekey = $this->storekey;
        $hashval = $paramsval . $storekey;

        $hash = base64_encode(pack('H*', sha1($hashval)));

        $response = array();
        $hashText = "";
        if ($paramsval != $hashparamsval || $hashparam != $hash) {
            $hashText = "<h4>Güvenlik Uyarisi. Sayisal Imza Geçerli Degil</h4>";
            $response['message'] = $hashText;
            echo $hashText;
            die;
        }
        $mdStatus = $bank_response['mdStatus'];// if mdstatus 1,2,3,4 then 3D authentication is successful, if mdstatus 5,6,7,8,9,0 then 3D authentication is FAILED
        $mdArray = array('1', '2', '3', '4');
        $sonuc = array();

        $sonuc['message'] = "";
        if (in_array($mdStatus, $mdArray)) {
            $sonuc['message'] = '3D Onayı Başarılı.<br/>';
            
            $lip = $_SERVER['REMOTE_ADDR'];

            $fields = array(
                "url" => $this->api_url,
                "name" => $this->name,
                "password" => $this->password,
                "clientid" => $bank_response["clientid"],
                "lip" => $lip,
                "mode" => $this->mode,
                "type" => $this->type,
                "order_id" => $bank_response["oid"],
                "tutar" => $bank_response["amount"],
                "taksit" => "",
                "md" => $bank_response["md"],
                "eci" => $bank_response["eci"],
                "xid" => $bank_response["xid"],
                "cavv" => $bank_response["cavv"],
                "islemtipi" => "Auth",
                "firmaadi" => "WİNGS SEYAHAT TURİZM SANAYİ",
                // 'bank_id' => $bank['bank_id'],
                "cc_owner"=>$bank_response["cc_owner"]
            );

            $result = $this->xmlSend($fields);
            
            if ($result["Response"] === "Approved") {
                $sonuc['result'] = 1;
                $sonuc['message'] = 'Ödeme Başarılı<br/>'.json_encode($result).json_encode($bank_response);                
            } else {
                $sonuc['result'] = 0;
                $sonuc['message'] .= 'Ödeme Başarısız.<br/>' . @$result["ErrMsg"] . @$result["Response"];
            }

        } else {
            $sonuc['result'] = 0;
            $sonuc['message'] .= '3D doğrulama başarısız<br/>';            
            $sonuc['message'] .= @$bank_response['ErrMsg'];
        }
        return $sonuc;
    }

    private function xmlSend($fields)
    {
        $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
        "<CC5Request>" .
        "<Name>{NAME}</Name>" .
        "<Password>{PASSWORD}</Password>" .
        "<ClientId>{CLIENTID}</ClientId>" .
        "<IPAddress>{IP}</IPAddress>".
        "<OrderId>{OID}</OrderId>" .
        "<Type>{TYPE}</Type>" .
        "<Number>{MD}" .
        "</Number>".
        "<Amount>{TUTAR}</Amount>".
        "<Currency>949</Currency>".
        "<PayerTxnId>{XID}</PayerTxnId>".
        "<PayerSecurityLevel>{ECI}</PayerSecurityLevel>".
        "<PayerAuthenticationCode>{CAVV}</PayerAuthenticationCode>".
        "</CC5Request>";

        $request = str_replace("{NAME}", $fields["name"], $request);
        $request = str_replace("{PASSWORD}", $fields["password"], $request);
        $request = str_replace("{CLIENTID}", $fields["clientid"], $request);
        $request = str_replace("{IP}", $fields["lip"], $request);
        $request = str_replace("{MODE}", $fields["mode"], $request);
        $request = str_replace("{OID}", $fields["order_id"], $request);
        $request = str_replace("{TYPE}", $fields["type"], $request);
        $request = str_replace("{XID}", $fields["xid"], $request);
        $request = str_replace("{ECI}", $fields["eci"], $request);
        $request = str_replace("{CAVV}", $fields["cavv"], $request);
        $request = str_replace("{MD}", $fields["md"], $request);
        $request = str_replace("{TUTAR}", $fields["tutar"], $request);
        $request = str_replace("{TAKSIT}", $fields["taksit"], $request);

        //$request = str_replace("{CURRENCY}", $fields["currency"], $request);

        /*Bu fonksiyon curl oturumu başlatmaya yarar. Argüman olarak oturumun açılacağı url'yi verebilirsinizde tabii isterseniz argümansız olarak çağırıp url'yi sonradan ayarlayabilirsiniz. Oturum açtığınız zaman bu oturumu bir değişkene atayarak oturum işlemlerini bu değişken üstünden yapmalısınız*/
        $ch = curl_init();    // initialize curl handle

        /*- CURLOPT_URL : Oturumun açılacağı adresi bu değişken tutmaktadır. Eğer curl_init fonksiyonunu argümansız olarak çağırdıysanız burada oturumun açılacağı adresi mutlaka belirtmeniz lazım. Curl_init ile adresi verdiyseniz bile burada tekrar adresi değiştirebilirsiniz.*/
        curl_setopt($ch, CURLOPT_URL, $this->api_url); // set url to post to

        //Normal şartlar altında burası 1 di ama laravelde bu değer 2 olması gerekiyor.
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        //Normal şartlar altında version 3 tü ama laravelde bu değer 4 olması gerekiyor. Codeigniterda 6 kullanmıştım.
         curl_setopt($ch, CURLOPT_SSLVERSION, 4);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        /* CURLOPT_RETURNTRANSFER : Curl oturumunu çalıştırdığınız zaman gelen veriyi çıktı olarak almak yerine değilde bir değişkene atanmasını istiyorsanız bu değişkene true veya 1 olarak atamalısınız. Aksi halde gelen çıktı direk olarak ekrana bastırılacaktır.*/
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable

        /* CURLOPT_TIMEOUT : Curl işlemi çalıştırılıdığı zaman fonksiyonun çalışacağı en uzun süre sınırı bu değişkende tutulur.    */
        curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s

        /*- CURLOPT_POSTFIELDS : Post işlemi yapacaksanız buraya yollıyacağınız değişken isimlerini ve değerlerini girmelisiniz.*/
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request); // add POST fields


        /*Bu fonksiyon setpot ile gerekli ayarları yaptıktan sonra oturumu çalıştırmanızı sağlar. Dönen veriyi eğer setopt ile ayarını yaptıysanız dosyaya, değişkene veya çıktı olarak ekrana aktarabilirsiniz.*/
        $result = curl_exec($ch);


        if (curl_errno($ch)) {
            print curl_error($ch);
        } else {
            curl_close($ch);
        }

        $data = $this->estModelResponse($result);
        return $data;
    }

    public function estModelResponse($result)
    {
        $response_tag = "Response";
        $posf = strpos($result, ("<" . $response_tag . ">"));
        $posl = strpos($result, ("</" . $response_tag . ">"));
        $posf = $posf + strlen($response_tag) + 2;
        $Response = substr($result, $posf, $posl - $posf);
        $response_tag = "OrderId";
        $posf = strpos($result, ("<" . $response_tag . ">"));
        $posl = strpos($result, ("</" . $response_tag . ">"));
        $posf = $posf + strlen($response_tag) + 2;
        $OrderId = substr($result, $posf, $posl - $posf);
        $response_tag = "AuthCode";
        $posf = strpos($result, "<" . $response_tag . ">");
        $posl = strpos($result, "</" . $response_tag . ">");
        $posf = $posf + strlen($response_tag) + 2;
        $AuthCode = substr($result, $posf, $posl - $posf);
        $response_tag = "ProcReturnCode";
        $posf = strpos($result, "<" . $response_tag . ">");
        $posl = strpos($result, "</" . $response_tag . ">");
        $posf = $posf + strlen($response_tag) + 2;
        $ProcReturnCode = substr($result, $posf, $posl - $posf);
        $response_tag = "ErrMsg";
        $posf = strpos($result, "<" . $response_tag . ">");
        $posl = strpos($result, "</" . $response_tag . ">");
        $posf = $posf + strlen($response_tag) + 2;
        $ErrMsg = substr($result, $posf, $posl - $posf);
        $response_tag = "HostRefNum";
        $posf = strpos($result, "<" . $response_tag . ">");
        $posl = strpos($result, "</" . $response_tag . ">");
        $posf = $posf + strlen($response_tag) + 2;
        $HostRefNum = substr($result, $posf, $posl - $posf);
        $response_tag = "TransId";
        $posf = strpos($result, "<" . $response_tag . ">");
        $posl = strpos($result, "</" . $response_tag . ">");
        $posf = $posf + strlen($response_tag) + 2;
        $TransId = substr($result, $posf, $posl - $posf);
        return array(            
            'Response' => $Response, 
            'Orderid' => $OrderId, 
            'AuthCode' => $AuthCode, 
            'ProcReturnCode' => $ProcReturnCode, 
            'HostRefNum' => $HostRefNum, 
            'TransId' => $TransId, 
            'ErrMsg' => $ErrMsg,
            'allData'=>json_encode($result),
        );
    }
}
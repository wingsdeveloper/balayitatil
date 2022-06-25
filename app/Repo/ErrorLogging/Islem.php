<?php

namespace App\Repo\ErrorLogging;

/**
 * Telegram Bot Class.
 *
 */

use Exception;

class Islem extends Telegram
{


    /**
     * Islem constructor.
     * @param $bot_token
     */
    public function __construct($bot_token)
    {
        parent::__construct($bot_token);

        $this->karsila();

        //Gelen veriyi küçük haflere çevirip parçalıyoruz.
        $text = str_replace("\n", ' ', $this->Text());
        $komut = explode(' ', $text);
        $komut = mb_strtolower($komut[0]);
        $parametre = trim(str_replace($komut, '', mb_strtolower($text)));
        if ($text !== null && $this->ChatID() !== null) {
            $this->yanitla($komut, $parametre);
        }
    }

    /**
     * Gelen mesajları kontrol etme fonksiyonu
     */
    public function karsila(): void
    {
        $new_members = $this->new_chat_members();
        if ($new_members) {
            foreach ($new_members as $new_member) {

                if ($new_member['is_bot'] && $this->getMyId()!==$new_member['id']) {
                    $karsilama_mesaji = MessageTemplates::get('welcome_bot');
                    $this->kick($new_member['id'], $new_member['first_name'], 'Bot olduğu için');
                } elseif( $this->getMyId()===$new_member['id']) {
                    $karsilama_mesaji = MessageTemplates::get('icome');
                } else {
                    switch ($this->ChatID()) {
                        case '-1001234623408':
                            $karsilama_mesaji = MessageTemplates::get('welcome_business_network');
                            break;
                        case '-1001421925347':
                            $karsilama_mesaji = MessageTemplates::get('welcome_denizli_developers');
                            break;
                        default:
                            $karsilama_mesaji = MessageTemplates::get('default_welcome_message');
                    }
                }
                $content = ['chat_id' => $this->ChatID(), 'text' => $karsilama_mesaji, 'reply_to_message_id' => $this->MessageID()];
                $this->sendMessage($content);
            }

        }

        $otherAdmins = str_replace('@' . $this->getMyUsername(), '', $this->getAdminsUsername());

        if (!in_array($this->UserID(), $this->getAdminsId(), true)) {
            if ($this->urlMi($this->Text())) {
                $reply = $this->Username() . ' REKLAM YOK!!! ' . $otherAdmins;
                $content = ['chat_id' => $this->ChatID(), 'text' => $reply];
                $delete_content = ['chat_id' => $this->ChatID(), 'message_id' => $this->MessageID()];
                $this->deleteMessage($delete_content);
                $this->sendMessage($content);
            }

            if ($this->argoMu($this->Text())) {
                $reply = $this->Username() . ' ARGO YOK!!! ' . $otherAdmins;
                $content = ['chat_id' => $this->ChatID(), 'text' => $reply];
                $delete_content = ['chat_id' => $this->ChatID(), 'message_id' => $this->MessageID()];
                $this->deleteMessage($delete_content);
                $this->kick($this->UserID(), $this->FirstName(), 'argo nedeniyle');
                $this->sendMessage($content);
            }
        }
    }

    /**
     * @param $text
     * @return bool
     */
    public function urlMi($text): bool
    {
        // Regular Expression filtresi
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

        return preg_match($reg_exUrl, $text, $url) ? true : false;
    }

    /**
     * @param $text
     * @return bool
     */
    public function argoMu($text): bool
    {
        $badWords = array('amk', 'yarrak', 'oruspu', 'orospu','şerefsiz','serefsiz','piç','ananın','kahpe','sikik','göt','got','götveren','amcık','amcik','karaktersiz','haysiyetsiz','amına','amina','götveren','gotveren','ibne','gay','lgbt','lgbti','lezbiyen','travesti','pezevenk','pezeveng','pezo','fuck','fuck you','fuckyou','bitch','shit','bok','motherfucker','mother fucker','sucker','suck my dick','yarrağımı','götünü','gotunu','amını','amini');
        $matches = array();
        $matchFound = preg_match_all("/\b(" . implode('|', $badWords) . ")\b/i", $text, $matches);

        return $matchFound ? true : false;
    }


    /**
     * @return string
     */
    public function dovizKuru(): string
    {
        $connect_web = simplexml_load_string(file_get_contents('http://www.tcmb.gov.tr/kurlar/today.xml'));
        $usd_buying = $connect_web->Currency[0]->BanknoteBuying;
        $usd_selling = $connect_web->Currency[0]->BanknoteSelling;
        $euro_buying = $connect_web->Currency[3]->BanknoteBuying;
        $euro_selling = $connect_web->Currency[3]->BanknoteSelling;
        $reply = "USD Alış: $usd_buying \nUSD Satış: $usd_selling.\nEUR Alış: $euro_buying \nEUR Satış: $euro_selling";
        return $reply;
    }

    /**
     * @param $text
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function yandexCevir($text, $from = 'tr', $to = 'en')
    {
        $text = urlencode($text);
        try {
            $url = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20190730T082443Z.486413024408fd66.4bc5696675f8b975af989119f79f3eaae07a9a60&lang=$from-$to&text=" . $text);
            $json = json_decode($url, true);
            return $json['text'][0];
        } catch (Exception $e) {
            return MessageTemplates::get('translate_error');
        }
    }

    /**
     * @return mixed
     */
    public function getMyId()
    {
        $me = $this->getMe();
        return $me['result']['id'];
    }

    /**
     * @return mixed
     */
    public function getMyUsername()
    {
        $me = $this->getMe();
        return $me['result']['username'];
    }

    /**
     * @return bool
     */
    public function selfAdminControl(): bool
    {

        $adminList = $this->getChatAdministrators(['chat_id' => $this->ChatID()]);
        $check = false;
        if (!empty($adminList['result'])) {
            foreach ($adminList['result'] as $result) {
                if (in_array($this->getMyId(), array_column($result, 'id'), true)) {
                    $check = $result;
                    break;
                }

                $check = false;
            }
        } else {
            $check = false;
        }
        return $check;
    }

    /**
     * @return string|null
     */
    public function getAdminsUsername(): ?string
    {
        $adminList = $this->getChatAdministrators(['chat_id' => $this->ChatID()]);
        $check = null;
        if (!empty($adminList['result'])) {
            foreach ($adminList['result'] as $result) {
                $check .= ' @' . $result['user']['username'];
            }
        } else {
            $check = '';
        }
        return $check;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getUserInfo($user_id)
    {
        return $this->getChatMember(['chat_id' => $this->ChatID(), 'user_id' => $user_id]);
    }

    /**
     * @return array
     */
    public function getAdminsId(): array
    {
        $adminList = $this->getChatAdministrators(['chat_id' => $this->ChatID()]);
        $adminIds = array();
        if (!empty($adminList['result'])) {
            foreach ($adminList['result'] as $result) {
                $adminIds[] = $result['user']['id'];
            }
        }
        return $adminIds;
    }

    /**
     * @param $user_id
     * @param $name
     * @param $reason
     */
    public function kick($user_id, $name, $reason): void
    {
        $reply = $name . ' Yetkiye sahip olsaydım seni burada tutmazdım!';
        $selfAdmin = $this->selfAdminControl();
        if (($selfAdmin !== false) && $selfAdmin['can_restrict_members']) {
            $reply = "$name $reason kovuldu!";
            $this->kickChatMember(['chat_id' => $this->ChatID(), 'user_id' => $user_id]);
        }
        $this->sendMessage(['chat_id' => $this->ChatID(), 'text' => $reply]);
    }

    /**
     * @param string|null $komut
     * @param string $parametre
     */
    private function yanitla(?string $komut,
                             string $parametre): void
    {
        if (strpos($komut, '/') === 0) {
            if ($komut === '/info') {
                if ($this->messageFromGroup()) {
                    $reply = "Bu bir grup sohbeti\n";
                } else {
                    $reply = "Kişisel sohbet\n";
                }
//                $reply .= "user_id: " . $this->UserID();
//                $reply .= "message_id: " . $this->MessageID();
                $reply .= ' - ' . $this->ChatID();
                $content = ['chat_id' => $this->ChatID(), 'text' => $reply, 'reply_to_message_id' => $this->MessageID()];
            } elseif ($komut === '/botmu') {
                $user_info = $this->getUserInfo($parametre);
                $is_bot = $user_info['result']['user']['is_bot'];
                if ($is_bot) {
                    $reply = 'evet bot ' . json_encode($user_info);
                } else {
                    $reply = 'hayır normal üye ' . json_encode($user_info);
                }
                $content = ['chat_id' => $this->ChatID(), 'text' => $reply, 'reply_to_message_id' => $this->MessageID()];
            } elseif ($komut === '/benkimim') {
                if ($this->UserID() === 631916285) {
                    $reply = "Sen benim Babamsın ♥ \n";
                } elseif (in_array($this->UserID(), $this->getAdminsId(), true)) {
                    $reply = "Siz bir yöneticisiniz efendim\n";
                } else {
                    $reply = "Sen basit bir üye parçasısın\n";
                }
                $content = ['chat_id' => $this->ChatID(), 'text' => $reply, 'reply_to_message_id' => $this->MessageID()];
            } elseif ($komut === '/hello' || $komut === '/merhaba' || $komut === '/selam') {
                $reply = 'Merhaba ' . $this->FirstName() . '!';
                $content = ['chat_id' => $this->UserID(), 'text' => $reply];
            } elseif ($komut === '/naber') {
                $reply = 'sağlığınıza duacıyım';
                $content = ['chat_id' => $this->UserID(), 'text' => $reply];
            } elseif ($komut === '/dovizkuru') {
                $reply = $this->dovizKuru();
                $content = ['chat_id' => $this->UserID(), 'text' => $reply];
            } elseif ($komut === '/translatetr' || $komut === '/cevirtr') {
                if (!empty($parametre)) {
                    $reply = $this->yandexCevir($parametre, 'en', 'tr');
                } else {
                    $reply = MessageTemplates::get('empty_param');
                }
                $content = ['chat_id' => $this->UserID(), 'text' => $reply];
            } elseif ($komut === '/translateen' || $komut === '/ceviren') {
                if (!empty($parametre)) {
                    $reply = $this->yandexCevir($parametre);
                } else {
                    $reply = MessageTemplates::get('empty_param');
                }
                $content = ['chat_id' => $this->UserID(), 'text' => $reply];
            } elseif ($komut === '/tavsiye' || $komut === '/ozlusoz') {
                $reply = OzluSozler::sozVer();
                $content = ['chat_id' => $this->UserID(), 'text' => $reply];
            } else {
                $reply = MessageTemplates::get('help');
                $content = ['chat_id' => $this->UserID(), 'text' => $reply];
            }
            $this->sendMessage($content);
        }
    }
}
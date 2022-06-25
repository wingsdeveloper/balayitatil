<?php
namespace App\Repo\TaskList\Trello\src;

#bugun-gelenler->list->id = 5e398d6796b1c482623a7961
#onrezervasyonlar->list->id = 5e3bd84648204c5477b3bc14
#manuel-odemeler->id = 5e3bd8985673038b8b046364

class Card {
    use Config;
    public function createList($list_id = '5e398d6796b1c482623a7964', $data = [])
    {
        $form = '';
        if(!isset($data['name'])):
            dd('name parametresi ekle createList');
        endif;

        foreach($data as $key => $row):
            $form = $form . '&' . $key .'='. urlencode($row);
        endforeach;
        $url = ('https://api.trello.com/1/cards?idList='.$list_id.'&keepFromSource=all&key=yourApiKey&token=yourApiToken' . $form);
        return $this->prepareRequest($url, 'POST');
    }
    public function postComment($list_id, $value)
    {
        $value = urlencode($value);
        $url = 'https://api.trello.com/1/cards/'.$list_id.'/actions/comments?text='.$value.'&key=yourApiKey&token=yourApiToken';
        return $this->prepareRequest($url, 'POST');
    }
}

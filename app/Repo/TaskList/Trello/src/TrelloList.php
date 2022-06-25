<?php
namespace App\Repo\TaskList\Trello\src;

class TrelloList {
    use Config;
    public function create($id)
    {
        $url = 'https://api.trello.com/1/lists?name=vi̇llakalkan&idBoard='.$id.'&key=yourApiKey&token=yourApiToken';
        return $this->prepareRequest($url, 'POST');
    }
    public function createCheckList($id, $value, $debug = false)
    {
        $value = urlencode($value);
        $url = 'https://api.trello.com/1/cards/'.$id.'/checklists?key=yourApiKey&token=yourApiToken&name=' . $value;

        return $this->prepareRequest($url, 'POST', $debug);
    }
    public function createCheckListItem($check_list_id, $value, $debug = false)
    {
        $value = urlencode($value);
        $url = 'https://api.trello.com/1/checklists/'.$check_list_id.'/checkItems?name='.$value.'&pos=bottom&checked=false&key=yourApiKey&token=yourApiToken';
        return $this->prepareRequest($url, 'POST', $debug);

    }

}

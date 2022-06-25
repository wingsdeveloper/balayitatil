<?php

namespace App\Listeners;

use App\Events\PreReservationMail;

use App\Repo\TaskList\Trello\src\Card;
use App\Repo\TaskList\Trello\src\TrelloList;
use App\Repo\Tasklist\Trello\TrelloModel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repo\Model\PreReservation;
use App\Repo\Wunderlist\Main as WunderListApi;
use App\Repo\Wunderlist\Commmand as WunderListCommand;
use App\PreReservation as PreReservationModel;
use App\{Customer, PossibleCustomer};

class PreReservationListener implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repo = new PreReservation;

    }

    /**
     * Handle the event.
     *
     * @param  PreReservationMail  $event
     * @return void
     */
    public function handle(PreReservationMail $event)
    {
        // throw new \Exception("Error Processing Request", 1);
        $this->preReservationId = $event->preReservationId;
        $pre_reservation_id = $event->preReservationId;
        $customer = $event->customer;


        $this->repo->sendAdminMail($this->preReservationId, $customer);

        try {

            $subTasks = [
                '1-) TALEBİ SAHİPLEN',
                '2-) DOLULUK TAKVİMİNİ KONTROL ET',
                '3-) VİLLA İÇİN OPSİYON AL',
                '4-) MÜŞTERİ ARANACAK',
                '5-) EVRAK GÖNDERİLDİ',
                '6-) ÖDEME ONAYI AL',
                '7-) SÖZLEŞME GÖNDER',
                '8-) VİLLAYI KAPAT/SAHİBİNE BİLGİ VER'
            ];

            $reservation = PreReservationModel::with('villa')->where('id', $this->preReservationId)->first();
            $tarih1 = date('d-m-Y', strtotime($reservation->start_date));
            $tarih2 = date('d-m-Y', strtotime($reservation->end_date));

            if($reservation->customer_type == 'possible'):
                $customer = PossibleCustomer::where('id', $reservation->customer_id)->first();
            else:
                $customer = Customer::where('id', $reservation->customer_id)->first();
            endif;

            $str = $reservation->villa->name;
            $str = $str . ' ' . $tarih1 . ' ' . $tarih2 . ' ' . $customer->name . ' ' . $customer->phone;
            $email = view('emails.reservation', ['data' => $reservation, 'customer' => $customer])->render();
            dispatch(function() use($subTasks, $str, $email, $pre_reservation_id) {
                $card = new Card();
                $response = $card->createList('5e3bd84648204c5477b3bc14', ['name' => $str]);
                $card_id = $response->id;
                $trelloList = new TrelloList();
                $result = $trelloList->createCheckList($card_id , 'YAPILACAKLAR');
                $check_list_id = $result->id;
                foreach($subTasks as $row):
                    $trelloList->createCheckListItem($check_list_id, $row);
                endforeach;
                $card->postComment($card_id, strip_tags($email));
                $modelData = ['parent_id' => '5e3bd84648204c5477b3bc14', 'list_id' => $card_id,
                    'reservation_id' => $pre_reservation_id, 'title' => $str, 'type' => 'task', 'reservation_type' => 'prereservation'];
                $model = new TrelloModel();
                $model->save($modelData);
            });

        }catch(\Exception $e) {

        }

    }
}

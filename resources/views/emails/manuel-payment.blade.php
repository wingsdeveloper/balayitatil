Rezervasyon kodu {{ $data->reservation_code }} olan toplamda
{{ number_format($data->total, 2) . ' ' . $data->currency->name }} ödeme alınmıştır.
Müşteri : {{ $customer->name }} <br>
Müşteri Telefon: {{ $customer->phone }} <br>
Villa : {{ $villa->name }} <br>
Reservasyon Başlangıç: {{ date('d-m-Y', strtotime($reservation->start_date)) }} <br>
Reservasyon Bitiş: {{ date('d-m-Y', strtotime($reservation->end_date)) }} <br>
İşlem Tarihi : {{ date('d-m-Y', strtotime($reservation->created_at)) }}<br>
Kodu: {{  $odeme->order_id  }}

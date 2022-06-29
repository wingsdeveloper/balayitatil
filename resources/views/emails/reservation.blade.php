<b>Balayisepeti.com.tr</b> üzerinden yeni bir rezervasyon gerceklestirilmistir.<br>
Ad: {{ isset($customer) && ! empty($customer) ? $customer->name : ''}}<br>
Email: {{ isset($customer) && !empty($customer) ? $customer->email : '' }}<br>
Phone: {{ isset($customer) && !empty($customer) ? $customer->phone :'' }}<br>
Villa : {{ isset($data->villa) && !empty($data->villa) ? $data->villa->name : ''}}<br>
Villa Kodu  : {{ isset($data->villa) && !empty($data->villa) ? $data->villa->code : '' }}<br>
Kişi Bilgisi: Yetişkin:{{ isset($data) && !empty($data) ? $data->adult_count : '' }} Çocuk: {{ isset($data) && !empty($data) ? $data->child_count : ''  }}  Bebek: {{ isset($data) && !empty($data) ? $data->baby_count : '' }}<br>
Giriş Tarihi : {{  isset($data) && !empty($data) ? date('d-m-Y', strtotime($data->start_date)) : ''}}<br>
Çıkış Tarihi : {{  isset($data) && !empty($data) ? date('d-m-Y', strtotime($data->end_date)) : ''}}<br>
Rezervasyon kodu: {{ isset($data) && !empty($data) ? $data->code : ''}}<br>
Ön Ödeme : {{ isset($data) && !empty($data) ? $data->pre_payment : ''}} TL<br>
Toplam : {{ isset($data) && !empty($data) ? $data->total_price : ''}} TL
<br>
Url: http://{{ config('app.server_ip') }}/prereservation/{{ $data->id }}/detail

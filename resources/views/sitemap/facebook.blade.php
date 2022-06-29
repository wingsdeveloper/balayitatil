<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">
<title>Villa Kalkan </title>
<link rel="self" href="https://www.balayisepeti.com.tr"/>


   @foreach($products as $row)
   
   @if(empty($row->seo->seo_url))
   @continue;
   @endif
   @php
		
		$orderbyraw = "CAST(daily_price_tl AS DECIMAL(10,2)) ASC";
		$pricesmin = App\villaPrice::select("daily_price_tl")->where('villa_id', $row->id)->where("daily_price_tl", ">", 0)->whereDate('end_date', '>', Carbon\Carbon::now())->whereNotNull("start_date")->whereNotNull("end_date")->orderByRaw($orderbyraw)->first();
		//$villa = DB::table('villas')->where('id', $row->panel_villa->villa_id)->first();

		// dd($row->seo_title);

		try {
			  $tmp  = explode('-', $row->seo->seo_title);
			  $tmp2 = explode('|', $tmp[1]);
			  $description = $tmp2[0];
		} catch (\Exception $e) {
			  $description = $row->seo->seo_title;
		}

		  @endphp
		  @php
			if(empty($row->panel_villa->list_image)){
				$resim="uploads/villa/gallery/$row->list_image/$row->list_image_name";
			}else{
				$resim=$row->panel_villa->list_image;
			}
		@endphp
		@if(empty($pricesmin->daily_price_tl) || ($pricesmin->daily_price_tl==0))
		@continue;
		@endif

	   <entry>
	  	  <g:id>{{ $row->id }}</g:id>
	 	  <g:link>{{ route('static', $row->seo->seo_url) }}</g:link>
		  <g:title>{{ Transliterator::create('tr-title')->transliterate($row->name) }}</g:title>
		  <g:image_link>{{ asset($resim) }}</g:image_link>
	     
		 @php
	      $gune_ait_fiyat=floatval(str_replace(",",".",$pricesmin->daily_price_tl));
	      @endphp
		  <g:price>{{ ceil(number_format($gune_ait_fiyat, 2, '.', '') ) }}</g:price>
	      <g:description>{{ Transliterator::create('tr-title')->transliterate($row->name) }} - {{$row->number_person}} Kişilik tesistir. </g:description>
		  <g:brand>Balayisepeti</g:brand>
		  <g:condition>new</g:condition>
		  <g:availability>in stock</g:availability>
		  <g:google_product_category> {{ isset($row->area->name) ? Transliterator::create('tr-title')->transliterate($row->area->name) : '' }} &gt; {{$row->number_person}} Kişilik</g:google_product_category> 
	   </entry>
   @endforeach





   </feed>


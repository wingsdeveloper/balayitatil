<html>
<head>
  


<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>

    <style type="text/css">
        body {
            witdh:%100;
        }

        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            font-size: 12px;
            padding: 5px 5px;
            word-break: normal;
            background-color: #fff;
            width: 50%;
        }

        .tg th {
            font-size: 12px;
            font-weight: normal;
            padding: 10px 5px;
            
            overflow: hidden;
            word-break: normal;
            border-color: #ccc;
            color: white;

            @if($website->id == 2)
                                                           background-color: #102754;
            @elseif($website->id == 4)
                                               background-color: #764ca8;
            @elseif($website->id == 13)
                background-color: #0C4473;
            @else
                                               background-color: skyblue;
        @endif







        }

        .tg .tg-0pky {
            border-color: inherit;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-btxf {
            background-color: #f9f9f9;
            border-color: inherit;
            text-align: left;
            vertical-align: top
        }

        .bold {
            font-weight: bold
        }

        .tg-wrap {
            width: 100%;
        }

        .tg-wrap table {
            width: 100%;
        }

        .tg-wrap {
            padding-bottom: 3px;
        }

        p {
            padding-bottom: 2px !important;
            font-size: 12px;
        }

        ul li {
            font-size: 12px
        }

        ul {
            list-style-type: none
        }

        .no-border {
            background-color: white;
            border: none !important;
            width: 100%;
        }

        .no-border th {
            font-size: 12px;
            font-weight: normal;
            overflow: hidden;
            word-break: normal;
        }

        @switch($website->id)
            @case(2)
        .logo-img {
            width: 150px;

        }

        @break
            @case(4)
        .logo-img {
            width: 200px;

        }

        @break
            @case(5)
        .logo-img {
            width: 100px;

        }

        @break
            @case(7)
        .logo-img {
            width: 100px;

        }

        @break
            @case(13)
        .logo-img {
            height: 72px;
        }
        @break

        @default

        @endswitch
    </style>
    <script>
module.exports = {
  theme: {
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    colors: {
      'blue': '#1fb6ff',
      'purple': '#7e5bef',
      'pink': '#ff49db',
      'orange': '#ff7849',
      'green': '#13ce66',
      'yellow': '#ffc82c',
      'gray-dark': '#273444',
      'gray': '#8492a6',
      'gray-light': '#d3dce6',
    },
    fontFamily: {
      sans: ['Graphik', 'sans-serif'],
      serif: ['Merriweather', 'serif'],
    },
    extend: {
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
      borderRadius: {
        '4xl': '2rem',
      }
    }
  }
}
  </script>
</head>
<body>


  
<div  class="bg-indigo-900 text-center py-4 lg:px-4">
  <div  class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">Teşekkürler</span>
    <span class="font-semibold mr-2 text-left flex-auto">Sözleşmenizi aşağıdan okuyabilir dilerseniz indirebilirsiniz</span>
    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center" onclick="test()">  İndir</button>

  </div>
</div>
<div class="container mx-auto"  id="root">
<table class="no-border">
    <tr>
    <th class="text-left"><img  class="logo-img" src='/reservation_assets/images/logo.png'></th>
        <th>
            <table class="no-border">
         
                <tr>
                    <th class="text-right">{{ date('d/m/Y') }}</th>
                </tr>
                <tr>
                    <th style="font-size:11px;" class="text-right"><b>WİNGS SEYAHAT TURİZM SANAYİ ve TİCARET LİMİTED ŞİRKETİ</b></br>
                    <b>KAŞ V.D. 813 105 78 04</b>
                    </th>
                </tr>
                <tr>
                  
                </tr>
            </table>
        </th>
    </tr>
</table>

<p class="bold">
    TARAFLAR
</p>
<p>
    İş bu sözleşme tarafları, Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirketi, Müşteri ve Ziyaretci olarak
    belirlenmiş olup.
    Taraflar sözleşmede belirtilen şekilde tanımlanmıştır.
</p>
<p class="bold">
    WİNGS
</p>
<p>
    Merkezi Kalkan Mah. Cumhuriyet Cad No: 48/2 Kaş/ Antalya adresinde,Şubesi Taşyaka Mah. Baha Şıkman Cad. No:201/A
    Fethiye-MUĞLA adresinde
    bulunan Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirketi'ni (Kaş V.D. 813 105 78 04 ) ifade eder.
    (Sözleşme içerisinde kısaca ''WİNGS'' olarak anılacaktır.) WİNGS {{ $website->domain }} internet sitesi üzerinden
    münferit bireylere veya tüzel kişilere kısa dönem
    villa/apart kiralama hizmeti sunan bir kuruluştur.
</p>
<p class="bold">
    ZİYARETÇİ
</p>
<p>
    Terimi, bunlarla sınırlı olmamak üzere sitemizde yayınlanmakta olan hizmet,kiralik villa,apart,konut ve işyeri ya da
    satın alınabilir diğer materyalleriinceleyen,
    satın alma veya kiralama talebinde bulunan ya da satın alan veya kiralayan gerçek veya tüzel kişileri ifade eder.
</p>
<div class="tg-wrap">
    <table class="tg">
        <tr>
            <th class="tg-0pky" colspan="2"><b>REZERVASYON DETAYLARI</b></th>
        </tr>
        <tr>
            <td class="tg-btxf">Rezervasyon No</td>
            <td class="tg-btxf">{{ $res->code }}</td>
        </tr>
        <tr>
            <td class="tg-0pky">ZİYARETÇİ ADI SOYADI</td>
            <td class="tg-0pky">{{ $customer->name }}</td>
        </tr>
        @if(!empty($customer->idnumber))
            <tr>
                <td class="tg-0pky">ZİYARETÇİ KİMLİK NUMARASI</td>
                <td class="tg-0pky">{{ $customer->idnumber }}</td>
            </tr>
        @endif
        {{--        @if(!empty($res->other))--}}
        {{--            @if($other_info = json_decode($res->other, true))--}}
        {{--                @if($other_info['platform'])--}}
        {{--                    <tr>--}}
        {{--                        <td class="tg-0pky">ZİYARETÇİ İŞLETİM SİSTEMİ</td>--}}
        {{--                        <td class="tg-0pky">{{ $other_info['platform'] }}</td>--}}
        {{--                    </tr>--}}
        {{--                    @if($other_info['name'])--}}
        {{--                        <tr>--}}
        {{--                            <td class="tg-0pky">ZİYARETÇİ TARAYICI</td>--}}
        {{--                            <td class="tg-0pky">{{ $other_info['name'] }}</td>--}}
        {{--                        </tr>--}}
        {{--                    @endif--}}

        {{--                @endif--}}


        {{--            @endif--}}
        {{--        @endif--}}
        {{--        @if(!empty($res->ip))--}}
        {{--            <tr>--}}
        {{--                <td class="tg-0pky">ZİYARETÇİ İP ADRESİ</td>--}}
        {{--                <td class="tg-0pky">{{ $res->ip }}</td>--}}
        {{--            </tr>--}}
        {{--        @endif--}}

        <tr>
            <td class="tg-btxf">KONAKLAYACAK KİŞİ SAYISI</td>
            <td class="tg-btxf">
                {{ $res->adult_count }} Yetişkin @if(!empty($res->child_count)), {{ $res->child_count }}
                Çocuk @endif @if(!empty($res->baby_count)), {{ $res->baby_count }} Bebek  @endif
            </td>
        </tr>
    </table>
</div>
<br>
<div class="tg-wrap">
    <table class="tg">
        <tr>
            <th class="tg-0pky" colspan="2"><b>TESİS DETAYLARI</b></th>
        </tr>
        <tr>
            <td class="tg-btxf">TESİS ADI</td>
            <td class="tg-btxf">{{ ($website->id==2)?$villa->name:$website->prefix.$villa->code }}</td>
        </tr>
        @php
            $villaseo = DB::table('website_panel_seos')->select('seo_url')->where('item_id', $villa->id)->where('website_id',$website->id)->where('pivot','website_panel_villas')->first();
        @endphp
        @if(isset($villaseo) && !empty($villaseo))
            @php
                $url = isset($villa_seo) ? $website->domain . '/' . $villa_seo->seo_url : '';
            @endphp
            <tr>
                <td class="tg-btxf">VILLA WEB LINKI</td>
                <td class="tg-0lax">
                    <a target="_blank"
                       href="https://www.{{($website->domain."/".$villaseo->seo_url)}}">http://www.{{($website->domain."/".$villaseo->seo_url)}}</a>
                </td>
            </tr>
        @endif

        <tr>
            <td class="tg-btxf">GİRİŞ TARİHİ</td>
            <td class="tg-btxf">{{ date('d/m/Y', strtotime($res->start_date)) . ($villa->checkin_time ? " (EN ERKEN " . $villa->checkin_time . ")":"")  }}</td>
        </tr>
        <tr>
            <td class="tg-btxf">ÇIKIŞ TARİHİ</td>
            <td class="tg-btxf">{{ date('d/m/Y', strtotime($res->end_date)) . ($villa->checkin_time ? " (EN GEÇ " . $villa->checkout_time . ")":"") }}</td>
        </tr>
    </table>
</div>
<br>
<div class="tg-wrap">
    <table class="tg">
        <tr>
            <th class="tg-0pky" colspan="2"><b>ÖDEME DETAYLARI</b></th>
        </tr>
        @if($res->refundable == 1)
            <tr>
                <td class="tg-btxf">REZERVASYON ÖN ÖDEME TUTARI</td>

                <td class="tg-btxf">{{ number_format($res->pre_payment - $res->refundable_total, 0) }} TL</td>

            </tr>
            <tr>
                <td class="tg-btxf">İPTAL GÜVENCE BEDELİ</td>

                <td class="tg-btxf">{{ number_format($res->refundable_total, 0) }} TL  ({{ date('d-m-Y', strtotime($res->refundable_last_date)) }} tarihine kadar yapılan iptallerde Rezervasyon Ön Ödemesi koşulsuz iade edilir,İptal Güvence Bedeli iade edilmemektedir.)</td>

            </tr>
            <tr>
                <td class="tg-btxf">TOPLAM ÖN ÖDEME</td>

                <td class="tg-btxf">{{ number_format($res->pre_payment, 0) }} TL</td>

            </tr>
        @else
            <tr>
                <td class="tg-btxf">ÖDENEN TUTAR</td>
                @if(empty($res->pre_payment_alter))
                    <td class="tg-btxf">{{ number_format($res->pre_payment, 0) }} TL</td>
                @else
                    <td class="tg-btxf">{{ number_format($res->pre_payment_alter, 0) }} TL</td>
                @endif

            </tr>
        @endif
        <tr>
            <td class="tg-0pky">VİLLAYA GİRİŞTE ÖDENECEK TUTAR</td>
            @if(empty($res->entry_payment_alter))
                <td class="tg-0pky">{{ number_format($res->entry_payment, 0) }} TL</td>
            @else
                <td class="tg-0pky">{{ number_format($res->entry_payment_alter, 0) }} TL</td>
            @endif

        </tr>
        <tr>
            <td class="tg-btxf">TOPLAM TUTAR</td>
            @if(empty($res->total_alter))
                <td class="tg-btxf">{{ number_format($res->total_price, 0) }} TL</td>
            @else
                <td class="tg-btxf">{{ number_format($res->total_alter, 0) }} TL</td>
            @endif
        </tr>
    </table>
</div>


<p class="bold">
    MÜŞTERİ
</p>
<p>
    WİNGS aracılığı ile gerçek kişi veya tüzel kişilerin web sitesinde doğrudan bizim üzerimizden ya da kendileri
    vasıtasıyla hizmetlerimizi sunduğumuz veya sitelerimiz üzerinden dolaylı olarak hizmetlerimizden yararlanan,
    villa, apart,konut, ve diğer hizmetlerinin ilanlarını sitemiz aracılığı ile kiralamak üzere sitemizde yayınlayan
    müşteriyi ifade eder. Müşteriler aynı zamanda kiralama yapan kişilerdir.
</p>
<br>
<p class="bold">
    REZERVASYON ÖDEMESİ
</p>
<p>
    Rezervasyon talebinizin online olarak web sitesi üzerinden alınmasına müteakip tesisin müsaitliği tesis sahibinden
    teyit edilip tarafınıza ön ödeme bilgilerini içeren bir mail gönderilir,rezervasyon ön ödemesi rezervasyon
    talebinden sonra en geç 24 saat içerisinde yapılmalıdır.
    <br>
    Rezervasyon yaptığınız tesis ile ilgili toplam rezervasyon bedelinin belli bir tutarı kredi kartı veya banka
    havalesi ile yapılması gerekmektedir.
    <br>
    Rezervasyon ön ödeme oranı konaklama yapacağınız tesise göre toplam tutarın %20-%50'si arasındadır net ön ödeme
    tutarını tesisin sayfasında giriş ve çıkış tarihleri seçildiğinde fiyat tablosunda görülebilir.
    <br>
    Ön Ödemenin tarafımıza ulaşmasına müteakip sisteme kayıtlı e-posta adresinize rezervasyon onayı ve sözleşmeniz
    iletilmektedir.Kalan ödeme tutarı tesise giriş gününde <b>NAKİT</b> olarak ödenir.
    <br>
    Kiralama bedeli yabancı para birimi ise ve ziyaretçi ödemeyi TL bazında yapmak isterse, merkez bankası günlük satış
    fiyatı baz alınacaktır.
</p>
<p class="bold">
    HASAR DEPOZİTOSU
</p>
<p>
    Gerçekleşen tüm Rezervasyonlar için bir hasar depozitosu bedeli tespit edilmiştir, bu rakam apart veya villa
    çeşitlerine göre 500 TL ile 3.500 TL arasında değişmektedir
    Rezervasyonu gerçekleştiren kişi hasar bedelini tesise girişte NAKİT olarak öder .Misafirin tesisten ayrılacağı gün
    tesis görevlisi odayı kontrol eder, hasar depozitosu geri ödemesi (hasar yoksa) çıkışta ödenir.
    Hasar depozitosu sadece villa/apart kiralamalarında alınmaktadır Otel konaklamalarında hasar depozitosu
    alınmamaktadır.
</p>
<p class="bold">
    REZERVASYON İPTAL KOŞULLARI
</p>
<ul>
    <li>
        * Rezervasyon iptalinin mail ya da fax yolu ile bildirilmesi gerekmektedir.
    </li>
    <li>
        *Rezervasyonun onaylanmasını takip eden 24 saat içerisinde İPTAL gerçekleşirse ziyaretçi ödemiş olduğu kaporayı
        koşulsuz iade alır.
    </li>
    <li>
        * Rezervasyon iptali seyahat başlangıcından 30 gün veya daha uzun süre önce gerçekleşirse, ziyaretçi,toplam
        seyahat
        bedelinin %35’ini ödemek zorundadır. Eğer ödemiş olduğu kapora %35'ten fazla ise arada oluşan farkı geri
        alabilecektir eğer %35'ten daha az ön ödeme yapıldıysa zirayetçi arada oluşan farkı ödemekle yükümlüdür.
    </li>
    <li>
        * Rezervasyon iptali seyahat başlangıcından 8-29 gün kadar öncesi gerçekleşirse, ziyaretçi,toplam seyahat
        bedelinin
        %50'sini ödemek zorundadır.
    </li>
    <li>
        *Rezervasyon iptali seyahat başlangıcından 0-7 gün kadar öncesi gerçekleşirse veya ziyaretçi konaklama tesisine
        giriş yapmazsa toplam seyahat bedelinin %100'ünü ödemek zorundadır.

    </li>
    <li>

        * ZİYARETÇİ'nin işbu sözleşmeden kaynaklanan tazminat ödemesini yapmadığı durumlarda, bu ücretler WİNGS
        tarafından
        İhtarname yada İcra takibi vasıtası ile yasal olarak

    </li>
    <li>
        ZİYARETÇİ‘den talep edilir.Bu gibi durumlarda doğabilecek tüm masraflar (Avukat, noter, icra ve dosya masrafları
        vs…)ödenecek ücrete ilaveten ZİYARETÇİ‘den talep edilmektedir
    </li>
</ul>


<p class="bold">
    CAYMA HAKKI
</p>
<p class="bold">
    6502 sayılı Tüketicinin Korunması Hakkında Kanunun 48 inci ve 84 üncü maddelerine dayanılarak hazırlanan Mesafeli
    Sözleşmeler Yönetmeliği’nin 15. maddesi’nin (g) bendi uyarınca, Belirli bir tarihte veya dönemde yapılması gereken,
    konaklama, eşya taşıma, araba kiralama, yiyecek-içecek tedariki ve eğlence veya dinlenme amacıyla yapılan boş
    zamanın değerlendirilmesine ilişkin sözleşmelerde tüketici cayma hakkını kullanamaz.
</p>
<p class="bold">
    İSTİSNAİ DURUMLAR
</p>
<p>
    * Tamamen kontrolümüz dışında gerçekleşen savaş, savas tehdidi, toplumsal kargaşa, terörist eylemler, doğal afetler,
    sağlık riskleri,salgın hastalıklar(Covid-19 vb) veya rezervasyon sahibinin 1. derece yakın ailesinde vefat gibi
    durumlarda gerekli belgeler firmamıza sunulduğu takdirde rezervasyon için ödenmiş olan ön ödeme farklı bir
    rezervasyonda kullanılmak üzere açığa alınır ve yeni yapılacak olan rezervasyonun toplam tutarından düşülerek işlem
    yapılır.
</p>
</br>
<p class="bold">
    Yeni yapılacak rezervasyonun toplam tutarı seçilen tesise veya konaklanacak tarihlere göre değişiklik gösterebilir.
</p>

<p class="bold">
    CHECK-IN VE CHECK- OUT
</p>
<p>
    Taşınmazlara giriş (Check-in) saat 16:00’dan sonra, çıkış (Check-out) ise en geç sabah saat 10:00’da olmalıdır. Bu
    arada kalan zaman dilimi taşınmazların temizliği ve bir sonraki ziyaretçi’nin girişi için ayrılmıştır. Sadece uygun
    durumlarda geç çıkış veya erken girişe izin verilir. Bunun haricinde ziyaretçi belirtilen saatte çıkış yapmak
    zorundadır.

    Geç çıkış yapıldığı takdirde ziyaretçi bu durumdan kaynaklanabilecek olan kayıpları ödemeyi kabul ve taahhüt eder.

    Mesai saati bitimi olan saat 19:00’dan sonraki (Saat 23:59'a kadar) karşılamalarda, eğer firmanın onayı alınmamış
    ise WİNGS'in ekstra olarak 190 TL karşılama ekstra mesai ücreti talep etme hakkı doğar. Bu ücret ödenmeden tesise
    giriş yapılamaz. ZİYARETÇİ yola çıkmadan önce varış saatini bu saatlere denk getirmekle yükümlüdür.(Saat 23:59'dan
    sonraki girişler kabul edilmemektedir.)
</p>
<p>
    Mesai saati bitimi olan saat 19:00’dan sonraki (Saat 23:59'a kadar) karşılamalarda, eğer firmanın onayı alınmamış
    ise {{$website->name}}'ın ekstra olarak 190 TL karşılama ekstra mesai ücreti talep etme hakkı doğar. Bu ücret
    ödenmeden villaya giriş yapılamaz. ZİYARETÇİ yola çıkmadan önce varış saatini bu saatlere denk getirmekle
    yükümlüdür.(Saat 23:59'dan sonraki girişler kabul edilmemektedir.)
</p>
<p class="bold">
    TEMİZLİK
</p>
<p>
    Tüm villa ve apartlar girişte temiz olarak teslim edilir.
</p>
<p class="bold">
    KİŞİ SAYISI
</p>
<p>
    Konaklanacak tesiste en fazla konaklayabilecek kişi sayısı internet sitemizde açıkça belirtilmiştir.Ziyaretçi
    internet sitesinden rezervasyon talebi iletirken konaklayacak kişi sayısını seçmiş ve rezervasyon bu şekilde
    onaylanmıştır.Ziyaretçinin konaklama yaptığı tesiste kişi kapasitesinin üzerinde konaklama yaptığı tespit edilirse
    mülk sahibi veya firmamız ek ücret talep edebilir ya da ücret iadesi yapmaksızın Ziyaretçi ve yanında diğer
    konaklayanların tesisten çıkışını yapabilir.
</p>
<p class="bold">
    ÖZEL TALEPLER
</p>
<p>
    Özel istek ve taleplerinizin rezervasyon esnasında bildirilmesi gereklidir. Özel istek ve taleplerinizin
    karşılanması için azami gayret gösterileceğini belirtiriz.


</p>
<p class="bold">
    SÖZLEŞMENİN AKTEDİLMESİ
</p>

<p>*İşbu sözleşme web sitemizde açıkça gösterilmektedir https://{{$website->domain}}/rezervasyon-kosullari</p>
<p>
    *Ziyaretçi rezervasyon talep sayfasında sözleşmeyi açıkça görmüş ve koşulları site üzerinde elektronik ortamda
    onaylamış ve bu şekilde rezervasyon talebini WİNGS'e iletmiştir.


</p>
<p>
    *Ziyaretçi sözleşme’yi okuduğunu, anladığını, haklarının ve yükümlülüklerinin bilincinde olduğunu kabul eder.


</p>
<p>
    * Ziyaretçi, sözleşme ile kararlaştırılan edimler arasında hiçbir oransızlık bulunmadığını ve karşılıklı edimlerin
    işin niteligine uygun olduğunu, sözleşme konusuna giren işlemler kapsamında herhangi bir tecrübesizliklerinin
    bulunmadığını kabul ederler.


</p>
<p>
    * Ziyaretçi, sözleşme kapsamında yer alan işlemlerin kendi menfaatine uygun olduğu konusunda tam bir kanaate
    vardığını ve tüm şartlara kendi özgür iradesi ile, hiçbir güçlük veya sıkıntı içinde olmadan, düşünerek, isteyerek
    ve bilerek uyacağını kabul eder.
</p>
<p>
    * WİNGS ve ziyaretçi, sözleşmenin hükümlerinin haksız şart sayılabilecek bir özellik taşımadığını, menfaatler
    dengesi bakımından bir haksızlık olmadığını kabul eder.
</p>
<p>
    İşbu sözleşme hükümleri tüketici sözleşmelerindeki haksız şartlar hakkında yönetmelik hükümleri uyarınca herhangi
    bir haksız şart içermemektedir.
    hükümler dürüstlük ve iyi niyet kuralına aykırılık teşkil etmemekte olup tüketicinin korunması mevzuatına uygun
    olarak hazırlanmıştır.
</p>
<p>
    İşbu sözleşme hükümleri 6098 sayılı borçlar kanunu hükümleri de dikkate alınarak hazırlanmıştır. borçlar kanunu’nun
    21. maddesinde öngörülen bağlayıcılık
    ve içerik denetimi ziyaretçi tarafından yapılmıştır. işbu sözleşme hükümlerinden hiçbiri işbu sözleşme’nin
    niteliğine ve işin özelliğine yabancı (şaşırtıcı şartlar)</br> </br> nitelik taşımaz. işbu sözleşme hükümleri açık ve anlaşılır
    bir şekilde yazılmış olup birden çok anlamı ifade etmemektedir.
</p>
<p class="bold">
    FİRMAMIZIN SORUMLULUKLARI
</p>
<p>
    *Web sitemizden rezervasyon yaptığı tarihten itibaren villaya girişe kadar bu rezervasyon ile ilgili tüm işlemler
    firmamızın sorumluluğundadır.


</p>
<p>
    * Konutta olabilecek aksaklıkları(elektrik arızası, su arızası vs.) en kısa zamanda onarımını veya bakımını
    yaptırır. Fakat yaz aylarının çok yoğun olması sebebi ile gecikmeler yaşanabileceğini de hatırlatmak isteriz.

</p>
<p>
    * Ziyaretçilerin özel eşyalarından firmamız hiç bir şekilde sorumlu değildir. Tatil beldelerinde hırsızlık
    olaylarının olabileceğini dikkate alarak misafirlerimizin dikkatli olmalarını öneriyoruz.
</p>
<p>
    * Seyahat sigortası yaptırmanızı öneririz. Eve ait eşyaların çalınması, zarar görmesi veya benzer koşullarda, olay
    yerinde inceleme yapan polis veya jandarmanın raporuna göre hareket edilecektir.
</p>
<p>
    * Tamamen kontrolümüz dışında gerçekleşen savaş, savas tehdidi, toplumsal kargaşa, terörist eylemler, doğal
    afetler, sağlık riskleri ve şiddetli hava koşulları gibi durumlardan kaynaklanan değişikliklerden sorumluluk
    kabul etmeyeceğimiz gibi para iadesi de yapmayacağımızı belirtmek isteriz.
</p>
<p>
    * Evde kaynaklanan konaklama konforunu etkileyen arıza 48 saat içerisinde giderilecektir,bu süreyi aşan durumlarda
    Ziyaretçi'nin kaldığı tesise muadil farklı bir tesise geçme hakkı bulunmaktadır.
</p>
<p>
    * Doğa içerisinde konuma sahip olan tüm villalarımızda düzenli olarak ilaçlama yapılmaktadır. Ancak mevsimsel ve
    konumları itibari ile çevrede; kelebek, böcek, sinek,arı,akrep,karınca vs. bulunma ihtimali göz önüne alınmalıdır.
    Bu durumdan dolayı firmamız sorumlu
    tutulmayacaktır.
</p>
<p class="bold">
    VERGİ VE FATURALANDIRMA
</p>
<p>
    Web sitemizde yayınlanan hiç bir villa, veya apart, firmamıza ait değildir. Her villanın/apartın sahipleri farklı
    gerçek veya tüzel kişilerdir.

    WİNGS, gerçek yada tüzel kişilerin villalarını/apartlarını müşteriye kiralamak için aracılık konumundadır. Bu
    nedenle WİNGS sadece komisyon faturası keser. Ziyaretcinin ödediği bedelin belirli bir tutarı komisyon geliridir ve
    bu gelire istinaden komisyon faturası ibraz etmektedir.

    Ziyaretci tarafından ödenen toplam tutarın firmamız tarafından fatura keşide edilmeyen kalan kısmı villa/apart
    sahibinin geliridir.

    Villa/Apart sahibi vergi mükellefi ise kiralamadan elde ettiği gelire karşılık fatura düzenler aksi durumda kira
    gelirleri devlete beyannamede bulunarak vergilendirilirler.

    WİNGS üçüncü şahısların, kurumların, kişilerin, şirketlerin elde etiği gelir için fatura ibraz etmez, bu durumdan
    kaynaklı bir yükümlülüğü bulunmamaktadır.
</p>

<p>
    WİNGS; villanın/apartın/dairenin belirlenen tarih ve saatte, temiz ve kullanıma hazır olarak müşteriye teslim
    edilmesinden sorumludur. Villaya/Aparta/daireye girişte, eğer bozuk, çalışmayan herhangi bir eşya ya da aksaklık
    varsa müşteri tarafından WİNGS'e derhal bildirilmeli ve bu aksaklıkların giderilmesi talep edilmelidir.WİNGS bu
    talebi villa/apart/daire sahibine ya da ilgili şirkete bildirecek ve en geç 48 saat içinde bu aksaklığın
    giderilmesini sağlayacaktır. WİNGS aksaklığın giderilmesinden sorumlu değildir, aksaklığın giderilmesine yardımcı
    olur. WİNGS, zamanında bildirilmeyen aksaklıklardan sorumlu tutulamaz. WİNGS villa/apart/daire sahibi ile müşteri
    arasında aracı durumundadır ve bu nedenle villada/apartta/dairede oluşabilecek aksaklıkların giderilmesinden
    villa/apart/daire sahibi sorumludur. Bunun dışında ortaya çıkabilecek ve müşterilerin kendi sorumluluklarında olan
    hiçbir kaza, hastalık, yaralanma, havuzda boğulma, ölüm, hırsızlık, düşme vb. ve villada/apartta/dairede olabilecek
    yangın, hırsızlık vb. olaylardan ve kazalardan WİNGS sorumlu tutulamaz. Bunun dışında, müşterinin
    villaya/aparta/daireye ulaşmasında, geri dönüşlerinde, tatil sırasında üçüncü şahıslardan/firmalardan alacakları
    gezi, alışveriş, yiyecek, içecek, eğlence, ulaşım, seyahat, rehberlik hizmetleri vb. gibi herhangi bir servisten
    doğacak sorunlardan WİNGS kesinlikle sorumlu olmayacaktır. <b>Ziyaretçi, villadan/aparttan/daireden ayrıldıktan
        sonra,
        villada/apartta/dairede kaldığı süre içerisinde WİNGS'e bildirmediği bir aksaklık ya da arıza nedeni ile
        alamadığı
        bir hizmet için herhangi bir hak ya da geri ödeme talep edemez.</b>
</p>
</br></br>
<p class="bold">
    ZİYARETÇİNİN SORUMLULUKLARI
</p>
<ul>
    <li>
        * Evin içerisinde sigara içilmesi yasaktır.


    </li>
    <li>
        * Firmamızdan onay alınmadığı takdirde evcil hayvan kabul edilmez.


    </li>
    <li>
        * Ziyaretçiler kiraladıkları tatil konutunun tüm eşyalarını ve mobilyalarını kullanmaya yetkilidir. Fakat tüm
        ekipmanları temiz ve hasar vermeden kullanmaya
        özen göstermelidir. Herhangi bir hasar ziyanda firmamızı haberdar etmelidir.


    </li>
    <li>
        * Oluşan herhangi bir hasarın bedeli neyse depozitodan düşülecektir. Hasar bedeli depozito bedelinden yüksek ise
        ziyaretçi fazlasını ödemeyi kabul eder.


    </li>
    <li>
        *Ziyaretciler 678 sayılı kanun hükmünde kararname, 22 Kasım 2016 tarihli ve 29896 sayılı Resmi Gazete de
        yayımlanan Kimlik Bildirme Kanununa göre;

        Villaya girişlerden önce villada konaklayacak tüm kişilerin kimliklerini (Nüfus Cüzdanı,Ehliyet,Pasaport) firma
        yetkilisine veya firmanın belirlediği kişi

        veya kişilere bildirmek ile yükümlüdür.


    </li>
    <li>
        *Ziyaretciler, bu Sözleşme’den kaynaklanan hak ve yükümlülüklerini WİNGS onayı olmadan devredemezler. WİNGS
        sözleşme’den kaynaklanan

        hak ve yükümlülüklerini 3. kişilere devredebilir.
    </li>
    <li>
        *Kullanan, taşınmazı hukuka ve genel ahlak kurallarına uygun şekilde, temiz, dikkatli ve özenli şekilde ve
        anlaşma ve mutabakata uygun bir tarzda kendi

        malı gibi koumalı ve gelebilecek tüm tehlikelerden uzak tutmalıdır.
    </li>
    <li>
        *Taşınmazın kullanımı için ziyaretçinin kontrolüne bırakıldığı sırada hukuka ve genel ahlak kurallarına uygun
        şekilde, temiz, dikkatli ve özenli şekilde ve

        anlaşma ve mutabakata uygun bir tarzda kendi malı gibi kullanılmaması ve/veya gelebilecek tehlikelerden uzak
        tutulmaması halinde ziyaretci,

        Taşınmaz Sahibi’ne karşı kusuru oranında sorumlu olacak, WİNGS kesinlikle sorumlu olmayacaktır.
    </li>
    <li>
        *Taşınmaz esas olarak sadece ziyaretçi ve sözleşme belirtilen kişiler tarafından kullanılacaktır.Sözleşme
        belirtilen kişiler dışında, kişilerin de kullandırılabileceğine

        dair bir şart bulunmadığı takdirde Taşınmaz başkasına kullandırılamaz. İzin verilen kişilerin bulunması halinde
        dahi bu kullandırmalar ziyaretçi tarafından

        bedel karşılığında üçüncü kişilere tahsis edilemez. Ziyaretinin izin verdiği kişilerin de kullandırılabileceğine
        dair bir şart bulunması halinde söz konusu izin

        verilen kişilerin bu Sözleşmede yer alan hükümlere aykırı hareketleri doğrudan ziyaretçinin aykırılığı olarak
        telakki edilir. Kullanan taşınmazı başkalarına

        kullandırarak ticari veya benzeri kazanç sağlayamaz.
    </li>
    <li>
        * Ziyaretçiler kullanılan evin çevresindeki komşulara karşı anlayışlı olmalı ve çevreyi rahatsız edecek her
        türlü davranış ve gürültüden sakınmalıdır.

        Ayrıca kanunen yasak olan herhangi bir yasadışı (silah, uyuşturucu, her türlü kaçakçılık vs..) faaliyet içinde
        bulunmamalıdır. Böyle bir durum karşısında

        WİNGS‘İn derhal ve ihtara gerek kalmadan evi tahliye ettirme hakkı saklıdır. Anılan sebeplerle yapılacak tahliye
        esnasında oluşabilecek zarar ve kayıplardan

        WİNGS sorumlu tutulamaz.

        Bu anlaşma ile evin söz konusu tarihlerde başkasına kiralanmayacağı teminat altına alınmaktadır. Afet ve mücbir
        sebepler durumunda bu sözleşme geçersiz olacaktır.
    </li>
    <li>
        *Villaya/Aparta giden yolların bozuk olması, yokuş yukarı olması, stabilize olması, ıslak zemin olması vs. gibi,
        WİNGS'in önüne geçemediği durumlarda

        WİNGS kesinlikle sorumlu tutulamaz.
    </li>
    <li>
        *Villaya/Aparta ulaşım esnasında oluşabilecek kaza vs. kısacası her türlü olumsuzluktan WİNGS kesinlikle sorumlu
        tutulamaz.


    </li>
    <li>
        *Bazı villaların inşaasında kullanılan, farklı malzemeler (sedir ağacı, çam ağacı, bazıplastik ürünler, bahçede
        veya villanın içinde bulunan her türlü bitki vs.) müşteriyi sağlıksal yönden veya psikolojik yönden rahatsız
        etmesi durumunda, bu olaydan WİNGS'in kesinlikle sorumlu tutulamaz.


    </li>
    <li>
        Müşterinin villaya/aparta ulaşımı kendi sorumluluğundadır. WİNGS, müşteriyi hiçbir zaman, hiç bir şekilde
        kiraladığı villaya/aparta, WİNGS Firmasının otomobili içerisinde taşımaz. Müşteri, üçüncü kişilerden taksi,
        transfer aracı veya kiralık araç temin edebilir. WİNGS, üçüncü şahıslardan kiralanacak veya kiralanmış olan veya
        transfer veya taksi hizmetine karışmaz.


    </li>
    <li>
        *Villa veya apart kiralamış olan müşteri, kiralamış olduğu villanın veya apartın coğrafi konumundan dolayı
        hoşnutsuz kalması durumundan WİNGS sorumlu tutulamaz. WİNGS, villanın/apartın konumunu Google Harita üzerinden,
        yaklaşık olarak işaretlemiştir


    </li>
    <li>
        Villaya/Aparta ulaşım esnasında, özel veya kiralamış olduğunuz aracın zarar görmesinden WİNGS Villa sorumlu
        tutulamaz.


        *Villayı/Apartı kiralamış olan müşterinin aracının (motor, otomobil vs.) altının yere yakın olması, aracın motor
        gücünün zayıf olması, müşterinin; otomobil, motor vs. kullanmadaki acemiliği ve buna bağlı olarak villaya/aparta
        ulaşamaması sebebiyle ortaya çıkabilecek her türlü olumsuzluk müşterinin kendi sorumluluğundadır. Bu gibi veya
        buna benzer sorunlardan WİNGS kesinlikle sorumlu tutulamaz.


    </li>
    <li>
        *Villalarımızın/Apartlarımızın aksi belirtilmediği taktirde yüzme havuzları ısıtmalı değildir. Mevsim şartlarına
        göre sıcaklıkları değişiklik gösterir, havuz suyu sıcaklığı veya soğukluğu sebebi ile müşterinin havuzu
        kullanamaması durumunda, WİNGS hiç bir şekilde sorumlu tutulamaz. Müşteri, villayı/apartı kiralamadan önce,
        Meteoroloji Genel Müdürlüğü’nün web sitesinden veya telefonundan hava durumu hakkında bilgi alabilirler.


    </li>
    <li>
        Villaya/Aparta ulaşım esnasında, özel veya kiralamış olduğunuz aracın zarar görmesinden WİNGS Villa sorumlu
        tutulamaz.


    <li>
        Villalarımızda/Apartlarımızda aksi belirtilmediği taktirde jeneratör bulunmamakta olup,
        konaklama süresince oluşan genel elektrik kesintileri ile ilgili olarak WİNGS sorumlu tutulamaz.


    </li>
    <li>
        Villalarımızda/Apartlarımızda aksi belirtilmediği taktirde jeneratör bulunmamakta olup,
        konaklama süresince oluşan genel elektrik kesintileri ile ilgili olarak WİNGS sorumlu tutulamaz.
    </li>
</ul>

<p class="bold">
    HUKUKİ ŞARTLAR
</p>
<ul>
    <li>
        a. Uygulanacak Hukuk: Taraflar, işbu Sözleşme’nin uygulanması ve yorumlanması ile ilgili ihtilafların Türkiye
        Cumhuriyeti yasalarına göre çözümleneceğini kabul etmektedirler.


    </li>
    <li>
        (b) Yetkili Mahkeme: İşbu Sözleşme’den doğan ihtilafların hallinde münhasıran Kaş Mahkemeleri ve İcra Daireleri
        yetkilidir. İşbu Sözleşme’den dolayı her türlü şikayet ve itirazlar, Gümrük ve Ticaret Bakanlığı’nca her yıl
        Aralık ayında belirlenen parasal sınırlara göre merkezi bulunan yerdeki Tüketici Sorunları Hakem Heyeti’ne veya
        Tüketici Mahkemesi’ne yapılabilecektir.


    </li>
    <li>
        (c) Ayrılabilirlik: Sözleşme’nin esaslı olmayan hükümlerinden herhangi birisinin veya bir kısmının, kısmen veya
        tamamen hukuken geçersiz olması ve Sözleşme’nin geri kalan hükümlerinin bu hüküm veya kısım olmaksızın da icra
        kabiliyetinin olduğunun anlaşılması halinde bu durum yalnızca söz konusu hüküm veya kısım için geçerli olacak ve
        diğer Sözleşme hükümlerinin geçerliliğini veya yürürlülüğünü etkilemeyecektir.


    </li>
    <li>
        (d) Sözleşmenin Dili: İşbu Sözleşme Türkçe olarak hazırlanmış ve elektronik ortamda imzalanmıştır.

    </li>
    <li>
        (e) Sözleşme ve Eklerinin Bütünlüğü ve Tadiller: Sözleşmenin ekleri bu Sözleşmenin ayrılmaz bir parçasını teşkil
        edecek olup birbirlerinden ayrı olarak yorumlanamaz.


    </li>
    <li>
        (f) WİNGS İletişim Bilgileri:


        <ul>
            <li>
                Merkez:


                Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirketi'ni (Kaş V.D. 813 105 78 04 ) Kalkan Mah.
                Cumhuriyet Cad. No:48/2 Kaş Antalya

                Telefon: 0242 252 00 32

                E-posta: {{ 'info@' . $website->domain }}

                Fethiye Şubesi:Baha Şıkman caddesi no:41/1 Taşyaka Mahallesi Fethiye Muğla

                Telefon:0252 606 08 76
            </li>
        </ul>

    </li>
    <li>
        (g) Tüketici İlişkileri: Ziyaretci ile WİNGS arasında çıkabilecek sıkıntıları WİNGS iyi niyet ve
        dürüstlük kaideleri kapsamında çözmek için her türlü gayreti
        sarfedecektir.

        Fakat şikayet ve itirazlar içintüketici sorunları hakem heyetine veya tüketici mahkemesine
        başvurulabilir. Mesafeli Sözleşmelere Dair Yönetmelik hükümleri uyarınca cayma hakkının

        kullanılamayacağı istisnai durumlara girmesi sebebiyle- işbu Sözleşme kapsamında ziyaretçinin cayma
        hakkı bulunmaz.
    </li>
    <li>
        (h) {{$website->domain}} Üzerinden Yapılan İşlemler ve irade açıklaması niteliğindeki işlemler 6098 sayılı
        Borçlar Kanunu, Tüketici Mevzuatı ve yürürlükte bulunan sair mevzuat uyarınca Tarafları bağlayıcı irade
        açıklamaları olarak telakki edilirler.
    </li>
</ul>
<p>
    Yukarıda belirtilen maddelerin doğrultusunda WİNGS para iadesi olmadan kontratı iptal eder.
</p>
<p>
    @if(!empty($res->ip))
        {{ $res->ip }} numaralı ip üzerinden rezervasyon talebi alınmıştır.
    @endif

</p>
<p style="float: left">
    Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirket
    <br>
    (Kaş V.D. 813 105 78 04 )
</p>
<p style="float: right">
    {{ $customer->name }} </br> {{ $customer->idnumber }} @if($res->idnumber) ) ({{ $customer->idnumber }}) @endif
    <span></span>
</p>
</div>

<script src="/reservation_assets/js/html2pdf.bundle.min.js"></script>
<script>
      function test() {
        // Get the element.
        var element = document.getElementById('root');

        // Generate the PDF.
        html2pdf().from(element).set({
          margin: 1,
          filename: '{{ $res->code }}.pdf',
          html2canvas: { scale: 2 },
          jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
        }).save();
      }
    </script>


</body>
</html>

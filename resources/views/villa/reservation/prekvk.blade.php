@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush

@section('content')
<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<style>
        .check_mark {
            width: 80px;
            height: 130px;
            margin: 0 auto;
        }

        .hide {
            display: none;
        }

        .sa-icon {
            width: 80px;
            height: 80px;
            border: 4px solid gray;
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50%;
            margin: 20px auto;
            padding: 0;
            position: relative;
            box-sizing: content-box;
        }

        .sa-icon.sa-success {
            border-color: #4CAF50;
        }

        .sa-icon.sa-success::before, .sa-icon.sa-success::after {
            content: '';
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50%;
            position: absolute;
            width: 60px;
            height: 120px;
            background: white;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .sa-icon.sa-success::before {
            -webkit-border-radius: 120px 0 0 120px;
            border-radius: 120px 0 0 120px;
            top: -7px;
            left: -33px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 60px 60px;
            transform-origin: 60px 60px;
        }

        .sa-icon.sa-success::after {
            -webkit-border-radius: 0 120px 120px 0;
            border-radius: 0 120px 120px 0;
            top: -11px;
            left: 30px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 0px 60px;
            transform-origin: 0px 60px;
        }

        .sa-icon.sa-success .sa-placeholder {
            width: 80px;
            height: 80px;
            border: 4px solid rgba(76, 175, 80, .5);
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50%;
            box-sizing: content-box;
            position: absolute;
            left: -4px;
            top: -4px;
            z-index: 2;
        }

        .sa-icon.sa-success .sa-fix {
            width: 5px;
            height: 90px;
            background-color: white;
            position: absolute;
            left: 28px;
            top: 8px;
            z-index: 1;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .sa-icon.sa-success.animate::after {
            -webkit-animation: rotatePlaceholder 4.25s ease-in;
            animation: rotatePlaceholder 4.25s ease-in;
        }

        .sa-icon.sa-success {
            border-color: transparent \9;
        }

        .sa-icon.sa-success .sa-line.sa-tip {
            -ms-transform: rotate(45deg) \9;
        }

        .sa-icon.sa-success .sa-line.sa-long {
            -ms-transform: rotate(-45deg) \9;
        }

        .animateSuccessTip {
            -webkit-animation: animateSuccessTip 0.75s;
            animation: animateSuccessTip 0.75s;
        }

        .animateSuccessLong {
            -webkit-animation: animateSuccessLong 0.75s;
            animation: animateSuccessLong 0.75s;
        }

        @-webkit-keyframes animateSuccessLong {
            0% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            84% {
                width: 55px;
                right: 0px;
                top: 35px;
            }
            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }

        @-webkit-keyframes animateSuccessTip {
            0% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }
            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }
            100% {
                width: 25px;
                left: 14px;
                top: 45px;
            }
        }

        @keyframes  animateSuccessTip {
            0% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }
            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }
            100% {
                width: 25px;
                left: 14px;
                top: 45px;
            }
        }

        @keyframes  animateSuccessLong {
            0% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            84% {
                width: 55px;
                right: 0px;
                top: 35px;
            }
            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }

        .sa-icon.sa-success .sa-line {
            height: 5px;
            background-color: #4CAF50;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 2;
        }

        .sa-icon.sa-success .sa-line.sa-tip {
            width: 25px;
            left: 14px;
            top: 46px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .sa-icon.sa-success .sa-line.sa-long {
            width: 47px;
            right: 8px;
            top: 38px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        @-webkit-keyframes rotatePlaceholder {
            0% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            5% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            12% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
            100% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
        }

        @keyframes  rotatePlaceholder {
            0% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            5% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            12% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
            100% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
        }
    </style>
   <section class="Hakkimizda " style="margin-top: 150px;" >
    <div class="Hakkimizda-text">
        <div class="container">
            <div class="Hakkimizda-text-in flex-column">
              
            <h3 style="text-align: center;"><strong>K??????SEL VER??LER??N KORUNMASI HAKKINDA AYDINLATMA METN??</strong></h3>
<ul>
<li><strong>K??????SEL VER??LER??N KORUNMASINA ??L????K??N TANIMLAR NELERD??R?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Ki??isel Verilerin Korunmas??na ??li??kin Ayd??nlatma Metni, 6698 Ki??isel Verilerin Korunmas?? Kanunu&rsquo;nun 10. Maddesi gere??ince veri sorumlular?? taraf??ndan ilgili ki??ilere sunulmas?? gereken bir y&uuml;k&uuml;ml&uuml;l&uuml;kt&uuml;r. Taraf??m??zca i??bu Ayd??nlatma Metni taraf??n??za sunulmakla metnin daha anla????labilir olmas?? i&ccedil;in tan??mlara a??a????da yer verilmektedir.</p>
<ol>
<li>a) Al??c?? grubu: Veri sorumlusu taraf??ndan ki??isel verilerin aktar??ld?????? ger&ccedil;ek veya t&uuml;zel ki??i kategorisini,</li>
<li>b) ??lgili ki??i: Ki??isel verisi i??lenen ger&ccedil;ek ki??iyi,</li>
<li>c) Kanun: 24/3/2016 tarihli ve 6698 say??l?? Ki??isel Verilerin Korunmas?? Kanununu,</li>
</ol>
<p>&ccedil;) Kurul: Ki??isel Verileri Koruma Kurulunu,</p>
<ol>
<li>d) Kurum: Ki??isel Verileri Koruma Kurumunu,</li>
<li>e) Sicil: Ba??kanl??k taraf??ndan tutulan Veri Sorumlular?? Sicilini,</li>
<li>f) Veri kay??t sistemi: Ki??isel verilerin belirli&nbsp;kriterlere&nbsp;g&ouml;re yap??land??r??larak i??lendi??i kay??t sistemini,</li>
<li>g) Veri sorumlusu: Ki??isel verilerin i??leme ama&ccedil;lar??n?? ve vas??talar??n?? belirleyen, veri kay??t sisteminin kurulmas??ndan ve y&ouml;netilmesinden sorumlu olan ger&ccedil;ek veya t&uuml;zel ki??iyi,</li>
</ol>
<p>??)<strong>&nbsp;</strong>Veri sorumlusu temsilcisi: T&uuml;rkiye&rsquo;de yerle??ik olmayan veri sorumlular??n??&nbsp;30/12/2017&nbsp;tarihli ve 30286 say??l?? Resm&icirc; Gazete&rsquo;de yay??mlanan Veri Sorumlular?? Sicili Hakk??nda Y&ouml;netmeli??in 11 inci maddesinin &uuml;&ccedil;&uuml;nc&uuml; f??kras??nda belirtilen konularda asgari temsile yetkili T&uuml;rkiye&rsquo;de yerle??ik t&uuml;zel ki??i ya da T&uuml;rkiye Cumhuriyeti vatanda???? ger&ccedil;ek ki??iyi,</p>
<p>ifade etmektedir.</p>
<ul>
<li><strong>K??????SEL VER?? VE AYDINLATMA Y&Uuml;K&Uuml;ML&Uuml;L&Uuml;??&Uuml; NE DEMEKT??R?</strong></li>
</ul>
<p>Ki??isel veri; kimli??i belirli veya belirlenebilir ger&ccedil;ek ki??iye ili??kin her t&uuml;rl&uuml; bilgiyi ifade etmekle ayd??nlatma y&uuml;k&uuml;ml&uuml;l&uuml;??&uuml; ise ki??isel verilerin elde edilmesi s??ras??nda veri sorumlular?? veya yetkilendirdi??i ki??ilerce, ilgili ki??ilerin bilgilendirilmesini kapsamaktad??r.</p>
<ul>
<li><strong>K??????SEL VER??LER??N??Z K??M TARAFINDAN ????LENMEKTED??R? </strong></li>
</ul>
<p>Wings Seyahat Turizm Sanayi ve Ticaret Limited ??irketi (VillaKalkan) olarak a??a????da a&ccedil;??k&ccedil;a belirtilecek olan ki??isel verileriniz i??lenmektedir. Taraf??m??zca siz de??erli m&uuml;??terilerimizin ki??isel verilerinin gizlili??i ve g&uuml;venli??i en &ouml;nemli hassasiyetlerimizdendir.</p>
<ul>
<li><strong>HANG?? K??????SEL VER??LER??N??Z ????LENMEKTED??R?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Balayi Sepeti taraf??ndan olu??turulan www.villkalkan.com.tr adresi &uuml;zerinden yay??nlanan tatil konutlar??n??n taraf??n??zca kiralanmak istenmesi ve/veya rezervasyon yapt??rman??z halinde a??a????da yer alan ki??isel verileriniz i??lenebilmektedir.</p>
<ul>
<li>Kimlik Bilgileriniz (Ad??n??z, soyad??n??z, TC kimlik numaran??z)</li>
<li>??leti??im Bilgileriniz (Telefon numaran??z, e-posta adresiniz, ileti??im adresiniz)</li>
<li>Lokasyon (Taraf??n??za daha iyi hizmet sunabilmek ad??na belirledi??iniz tarihler aras??nda kiralayarak bulundu??unuz tatil konutuna ili??kin lokasyon bilgileri)</li>
<li>M&uuml;??teri ????lem Bilgileriniz (Kiralanan tatil konutuna ili??kin rezervasyon &ouml;zetiniz, fatura bilgileriniz, giri?? &ccedil;??k???? tarihleriniz, talep ve ??ikayet bilgileriniz, IBAN ve hesap numaralar??n??z, &ouml;deme bilgileriniz.)</li>
<li>Fiziksel Mekan G&uuml;venli??i (Tatil konutuna giri??-&ccedil;??k???? tarihleri kay??tlar??n??z, tatil konutunda bulundu??unuz s&uuml;re i&ccedil;erisindeki g&uuml;venlik ama&ccedil;l?? bulunan kamera kay??tlar??)</li>
<li>????lem G&uuml;venli??i (IP bilgileriniz, balayisepeti.com.tr adresindeki &uuml;yelik giri??-&ccedil;??k???? bilgileriniz, &ccedil;erez bilgileriniz)</li>
<li>Pazarlama (balayisepeti.com.tr adresindeki al????veri?? ge&ccedil;mi??i bilgileriniz, &ccedil;erez kay??tlar??n??z, anket ve faaliyet konumuza ili??kin kampanya &ccedil;al????malar??)</li>
</ul>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong>K??????SEL VER??LER??N??Z HANG?? AMA&Ccedil;LA ????LENMEKTED??R?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Ki??isel verileriniz a??a????daki ama&ccedil;larla s??n??rl?? olmak &uuml;zere i??lenmektedir.</p>
<p><strong>&nbsp;</strong></p>
<ul>
<li>Rezervasyon talebinizin kar??????kl????a mahal vermeyecek ??ekilde olu??turulabilmesi</li>
<li>Rezervasyon ve &ouml;deme bilgilerinize ili??kin &ouml;zetin telefon ve e-posta yoluyla taraf??n??za iletilmesi</li>
<li>Konaklama bilgilerinizin kolluk kuvvetlerine bildirilebilmesi</li>
<li>Soru ve taleplerinize kar??????kl????a mahal vermeden cevap verebilmek veya &ccedil;&ouml;z&uuml;m &uuml;retebilmek</li>
<li>Tatil konutunda bulundu??unuz s&uuml;re i&ccedil;erisinde sorunlar??n eksiksiz ve gecikmeden &ccedil;&ouml;z&uuml;m&uuml;</li>
<li>Taraf??n??zdan &ouml;nce ve sonra konaklama yapacak di??er m&uuml;??terilerin rezervasyon taleplerinin olu??turulmas?? ve tatil konutuna ili??kin bo?? g&uuml;n ve tarihlerin belirlenebilmesi</li>
<li>??irketimiz taraf??ndan verilen hizmete ili??kin taraf??n??za ait fatura d&uuml;zenlenebilmesi</li>
<li>Taraf??n??zca yap??lm???? veya yap??lacak &ouml;demelerin kaydedilmesi</li>
<li>??ade edilmesi gereken tutarlar olmas?? halinde gecikmeksizin iadenin yap??labilmesi</li>
<li>Tatil konutunda bulundu??unuz s??rada siz ve yan??n??zda bulunan di??er ki??ilerin g&uuml;venli??inin sa??lanabilmesi</li>
<li>??nternet sitemizde taraf??n??zca kabul veya reddedilen s&ouml;zle??me, form ile taleplerinizin belirlenebilmesi</li>
<li>Do??mu?? ve do??abilecek hukuki ihtilaflarda delil te??kil edebilmesi</li>
<li>com.tr taraf??ndan i?? s&uuml;re&ccedil;lerinin y&ouml;netilebilmesi ve takibi</li>
<li>Taraf??n??z??n talebi do??rultusunda yap??lan rezervasyonlarda olumsuz durumlar do??mas?? halinde ileti??ime ge&ccedil;ilebilmesi</li>
<li>Taraf??n??z??n kiralama &ouml;ncesi, esnas?? veya sonras?? talep, ??ikayet ve de??erlendirmelerinin takibi</li>
</ul>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong>K??????SEL VER??LER??N??Z HANG?? Y&Ouml;NTEMLE TOPLANMAKTA VE BUNUN HUKUK?? DAYANA??I NED??R?</strong></li>
</ul>
<p>&nbsp;</p>
<p>Taraf??m??zca ki??isel verileriniz 6698 Say??l?? Ki??isel Verilerin Korunmas?? Kanunu uyar??nca;</p>
<p>&nbsp;</p>
<ul>
<li>6098 Say??l?? T&uuml;rk Bor&ccedil;lar Kanunu, 6102 Say??l?? T&uuml;rk Ticaret Kanunu, 5237 Say??l?? T&uuml;rk Ceza Kanunu ve 6502 say??l?? T&uuml;keticinin Korunmas?? Hakk??nda Kanun ba??ta olmak &uuml;zere di??er kanun ve y&ouml;netmeliklerde a&ccedil;??k&ccedil;a &ouml;ng&ouml;r&uuml;lm&uuml;?? olmas??,</li>
<li>S&ouml;zle??menin kurulmas?? veya ifas??yla do??rudan do??ruya ilgili olmas?? kayd??yla, ki??isel verilerinizin i??lenmesinin gerekli olmas??,</li>
<li>com.tr&rsquo;nin hukuki y&uuml;k&uuml;ml&uuml;l&uuml;??&uuml;n&uuml; yerine getirebilmesi i&ccedil;in zorunlu olmas??,</li>
<li>Bir hakk??n tesisi, kullan??lmas?? veya korunmas?? i&ccedil;in veri i??lemenin zorunlu olmas??,</li>
<li>Temel hak ve &ouml;zg&uuml;rl&uuml;klerine zarar vermemek kayd??yla me??ru menfaatlerimiz i&ccedil;in veri i??lenmesinin zorunlu olmas??,</li>
</ul>
<p>&nbsp;</p>
<p>Hukuki sebeplerine dayan??larak taraf??n??za verilen hizmet ba??ta olmak &uuml;zere hukuki olarak s&ouml;zle??mesel ili??kilerimiz do??rultusunda bizzat sizden, taraf??n??zca web sitemize eklenen bilgilerden ve g&uuml;venlik dolay??s??yla kamera kay??tlar??ndan yukar??da 5. Maddede yer alan ama&ccedil;lar do??rultusunda toplanmaktad??r.&nbsp;</p>
<p>&nbsp;</p>
<ul>
<li><strong>K??????SEL VER??LER??N??Z K??MLERE, HANG?? AMA&Ccedil;LA AKTARILIYOR?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Taraf??m??zca faaliyet alan??m??z??n s&uuml;rd&uuml;r&uuml;lmesi, faaliyetlerin mevzuata uygun devam?? ve ticari sebeplerle farkl?? ki??i ve/veya kurumlarla birlikte &ccedil;al??????lmaktad??r. Bu bak??mdan bu hususlar??n hukuka ve mevzuata uygun ??ekilde yerine getirilebilmesi i&ccedil;in ki??isel verilerinizin ba??kaca ki??i ve/veya kurumlara aktar??lmas?? s&ouml;z konusu olabilmektedir. Taraf??m??zca i??lenen veriler nitelikli veri olmad??????ndan 6698 Say??l?? Ki??isel Verilerin Korunmas?? Kanunu 8. Maddesi gere??ince a&ccedil;??k r??za aranmaks??z??n a??a????daki sebeplerle s??n??rl?? olmak &uuml;zere a??a????da belirtilen ki??ilere aktar??labilmektedir.</p>
<p>&nbsp;</p>
<ul>
<li>Rezervasyon kay??tlar??n??n do??ru ve eksiksiz tutulabilmesi ve konaklama tarihlerinde taraf??n??za destek hizmetleri ve sorun &ccedil;&ouml;z&uuml;m&uuml; i&ccedil;in konut sahipleri</li>
<li>Finansal ve muhasebe s&uuml;re&ccedil;lerinin y&ouml;netimi, faturaland??rma ve vergilendirme y&uuml;k&uuml;ml&uuml;l&uuml;kleri dolay??s??yla mali m&uuml;??avirlerimiz ve yetkili kamu kurumlar??yla,</li>
<li>Kay??tlar??n olu??turulmas??n??n gerekmesi halinde bili??im altyap??m??z?? sa??layan, i??leten veya hizmet sunan i?? ortaklar??m??zla ve hizmet sa??lay??c??lar??m??zla.</li>
<li>Hukuki y&uuml;k&uuml;ml&uuml;l&uuml;klerin yerine getirilmesi, do??mu?? veya do??abilecek hukuki ihtilaflar??n &ccedil;&ouml;z&uuml;m&uuml;, doland??r??c??l??klar??n &ouml;nlenmesi, su&ccedil; i??lenmesi olas??l??????n??n azalt??lmas??, s&ouml;zle??me s&uuml;re&ccedil;lerinin y&ouml;netilmesi kapsam??nda dan????manl??k ve hizmet ald??????m??z Hukuk B&uuml;rosu ve avukatlar??m??zla,</li>
<li>D&uuml;zenleyici ve denetleyici kurumlar ile mahkeme ve icra m&uuml;d&uuml;rl&uuml;kleri gibi adli makamlar yahut yetkili kamu kurum ve kurulu??lar??yla,</li>
<li>2559 Say??l?? Polis Vazife ve Salahiyetleri Kanunu h&uuml;k&uuml;mleri gere??ince taraf??n??z??n g&uuml;venli??inin sa??lanmas??, toplum g&uuml;venli??inin sa??lanmas?? ve konut sahibinin kanuni y&uuml;k&uuml;ml&uuml;l&uuml;kleri dolay??s??yla yetkili kolluk kuvvetleriyle,</li>
<li>Ki??isel verilerinizi talep etmeye yetkili olan di??er kamu kurum veya kurulu??lar??yla,</li>
<li>Ticari y&ouml;netim ve i??letme esaslar??n??n belirlenebilmesi i&ccedil;in hissedarlar??m??zla</li>
</ul>
<p>&nbsp;</p>
<p>Taraf??n??za ait olan Balayi Sepeti taraf??ndan i??lenen hi&ccedil;bir ki??isel veriniz yurtd??????na aktar??lmamaktad??r.</p>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong>K??????SEL VER??LER??N??ZE ??L????K??N HAKLARINIZ NELERD??R?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Taraf??n??z 6698 Say??l?? Ki??isel Verilerin Korunmas?? Kanunu 11. Madde gere??ince a??a????da yer alan haklara sahiptir.</p>
<ul>
<li>Ki??isel veri i??lenip i??lenmedi??ini &ouml;??renme,</li>
<li>Ki??isel verileri i??lenmi??se buna ili??kin bilgi talep etme,</li>
<li>Ki??isel verilerin i??lenme amac??n?? ve bunlar??n amac??na uygun kullan??l??p kullan??lmad??????n??&ouml;??renme,</li>
<li>Yurt i&ccedil;inde veya yurt d??????nda ki??isel verilerin aktar??ld?????? &uuml;&ccedil;&uuml;nc&uuml; ki??ileri bilme,</li>
<li>Ki??isel verilerin eksik veya yanl???? i??lenmi?? olmas?? h&acirc;linde bunlar??n d&uuml;zeltilmesini isteme,</li>
<li>KVKK ??artlar?? &ccedil;er&ccedil;evesinde ki??isel verilerin silinmesini veya yok edilmesini isteme,</li>
<li>D&uuml;zeltme, silme ve yok edilme istemleri uyar??nca yap??lan i??lemlerin, ki??isel verilerin aktar??ld?????? &uuml;&ccedil;&uuml;nc&uuml; ki??ilere bildirilmesini isteme,</li>
<li>????lenen verilerin m&uuml;nhas??ran otomatik sistemler vas??tas??yla analiz edilmesi suretiyle ki??inin kendisi aleyhine bir sonucun ortaya &ccedil;??kmas??na itiraz etme,</li>
<li>Ki??isel verilerin kanuna ayk??r?? olarak i??lenmesi sebebiyle zarara u??ramas?? h&acirc;linde zarar??n giderilmesini talep etme.</li>
</ul>
<p>&nbsp;</p>
<ul>
<li><strong>K??????SEL VER??LER??N??ZE ??L????K??N HAK VE TALEPLER??N??Z ??&Ccedil;??N V??LLA KALKAN&rsquo;A NASIL BA??VURAB??L??RS??N??Z?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Ki??isel verilerinizin elde edilmesi, i??lenmesi, aktar??lmas??, silinmesi, d&uuml;zeltilmesi gibi t&uuml;m hususlara ili??kin sorular??n??z ve taleplerinizi Veri Sorumlusuna Ba??vuru Usul ve Esaslar?? Hakk??nda Tebli??'de belirtilen ??artlara uygun ??ekilde yaz??l?? olarak &ldquo;Wings Seyahat Turizm Sanayi ve Ticaret Limited ??irketi (Balayi Sepeti)&rdquo;ne a??a????da belirtilen &ccedil;e??itli y&ouml;ntemlerden biri ile yaz??l?? olarak iletebilirsiniz.</p>
<p>Islak imzal?? dilek&ccedil;e ile yap??lacak ba??vurular i&ccedil;in ??irket adresi : Kalkan Mahallesi Kalkan Cumhuriyet Caddesi No: 48/2 Ka??/Antalya</p>
<p>G&uuml;venli Elektronik ??mza ile yap??lacak ba??vurularda Kay??tl?? Elektronik Posta (KEP) adresi: wingsseyhtursan@hs01.kep.tr</p>
<p>Yap??lacak ba??vurularda ilgili ki??inin kimli??ine ili??kin belgeleri eklemesi zorunludur.</p>
<p>Balayi Sepeti taraf??ndan i??bu Ki??isel Verilerin Korunmas?? Hakk??nda Ayd??nlatma Metni&rsquo;nin y&uuml;r&uuml;rl&uuml;kteki mevzuat h&uuml;k&uuml;mlerine uygun ??ekilde haz??rland?????? taahh&uuml;t edilmekle, mevzuat de??i??ikli??i halinde de??i??iklik ve d&uuml;zeltme hakk?? sakl?? tutulmaktad??r.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
            </div>
        </div>
    </div>

   </section>
@endsection

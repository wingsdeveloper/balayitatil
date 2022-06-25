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
              
            <h3 style="text-align: center;"><strong>KİŞİSEL VERİLERİN KORUNMASI HAKKINDA AYDINLATMA METNİ</strong></h3>
<ul>
<li><strong>KİŞİSEL VERİLERİN KORUNMASINA İLİŞKİN TANIMLAR NELERDİR?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Kişisel Verilerin Korunmasına İlişkin Aydınlatma Metni, 6698 Kişisel Verilerin Korunması Kanunu&rsquo;nun 10. Maddesi gereğince veri sorumluları tarafından ilgili kişilere sunulması gereken bir y&uuml;k&uuml;ml&uuml;l&uuml;kt&uuml;r. Tarafımızca işbu Aydınlatma Metni tarafınıza sunulmakla metnin daha anlaşılabilir olması i&ccedil;in tanımlara aşağıda yer verilmektedir.</p>
<ol>
<li>a) Alıcı grubu: Veri sorumlusu tarafından kişisel verilerin aktarıldığı ger&ccedil;ek veya t&uuml;zel kişi kategorisini,</li>
<li>b) İlgili kişi: Kişisel verisi işlenen ger&ccedil;ek kişiyi,</li>
<li>c) Kanun: 24/3/2016 tarihli ve 6698 sayılı Kişisel Verilerin Korunması Kanununu,</li>
</ol>
<p>&ccedil;) Kurul: Kişisel Verileri Koruma Kurulunu,</p>
<ol>
<li>d) Kurum: Kişisel Verileri Koruma Kurumunu,</li>
<li>e) Sicil: Başkanlık tarafından tutulan Veri Sorumluları Sicilini,</li>
<li>f) Veri kayıt sistemi: Kişisel verilerin belirli&nbsp;kriterlere&nbsp;g&ouml;re yapılandırılarak işlendiği kayıt sistemini,</li>
<li>g) Veri sorumlusu: Kişisel verilerin işleme ama&ccedil;larını ve vasıtalarını belirleyen, veri kayıt sisteminin kurulmasından ve y&ouml;netilmesinden sorumlu olan ger&ccedil;ek veya t&uuml;zel kişiyi,</li>
</ol>
<p>ğ)<strong>&nbsp;</strong>Veri sorumlusu temsilcisi: T&uuml;rkiye&rsquo;de yerleşik olmayan veri sorumlularını&nbsp;30/12/2017&nbsp;tarihli ve 30286 sayılı Resm&icirc; Gazete&rsquo;de yayımlanan Veri Sorumluları Sicili Hakkında Y&ouml;netmeliğin 11 inci maddesinin &uuml;&ccedil;&uuml;nc&uuml; fıkrasında belirtilen konularda asgari temsile yetkili T&uuml;rkiye&rsquo;de yerleşik t&uuml;zel kişi ya da T&uuml;rkiye Cumhuriyeti vatandaşı ger&ccedil;ek kişiyi,</p>
<p>ifade etmektedir.</p>
<ul>
<li><strong>KİŞİSEL VERİ VE AYDINLATMA Y&Uuml;K&Uuml;ML&Uuml;L&Uuml;Ğ&Uuml; NE DEMEKTİR?</strong></li>
</ul>
<p>Kişisel veri; kimliği belirli veya belirlenebilir ger&ccedil;ek kişiye ilişkin her t&uuml;rl&uuml; bilgiyi ifade etmekle aydınlatma y&uuml;k&uuml;ml&uuml;l&uuml;ğ&uuml; ise kişisel verilerin elde edilmesi sırasında veri sorumluları veya yetkilendirdiği kişilerce, ilgili kişilerin bilgilendirilmesini kapsamaktadır.</p>
<ul>
<li><strong>KİŞİSEL VERİLERİNİZ KİM TARAFINDAN İŞLENMEKTEDİR? </strong></li>
</ul>
<p>Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirketi (VillaKalkan) olarak aşağıda a&ccedil;ık&ccedil;a belirtilecek olan kişisel verileriniz işlenmektedir. Tarafımızca siz değerli m&uuml;şterilerimizin kişisel verilerinin gizliliği ve g&uuml;venliği en &ouml;nemli hassasiyetlerimizdendir.</p>
<ul>
<li><strong>HANGİ KİŞİSEL VERİLERİNİZ İŞLENMEKTEDİR?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Villa Kalkan tarafından oluşturulan www.villkalkan.com.tr adresi &uuml;zerinden yayınlanan tatil konutlarının tarafınızca kiralanmak istenmesi ve/veya rezervasyon yaptırmanız halinde aşağıda yer alan kişisel verileriniz işlenebilmektedir.</p>
<ul>
<li>Kimlik Bilgileriniz (Adınız, soyadınız, TC kimlik numaranız)</li>
<li>İletişim Bilgileriniz (Telefon numaranız, e-posta adresiniz, iletişim adresiniz)</li>
<li>Lokasyon (Tarafınıza daha iyi hizmet sunabilmek adına belirlediğiniz tarihler arasında kiralayarak bulunduğunuz tatil konutuna ilişkin lokasyon bilgileri)</li>
<li>M&uuml;şteri İşlem Bilgileriniz (Kiralanan tatil konutuna ilişkin rezervasyon &ouml;zetiniz, fatura bilgileriniz, giriş &ccedil;ıkış tarihleriniz, talep ve şikayet bilgileriniz, IBAN ve hesap numaralarınız, &ouml;deme bilgileriniz.)</li>
<li>Fiziksel Mekan G&uuml;venliği (Tatil konutuna giriş-&ccedil;ıkış tarihleri kayıtlarınız, tatil konutunda bulunduğunuz s&uuml;re i&ccedil;erisindeki g&uuml;venlik ama&ccedil;lı bulunan kamera kayıtları)</li>
<li>İşlem G&uuml;venliği (IP bilgileriniz, villakalkan.com.tr adresindeki &uuml;yelik giriş-&ccedil;ıkış bilgileriniz, &ccedil;erez bilgileriniz)</li>
<li>Pazarlama (villakalkan.com.tr adresindeki alışveriş ge&ccedil;mişi bilgileriniz, &ccedil;erez kayıtlarınız, anket ve faaliyet konumuza ilişkin kampanya &ccedil;alışmaları)</li>
</ul>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong>KİŞİSEL VERİLERİNİZ HANGİ AMA&Ccedil;LA İŞLENMEKTEDİR?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Kişisel verileriniz aşağıdaki ama&ccedil;larla sınırlı olmak &uuml;zere işlenmektedir.</p>
<p><strong>&nbsp;</strong></p>
<ul>
<li>Rezervasyon talebinizin karışıklığa mahal vermeyecek şekilde oluşturulabilmesi</li>
<li>Rezervasyon ve &ouml;deme bilgilerinize ilişkin &ouml;zetin telefon ve e-posta yoluyla tarafınıza iletilmesi</li>
<li>Konaklama bilgilerinizin kolluk kuvvetlerine bildirilebilmesi</li>
<li>Soru ve taleplerinize karışıklığa mahal vermeden cevap verebilmek veya &ccedil;&ouml;z&uuml;m &uuml;retebilmek</li>
<li>Tatil konutunda bulunduğunuz s&uuml;re i&ccedil;erisinde sorunların eksiksiz ve gecikmeden &ccedil;&ouml;z&uuml;m&uuml;</li>
<li>Tarafınızdan &ouml;nce ve sonra konaklama yapacak diğer m&uuml;şterilerin rezervasyon taleplerinin oluşturulması ve tatil konutuna ilişkin boş g&uuml;n ve tarihlerin belirlenebilmesi</li>
<li>Şirketimiz tarafından verilen hizmete ilişkin tarafınıza ait fatura d&uuml;zenlenebilmesi</li>
<li>Tarafınızca yapılmış veya yapılacak &ouml;demelerin kaydedilmesi</li>
<li>İade edilmesi gereken tutarlar olması halinde gecikmeksizin iadenin yapılabilmesi</li>
<li>Tatil konutunda bulunduğunuz sırada siz ve yanınızda bulunan diğer kişilerin g&uuml;venliğinin sağlanabilmesi</li>
<li>İnternet sitemizde tarafınızca kabul veya reddedilen s&ouml;zleşme, form ile taleplerinizin belirlenebilmesi</li>
<li>Doğmuş ve doğabilecek hukuki ihtilaflarda delil teşkil edebilmesi</li>
<li>com.tr tarafından iş s&uuml;re&ccedil;lerinin y&ouml;netilebilmesi ve takibi</li>
<li>Tarafınızın talebi doğrultusunda yapılan rezervasyonlarda olumsuz durumlar doğması halinde iletişime ge&ccedil;ilebilmesi</li>
<li>Tarafınızın kiralama &ouml;ncesi, esnası veya sonrası talep, şikayet ve değerlendirmelerinin takibi</li>
</ul>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong>KİŞİSEL VERİLERİNİZ HANGİ Y&Ouml;NTEMLE TOPLANMAKTA VE BUNUN HUKUKİ DAYANAĞI NEDİR?</strong></li>
</ul>
<p>&nbsp;</p>
<p>Tarafımızca kişisel verileriniz 6698 Sayılı Kişisel Verilerin Korunması Kanunu uyarınca;</p>
<p>&nbsp;</p>
<ul>
<li>6098 Sayılı T&uuml;rk Bor&ccedil;lar Kanunu, 6102 Sayılı T&uuml;rk Ticaret Kanunu, 5237 Sayılı T&uuml;rk Ceza Kanunu ve 6502 sayılı T&uuml;keticinin Korunması Hakkında Kanun başta olmak &uuml;zere diğer kanun ve y&ouml;netmeliklerde a&ccedil;ık&ccedil;a &ouml;ng&ouml;r&uuml;lm&uuml;ş olması,</li>
<li>S&ouml;zleşmenin kurulması veya ifasıyla doğrudan doğruya ilgili olması kaydıyla, kişisel verilerinizin işlenmesinin gerekli olması,</li>
<li>com.tr&rsquo;nin hukuki y&uuml;k&uuml;ml&uuml;l&uuml;ğ&uuml;n&uuml; yerine getirebilmesi i&ccedil;in zorunlu olması,</li>
<li>Bir hakkın tesisi, kullanılması veya korunması i&ccedil;in veri işlemenin zorunlu olması,</li>
<li>Temel hak ve &ouml;zg&uuml;rl&uuml;klerine zarar vermemek kaydıyla meşru menfaatlerimiz i&ccedil;in veri işlenmesinin zorunlu olması,</li>
</ul>
<p>&nbsp;</p>
<p>Hukuki sebeplerine dayanılarak tarafınıza verilen hizmet başta olmak &uuml;zere hukuki olarak s&ouml;zleşmesel ilişkilerimiz doğrultusunda bizzat sizden, tarafınızca web sitemize eklenen bilgilerden ve g&uuml;venlik dolayısıyla kamera kayıtlarından yukarıda 5. Maddede yer alan ama&ccedil;lar doğrultusunda toplanmaktadır.&nbsp;</p>
<p>&nbsp;</p>
<ul>
<li><strong>KİŞİSEL VERİLERİNİZ KİMLERE, HANGİ AMA&Ccedil;LA AKTARILIYOR?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Tarafımızca faaliyet alanımızın s&uuml;rd&uuml;r&uuml;lmesi, faaliyetlerin mevzuata uygun devamı ve ticari sebeplerle farklı kişi ve/veya kurumlarla birlikte &ccedil;alışılmaktadır. Bu bakımdan bu hususların hukuka ve mevzuata uygun şekilde yerine getirilebilmesi i&ccedil;in kişisel verilerinizin başkaca kişi ve/veya kurumlara aktarılması s&ouml;z konusu olabilmektedir. Tarafımızca işlenen veriler nitelikli veri olmadığından 6698 Sayılı Kişisel Verilerin Korunması Kanunu 8. Maddesi gereğince a&ccedil;ık rıza aranmaksızın aşağıdaki sebeplerle sınırlı olmak &uuml;zere aşağıda belirtilen kişilere aktarılabilmektedir.</p>
<p>&nbsp;</p>
<ul>
<li>Rezervasyon kayıtlarının doğru ve eksiksiz tutulabilmesi ve konaklama tarihlerinde tarafınıza destek hizmetleri ve sorun &ccedil;&ouml;z&uuml;m&uuml; i&ccedil;in konut sahipleri</li>
<li>Finansal ve muhasebe s&uuml;re&ccedil;lerinin y&ouml;netimi, faturalandırma ve vergilendirme y&uuml;k&uuml;ml&uuml;l&uuml;kleri dolayısıyla mali m&uuml;şavirlerimiz ve yetkili kamu kurumlarıyla,</li>
<li>Kayıtların oluşturulmasının gerekmesi halinde bilişim altyapımızı sağlayan, işleten veya hizmet sunan iş ortaklarımızla ve hizmet sağlayıcılarımızla.</li>
<li>Hukuki y&uuml;k&uuml;ml&uuml;l&uuml;klerin yerine getirilmesi, doğmuş veya doğabilecek hukuki ihtilafların &ccedil;&ouml;z&uuml;m&uuml;, dolandırıcılıkların &ouml;nlenmesi, su&ccedil; işlenmesi olasılığının azaltılması, s&ouml;zleşme s&uuml;re&ccedil;lerinin y&ouml;netilmesi kapsamında danışmanlık ve hizmet aldığımız Hukuk B&uuml;rosu ve avukatlarımızla,</li>
<li>D&uuml;zenleyici ve denetleyici kurumlar ile mahkeme ve icra m&uuml;d&uuml;rl&uuml;kleri gibi adli makamlar yahut yetkili kamu kurum ve kuruluşlarıyla,</li>
<li>2559 Sayılı Polis Vazife ve Salahiyetleri Kanunu h&uuml;k&uuml;mleri gereğince tarafınızın g&uuml;venliğinin sağlanması, toplum g&uuml;venliğinin sağlanması ve konut sahibinin kanuni y&uuml;k&uuml;ml&uuml;l&uuml;kleri dolayısıyla yetkili kolluk kuvvetleriyle,</li>
<li>Kişisel verilerinizi talep etmeye yetkili olan diğer kamu kurum veya kuruluşlarıyla,</li>
<li>Ticari y&ouml;netim ve işletme esaslarının belirlenebilmesi i&ccedil;in hissedarlarımızla</li>
</ul>
<p>&nbsp;</p>
<p>Tarafınıza ait olan Villa Kalkan tarafından işlenen hi&ccedil;bir kişisel veriniz yurtdışına aktarılmamaktadır.</p>
<p><strong>&nbsp;</strong></p>
<ul>
<li><strong>KİŞİSEL VERİLERİNİZE İLİŞKİN HAKLARINIZ NELERDİR?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Tarafınız 6698 Sayılı Kişisel Verilerin Korunması Kanunu 11. Madde gereğince aşağıda yer alan haklara sahiptir.</p>
<ul>
<li>Kişisel veri işlenip işlenmediğini &ouml;ğrenme,</li>
<li>Kişisel verileri işlenmişse buna ilişkin bilgi talep etme,</li>
<li>Kişisel verilerin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını&ouml;ğrenme,</li>
<li>Yurt i&ccedil;inde veya yurt dışında kişisel verilerin aktarıldığı &uuml;&ccedil;&uuml;nc&uuml; kişileri bilme,</li>
<li>Kişisel verilerin eksik veya yanlış işlenmiş olması h&acirc;linde bunların d&uuml;zeltilmesini isteme,</li>
<li>KVKK şartları &ccedil;er&ccedil;evesinde kişisel verilerin silinmesini veya yok edilmesini isteme,</li>
<li>D&uuml;zeltme, silme ve yok edilme istemleri uyarınca yapılan işlemlerin, kişisel verilerin aktarıldığı &uuml;&ccedil;&uuml;nc&uuml; kişilere bildirilmesini isteme,</li>
<li>İşlenen verilerin m&uuml;nhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle kişinin kendisi aleyhine bir sonucun ortaya &ccedil;ıkmasına itiraz etme,</li>
<li>Kişisel verilerin kanuna aykırı olarak işlenmesi sebebiyle zarara uğraması h&acirc;linde zararın giderilmesini talep etme.</li>
</ul>
<p>&nbsp;</p>
<ul>
<li><strong>KİŞİSEL VERİLERİNİZE İLİŞKİN HAK VE TALEPLERİNİZ İ&Ccedil;İN VİLLA KALKAN&rsquo;A NASIL BAŞVURABİLİRSİNİZ?</strong></li>
</ul>
<p><strong>&nbsp;</strong></p>
<p>Kişisel verilerinizin elde edilmesi, işlenmesi, aktarılması, silinmesi, d&uuml;zeltilmesi gibi t&uuml;m hususlara ilişkin sorularınız ve taleplerinizi Veri Sorumlusuna Başvuru Usul ve Esasları Hakkında Tebliğ'de belirtilen şartlara uygun şekilde yazılı olarak &ldquo;Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirketi (Villa Kalkan)&rdquo;ne aşağıda belirtilen &ccedil;eşitli y&ouml;ntemlerden biri ile yazılı olarak iletebilirsiniz.</p>
<p>Islak imzalı dilek&ccedil;e ile yapılacak başvurular i&ccedil;in şirket adresi : Kalkan Mahallesi Kalkan Cumhuriyet Caddesi No: 48/2 Kaş/Antalya</p>
<p>G&uuml;venli Elektronik İmza ile yapılacak başvurularda Kayıtlı Elektronik Posta (KEP) adresi: wingsseyhtursan@hs01.kep.tr</p>
<p>Yapılacak başvurularda ilgili kişinin kimliğine ilişkin belgeleri eklemesi zorunludur.</p>
<p>Villa Kalkan tarafından işbu Kişisel Verilerin Korunması Hakkında Aydınlatma Metni&rsquo;nin y&uuml;r&uuml;rl&uuml;kteki mevzuat h&uuml;k&uuml;mlerine uygun şekilde hazırlandığı taahh&uuml;t edilmekle, mevzuat değişikliği halinde değişiklik ve d&uuml;zeltme hakkı saklı tutulmaktadır.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
            </div>
        </div>
    </div>

   </section>
@endsection

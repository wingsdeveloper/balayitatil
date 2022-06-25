<?php

namespace App\Repo\ErrorLogging;

class MessageTemplates
{
    /**
     * @param $index
     * @return mixed
     */
    public static function get($index)
    {
        return self::messages()[$index];
    }

    /**
     * @return array
     */
    public static function messages(): array
    {
        return [
            'empty_param' => "parametre giriniz
ÖR: /komut < metin >",
            'help' => "Size yardımcı olabileceğim konular

/ozlusoz - Değerli bir özlüsöz
/dovizkuru - Döviz kurları
/cevirTr < metin > - Girilen Ingilizce metni Türkçe'ye çeviririm
/cevirEn < metin > - Girilen Türkçe metni Ingilizce'ye çeviririm
",
            'unkown_command' => 'Üzgünüm buna nasıl yanıt vereceğimi bilemiyorum',
            'translate_error' => 'Şu an çeviri yapamıyorum',
            'welcome_business_network' => "
Business Network Grubuna hoş geldiniz.
 
Kullanım Kuralları:

Herkesin öncelikle bu formu doldurması gerekiyor

https://forms.gle/6iyZQiTmC3erWyXr7

Business Network Kullanımı Kuralları grubumuzdan daha fazla fayda etmeniz amaçlıdır.

 Lütfen şu adımları izleyin. Aksi takdirde hem gruptan gereken verimi alamazsınız hem de gruptan çıkarılmanız durumunda itiraz hakkınız olmaz.

 Ayarlar sekmesinden profilinize girin.

 Sağ üstte yer alan 3 noktaya tıklayın. \"Adı düzenle\" sekmesinden adınızı soyadınızı yazdıktan sonra soyadınızın yanına yaptığınız mesleği (örneğin; inşaat mühendisi) ve lokasyon bazlı çalışıyorsanız bölgenizi (örneğin; Ankara, yurt geneli ya da yurtdışı) yazın. Bunun nedeni grup içi üye aramalarında meslek ve lokasyon bazlı aramalarda bulunabilmeniz. (1)

 Daha sonra yine profilinize gelip kendinize kullanıcı @ adı (2) alın.

 Profesyonel iş hayatına uygun olarak bir fotoğraf yükleyin. (3) 

 Hakkında sekmesinde iş detayı verin ve Linkedin profil linkinizi ekleyin.

 Gruptaki iş ilanlarında hastag kullanın. Yazınızın başında Hem #sektör hem #şehir yazsın. Böylece şehre ve sektöre göre iş arayanlar boşuna iş ilanlarını okumamış olurlar. Hastaglere tıklayıp o sektördeki ve şehirdeki tüm ilanları görebilirler.

 Grupta sabitlenmiş mesajlar'a tıklayın. Önemli duyurular bu mesajlarda açıklanacaktır.

 Herhangi bir yanlış paylaşmanızı silebilir ya da üzerine hızlıca tek dokunuş yapıp çekerek (basılı tutarak değil) ortaya çıkan düzenle sekmesinden düzenleyebilirsiniz.

 Yanıtlamak istediğiniz bir paylaşımın üstüne bastıktan sonra üst tarafta sola yönelen oka basarak yanıtlayabilirsiniz  Böylece o kişiye bildirim gider. Sağ tarafa yönelen oka basarak ise önemli gördünüz mesajları Telegram'da bulunan bir başka sohbetinize, bir başka gruba ya da \"Kayıtlı Mesajlar\"a atabilirsiniz. Grubun kullanımına daha fazla başvurmak açısından bu paylaşımı da kayıtlı mesajlar'a göndermenizi tavsiye ederiz.

 Grupta hitabet; bey, hanım şeklindedir. Abi, abla, hocam, başkan, kardeşim tarzı hitabı kullanılamaz.

 Grupta diğer insanları sıkmamak ve yüzünüzü eskitmemek adına gereksiz paylaşımlardan kaçının. Söylemek istediklerinizi tek mesajda toplayın ve böylece insanların daha fazla bildirim alıp rahatsız olmasına sebep olmayın. Temiz ve yalın Türkçe kullanın. Slm, tşk, ok gibi kısaltmalardan kaçının. İşle ilgili olmayan dosyalar atmayın. Günaydın mesajlarınızı bile grubun içeriğine uygun olacak şekilde bitirin. İkili sohbetlere özel mesaj yoluyla devam edin. (İş dışında özel mesaj atmanız karşıdaki kişinin sizi spam olarak işaretlemesine ve/veya yöneticiye bildirmesine yol açar ve hesabınız kapanır ya da gruptan çıkarılırsınız )

 Grubun sağındaki üç noktadan bul'a basarak kişi ve takvime göre grupta aradıklarınızı bulabilirsiniz.

(1) Grup içi üye aramaları şu şekilde gerçekleşiyor:

Grubun fotoğrafına tıklayın. Sağ üstteki üç noktadan \"Üyeleri bul\" sekmesinden üyeleri aratabilirsiniz.

(2) Kullanıcı adınızın olması grup içi yazışmalarda etiketlenebilmenize, bir başka kullanıcıya özel mesajlarda  kullanıcı adınız sayesinde önerilebilmenize yarar. Telegram bulut sistemini kullanır, Telegram kullanıcı adınızı aynı zamanda mail adresiniz gibi kartvizitinize ve  sosyal medyanıza yazabilirsiniz.

(3) Bir fotoğrafınızın olması iş insanları tarafından fotoğrafı olmayanlara göre ciddiye alınmanızı 12 kat, profesyonel iş hayatına uygun bir fotoğrafınızın olması ise sıradan profil fotoğrafı olanlara göre farkedilmenizi 4 kat arttırır.

Bu grup kurallarını uygulamaya özen gösterirseniz aradığınız iş bağlantısı ve iş yönlendirmenizi bulmanız kolaylaşacaktır. İş hacminizi daha da geliştirmeniz ve genişletmenizde başarılar dilerim.
",
            'welcome_denizli_developers' => "
Denizli Software Team  Grubuna hoş geldiniz.

Kısaca kendinizden ve yaptığınız işlerden bahsediniz.

Gruptaki diğer üyeleri rahatsız etmek argo konuşmak, spam ve reklam yapmak kesinlikle yasaktır uyarılmadan direk kovulmanıza neden olur.",
            'default_welcome_message' => "Grubumuza hoşgeldiniz!",
            'welcome_bot' => "Biz burada botları hiç sevmeyiz!",
            'icome' => "Hey! yo mekanın sahibi geldi!",
        ];
    }

}
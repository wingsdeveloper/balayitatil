
$(document).ready(function() {
  var a=0;
	$('.datepicker').pickadate({
        monthsFull: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        weekdaysShort: ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt'],
        firstDay: 3,
        clear: 'Temizle',
        today: 'Bugün',
        close: 'Kapat',
        format: 'd mmmm, yyyy',
        formatSubmit: 'dd-mm-yyyy',
        hiddenSuffix: '_tarih',
        onStart: function() {
    var date = new Date();
    this.set('min',0,date.getMonth(),date.getFullYear());
}
    });
var from_$input = $('#mgiris_tarih').pickadate(),
    from_picker = from_$input.pickadate('picker')
var to_$input = $('#mcikis_tarih').pickadate(),
    to_picker = to_$input.pickadate('picker')


// Check if there’s a “from” or “to” date to start with.
if ( from_picker.get('value') ) {
  if(a==1){
    $("#mcikis_tarih").click();
  }
  to_picker.set('min', from_picker.get('select'))
}
if ( to_picker.get('value') ) {
 // from_picker.set('max', to_picker.get('select'))
  if($("#dgiris_tarih").attr("data-page")=="detail"){
   reservationDone('m');
  }
}

// When something is selected, update the “from” and “to” limits.
from_picker.on('set', function(event) {
  if ( event.select ) {
    a=1;
    $("#mcikis_tarih").click();
    to_picker.set('min', from_picker.get('select'))
  }
  else if ( 'clear' in event ) {
    to_picker.set('min', false)
  }
})
to_picker.on('set', function(event) {
  if ( event.select ) {
  //  from_picker.set('max', to_picker.get('select'))
         if($("#dgiris_tarih").attr("data-page")=="detail"){
          reservationDone('m');
        }
  }
  else if ( 'clear' in event ) {
    from_picker.set('max', false)
  }
});

$('#mmst_btn').click( function( e ) {
    // stop the click from bubbling
    e.stopPropagation();
    // prevent the default click action
    e.preventDefault();
    // open the date picker
    from_picker.open();
});
//villaStatus();

    $(".Dropdown-buton").click(function (e) {
        e.preventDefault();
        $(this).closest('.Dropdown').find('.Dropdown-menu').slideToggle()

    });
    $(".Dropdown-close").click(function (e) {
        e.preventDefault();
        $(this).closest('.Dropdown').find('.Dropdown-menu').slideToggle(400)
    });
});
function villaStatus(){
  var tarihler = [];
      if($("#dgiris_tarih").attr("data-page")=="detail"){
        var villa_id=$("#data_villa").text();
        var status;

      
var from_$input = $('#mgiris_tarih').pickadate(),
    from_picker = from_$input.pickadate('picker')
var to_$input = $('#mcikis_tarih').pickadate(),
    to_picker = to_$input.pickadate('picker')
 /* var picker_$picker = $('.datepicker').pickadate(),
      picker = picker_$picker.pickadate('picker')*/
        $.ajax({
            type: "GET",
            url: url + "/villa_status/"+villa_id+"/2019",
            success: function (sonc) {
                var data = $.parseJSON(sonc);//parse JSON
                    data.forEach(function (date) {
                     if(date.status=="2"){
                      if(date.start!=true && date.end!=true){
    var res = date.tarih.split("-");
    var ay=parseInt(parseInt(res[1])-1);
   // picker.set("disable", [[res[0],ay,res[2]]]);
   // from_picker.set("disable", [[res[0],ay,res[2]]]);
   // to_picker.set("disable", [[res[0],ay,res[2]]]);
    tarihler.push([res[0],ay,res[2]]);
                     }
                   }
                    });
//console.log(tarihler);
                    from_picker.set("disable", tarihler); 
                    to_picker.set("disable", tarihler); 

}
                    });


      }
      }

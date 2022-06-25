@php
    $defaultContact = App\Website::with(['contacts' => function($q){
                                            $q->orderBy('id','ASC');
                                            $q->first();
                                        }])->where('id',15/*APP_WEBSITE_ID*/)->select('id')->firstOrFail();
                                        $defaultContact = $defaultContact->contacts[0];

@endphp

<section class="Map desktop">
    <div id="map2"></div>
    <script>
        var x=@php echo isset($defaultContact) && !empty($defaultContact) ? $defaultContact->x_coordinate : '' @endphp ;
        var y=@php echo isset($defaultContact) && !empty($defaultContact) ? $defaultContact->y_coordinate  : ''@endphp ;
        var myMap;
        ymaps.ready(function () {
            myMap = new ymaps.Map('map2', {
                center: [x, y],
                zoom: 9
            })
            myMap.behaviors.disable('scrollZoom');

            myGeoObject = new ymaps.GeoObject({
                // The geometry description.
                geometry: {
                    type: "Point",
                    coordinates: [x, y]
                },
                // Properties.
                properties: {
                    // The placemark content.
                    iconContent: 'Villa Kalkan',

                }
            }, {
                /**
                 * Options.
                 * The placemark's icon will stretch to fit its contents.
                 */
                preset: 'islands#blackStretchyIcon',
                // The placemark can be dragged.
                draggable: false,
            })
            myMap.geoObjects.add(myGeoObject)


        });
        function changeMap(xX,yY){
            myMap.setCenter([xX, yY])

        }
    </script>
</section>

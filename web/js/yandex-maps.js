ymaps.ready(init);
var myMap,
    myPlacemark_1,
    myPlacemark_2,
    myPlacemark_3,
    myPlacemark_4,
    myPlacemark_5,
    myPlacemark_6,
    myPlacemark_7,
    myPlacemark_8,
    myPlacemark_9,
    myPlacemark_10,
    myPlacemark_11,
    myPlacemark_12,
    myPlacemark_13,
    myPlacemark_14,
    myPlacemark_15,
    myPlacemark_16;

function init() {
    myMap = new ymaps.Map("map", {
        center: [53.36245122, 83.79524221],
        zoom: 11
    });

    myPlacemark_1 = new ymaps.Placemark([53.36980892, 83.67522015], {
        hintContent: 'ФАТО'
    });
    myPlacemark_2 = new ymaps.Placemark([53.36024613, 83.69871495], {
        hintContent: 'ФАТО'
    });
    myPlacemark_3 = new ymaps.Placemark([53.38827912, 83.72851781], {
        hintContent: 'ФАТО'
    });
    myPlacemark_4 = new ymaps.Placemark([53.38963090, 83.73379504], {
        hintContent: 'ФАТО'
    });
    myPlacemark_5 = new ymaps.Placemark([53.39074687, 83.73334443], {
        hintContent: 'ФАТО'
    });
    myPlacemark_6 = new ymaps.Placemark([53.37527683, 83.75369170], {
        hintContent: 'ФАТО'
    });
    myPlacemark_7 = new ymaps.Placemark([53.36194590, 83.76751802], {
        hintContent: 'ФАТО'
    });
    myPlacemark_8 = new ymaps.Placemark([53.33034375, 83.79666127], {
        hintContent: 'ФАТО'
    });
    myPlacemark_9 = new ymaps.Placemark([53.32900781, 83.79659689], {
        hintContent: 'ФАТО'
    });
    myPlacemark_10 = new ymaps.Placemark([53.39013864, 83.93468458], {
        hintContent: 'ФАТО'
    });
    myPlacemark_11 = new ymaps.Placemark([53.41207102, 83.93809744], {
        hintContent: 'ФАТО'
    });
    myPlacemark_12 = new ymaps.Placemark([53.41964357, 83.92884361], {
        hintContent: 'ФАТО'
    });
    myPlacemark_13 = new ymaps.Placemark([52.50704550, 85.14463113], {
        hintContent: 'ФАТО'
    });
    myPlacemark_14 = new ymaps.Placemark([52.53028290, 85.17582823], {
        hintContent: 'ФАТО'
    });
    myPlacemark_15 = new ymaps.Placemark([52.54996369, 85.23347121], {
        hintContent: 'ФАТО'
    });
    myPlacemark_16 = new ymaps.Placemark([51.99760864, 84.98211431], {
        hintContent: 'ФАТО'
    });

    myMap.geoObjects.add(myPlacemark_1);
    myMap.geoObjects.add(myPlacemark_2);
    myMap.geoObjects.add(myPlacemark_3);
    myMap.geoObjects.add(myPlacemark_4);
    myMap.geoObjects.add(myPlacemark_5);
    myMap.geoObjects.add(myPlacemark_6);
    myMap.geoObjects.add(myPlacemark_7);
    myMap.geoObjects.add(myPlacemark_8);
    myMap.geoObjects.add(myPlacemark_9);
    myMap.geoObjects.add(myPlacemark_10);
    myMap.geoObjects.add(myPlacemark_11);
    myMap.geoObjects.add(myPlacemark_12);
    myMap.geoObjects.add(myPlacemark_13);
    myMap.geoObjects.add(myPlacemark_14);
    myMap.geoObjects.add(myPlacemark_15);
    myMap.geoObjects.add(myPlacemark_16);
}
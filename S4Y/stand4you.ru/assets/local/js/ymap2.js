var isShowMap = false;
var address = null;

function createMap() {
    if (!isShowMap) {
        isShowMap = true;
        address = $("address").text();
        ymaps.ready(ymap_init);
        $("#ymap").show();
    }
}

function ymap_init() {
    // Поиск координат
    ymaps.geocode(address, {
        results : 1
    }).then(function(res) {
        // Выбираем первый результат геокодирования
        var firstGeoObject = res.geoObjects.get(0);

        if (null == window.myMap) {
            // Создаём карту.
            // Устанавливаем центр и коэффициент масштабирования.
            window.myMap = new ymaps.Map("ymap", {
                center : firstGeoObject.geometry.getCoordinates(),
                zoom : 15,
                behaviors : ["default", "scrollZoom"],
                type : "yandex#map"
            });
        } else {
        // myMap.geoObjects.remove(myMap.geoObjects.get(0));
        }

        myMap.geoObjects.add(firstGeoObject);

    }, function(err) {
        // Если геокодирование не удалось,
        // сообщаем об ошибке
        alert(err.message);
    })
}
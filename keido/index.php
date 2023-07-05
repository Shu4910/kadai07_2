<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Geolocation API Sample</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <button id="get-location">現在地を取得する</button>

    <script>
        $(document).ready(function () {
            $('#get-location').click(function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;

                        // データをサーバーに送信
                        $.post('location_save.php', { lat: lat, lng: lng }, function (data) {
                            alert('現在地の経度と緯度が送信されました。');
                        });
                    }, function () {
                        alert('位置情報の取得に失敗しました。');
                    });
                } else {
                    alert('お使いのブラウザではGeolocation APIがサポートされていません。');
                }
            });
        });
    </script>
</body>
</html>

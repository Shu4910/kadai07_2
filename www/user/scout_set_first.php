<!DOCTYPE html>
<html>

<head>
    <title>エリア条件設定</title>
    <!-- ブートストラップのCSSを読み込む -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        .btn {
            width: 60%;
            }

    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body> 
    <div class="text-center container mt-5">
    <h2 class="text-center mb-4">どの条件でエリアを設定しますか？</h2>
    <div class="text-center"> <!-- ここを追加 -->
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- エリア条件設定画面のボタン -->
                <form action="scout_set.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">市区町村</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- こだわり条件設定画面のボタン -->
                <form action="scout_set_train.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">駅・路線</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- 基本情報修正画面のボタン -->
                <form action="scout_set_location.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">現在地周辺</button>
                </form>
            </div>
        </div>
    </div>
    <!-- フッターにサービス名を追加 -->
<footer class="text-center mb-4 pt-3">
    <p>&copy; BizDiverse</p>
</footer>

    <!-- ブートストラップのJSを読み込む（オプション） -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

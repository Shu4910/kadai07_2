<!DOCTYPE html>
<html>
<title>登録画面</title>
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
    <h2 class="text-center mb-4">BizDiverse</h2>
<div class="text-center"> <!-- ここを追加 -->
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- 基本情報修正画面のボタン -->
                <form action="info_com.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">基本情報修正画面</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- エリア条件設定画面のボタン -->
                <form action="com_scout_set.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">エリア条件設定画面</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- こだわり条件設定画面のボタン -->
                <form action="com_kodawari.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">こだわり条件設定画面</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- 基本情報修正画面のボタン -->
                <form action="cus_search.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">会員検索画面</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- スカウト受信画面のボタン -->
                <form action="com_chat.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">スカウトやり取り画面</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- スカウト受信画面のボタン -->
                <form action="pass_com.php" method="get">
                    <button class="btn btn-primary btn-block" type="submit">パスワード変更</button>
                </form>
            </div>
            <div class="mb-3"> <!-- カラムのサイズを変更 -->
                <!-- ログアウトのボタン -->
                <form action="../index.php">
                    <button class="btn btn-primary btn-block" type="submit">ログアウト</button>
                </form>
            </div>
        </div>
    </div>


    <!-- フッターにサービス名を追加 -->
    <footer class="text-center mb-4 pt-3">
    <p>&copy; BizDiverse</p>
</footer>
<!-- Bootstrap JS and JQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-feJI7QwhOS+hwpX2zkaeJQjeiwlhOP+SdQDqhgvvo1DsjtiSQByFdThsxO669S2D" crossorigin="anonymous"></script>

</body>
</html>

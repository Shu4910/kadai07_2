<!DOCTYPE html>
<html>
<head>
    <title>pipi</title>
    <!-- ブートストラップのCSSを読み込む -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 mb-3">
            <!-- 基本情報修正画面のボタン -->
            <form action="info.php" method="get">
                <button class="btn btn-primary btn-block" type="submit">基本情報修正画面</button>
            </form>
        </div>
        <div class="col-md-12 mb-3">
            <!-- エリア条件設定画面のボタン -->
            <form action="scout_set.php" method="get">
                <button class="btn btn-primary btn-block" type="submit">エリア条件設定画面</button>
            </form>
        </div>
        <div class="col-md-12 mb-3">
            <!-- こだわり条件設定画面のボタン -->
            <form action="scout_kodawari.php" method="get">
                <button class="btn btn-primary btn-block" type="submit">こだわり条件設定画面</button>
            </form>
        </div>
        <div class="col-md-12 mb-3">
            <!-- スカウト受信画面のボタン -->
            <form action="chat_non.php" method="get">
                <button class="btn btn-primary btn-block" type="submit">スカウト受信画面</button>
            </form>
        </div>
        <div class="col-md-12">
            <!-- ログアウトのボタン -->
            <form action="../index.php">
                <button class="btn btn-primary btn-block" type="submit">ログアウト</button>
            </form>
        </div>
    </div>
</div>

<!-- ブートストラップのJSを読み込む（オプション） -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

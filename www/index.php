<!DOCTYPE html>
<html>
<head>
    <title>ログイン画面</title>
    <!-- ブートストラップのCSSを読み込む -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 col-lg-6 mb-3">
            <!-- 個人用ログイン画面のボタン -->
            <form action="user/index_user.php" method="get">
                <button class="btn btn-primary btn-lg btn-block" type="submit">個人用ログイン画面</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <!-- 企業用ログイン画面のボタン -->
            <form action="company/index_com.php" method="get">
                <button class="btn btn-primary btn-lg btn-block" type="submit">企業用ログイン画面</button>
            </form>
        </div>
    </div>
</div>

<!-- ブートストラップのJSを読み込む（オプション） -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

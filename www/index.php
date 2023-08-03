<!DOCTYPE html>
<html>
<head>
    <title>ログイン 画面</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .login-container {
            text-align: center;
        }
        
        .login-button {
            margin-bottom: 15px;
        }
        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
        }
        
        .service-title {
            text-align: center; /* タイトルを中央寄せにする */
            font-size: 18px; /* フォントサイズを調整 */
            margin-bottom: 20px; /* 下部の余白を追加 */
        }
    </style>
</head>
<body>

<div class="container mt-5">
        <div class="service-title">精神障害者特化型<br>スカウトメディアサービス</div> <!-- クラスを追加 -->
        <h2 class="text-center mb-4">BizDiverse</h2>


    <div class="row justify-content-center">
        <div class="col-12 col-md-6 login-container">
            <!-- 個人用ログイン画面のボタン -->
            <form action="user/index_user.php" method="get" class="mb-3">
                <button class="btn btn-primary btn-lg login-button" type="submit">個人用ログイン画面</button>
            </form>
            <!-- 企業用ログイン画面のボタン -->
            <form action="company/index_com.php" method="get">
                <button class="btn btn-primary btn-lg login-button" type="submit">企業用ログイン画面</button>
            </form>
        </div>
    </div>
</div>

<!-- フッターにサービス名を追加 -->
<footer>
    <p>&copy; BizDiverse</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

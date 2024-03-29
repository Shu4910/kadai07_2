<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">   
    <title>Login Page</title>
    </head>
    <body>
    <div class="container mt-5">
            <!-- エラーメッセージの表示 -->
        <?php if (!empty($msg)) { echo '<p style="color:red;">' . $msg . '</p>'; } ?>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center mb-4">BizDiverse</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="mail">Eメール</label>
                                <input type="email" class="form-control" id="mail" name="mail" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">パスワード</label>
                                <input type="password" class="form-control" id="pass" name="pass" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">ログインする</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p> <a href="../register.php">会員登録するaa</a></p>
                </div>
                <div class="text-center mt-4">
                <p> <a href="../forgot1.php">パスワードを忘れた</a></p>
                </div>
                
                <div class="text-center mt-4">
                    <p> <a href="../index.php">もとに戻る</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- フッターにサービス名を追加 -->
<footer class="text-center mb-4">
    <p>&copy; BizDiverse</p>
</footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>

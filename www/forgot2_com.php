<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <title>Auth Login Page</title>
  </head>
  <body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center mb-4">Auth Login</h2>
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="authlogin_com.php">
                            <div class="form-group">
                                <label for="mail">Email：</label>
                                <input type="text" class="form-control" id="mail" name="mail" required>
                            </div>
                            <div class="form-group">
                                <label for="code">認証コード：</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">ログイン</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <form action="forgot1_com.php">
                        <button type="submit" class="btn btn-link">戻る</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="container my-5">
    <div class="row">
        <div class="col-sm">
            <form action="info_com.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">基本情報修正画面</button>
            </form>
            <form action="com_scout_set.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">条件設定画面</button>
            </form>
            <form action="cus_search.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">会員検索画面</button>
            </form>
            <form action="com_chat.php" method="get">
                <button type="submit" class="btn btn-primary btn-block mb-2">スカウトやり取り画面</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and JQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-feJI7QwhOS+hwpX2zkaeJQjeiwlhOP+SdQDqhgvvo1DsjtiSQByFdThsxO669S2D" crossorigin="anonymous"></script>

</body>
</html>

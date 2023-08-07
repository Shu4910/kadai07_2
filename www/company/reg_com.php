<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BizDiverse</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="desired-jobs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">情報を入力してください。</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="write_com.php" method="post" id="myForm" onsubmit="return checkPasswordMatch();">
                                <div class="form-group">
                                    <label for="houjin">法人・事業者名:</label>
                                    <input type="text" class="form-control" id="houjin" name="houjin">
                                </div>

                                <div class="form-group">    
                                    <label for="tanto">担当者名：</label>
                                    <input type="text" class="form-control" id="tanto" name="tanto">
                                </div>

                                <div class="form-group">
                                    <label for="mail">メールアドレス:</label>
                                    <input type="email" class="form-control" id="mail" name="mail">
                                </div>

                                <div class="form-group">
                                    <label for="tel">電話番号:</label>
                                    <input type="tel" class="form-control" id="tel" name="tel">
                                </div>

                                <div class="form-group">
                                    <label for="types">事業種別:</label>
                                    <select class="form-control" id="types" name="types">
                                        <option name="types"> 企業 </option>
                                        <option name="types"> 就労移行 </option>
                                        <option name="types"> A・B型 </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="zipcode">郵便番号:</label>
                                    <input id="zipcode" class="form-control" type="text" name="zipcode" value="" placeholder="例)8120012">
                                </div>

                                <div class="form-group">
                                    <label for="address1">都道府県:</label>
                                    <input id="address1" class="form-control" type="text" name="address1" value="">
                                </div>

                                <div class="form-group">
                                    <label for="address2">市区町村:</label>
                                    <input id="address2" class="form-control" type="text" name="address2" value="">
                                </div>

                                <div class="form-group">
                                    <label for="address3">町名:</label>
                                    <input id="address3" class="form-control" type="text" name="address3" value="">
                                </div>

                                <div class="form-group">
                                    <label for="pass">パスワード:</label>
                                    <input type="password" class="form-control" id="pass" name="pass">
                                </div>

                                <div class="form-group">
                                    <label for="confirm_pass">パスワード(確認):</label>
                                    <input type="password" class="form-control" id="confirm_pass" name="confirm_pass">
                                </div>

                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-secondary" id="back_btn3"><span>戻る</span></button>
                                    <input type="submit" value="送信" class="btn btn-primary ml-2">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/fetch-jsonp@1.1.3/build/fetch-jsonp.min.js"></script>
    
    <script>
        document.getElementById('back_btn3').addEventListener('click', function() {
            window.location.href = "index_com.php";
        });
    </script>

    <script>
        // This function is now called every time the value of the input field with id "zipcode" is changed
        document.getElementById('zipcode').addEventListener('input', function () {
            let api = 'https://zipcloud.ibsnet.co.jp/api/search?zipcode=';
            let input = this;
            let address1 = document.getElementById('address1');
            let address2 = document.getElementById('address2');
            let address3 = document.getElementById('address3');
            let param = input.value.replace("-", ""); //入力された郵便番号から「-」を削除
            let url = api + param;

            fetchJsonp(url, {
                timeout: 10000, //タイムアウト時間
            })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    if (data.status === 400) { //エラー時
                        console.log(data.message);
                    } else if (data.results === null) {
                        console.log('郵便番号から住所が見つかりませんでした。');
                    } else {
                        address1.value = data.results[0].address1;
                        address2.value = data.results[0].address2;
                        address3.value = data.results[0].address3;
                    }
                })
                .catch((ex) => { //例外処理
                    console.log(ex);
                });
        }, false);
    </script>

    <script>
        window.onload = function() {
    document.getElementById('myForm').onsubmit = function() {
        // 入力項目のIDを配列に格納
        let fields = ['houjin', 'tanto', 'mail', 'tel', 'types', 'zipcode', 'address1', 'address2', 'address3', 'pass', 'confirm_pass'];

        for (let i = 0; i < fields.length; i++) {
            // 入力項目を取得
            let field = document.getElementById(fields[i]);

            // 入力項目が空だった場合
            if (field.value === '') {
                // アラートを表示
                alert('入力が必要な項目が入力されていません。');
                // 送信を中止
                return false;
            }
        }

        // パスワードの確認が一致しているかチェック
        if (document.getElementById('pass').value !== document.getElementById('confirm_pass').value) {
            alert('パスワードが一致していません。');
            return false;
        }

        // すべてのチェックを通過したら送信を許可
        return true;
    };
};

    </script>
    <footer class="footer bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p>BizDiverse</p>
        </div>
    </footer>

</body>

</html>

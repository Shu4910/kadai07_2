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
    <div class="fv_text">
        <p style="margin-bottom: 4px;">精神障害者に特化したスカウトメディアサービス</p>
        </div>
        <div class="fv_main">
        <p style="margin-bottom: 8px;">BizDiverse</p>
        </div>
    <div class="step_bar_wrap">
        <div class="step_text">STEP</div>
        <div class="step_nav_wrap">
            <ul class="step_nav_list">
                <li id="li_1" class="active">
                    <div>
                        <span>1</span>
                    </div>
                </li>
                <li id="li_2" class="">
                    <div>
                        <span>2</span>
                    </div>
                </li>
                <li id="li_3" class="">
                    <div>
                        <span>3</span>
                    </div>
                </li>
                <li id="li_4" class="">
                    <div>
                        <span>4</span>
                    </div>
                </li>
            </ul>
        </div>
        <!-- <div class="easy_sec">簡単15秒</div> -->
    </div>
    <section class="desired-jobs">
			<p>簡単4STEP！30秒で入力完了</p>
	</section>



    <div class="center-screen">
    <div class="each-form  step1">
        <div class="fukidashi_text">
        <p style="margin-bottom: 0px;">名前とふりがなを<br>記入してください。</p>
        </div>
        <div id="form" class="step_flex">
            
<form action="write.php" method="post" id="myForm" onsubmit="return checkPasswordMatch();">
            <div class="each-form">
                    名前（公開されません）: <input type="text" id="name" name="name">
                    <br>
                    ニックネーム（公開されます）：<input type="text" id="kana" name="kana">
                    </div>
            
                    <div class="pager_wrap" style="margin-top: 100px;">
                        <div class="pager_inner">
                            <button  type="button" id="next_btn1" class="next_step_btn"><span>次へ進む</span></button>
                        </div>
                    </div>
        </div>
         </div>
    </div>


        <div class="each-form step2" style="display:none">
        <div class="fukidashi_text">
        <p style="margin-bottom: 0px;">生年月日とメールアドレス<br>電話番号を記入してください。</p>
        </div>
        
        <div class="each-form">
        生年月日: <input type="date" id="birthday" name="birthday" value="1992-09-10">
        </div>
        <div class="each-form">
            メールアドレス: <input type="email" id="email" name="email">
        </div>
        <div class="each-form">
            電話番号: <input type="tel" id="tel" name="tel">
        </div>


        <div class="pager_wrap" style="margin-top: 100px;">
                        <div class="pager_inner">
                            <button type="button" id="back_btn1" class="back_step_btn"><span>戻る</span></button>
                            <button type="button" id="next_btn2" class="next_step_btn"><span>次へ進む<br>（残り2問）</span></button>
                        </div>
                    </div>
                </div>
         </div>


        </div>





    <div class="each-form step3" style="display:none">
        <div class="fukidashi_text">
            <p style="margin-bottom: 0px;">障害種別と手帳の有無、<br>希望する情報を選択してください。</p>
            </div>
            
        <div class="each-form">
            障害種別: 
            <select id="types" name="types">
                <option name="types"> 精神 </option>
                <option name="types"> 身体 </option>
                <option name="types"> 発達 </option>
                <option name="types"> その他 </option>
            </select>
                <br>
            手帳の有無: 
            <select id="techo" name="techo">
                <option name="techo"> - </option>
                <option name="techo"> 有り </option>
                <option name="techo"> 無し </option>
                <option name="techo"> 申請中 </option>
            </select>
        <br>
            希望する情報: 
            <select id="info" name="info">
                <option name="info"> 全ての情報 </option>
                <option name="info"> 就転職情報のみ </option>
                <option name="info"> 福祉サービス情報のみ </option>
            </select>
                <br>
        </div>
                <div class="pager_wrap" style="margin-top: 100px;">
                            <div class="pager_inner">
                                <button type="button" id="back_btn2" class="back_step_btn"><span>戻る</span></button>
                                <button type="button" id="next_btn3" class="next_step_btn"><span>最後の質問に<br>進む</span></button>
                            </div>
                </div>
        </div>
    </div>

    <div class="each-form step4" style="display:none">
        <div class="fukidashi_text">
        <p style="margin-bottom: 0px;">住まいの地域とパスワードを入力してください。</p>
        </div>
        
        <div class="each-form">
        <table>
        <tbody>
            <tr>
                <th>郵便番号: </th>
                <td class="zipcode-cell" style="padding-top: 0px;">
                    <input id="zipcode" class="zipcode" type="text" name="zipcode" value="" placeholder="例)8120012">
                    <button id="search" type="button">ボタンを押して<br>住所を自動入力</button>
                    <p id="error"></p>
                </td>
            </tr>

            <tr>
                <th>都道府県: </th>
                <td><input id="address1" type="text" name="address1" value=""></td>
            </tr>

            <tr>
                <th>市区町村: </th>
                <td><input id="address2" type="text" name="address2" value=""></td>
            </tr>

            <tr>
                <th>町域: </th>
                <td><input id="address3" type="text" name="address3" value=""></td>
            </tr>
            <br>
        </tbody>
        </table>
        </div>
        
        <div class="each-form pass-check">
            パスワード: <input type="password" id="pass" name="pass">
            <br>
        </div>
        <div class="each-form pass-check"> <!-- new line -->
            パスワード(確認): <input type="password" id="confirm_pass" name="confirm_pass"> <!-- new line -->
            <br>
        </div>

        <div class="pager_wrap" style="margin-top: 100px;">
            <div class="pager_inner">
                <div class="button-group"> 
                    <button type="button" id="back_btn3" class="back_step_btn"><span>戻る</span></button>
                    <input type="submit" value="送信" class="submit-button next_step_btn" style="margin-top: 8px;">
                </div>
            </div>
        </div>
        </div>
    </div>
    </form>

    <script src="js/main.js"></script>
    <script src="js/index.js"></script>

    <script>
function checkPasswordMatch() {
    var password = document.getElementById("pass").value;
    var confirmPassword = document.getElementById("confirm_pass").value;

}
</script>


    <script>
        $(document).on("keydown", ":input:not(textarea)", function(event) {
            if (event.key == "Enter") {
                event.preventDefault();
            }
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/fetch-jsonp@1.1.3/build/fetch-jsonp.min.js"></script>
<script src="js/enter.js"></script>


<footer>© BizDiverse</footer>
</div>
</body>

</html>

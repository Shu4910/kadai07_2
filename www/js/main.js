$(document).ready(function() {
    var isStep4 = false;  // 追加：ステップ4に到達したかどうかを保持する変数

    $("#next_btn1").click(function() {
        if ($('#name').val() == "" || $('#kana').val() == "") {
            alert('入力項目に不備があります。');
            return; // ここで処理を終了する
        }
        $("#li_1").removeClass("active");
        $("#li_2").addClass("active");
        $(".step1").hide();
        $(".step2").show();
    });


    $('#next_btn2').click(function() {
        if($('#birthday').val() == "" || $('#email').val() == ""|| $('#tel').val() == ""){
            alert('生年月日とメールアドレスを記入してください。');
            return; // ここで処理を終了する
        } else {
            $('.step2').hide();
            $('.step3').show();
        }
    });

    $('#next_btn3').click(function() {
        if($('#types').val() == "" || $('#techo').val() == "" || $('#info').val() == ""){
            alert('障害種別と手帳の有無、希望する情報を選択してください。');
            return; // ここで処理を終了する
        } else {
            $('.step3').hide();
            $('.step4').show();
            isStep4 = true;  // 追加：ステップ4に到達した
        }
    });

    $('#myForm').submit(function(){
        var password = $('#pass').val();
        var confirmPassword = $('#confirm_pass').val();
    
        // パスワードとパスワード(確認)が一致しているかチェック
        if (password !== confirmPassword) {
            alert('パスワードが一致していません。');
            return false;  // 送信をキャンセル
        }
    
        if(isStep4 && ($('#zipcode').val() == "" || $('#address1').val() == "" || $('#address2').val() == "" || $('#address3').val() == "")){
            alert('お住まいの地域を入力してください。');
            return false;
        }
    
        alert('登録が完了しました！ログイン後にエリア、こだわり条件は必ず設定してください。レジュメ登録は任意です。');
    });

    

    $('#back_btn1').click(function() {
    $('.step2').hide();
    $('.step1').show();
    });

    $('#back_btn2').click(function() {
        $('.step3').hide();
        $('.step2').show();
    });

    $('#back_btn3').click(function() {
        $('.step4').hide();
        $('.step3').show();
    });



});
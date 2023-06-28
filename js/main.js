$(document).ready(function() {
    var isStep4 = false;  // 追加：ステップ4に到達したかどうかを保持する変数

    $('#next_btn1').click(function() {
        if($('#name').val() == "" || $('#kana').val() == ""){
            alert('名前とふりがなを記入してください。');
        } else {
            $('.step1').hide();
            $('.step2').show();
        }
    });

    $('#next_btn2').click(function() {
        if($('#birthday').val() == "" || $('#email').val() == ""){
            alert('生年月日とメールアドレスを記入してください。');
        } else {
            $('.step2').hide();
            $('.step3').show();
        }
    });

    $('#next_btn3').click(function() {
        if($('#types').val() == "" || $('#techo').val() == "" || $('#info').val() == ""){
            alert('障害種別と手帳の有無、希望する情報を選択してください。');
        } else {
            $('.step3').hide();
            $('.step4').show();
            isStep4 = true;  // 追加：ステップ4に到達した
        }
    });

    $('#myForm').submit(function(){
        if(isStep4 && ($('#zipcode').val() == "" || $('#address1').val() == "" || $('#address2').val() == "" || $('#address3').val() == "")){
            alert('お住まいの地域を入力してください。');  // 変更：条件を満たしたときだけアラートを表示
            return false;
        }else{
            alert('登録が完了しました！');  // 変更：条件を満たしたときだけアラートを表示
        }
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
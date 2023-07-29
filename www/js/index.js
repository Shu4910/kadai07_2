document.getElementById('myForm').addEventListener('submit', function(e) {
    var name = document.getElementById('name').value;
    var kana = document.getElementById('kana').value;
    var email = document.getElementById('email').value;
    var birthday = document.getElementById('birthday').value;
    var types = document.getElementById('types').value;
    var techo = document.getElementById('techo').value;
    var info = document.getElementById('info').value;
    var zipcode = document.getElementById('zipcode').value;
    var address1 = document.getElementById('address1').value;
    var address2 = document.getElementById('address2').value;
    var address3 = document.getElementById('address3').value;

    // if (name == "" || kana == "" || email == "" || birthday == "" || types == "" || techo == "" || info == "" || zipcode == "" || address1 == "" || address2 == "" || address3 == "") {
    //     alert('全ての入力項目を入力してください。');
    //     e.preventDefault();
    // } else if (!/^[\u30A0-\u30FF\u3040-\u309F]+$/i.test(kana)) {
    //     alert('フリガナはカタカナもしくはひらがなで入力してください。');
    //     e.preventDefault();
    // }
});
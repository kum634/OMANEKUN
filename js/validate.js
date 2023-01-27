$(function(){

  $('#form-login button#sub').on('click' , function() {

    $('.error_password1').text('');
    $('.error_username').text('');

    var username = $('#username').val();
    var password = $('#password').val();

    if (!username || !password) {
      if (!username) $('.error_username').text('ユーザー名が入力されていません。');
      if (!password) $('.error_password').text('パスワードが入力されていません。');
      return;
    }

    $('#form-login').submit();

  });

  $('#form-signup button#sub').on('click' , function() {

    var error_flg = 0;
    $('.error_username').text('');
    $('.error_mailaddress').text('');
    $('.error_password1').text('');
    $('.error_password2').text('');

    var username = $('#username').val();
    var mailaddress = $('#mailaddress').val();
    var password1 = $('#password1').val();
    var password2 = $('#password2').val();


    if (!username || !mailaddress || !password1 || !password2) {
     if (!username) $('.error_username').text('ユーザー名が入力されていません。');
     if (!mailaddress) $('.error_mailaddress').text('メールアドレスが入力されていません。');
     if (!password1) $('.error_password1').text('パスワードが入力されていません。');
     if (!password2) $('.error_password2').text('パスワードが入力されていません。');
     error_flg = 1;
    }
    if (!mailaddress.match(/.+@.+\..+/)) {
      $('.error_mailaddress').text('正しい形式で入力してください。');
      error_flg = 1;
    }
    if (password1 && password2) {
      if (password1 !== password2) {
        $('.error_password2').text('パスワードが一致しません。');
        error_flg = 1;
      }
    }

    if (error_flg == 1) return false;
    $('#form-signup').submit();
  });

  $('#form-reset button#sub').on('click' , function() {

    var error_flg = 0;
    $('.error_password1').text('');
    $('.error_password2').text('');

    var password1 = $('#password1').val();
    var password2 = $('#password2').val();

    console.log(password1);
    console.log(password2);


    if (!password1 || !password2) {
     if (!password1) $('.error_password1').text('パスワードが入力されていません。');
     if (!password2) $('.error_password2').text('パスワードが入力されていません。');
     error_flg = 1;
    }
    if (password1 && password2 && (password1 !== password2)) {
      if (password1 !== password2) {
        $('.error_password2').text('パスワードが一致しません。');
        error_flg = 1;
      }
    }
    console.log(error_flg);
    if (error_flg == 1) return false;
    // return false;
    $('#form-reset').submit();
  });

  $('#form-email button#sub').on('click' , function() {

    var error_flg = 0;
    $('.error_mailaddress').text('');

    var mailaddress = $('#mailaddress').val();

    if (!mailaddress.match(/.+@.+\..+/)) {
      $('.error_mailaddress').text('正しい形式で入力してください。');
      error_flg = 1;
    }

    if (error_flg == 1) return false;

    $('#form-email').submit();
  });


});

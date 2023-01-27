$(document).ready(function(){

  /****************************

  定義した関数

  *****************************/
  function nl2br(str) {

    return str.replace(/\r?\n/g, '<br />');

  }

  function getParam(name, url) {

    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));

  }

  function ajax_del(param) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url:"./func/ajax.php",
      type:"POST",
      data:param,
      dataType:"json",
      timeout:3000
    }).done(function(data) {
      alert('削除しました。');
      if (data['res'] == 1) {
        setTimeout(function(){
          location.href = location.href;
        },2000);
      }
    }).fail(function(data) {
      alert('失敗');
      console.log("ajax通信に失敗しました");
      console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
      console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
      console.log("errorThrown    : " + errorThrown.message); // 例外情報
      console.log("URL            : " + url);
    });

  }
  /****************************

  依頼データ削除

  *****************************/

  $(document).on('click', 'table button.del', function(){
    if (confirm('本当に削除しますか？') !== true) return;
    var id = $(this).data('id');
    var csrf_token = $(this).data('csrf_token');
    // console.log(csrf_token);
    var param = {
        id:id,
        ajax_mode:'del',
        csrf_token:csrf_token
      }
      // console.log(param);
    ajax_del(param);
  });


  /****************************

  ログアウト処理

  *****************************/

  $('a#logout').on('click' , function() {
    $('form#logout_form').submit();
    console.log("logout");
    // $('<form/>', {action: '', method: 'post'})
     // .append($('<input/>', {type: 'hidden', name: 'logout', value: 'logout'}))
     // .appendTo(document.body)
     // .submit();
    return false;
  });

  /****************************

  dataTable処理

  *****************************/

  jQuery(function($){
    $.extend( $.fn.dataTable.defaults, {});
    $('#datatable-example').DataTable({
      responsive : true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Japanese.json"
      },
      order: [ 0, "desc" ]
    });
  });



  /****************************

  フォーム送信

  *****************************/


  $('form button').on('click' , function() {
    console.log('フォームを送信しました。');
    $(this).parent().parent().submit();
    return false;
  });

  /****************************

  モーダルフォーム

  *****************************/

  $('#modal-form').on('show.bs.modal', function (event) {

    var modal_btn = $(event.relatedTarget);
    var modal = $(this);
    var mode = modal_btn.data('mode');
    var modal_subbtn = $('#modal-form button#sub');
    var title = modal_btn.data('title');
    $('.modal-title').text(title);
    if (mode == 'search') {

      var sel3 = $('form dd select:nth-of-type(3)');
      sel3.hide().next('span').hide();

      $('form dd select:nth-of-type(2)').on('change', function() {

        $(this).nextAll().val('');

        var sel_val = $(this).val();
        if (sel_val != '') $(this).next('span').nextAll().show();
        else $(this).next('span').nextAll().hide();
      });

    }

    modal.find('input[type="text"]').val('').end()
    .find('select').val('').end()
    .find('input[type="tel"]').val('').end()
    .find('input[type="email"]').val('').end()
    .find('input[type="radio"]').prop("checked", false).end()
    .find('input[type="checkbox"]').prop("checked", false).end();

    if (mode == 'add') modal_subbtn.text('登録');
    if (mode == 'search') modal_subbtn.text('検索');

    modal.find('form input[name="mode"]').val(mode);
  });


  /****************************

  詳細モーダル

  *****************************/

  $('#modal-detail').on('show.bs.modal', function (event) {

    var modal_btn = $(event.relatedTarget);
    var modal = $(this);
    var detail = modal.children('div.modal-dialog').children('div.modal-content').children('div.result');
    var edit_btn = $('button#edit');
    var prnt_btn = $('button#print');

    var edit_form = modal.children('div.modal-dialog').children('div.modal-content').children('div.form_area');
    var update_btn = edit_form.find('button#sub');

    $('.modal-title').text('詳細');

    edit_form.hide();
    detail.show();

    var id = modal_btn.data('id');
    var storage_date = modal_btn.data('storage_date');
    var retrieval_date = modal_btn.data('retrieval_date');
    var last_name = modal_btn.data('last_name');
    var first_name = modal_btn.data('first_name');
    var tel = modal_btn.data('tel');
    var mailaddress = modal_btn.data('mailaddress');
    var car_name = modal_btn.data('car_name');
    var model = modal_btn.data('model');
    var license = modal_btn.data('license');
    var inspection_date = modal_btn.data('inspection_date');
    var maintenance_type = modal_btn.data('maintenance_type');
    var maintenance_detail = modal_btn.data('maintenance_detail');
    var wash = modal_btn.data('wash');
    var clean = modal_btn.data('clean');

    var notices = modal_btn.data('notices');
    var notices_detail = modal_btn.data('notices_detail');

    //編集

    edit_btn.on('click' , function() {

      $('.modal-title').text('編集');
      edit_form.show();
      detail.hide();
      var mode = $(this).data('mode');
      update_btn.text('更新');
      modal.find('form input[name="mode"]').val(mode);
      modal.find('form input[name="id"]').val(id);

      storage_date = (String(storage_date)).split('-');
      retrieval_date = (String(retrieval_date)).split('-');
      inspection_date = (String(inspection_date)).split('-');
      wash = (String(wash)).split(',');
      clean = (String(clean)).split(',');
      maintenance_type = (String(maintenance_type)).split(',');
      notices = (String(notices)).split(',');

      modal
      .find('input[type="text"]').val('').end()
      .find('select').val('').end()
      .find('input[type="tel"]').val('').end()
      .find('input[type="email"]').val('').end()
      .find('input[type="radio"]').prop("checked", false).end()
      .find('input[type="checkbox"]').prop("checked", false).end();

        edit_form
        .find('select[name="storage_date_y"]').val(storage_date[0]).end()
        .find('form select[name="storage_date_m"]').val(storage_date[1]).end()
        .find('form select[name="storage_date_d"]').val(storage_date[2]).end()
        .find('form select[name="retrieval_date_y"]').val(retrieval_date[0]).end()
        .find('form select[name="retrieval_date_m"]').val(retrieval_date[1]).end()
        .find('form select[name="retrieval_date_d"]').val(retrieval_date[2]).end()
        .find('[name="last_name"]').val(last_name).end()
        .find('[name="first_name"]').val(first_name).end()
        .find('[name="tel"]').val(tel).end()
        .find('[name="mailaddress"]').val(mailaddress).end()
        .find('[name="car_name"]').val(car_name).end()
        .find('[name="model"]').val(model).end()
        .find('[name="license"]').val(license).end()
        .find('.inspection_date_y').val(inspection_date[0]).end()
        .find('.inspection_date_m').val(inspection_date[1]).end()
        .find('.inspection_date_d').val(inspection_date[2]).end()
        .find('[name="maintenance_type[]"]').val(maintenance_type).end()
        .find('[name="maintenance_detail"]').val(maintenance_detail).end()
        .find('[name="wash"]').val(wash).end()
        .find('[name="clean"]').val(clean).end()
        .find('[name="notices[]"]').val(notices).end()
        .find('[name="notices_detail"]').val(notices_detail).end();

    });

    prnt_btn.on('click' , function() {

      storage_date = (String(storage_date)).split('-');
      retrieval_date = (String(retrieval_date)).split('-');
      inspection_date = (String(inspection_date)).split('-');
      wash = (String(wash)).split(',');
      clean = (String(clean)).split(',');
      maintenance_type = (String(maintenance_type)).split(',');
      notices = (String(notices)).split(',');

      var print_page = './print.php?';
      print_page += 'storage_date_y' + '=' + storage_date[0];
      print_page += '&storage_date_m' + '=' + storage_date[1];
      print_page += '&storage_date_d' + '=' + storage_date[2];
      print_page += '&retrieval_date_y' + '=' + retrieval_date[0];
      print_page += '&retrieval_date_m' + '=' + retrieval_date[1];
      print_page += '&retrieval_date_d' + '=' + retrieval_date[2];
      print_page += '&last_name' + '=' + last_name;
      print_page += '&first_name' + '=' + first_name;
      print_page += '&tel' + '=' + tel;
      print_page += '&mailaddress' + '=' + mailaddress;
      print_page += '&car_name' + '=' + car_name;
      print_page += '&model' + '=' + model;
      print_page += '&license' + '=' + license;
      print_page += '&inspection_date_y' + '=' + inspection_date[0];
      print_page += '&inspection_date_m' + '=' + inspection_date[1];
      print_page += '&inspection_date_d' + '=' + inspection_date[2];
      print_page += '&maintenance_type' + '=' + maintenance_type;
      print_page += '&maintenance_detail' + '=' + maintenance_detail;
      print_page += '&wash' + '=' + wash;
      print_page += '&clean' + '=' + clean;
      print_page += '&notices' + '=' + notices;
      print_page += '&notices_detail' + '=' + notices_detail;

      location.href = print_page;



    });

    //詳細表示

    modal.find('#storage_date').text(storage_date).end()
      .find('#retrieval_date').text(retrieval_date).end()
      .find('#cos_name').text(last_name + first_name).end()
      .find('#tel').text(tel).end()
      .find('#email').text(mailaddress).end()
      .find('#car_name').text(car_name).end()
      .find('#model').text(model).end()
      .find('#license').text(license).end()
      .find('#inspection_date').text(inspection_date).end()
      .find('#maintenance_type').text(maintenance_type).end()
      .find('#maintenance_detail').html(nl2br(maintenance_detail)).end()
      .find('#wash').text(wash).end()
      .find('#clean').text(clean).end()
      .find('#notices').text(notices).end()
      .find('#notices_detail').html(nl2br(notices_detail)).end();

  });

});

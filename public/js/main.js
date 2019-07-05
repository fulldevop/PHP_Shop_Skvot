'use strict';

$(document).ready(() => {
  $("#login").on('click', () => {
    $(".auth-block").addClass("auth-block-visible");
  });
  $("#open-login").on('click', () => {
    event.preventDefault();
    document.getElementById('login').click();
  });

  $(".close-auth-btn").on('click', () => {
    $(".auth-block").removeClass("auth-block-visible");
  });

  $("#form-auth").submit(function(event) {
    event.preventDefault();
    $.ajax({
      url: "/users/login",
      type: "POST",
      dataType: "json",
      data: {
        login: $("#auth-login").val(),
        pass: $("#auth-pass").val(),
        save: $("#save").val(),
        send: $("#auth-send").val(),
      },
      error: function () {
        alert("Что-то пошло не так...");
      },
      success: function (answer) {
        if (answer.response === 'error') {
          $('.error-auth').css({display: 'block'});
          $('#auth-pass').val('');
        } else {
          document.location.reload(true);
        }
      }
    })
  });

  $("#order-form").submit(function(event) {
    event.preventDefault();
    $.ajax({
      url: "/orders/send",
      type: "POST",
      dataType: "json",
      data: {
        email: $("#order-form-email").val(),
        phone: $("#order-form-phone").val(),
        address: $("#order-form-address").val(),
        login: $("#order-form-login").val(),
        pass: $("#order-form-pass").val(),
        send: $("#order-form-send").val(),
      },
      error: function () {
        alert("Что-то пошло не так...");
      },
      success: function (answer) {
        if (answer.response === 'error') {
          $('#error-order-registr').css({display: 'block'});
          $('#order-form-login').val('');
          $('#order-form-pass').val('');
        } else {
          window.location.href='/basket//?message=ok'
        }
      }
    })
  });

  $("#order-btn").on('click', () => {
    $.ajax({
      url: "/orders/formalize",
      error: function () {
        alert("Что-то пошло не так...");
      },
      success: function () {
      window.location.href='/basket//?message=ok'
      }
    })
  });

  $(function(){
    $("#phone").mask("+7(999)999-9999");
  });

  $(".buy-btn").on('click', function (elem) {
    let id = elem.target.id;

    $.ajax({
      url: "/product/addBasket/",
      type: "POST",
      dataType: "json",
      data: {
        id: id,
      },
      error: function () {
        alert("Что-то пошло не так...");
      },
      success: function (answer) {
        $('.count').html(answer);
      }
    })
  });

  $(".delete-good").on('click', function (elem) {
    let id = elem.target.id;

    $.ajax({
      url: "/basket/delete/",
      type: "POST",
      dataType: "json",
      data: {
        id: id,
      },
      error: function () {
        alert("Что-то пошло не так...");
      },
      success: function (answer) {
        if (answer.quantity > 0) {
          $('#count-input_' + answer.id).val(answer.quantity);
          let sum = $('#price-good_' + answer.id).data('price') * $('#count-input_' + answer.id).val();
          $('#sum-good_' + answer.id).attr('data-sum', sum).text(sum.toLocaleString());
        } else {
          $('#cart-good_' + answer.id).remove();
        }

        if (answer.count) {
          $('.count').html(answer.count);

          $('#total-sum').text(answer.total.toLocaleString());
        } else {
          $('.count').html(0);
          location.reload();
        }
      }
    })
  });


  $('.basket-block-good').on('input', 'input', function (elem) {
    let id = elem.target.dataset.id;
    let quantity = $(this).val();

    if (quantity < 1) {
      $('#count-input_' + id).val(1);
      quantity = 1;
    } else if (quantity > 99) {
      $('#count-input_' + id).val(99);
      quantity = 99;
    }
    $.ajax({
      url: "/basket/updateQuantity/",
      type: "POST",
      dataType: "json",
      data: {
        id: id,
        quantity: quantity,
      },
      error: function () {
        alert("Что-то пошло не так...");
      },
      success: function (answer) {
        let sum = $('#price-good_' + id).data('price') * quantity;
        $('#sum-good_' + id).attr('data-sum', sum).text(sum.toLocaleString());
        $('#total-sum').text(answer.total.toLocaleString());

        $('.count').html(answer.count);
      }
    });
  });


  $('.status-select').change(function (elem) {
    let id = elem.target.id;
    let status = elem.target.value;

    $.ajax({
      url: "/orders/statusChange/",
      type: "POST",
      dataType: "json",
      data: {
        id: id,
        status: status,
      },
      error: function () {
      },
      success: function (answer) {
      }
    });
  });


  $(function () {
    $.each($('.price-good'), function () {
      let price = this.getAttribute('data-price');
      let parent = this.parentElement;
      let count = parent.querySelector('.count-input').value;
      let sum = price * count;
      parent.querySelector('.sum-product').innerHTML = sum.toLocaleString();
      parent.querySelector('.sum-product').setAttribute('data-sum', sum);
    });

    let totalSum = 0;
    $.each($('.sum-product'), function () {
      totalSum += parseInt(this.dataset.sum);
    });
    $('#total-sum').text(totalSum.toLocaleString());
  });
});
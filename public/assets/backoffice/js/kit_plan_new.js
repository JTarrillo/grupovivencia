function add_cart(id, name, price, contable, point) {
  var a = 'a_' + id;
  var aa = 'aa_' + id;
  document.getElementById(a).disabled = true;
  document.getElementById(a).innerHTML =
    "<span class='spinner-border spinner-border-sm' role='status'></span>";
  $.ajax({
    type: 'post',
    url: site + 'backoffice_new/planes/add_cart_planes',
    dataType: 'json',
    data: {
      id: id,
      name: name,
      price: price,
      qty: 1,
      contable: contable,
      point : point
    },
    success: function (data) {
      if (data.status == true) {
        document.getElementById(a).style.display = 'none';
        document.getElementById(aa).style.display = 'block';

        const btns = document.getElementsByClassName('btn_add_cart');

        for (var i = 0; i < btns.length; i++) {
          btns[i].disabled = true;
        }
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest);
    },
  });
}

function add_cart_product(id, name, price, qty, point, img) {
  var a = 'a_' + id;
  var aa = 'aa_' + id;
  document.getElementById(a).disabled = true;
  document.getElementById(a).innerHTML =
    "<span class='spinner-border spinner-border-sm' role='status'></span>";
  $.ajax({
    type: 'post',
    url: site + 'backoffice_new/planes/add_cart_product',
    dataType: 'json',
    data: {
      id: id,
      name: name,
      price: price,
      qty: qty,
      point: point,
      img: img,
    },
    success: function (data) {
      if (data.status == true) {
        document.getElementById(a).style.display = 'none';
        document.getElementById(aa).style.display = 'block';
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.message,
          showConfirmButton: false,
          timer: 1000,
        });
      }
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      console.log(XMLHttpRequest);
    },
  });
}

function deleted(row_id) {
  sessionStorage.removeItem('selection');
  // Swal.fire({
  //   title: "Confirma que desea eliminar el producto?",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "Si, Confirmo",
  // }).then((result) => {
  // if (result.isConfirmed) {
  $.ajax({
    type: 'post',
    url: site + 'backoffice_new/kit/carrito_delete',
    dataType: 'json',
    data: { row_id: row_id },
    success: function (data) {
      if (data.status == true) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Eliminado',
          showConfirmButton: false,
        });
        removeSessionStorage();
        window.setTimeout(function () {
          window.location = site + 'backoffice_new/kit/carrito';
        }, 1500);
      } else {
        window.setTimeout(function () {
          location.reload();
        }, 1000);
      }
    },
  });
  // } else {
  //   document.getElementById('btn_submit').disabled = false;
  //   document.getElementById('btn_submit').innerHTML = 'Enviar';
  // }
  // });
}

function stores_pay() {
  document.getElementById('submit_tienda').disabled = true;
  document.getElementById('submit_tienda').innerHTML =
    "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
  oData = new FormData(document.forms.namedItem('form'));
  Swal.fire({
    title: 'Confirma que desea pagar en la tienda?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Confirmo',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: site + 'backoffice_new/planes/activar_tienda',
        method: 'POST',
        data: oData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          var data = JSON.parse(data);
          if (data.status == true) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.message,
              showConfirmButton: false,
            });
            window.setTimeout(function () {
              window.location = site + 'backoffice_new/facturas';
            }, 2500);
          } else {
            Swal.fire({
              position: 'center',
              icon: 'info',
              title: data.message,
            });
            document.getElementById('submit_tienda').disabled = false;
            document.getElementById('submit_tienda').innerHTML =
              "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
          }
        },
      });
    } else {
      document.getElementById('submit_tienda').disabled = false;
      document.getElementById('submit_tienda').innerHTML =
        "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
    }
  });
}

function pay_adm() {
  document.getElementById('submit_pay').disabled = true;
  document.getElementById('submit_pay').innerHTML =
    "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
  oData = new FormData(document.forms.namedItem('form'));
  Swal.fire({
    title: 'Confirma que desea realizar la compra?',
    icon: 'warning',
    customClass: 'sweetalert-bg',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Confirmo',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: site + '/dashboard/nueva_venta/procesar_venta',
        method: 'POST',
        data: oData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          var data = JSON.parse(data);
          if (data.status == true) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              customClass: 'sweetalert-bg',
              title: data.message,
              showConfirmButton: false,
            });
            window.setTimeout(function () {
              window.location = site + 'dashboard/nueva_venta';
            }, 1000);
          } else {
            Swal.fire({
              position: 'center',
              icon: 'info',
              customClass: 'sweetalert-bg',
              title: data.message,
            });
            document.getElementById('submit_pay').disabled = false;
            document.getElementById('submit_pay').innerHTML =
              "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
          }
        },
      });
    } else {
      document.getElementById('submit_pay').disabled = false;
      document.getElementById('submit_pay').innerHTML =
        "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
    }
  });
}

function wallet_pay(available_balance, total, membership_id, phone) {
  Swal.fire({
    title: 'Confirma que desea realizar la compra?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Confirmo',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'post',
        url: site + 'backoffice_new/planes/activar_monedero',
        dataType: 'json',
        data: {
          available_balance: available_balance,
          total: total,
          membership_id: membership_id,
          phone: phone,
        },
        success: function (data) {
          if (data.status == true) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.message,
              showConfirmButton: false,
            });
            sessionStorage.removeItem('offer');
            window.setTimeout(function () {
              window.location = site + 'backoffice_new/facturas';
            }, 2500);
          } else {
            Swal.fire({
              position: 'center',
              icon: 'info',
              title: data.message,
            });
            document.getElementById('submit_monedero').disabled = false;
            document.getElementById('submit_monedero').innerHTML =
              "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
          }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        },
      });
    } else {
      document.getElementById('submit_monedero').disabled = false;
      document.getElementById('submit_monedero').innerHTML =
        "<i class='fa fa-usd' aria-hidden='true'></i> Pagar con Monedero";
    }
  });
}

function removeSessionStorage() {
  sessionStorage.removeItem('offer');
}

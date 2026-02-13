function left(position){
    document.getElementById("left").disabled = true;
    document.getElementById("left").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
              $.ajax({
                type: "post",
                url: site + "backoffice/temporal",
                dataType: "json",
                data: {position: position},
                success:function(data){
                    if(data.status == true){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Cambio Guardado',
                            showConfirmButton: false,
                        });
                        window.setTimeout(function () {
                            window.location = site + "backoffice";
                        }, 1000);
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Sucedio un error',
                            showConfirmButton: true,
                        });
                    }
                }            
        });
}

function right(position){
    document.getElementById("right").disabled = true;
    document.getElementById("right").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
    $.ajax({
      type: "post",
      url: site + "backoffice/temporal",
      dataType: "json",
      data: {position: position},
      success:function(data){
          if(data.status == true){
              Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Cambio Guardado',
                  showConfirmButton: false,
              });
              window.setTimeout(function () {
                  window.location = site + "backoffice";
              }, 1000);
          }else{
              Swal.fire({
                  position: 'center',
                  icon: 'info',
                  title: 'Sucedio un error',
                  showConfirmButton: true,
              });
          }
      }            
});
}
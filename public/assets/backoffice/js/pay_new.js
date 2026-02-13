function make_pay(){
      document.getElementById("submit").disabled = true;
      document.getElementById("submit").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Procesando...";
      var amount = document.getElementById("amount").value;
      var total_disponible = document.getElementById("total_disponible").value;
      var pin = document.getElementById("pin").value;
      var bank_name = document.getElementById("bank_name").value;
      var number = document.getElementById("number").value;
      var cci = document.getElementById("cci").value;
          if(amount < 100){
            Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'El importe debe ser mayor o igual a S/100',
                showConfirmButton: true,
            });
            document.getElementById("submit").disabled = false;
            document.getElementById("submit").innerHTML = "Enviar";
          }else{
            Swal.fire({
                title: 'Confirma que desea realizar el cobro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Confirmo'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: site + "backoffice_new/pay/make_pay",
                        dataType: "json",
                        data: {amount: amount,
                               total_disponible:total_disponible,
                               bank_name:bank_name,
                               number:number,
                               cci:cci,
                               pin:pin},
                        success:function(data){
                            if(data.status == true){
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                });
                                window.setTimeout(function () {
                                    window.location = site + "backoffice_new/cobros";
                                }, 2500);
                            }else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'info',
                                    title: data.message
                                });
                                document.getElementById("submit").disabled = false;
                                document.getElementById("submit").innerHTML = "Enviar";
                            }
                        }            
                    });
                }else{
                    document.getElementById("submit").disabled = false;
                    document.getElementById("submit").innerHTML = "Enviar";
                }
            });


              
          }
}

function send_pin(id, name, email){
    document.getElementById("text_pin").disabled = true;
    document.getElementById("text_pin").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span> Enviando...";
    $.ajax({
        type: "post",
        url: site + "backoffice_new/cobros/send_pin",
        dataType: "json",
        data: {id: id,
            name: name,
            email: email},
        success:function(data){
            if(data.status == true){
                document.getElementById("text_pin").disabled = false;
                document.getElementById("text_pin").innerHTML = "Enviado, revise sun bandeja de correo";
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'info',
                    title: data.message
                });
                document.getElementById("text_pin").disabled = false;
                document.getElementById("text_pin").innerHTML = "Clic Aquí para solicitar PIN";
            }
        }            
});
              
          

}

function Numtext(string){//solo letras y numeros
    var out = '';
    //Se añaden las letras validas
    var filtro = '.1234567890';//Caracteres validos
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
	     out += string.charAt(i);
    return out;
}
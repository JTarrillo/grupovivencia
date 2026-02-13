function copy(text) {
    r = document.querySelector("#kt_referral_link_input"); 
    e = document.querySelector("#kt_referral_program_link_copy_btn");
    navigator.clipboard.writeText(text);
    //change boton
    r.classList.add("bg-success")
    e.innerHTML = "Copiado!"
}

function dont_show() {
    e = document.querySelector("#response");
    var checkBox = document.getElementById("check_dont");
    // If the checkbox is checked, display the output text
    if (checkBox.checked == true){
        //change boton
        $.ajax({
            type: "post",
            url: site + "backoffice_new/dont_show_ads",
            dataType: "json",
            success:function(data){
                if(data.status == true){
                    //change boton
                    e.innerHTML = "Saved!" 
                    //l.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i> Selected';
                }
            }            
        });
    }
}

function left(position){
    l = document.querySelector("#botton_left"); 
    r = document.querySelector("#botton_right"); 
          $.ajax({
            type: "post",
            url: site + "backoffice/temporal",
            dataType: "json",
            data: {position: position},
            success:function(data){
                if(data.status == true){
                    //change boton
                    l.classList.add("active");
                    l.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i> Izquierda';
                    r.classList.remove("active");
                    r.innerHTML = '<i class="fa fa-chevron-right"></i> Derecha';
                }
            }            
    });
}

function right(position){
    l = document.querySelector("#botton_left"); 
    r = document.querySelector("#botton_right"); 
    $.ajax({
        type: "post",
        url: site + "backoffice/temporal",
        dataType: "json",
        data: {position: position},
        success:function(data){
            //change boton
            r.classList.add("active");
            r.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i> Derecha';
            l.classList.remove("active");
            l.innerHTML = '<i class="fa fa-chevron-left"></i> Izquierda';
            
        }            
    });
}
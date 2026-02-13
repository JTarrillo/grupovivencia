function go_home(){
    window.location = site + "backoffice_new/binario";
}

function go_back(){
    window.history.back();
}

function go_top(encryt_username){
    $.ajax({
        type: "post",
        url: site + "backoffice_new/binario_top",
        dataType: "json",
        data: {encryt_username : encryt_username},
        success:function(data){   
            if(data.status == true){
                window.setTimeout(function () {
                    window.location = site + "backoffice_new/binario/"+ data.id;
                }, 0000);
            }
        }         
    });
}

function go_left(encryt_username){
    $.ajax({
        type: "post",
        url: site + "backoffice_new/binario_left",
        dataType: "json",
        data: {encryt_username : encryt_username},
        success:function(data){   
            if(data.status == true){
                window.setTimeout(function () {
                    window.location = site + "backoffice_new/binario/"+ data.id;
                }, 0000);
            }
        }         
    });
}

function go_right(encryt_username){
    $.ajax({
        type: "post",
        url: site + "backoffice_new/binario_right",
        dataType: "json",
        data: {encryt_username : encryt_username},
        success:function(data){   
            if(data.status == true){
                window.setTimeout(function () {
                    window.location = site + "backoffice_new/binario/"+ data.id;
                }, 0000);
            }
        }         
    });
}  

function show_info(name, last_name, username, membership , range , status, pais_img){

    var name_text = document.getElementById("i_name");
    name_text.value = name +" "+ last_name;
    
    var username_text = document.getElementById("i_username");
    username_text.value = username;

    var membership_text = document.getElementById("i_membership");
    membership_text.value = membership;

    var range_text = document.getElementById("i_range");
    range_text.value = range;
    
    var pais_text = document.getElementById("i_country");
    url_img = site + "assets/images/paises/" + pais_img;
    pais_text.innerHTML = "<img src='" +url_img+ "' alt='pais' width='40'/> ";
    var status_text = document.getElementById("i_status");
    if(status == 1){
        status_text.innerHTML = '<span id="i_status" style="color:green !important" class="text-muted btn btn-sm btn-light-success fw-bold ms-2 fs-8 py-1 px-3">Activo</span>';
    }else{
        status_text.innerHTML = '<span id="i_status" style="color:red !important" class="text-muted btn btn-sm btn-light-danger fw-bold ms-2 fs-8 py-1 px-3">Inactivo</span>';
    }
}
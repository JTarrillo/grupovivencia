function up(id) {
    document.getElementById("up").disabled = true;
    document.getElementById("up").innerHTML = "<span class='spinner-border spinner-border-sm' role='status'></span>";
    $.ajax({
        url: site + "dashboard/estructura_up",
        method: "POST",
        data: { id: id },
        success: function (data) {
            var data = JSON.parse(data);
            if (data.status == true) {
                window.location = data.url;
            } else {
                document.getElementById("up").disabled = false;
                document.getElementById("up").innerHTML = "<i class='fa fa-chevron-up'></i>";
            }
        }
    });
}

function show_info(name, last_name, username, range, status, pais_img, point_personal, pointgroup) {

    var name_text = document.getElementById("i_name");
    name_text.value = name + " " + last_name;

    var username_text = document.getElementById("i_username");
    username_text.value = username;

    var range_text = document.getElementById("i_range");
    range_text.value = range;

    var point_text = document.getElementById("i_point");
    point_text.value = point_personal;

    var pointgroup_text = document.getElementById("i_pointgroup");
    pointgroup_text.value = pointgroup;

    var pais_text = document.getElementById("i_country");
    url_img = site + "assets/metronic8/media/flags/" + pais_img;
    pais_text.innerHTML = "<img style='border-radius:5px' src='" + url_img + "' alt='pais' width='25'/> ";
    var status_text = document.getElementById("i_status");
    if (status == 1) {
        status_text.innerHTML = '<span id="i_status" style="color:green !important" class="text-muted btn btn-sm btn-light-success fw-bold ms-2 fs-8 py-1 px-3">Activo</span>';
    } else {
        status_text.innerHTML = '<span id="i_status" style="color:red !important" class="text-muted btn btn-sm btn-light-danger fw-bold ms-2 fs-8 py-1 px-3">Inactivo</span>';
    }
}

function show() {
    var myvalue = "show_table";
    var request = new XMLHttpRequest();
    request.open("POST", "action.php", false);
    request.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    request.send("show_staff=" + myvalue);
    document.getElementById("tbody").innerHTML = request.responseText;
}


function show_id(id) {
    alert(id);
}
function chercher_employe(e) {
    var employe = e.target.value;
    var request = new XMLHttpRequest();
    request.open("POST", "action.php", false);
    request.setRequestHeader("Content-type", "application/x-wwW-form-urlencoded");
    request.send("chercher_un_employe=" + employe);
    document.getElementById("tbody").innerHTML = request.responseText;
  }
  document.getElementById("chercher_un_employe").onkeyup = chercher_employe;
// _____________________update  ____________________________________

var modal = document.getElementById("myModal");

var span = document.getElementsByClassName("close")[0];
function showmodal(id) {
    modal.style.display = "block";
    var staff_info = new XMLHttpRequest();
    staff_info.open("POST", "action.php", false);
    staff_info.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    staff_info.send("id_staff=" + id);
    document.getElementById("myform").innerHTML = staff_info.responseText;
}

span.onclick = function () {
    modal.style.display = "none";
};

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

function success_update() {
    Swal.fire({
        icon: "success",
        title: "Modifier avec succés",
        showConfirmButton: false,
        timer: 1500,
    });
}
function error_update() {
    Swal.fire({
        icon: "error",
        title: "Error...",
        text: "Quelque chose s'est mal passé",
    });
}
function update_staff_f() {
    var id = document.form_staff.update_id.value;
    var flname = document.form_staff.update_familyname.value;
    var frname = document.form_staff.update_firstname.value;
    var email = document.form_staff.update_email.value;
    var cin = document.form_staff.update_cin.value;
    var horaire = document.form_staff.update_horaire.value;
    var funcion = document.form_staff.update_functionality.value;
    var salaire = document.form_staff.update_salaire.value;

    var update_stf = new XMLHttpRequest();
    update_stf.open("POST", "action.php", false);
    update_stf.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    update_stf.send(
        "id=" +
            id +
            "&&flname=" +
            flname +
            "&&frname=" +
            frname +
            "&&email=" +
            email +
            "&&cin=" +
            cin +
            "&&horaire=" +
            horaire +
            "&&funcion=" +
            funcion +
            "&&salaire=" +
            salaire
    );
    if (update_stf.responseText == "updated") {
        success_update();
        show();
        modal.style.display = "none";
    } else {
        error_update();
        modal.style.display = "none";
    }
}

// _____________________update  ____________________________________

// _________________________Add________________________________

var modal2 = document.getElementById("myModal2");
var btn = document.getElementById("myBtn");
var span2 = document.getElementsByClassName("close2")[0];
btn.onclick = function () {
    modal2.style.display = "block";
};
span2.onclick = function () {
    modal2.style.display = "none";
};
window.onclick = function (event) {
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
};

function success_add() {
    Swal.fire({
        icon: "success",
        title: "Ajouter avec succès",
        showConfirmButton: false,
        timer: 1500,
    });
}
function error_add() {
    Swal.fire({
        icon: "error",
        title: "Error...",
        text: "Quelque chose s'est mal passé",
    });
}

function add_staff_f() {
    // var add_id = document.add_form.add_id.value;
    var add_flname = document.add_form.add_familyname.value;
    var add_frname = document.add_form.add_firstname.value;
    var add_email = document.add_form.add_email.value;
    var add_cin = document.add_form.add_cin.value;
    var add_horaire = document.add_form.add_horaire.value;
    var add_funcion = document.add_form.add_functionality.value;
    var add_Salaire = document.add_form.add_Salaire.value;

    var add_request = new XMLHttpRequest();
    add_request.open("POST", "action.php", false);
    add_request.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    add_request.send(
        "add_flname=" +
            add_flname +
            "&&add_frname=" +
            add_frname +
            "&&add_email=" +
            add_email +
            "&&add_cin=" +
            add_cin +
            "&&add_horaire=" +
            add_horaire +
            "&&add_funcion=" +
            add_funcion +
            "&&add_Salaire=" +
            add_Salaire
    );
    if (add_request.responseText == "added") {
        success_add();
        show();
        modal2.style.display = "none";
    } else {
        error_add();
        modal2.style.display = "none";
    }
}
// _________________________Add________________________________

// ____________ delete________________

function success_delete() {
    Swal.fire({
        icon: "success",
        title: "Supprimer avec succès",
        showConfirmButton: false,
        timer: 1500,
    });
}
function error_delete() {
    Swal.fire({
        icon: "error",
        title: "Error...",
        text: "Quelque chose s'est mal passé",
    });
}

var modal3 = document.getElementById("myModal3");
// var btn = document.getElementById("myBtn3");
var span3 = document.getElementsByClassName("close3")[0];
function showmodal_delet(id) {
    modal3.style.display = "block";
    var staff_info = new XMLHttpRequest();
    staff_info.open("POST", "action.php", false);
    staff_info.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    staff_info.send("id_delete=" + id);
    document.getElementById("myp_del").innerHTML = staff_info.responseText;
}
span3.onclick = function () {
    modal3.style.display = "none";
};
window.onclick = function (event) {
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
};

function delete_staff(id) {
    var id_to_delete = id;
    var request_to_delete = new XMLHttpRequest();
    request_to_delete.open("POST", "action.php", false);
    request_to_delete.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    request_to_delete.send("id_to_delete=" + id_to_delete);
    if (request_to_delete.responseText) {
        success_delete();
        show();
        modal3.style.display = "none";
    } else {
        error_delete();
        modal3.style.display = "none";
    }
}

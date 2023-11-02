function success_update() {
  Swal.fire({
    icon: "success",
    title: "Modifier avec succès",
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
function show() {
  var myvalue = "show_table";
  var request = new XMLHttpRequest();
  request.open("POST", "action.php", false);
  request.setRequestHeader("Content-type", "application/x-wwW-form-urlencoded");
  request.send("show_client=" + myvalue);
  document.getElementById("tbody").innerHTML = request.responseText;
}
function chercher_client(e) {
  var client = e.target.value;
  var request = new XMLHttpRequest();
  request.open("POST", "action.php", false);
  request.setRequestHeader("Content-type", "application/x-wwW-form-urlencoded");
  request.send("chercher_un_client=" + client);
  document.getElementById("tbody").innerHTML = request.responseText;
}
document.getElementById("chercher_un_client").onkeyup = chercher_client;
function show_and_alerts() {
  show();
  if (document.getElementById("message").innerHTML == 1) {
    success_update();
  } else if (document.getElementById("message").innerHTML == 2) {
    error_update();
  }
}
document.getElementsByTagName("body").onload = show_and_alerts();
// _____________________update  ____________________________________

var modal = document.getElementById("myModal");

var span = document.getElementsByClassName("close")[0];

function showmodal(id) {
  modal.style.display = "block";

  var clients_info = new XMLHttpRequest();
  clients_info.open("POST", "action.php", false);
  clients_info.setRequestHeader(
    "Content-type",
    "application/x-wwW-form-urlencoded"
  );
  clients_info.send("id_client=" + id);
  document.getElementById("myform").innerHTML = clients_info.responseText;
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
    title: "Modifier avec succès",
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
// function update_client() {
//     var id = document.form_client.update_id.value;
//     var frname = document.form_client.update_firstname.value;
//     var flname = document.form_client.update_familyname.value;
//     var identity_card = document.form_client.update_identity_card.value;
//     var email = document.form_client.update_email.value;
//     var password = document.form_client.update_password.value;
//     var city = document.form_client.update_city.value;
//     var password = document.form_client.update_password.value;
//     var password = document.form_client.update_password.value;
//     var password = document.form_client.update_password.value;
//     var password = document.form_client.update_password.value;

//     var update_client = new XMLHttpRequest();
//     update_client.open("POST", "action.php", false);
//     update_client.setRequestHeader(
//         "Content-type",
//         "application/x-wwW-form-urlencoded"
//     );
//     update_client.send(
//         "id_c_u=" +
//             id +
//             "&&frname_c_u=" +
//             frname +
//             "&&flname_c_u=" +
//             flname +
//             "&&email_c_u=" +
//             email +
//             "&&password_c_u=" +
//             password
//     );
//     if (update_client.responseText == "updated") {
//         success_update();
//         var myvalue = "show_table";
//         var request = new XMLHttpRequest();
//         request.open("POST", "action.php", false);
//         request.setRequestHeader(
//             "Content-type",
//             "application/x-wwW-form-urlencoded"
//         );
//         request.send("show_client=" + myvalue);
//         document.getElementById("tbody").innerHTML = request.responseText;
//     } else {
//         error_update();
//     }
// }
// _____________________update  ____________________________________

// ____________ delete________________

function success_delete() {
  Swal.fire({
    icon: "success",
    title: "Supprimé avec succès",
    showConfirmButton: false,
    timer: 1500,
  });
}
function error_delete() {
  Swal.fire({
    icon: "error",
    title: "Error...",
    text: "Client a déja une résérvation en cours",
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
  staff_info.send("id_delete_c=" + id);
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
  request_to_delete.send("id_c_to_delete=" + id_to_delete);

  if (request_to_delete.responseText == "deleted") {
    success_delete();
    show();
    modal3.style.display = "none";
  } else {
    error_delete();
    modal3.style.display = "none";
  }
}
// ____________ delete________________

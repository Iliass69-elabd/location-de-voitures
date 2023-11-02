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
function error_date_inf() {
  Swal.fire({
    icon: "error",
    title: "Error...",
    text: "la date de fin doit être supérieure à la date de début",
  });
}
function error_date_fields() {
  Swal.fire({
    icon: "error",
    title: "Error...",
    text: "les champs ne doivent pas être vides",
  });
}
// ___________________ modal of update ____________________
const showmodal = (e) => {
  // var mat = e.target.parentElement.parentElement.children[0].innerText;
  document.getElementById("myform_update_a").reset();
  let idr = e.target.getAttribute("idr");
  var voiture = window.reparation
    ? window.reparation.find((r) => r[0] == idr)
    : null;

  if (voiture) {
    document.getElementById("id_rep").value = voiture.id_rep;
    document.getElementById("matricule_v_search_update").value =
      voiture.matricule_rep;
    document.getElementById("mark_v_uapdate").value = voiture.mark_voiture;
    document.getElementById("type_rep").value = voiture.typeRep;
    document.getElementById("cout_rep_update").value = voiture.cout_reparation;
    document.getElementById("dete_rep_update").value = voiture.date_reparation;
  }
  console.log(voiture);
  modal.style.display = "block";
};
// ___________________________modal of delete _______________________________________
function sure_delete(e) {
  Swal.fire({
    title: "Es-vous sûr?",
    text: "Vous ne pourrez pas revenir en arrière!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Oui, supprimez-le!",
  }).then((result) => {
    if (result.isConfirmed) {
      var dalate_request = new XMLHttpRequest();
      dalate_request.open("POST", "action.php", false);
      dalate_request.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
      );
      dalate_request.send("id_delete=" + e.target.getAttribute("idr"));
      if (dalate_request.responseText == "deleted") {
        Swal.fire({
          icon: "success",
          title: "Supprimer avec succès",
          showConfirmButton: false,
          timer: 1500,
        });
        show();
      } else {
        Swal.fire({
          icon: "error",
          title: "Error...",
          text: "Quelque chose s'est mal passé",
        });
      }
    }
  });
}
// _____________________________________________________________________________________
function show() {
  var myvalue = "show_table_reparation";
  var request = new XMLHttpRequest();
  request.open("POST", "action.php", false);
  request.setRequestHeader("Content-type", "application/x-wwW-form-urlencoded");
  request.send("show_reparation=" + myvalue);
  if (request.responseText) {
    let result = JSON.parse(request.responseText);
    if (Object.keys(result).length > 0) {
      window.reparation = result.reparation;
      console.log(window.reparation);
      window.voitures = result.voitures;
      var table = document.getElementById("tbody");
      table.innerHTML = "";
      for (let i = 0; i < window.reparation.length; i++) {
        table.innerHTML += `
                <tr>
                    <td>${window.reparation[i][1]}</td>
                    <td>${window.reparation[i][2]}</td>
                    <td>${window.reparation[i][3]}</td>
                    <td>${window.reparation[i][4]}</td>
                    <td>${window.reparation[i][5]}</td>
                    <td><button  type='button' idr='${window.reparation[i][0]}' class='update'>Modifier</button><button type='button' idr='${window.reparation[i][0]}' class='delete'>Supprimer</button></td>
                </tr>
                `;
      }
      let btn = document.getElementsByClassName("update");
      for (let i = 0; i < btn.length; i++) {
        btn[i].onclick = showmodal;
      }
      let btn_delete = document.getElementsByClassName("delete");
      for (let i = 0; i < btn_delete.length; i++) {
        btn_delete[i].onclick = sure_delete;
      }
    }
    if (window.reparation.length <= 0) {
      var table = document.getElementById("tbody");
      console.log(table);
      table.innerHTML = "<tr><td colspan='6'> Vide</td></tr>";
    }
  }
}

document.getElementsByTagName("body").onload = show();
function chercher_reparation(e) {
  rep = window.reparation.filter(
    (r) =>
      r.matricule_rep.toLowerCase().trim().includes(e.target.value) ||
      r.typeRep.toLowerCase().trim().includes(e.target.value) ||
      r.mark_voiture.toLowerCase().trim().includes(e.target.value)
  );
  var table = document.getElementById("tbody");
  table.innerHTML = "";
  if (rep.length > 0) {
    for (let i = 0; i < rep.length; i++) {
      table.innerHTML += `
                <tr>
                    <td>${rep[i][1]}</td>
                    <td>${rep[i][2]}</td>
                    <td>${rep[i][3]}</td>
                    <td>${rep[i][4]}</td>
                    <td>${rep[i][5]}</td>
                    <td><button  type='button' idr='${rep[i][0]}' class='update'>Modifier</button><button type='button' idr='${rep[i][0]}' class='delete'>Supprimer</button></td>
                </tr>
                `;
    }
    let btn = document.getElementsByClassName("update");
    for (let i = 0; i < btn.length; i++) {
      btn[i].onclick = showmodal;
    }
    let btn_delete = document.getElementsByClassName("delete");
    for (let i = 0; i < btn_delete.length; i++) {
      btn_delete[i].onclick = sure_delete;
    }
  } else {
    var table = document.getElementById("tbody");
    console.log(table);
    table.innerHTML = "<tr><td colspan='6'> Vide</td></tr>";
  }

  //   document.getElementById("tbody").innerHTML = request.responseText;
}
document.getElementById("chercher_une_reparation").onkeyup =
  chercher_reparation;
document.getElementById("button_search_date").onclick = function () {
  var date_debut = document.getElementById("date_debut").value;
  var date_fin = document.getElementById("date_fin").value;
  if (date_fin < date_debut) {
    error_date_inf();
  } else if (date_fin == "" || date_debut == "") {
    error_date_fields();
  } else {
    rep = window.reparation.filter(
      (r) => r.date_reparation >= date_debut && r.date_reparation <= date_fin
    );
    var table = document.getElementById("tbody");
    table.innerHTML = "";
    if (rep.length > 0) {
      for (let i = 0; i < rep.length; i++) {
        table.innerHTML += `
                    <tr>
                        <td>${rep[i][1]}</td>
                        <td>${rep[i][2]}</td>
                        <td>${rep[i][3]}</td>
                        <td>${rep[i][4]}</td>
                        <td>${rep[i][5]}</td>
                        <td><button  type='button' idr='${rep[i][0]}' class='update'>Modifier</button><button type='button' idr='${rep[i][0]}' class='delete'>Supprimer</button></td>
                    </tr>
                    `;
      }
      let btn = document.getElementsByClassName("update");
      for (let i = 0; i < btn.length; i++) {
        btn[i].onclick = showmodal;
      }
      let btn_delete = document.getElementsByClassName("delete");
      for (let i = 0; i < btn_delete.length; i++) {
        btn_delete[i].onclick = sure_delete;
      }
    } else {
      var table = document.getElementById("tbody");
      console.log(table);
      table.innerHTML = "<tr><td colspan='6'> Vide</td></tr>";
    }
  }
};
document.getElementById("all_data").onclick = show;
var modal2 = document.getElementById("myModal2");
var btn2 = document.getElementById("myBtn2");
var span2 = document.getElementsByClassName("close2")[0];
btn2.onclick = function () {
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

document.getElementById("matricule_v_search").onblur = function (e) {
  let result_search = document.getElementById("result_search");
  setTimeout(() => {
    result_search.innerHTML = "";
  }, 300);
};
document.getElementById("matricule_v_search").onkeyup = function (e) {
  let text = e.target.value.toLowerCase().trim();
  let voitures_m = [];
  if (text.length > 0) {
    voitures_m = window.voitures.filter((m) =>
      m.matricul.toLowerCase().trim().startsWith(text)
    );
  }
  console.log(voitures_m);
  let result_search = document.getElementById("result_search");
  result_search.innerHTML = "";
  for (let i = 0; i < voitures_m.length; i++) {
    var mydiv = document.createElement("div");
    mydiv.innerText = voitures_m[i].matricul;
    mydiv.onclick = get_mark;
    result_search.appendChild(mydiv);
  }
};
function get_mark(e) {
  console.log("vvvvvv");
  let voiture = window.voitures.find(
    (m) =>
      m.matricul.toLowerCase().trim() == e.target.innerText.toLowerCase().trim()
  );
  if (voiture) {
    document.getElementById("matricule_v_search").value = voiture.matricul;
    document.getElementById("mark_v").value = voiture.mark_voi;
    document.getElementById("matricule_v_search").blur();
  }
}
var result_mm = document.querySelectorAll(".result_m");
for (let i = 0; i < result_mm.length; i++) {
  result_mm[i].onclick = function (e) {};
}
function ajouter_reparation() {
  var matricule = document.Ajout_form.add_matricule.value;
  var mark = document.Ajout_form.add_mark.value;
  var type_reparation = document.Ajout_form.add_type_reparation.value;
  var cout_rep = document.Ajout_form.add_cout.value;
  var date_rep = document.Ajout_form.add_date.value;
  var ajout_reparation = new XMLHttpRequest();
  ajout_reparation.open("POST", "action.php", false);
  ajout_reparation.setRequestHeader(
    "Content-type",
    "application/x-wwW-form-urlencoded"
  );
  ajout_reparation.send(
    "matricul_rep=" +
      matricule +
      "&&mark_rep=" +
      mark +
      "&&type_reparation=" +
      type_reparation +
      "&&cout_rep=" +
      cout_rep +
      "&&date_rep=" +
      date_rep
  );
  if (ajout_reparation.responseText == 1) {
    success_add();
    show();
    modal2.style.display = "none";
    document.getElementById("myform").reset();
  } else {
    error_add();
    modal2.style.display = "none";
  }
}

document.getElementById("ajouter_rep").onclick = ajouter_reparation;

// ___________________ update ____________________________

var modal = document.getElementById("myModal");

// var btn = document.getElementsByClassName("update");

var span = document.getElementsByClassName("close")[0];

span.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

document.getElementById("matricule_v_search_update").onblur = function (e) {
  let update_result_search = document.getElementById("update_result_search");
  setTimeout(() => {
    update_result_search.innerHTML = "";
  }, 300);
};

document.getElementById("matricule_v_search_update").onkeyup = function (e) {
  console.log(e.target.value);
  let text = e.target.value.toLowerCase().trim();
  let voitures_m = [];
  if (text.length > 0) {
    voitures_m = window.voitures.filter((m) =>
      m.matricul.toLowerCase().trim().startsWith(text)
    );
  }
  console.log(voitures_m);
  let update_result_search = document.getElementById("update_result_search");
  update_result_search.innerHTML = "";
  for (let i = 0; i < voitures_m.length; i++) {
    var mydiv = document.createElement("div");
    mydiv.innerText = voitures_m[i].matricul;
    mydiv.onclick = get_markk;
    update_result_search.appendChild(mydiv);
  }
};
function get_markk(e) {
  let voiture = window.voitures.find(
    (m) =>
      m.matricul.toLowerCase().trim() == e.target.innerText.toLowerCase().trim()
  );
  if (voiture) {
    document.getElementById("matricule_v_search_update").value =
      voiture.matricul;
    document.getElementById("mark_v_uapdate").value = voiture.mark_voi;
    document.getElementById("matricule_v_search_update").blur();
  }
}
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

function update_rep() {
  var id_rep = document.update_form.id_rep.value;
  var update_matricule = document.update_form.update_matricule.value;
  var update_mark = document.update_form.update_mark.value;
  var update_type_reparation =
    document.update_form.update_type_reparation.value;
  var update_cout = document.update_form.update_cout.value;
  var update_date = document.update_form.update_date.value;
  var myrequest = new XMLHttpRequest();
  myrequest.open("POST", "action.php", false);
  myrequest.setRequestHeader(
    "Content-type",
    "application/x-wwW-form-urlencoded"
  );
  myrequest.send(
    "update_matricule=" +
      update_matricule +
      "&&update_mark=" +
      update_mark +
      "&&update_type_reparation=" +
      update_type_reparation +
      "&&update_cout=" +
      update_cout +
      "&&update_date=" +
      update_date +
      "&&id_rep=" +
      id_rep
  );
  console.log(myrequest.responseText);
  if (myrequest.responseText == "updated") {
    success_update();
    show();
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  } else if (myrequest.responseText == "not_updated") {
    error_update();
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  }
}

document.getElementById("update_rep").onclick = update_rep;

// ___________________delete________________________
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

$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "post",
    data: { showData: "show" },
    dataType: "json",
    success: function (data) {
      showInfos(data.message);
      searchTableNEW();
    },
    error: function (err) {
      console.log(err);
    },
  });
  $(document).on("click", "#conf", function (e) {
    console.log(e.target.value);
    $.ajax({
      url: "./action.php",
      type: "post",
      data: { confirm: e.target.value },
      dataType: "json",
      success: function (data) {
        console.log("mcha khona !");
        alert("Confirmer avec succés");
        window.location.reload();
        // showInfos(data.message);
      },
      error: function (err) {
        console.log(err);
      },
    });
  });
});
// function set_duree() {
//   var db = $("#fin").val();
//   var fn = $("#debut").val();
//   var timeDiff = Math.abs(fn.getTime() - db.getTime());
//   var differenceDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
//   $("#duree").val(differenceDays);
// }
function success_update() {
  var modal = document.getElementById("myModal");
  modal.style.display = "none";
  Swal.fire({
    icon: "success",
    title: "Modifier avec succée",
    showConfirmButton: false,
    timer: 1500,
  });
}
function success_delete() {
  Swal.fire({
    icon: "success",
    title: "Supprimer avec succée",
    showConfirmButton: false,
    timer: 1500,
  });
}
function no_data() {
  Swal.fire({
    icon: "error",
    title: "Error...",
    text: "Aucune reservation !",
  });
}
function error_delete() {
  Swal.fire({
    icon: "error",
    title: "Error...",
    text: "Quellque chose ne va pas !",
  });
}
function deleteInfos(id_res) {
  $.ajax({
    url: "./action.php",
    type: "post",
    data: { id_res: id_res },
    dataType: "text",
    success: function (data) {
      console.log(data);
      document.getElementById(`${id_res}`).style.display = "none";
      success_delete();
    },
    error: function (err) {
      console.log(err);
      error_delete();
    },
  });
}

function updateInfos(
  id_res,
  idClient_res,
  debut_res,
  fin_res,
  matricule_res,
  nom_res,
  prenom_res,
  duree_res,
  price_res,
  modePay_res,
  Dconduct_res,
  prixUni_res
) {
  // Get the modal
  var modal = document.getElementById("myModal");
  // Get the button that opens the modal
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  // When the user clicks on the button, open the modal
  modal.style.display = "block";
  // When the user clicks on <span> (x), close the modal
  span.onclick = function () {
    modal.style.display = "none";
  };
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
  document.getElementById("id_res").value = id_res;
  document.getElementById("idClient").value = idClient_res;
  document.getElementById("nom").value = nom_res;
  document.getElementById("prenom").value = prenom_res;
  document.getElementById("matricule").value = matricule_res;
  document.getElementById("debut").value = debut_res;
  document.getElementById("fin").value = fin_res;
  document.getElementById("duree").value = duree_res;
  document.getElementById("prix").value = price_res;
  document.getElementById("modePay").value = modePay_res;
  document.getElementById("Dconduct").value = Dconduct_res;
  document.getElementById("prixUni").value = prixUni_res;
}
function update_success() {
  $.ajax({
    url: "./action.php",
    type: "post",
    data: {
      id_res_up: document.getElementById("id_res").value,
      debut_res: document.getElementById("debut").value,
      fin_res: document.getElementById("fin").value,
      matricule_res: document.getElementById("matricule").value,
      idClient_res: document.getElementById("idClient").value,
      nom_res: document.getElementById("nom").value,
      prenom_res: document.getElementById("prenom").value,
      duree_res: document.getElementById("duree").value,
      price_res: document.getElementById("prix").value,
      modePay_res: document.getElementById("modePay").value,
      Dconduct_res: document.getElementById("Dconduct").value,
      prixUni_res: document.getElementById("prixUni").value,
    },
    dataType: "text",
    success: function (data, status) {
      console.log(data);
      console.log(status);
      success_update();
    },
    error: function (err) {
      console.log(err);
    },
  });
}
function showInfos(infos) {
  console.log(infos);
  if (infos.includes("Aucune reservation !")) {
    no_data();
  } else {
    infos.map((elt) => {
      console.log(elt);
      const btn = document.querySelector("#modifier");
      btn.setAttribute("onclick", `update_success()`);
      document.querySelector("#tbody").innerHTML += `
            <tr id="${elt.id_reserve}">
                <td name="id_res">${elt.id_reserve}</td>
                <td>${elt.nom_client}</td>
                <td>${elt.prenom_client}</td>
                <td>${elt.telephone}</td>
                <td>${elt.matricule_voiture_reserver}</td>
                <td>${elt.debut_res}</td>
                <td>${elt.fin_res}</td>
                <td>${elt.duree}</td>
                <td>${elt.price} DH</td>
                <td>${elt.mode_paiment}</td>
                <td>${elt.Dconducteur}</td>
                <td>${elt.prix_unitaire}</td>
                
                <td> <input type="button" value="Update" class="update btn btn-primary" id="updt"  onclick="updateInfos('${
                  elt.id_reserve
                }','${elt.id_client_res_fk}','${elt.debut_res}','${
        elt.fin_res
      }','${elt.matricule_voiture_reserver}','${elt.nom_client}','${
        elt.prenom_client
      }','${elt.duree}',${elt.price},'${elt.mode_paiment}','${
        elt.Dconducteur
      }','${
        elt.prix_unitaire
      }')"/> <input type="button" value="Delete" class="delete btn btn-danger" name="delete" onclick="deleteInfos(${
        elt.id_reserve
      })"/> <a href="contrat_secretaire.php?id_res=${
        elt.id_reserve
      }" class="contrat_link btn btn-success"  >Contrat</a>
      ${
        elt.confirmer == "1"
          ? `<button disabled class="btn btn-secondary"> Confirmer </button>`
          : `<button value="${elt.id_reserve}" id="conf" class="btn btn-warning" oncklick="loadihadchi()"> Confirmer </button>`
      }
      </td>
            </tr>
          `;
    });
  }
}
var input = document.getElementById("searchInput");
var table = document.getElementById("myTable");

// Add an event listener to the input field
input.addEventListener("keyup", function () {
  searchTableNEW();
});
function searchTableNEW() {
  var query = input.value.toLowerCase();
  var rows = table.getElementsByTagName("tr");

  for (var i = 0; i < rows.length; i++) {
    var cells = rows[i].getElementsByTagName("td");
    var found = false;

    for (var j = 0; j < cells.length; j++) {
      var cellText = cells[j].innerText || cells[j].textContent;

      if (cellText.toLowerCase().indexOf(query) > -1) {
        found = true;
        break;
      }
    }

    if (found) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";

      $(rows[i]).children()[0].innerHTML == "ID"
        ? (rows[i].style.display = "")
        : null;
    }
  }
}
function searchTable() {
  var startDate = document.getElementById("startDate").value;
  var endDate = document.getElementById("endDate").value;
  var query = input.value.toLowerCase();
  var table = document.getElementById("myTable");
  var rows = table.getElementsByTagName("tr");

  for (var i = 0; i < rows.length; i++) {
    var cells = rows[i].getElementsByTagName("td");
    var date = $(cells[5]).html() || $(cells[5]).text();
    // console.log($(cells[1]).html());
    var found = false;

    if (date >= startDate && date <= endDate) {
      for (var j = 0; j < cells.length; j++) {
        var cellText = cells[j].innerText || cells[j].textContent;

        if (cellText.toLowerCase().indexOf(query) > -1) {
          found = true;
          break;
        }
      }
    }

    if (found) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
      rows[i].children[0].innerHTML == "ID"
        ? (rows[i].style.display = "")
        : null;
    }
  }
}
function loadihadchi() {
  window.location.reload();
}

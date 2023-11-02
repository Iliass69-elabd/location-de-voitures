var chs = [];
var matrr = [];
$(document).on("click", "[name='delete']", function (e) {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { delete_ch: e.target.value },
    dataType: "json",
    success: function (data) {
      console.log(data.message);
      success_delete(e.target.value);
      // location.reload();
    },
    error: function (err) {
      console.log(err);
    },
  });
});
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { show_ch: "charges" },
    dataType: "json",
    success: function (data) {
      //   console.log(data.message);
      chs = [...data.message];
      if (chs.length == 0) {
        no_data();
      }
      //   console.log(chs.id_ch);
      show_charges(chs);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
function show_charges(listeCharges) {
  listeCharges.map((elt) => {
    // console.log(elt.id_ch);
    $("#tbody").append(`
        <tr>
            <td>${elt.matricule_ch}</td>
            <td>${elt.dateAchat_ch}</td>
            <td>${elt.avance_ch}</td>
            <td>${elt.reste_ch}</td>
            <td>${elt.montant_global}</td>
            <td>${elt.prix_par_mois}</td>
            <td>${elt.etat}</td>
            <td>${elt.traite}</td>
            <td>${elt.prixAssurance}</td>
            <td>${elt.dateFinEchehance}</td>
            <td>  <button value="${elt.id_ch}" class="update" id="updt">Update</button>  <button name="delete" value="${elt.id_ch}" class="delete" >Delete</button> </td>
        </tr>
    `);
  });
}
function show_add_form() {
  var ajouter = document.getElementById("modifier");
  ajouter.style.display = "block";
  var modifier = document.getElementById("modf");
  modifier.style.display = "none";
  var modal = document.getElementById("myModal");
  var butt = document.getElementById("add_ch");
  var span = document.getElementsByClassName("close")[0];
  modal.style.display = "block";
  span.onclick = function () {
    modal.style.display = "none";
  };
  butt.onclick = function () {
    modal.style.display = "block";
  };
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
}
$(document).on("click", "#modifier", function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: {
      add_chh: "add_ch",
      matricule_ch: $("[name='matricule']").val(),
      dateAchat: $("#dateAchat").val(),
      avance: $("#avance").val(),
      reste: $("#reste").val(),
      prixParMois: $("#prix_par_mois").val(),
      etat: $("#etat").val(),
      traite: $("#traite").val(),
      prixAssurance: $("#prixAssurance").val(),
      dateFinEchehance: $("#dtFinEchehance").val(),
    },
    dataType: "json",
    success: function (data) {
      console.log(data.message);
      success_add();
      location.reload();
    },
    error: function (err) {
      console.log(err);
    },
  });
});
function success_add() {
  var modal = document.getElementById("myModal");
  modal.style.display = "none";
  Swal.fire({
    icon: "success",
    title: "Ajout fait avec succés",
    showConfirmButton: false,
    timer: 1500,
  });
}
function success_delete(id) {
  Swal.fire({
    icon: "success",
    title: "Supprimer avec succés",
    showConfirmButton: false,
    timer: 1500,
  });
  chs = chs.filter((elt) => elt.id_ch != id);
}
function no_data() {
  Swal.fire({
    icon: "error",
    title: "Error...",
    text: "Aucune charge !",
  });
}
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { select_matricule: "matricule" },
    dataType: "json",
    success: function (data) {
      matrr = [...data.message];
      display_matricule();
    },
    error: function (err) {
      console.log(err);
    },
  });
});
function display_matricule() {
  matrr.map((elt) => {
    $("#select_matricule").append(`
      <option value="${elt.matricul}">${elt.matricul}</option>
      `);
  });
}
// ---------------------------------- UPDATE ---------------------------------
function success_update() {
  var modal = document.getElementById("myModal");
  modal.style.display = "none";
  Swal.fire({
    icon: "success",
    title: "Mise à jour faite avec succée",
    showConfirmButton: false,
    timer: 1500,
  });
}
$(document).ready(function () {
  $(document).on("click", "#updt", function (e) {
    var ajouter = document.getElementById("modifier");
    ajouter.style.display = "none";
    var modifier = document.getElementById("modf");
    modifier.style.display = "block";
    chs = chs.filter((elt) => elt.id_ch == e.target.value);
    console.log(chs);
    chs.map((elt) => {
      console.log(elt);
      $("#select_matricule").val(elt.matricule_ch);
      $("#dateAchat").val(elt.dateAchat_ch);
      $("#avance").val(elt.avance_ch);
      $("#reste").val(elt.reste_ch);
      $("#prix_par_mois").val(elt.prix_par_mois);
      $("#etat").val(elt.etat);
      $("#traite").val(elt.traite);
      $("#prixAssurance").val(elt.prixAssurance);
      $("#dtFinEchehance").val(elt.dateFinEchehance);
      var modal = document.getElementById("myModal");
      var butt = document.getElementById("modifier");
      var span = document.getElementsByClassName("close")[0];
      modal.style.display = "block";
      span.onclick = function () {
        $("#formulaireWSF").trigger("reset");
        modal.style.display = "none";
      };
      butt.onclick = function () {
        modal.style.display = "block";
      };
      window.onclick = function (event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };
      $("[name='modd']").click(function () {
        $.ajax({
          url: "./action.php",
          type: "POST",
          data: {
            update: "update",
            id_ch_updt: elt.id_ch,
            matricule_updt: $("#select_matricule").val(),
            datAchat_updt: $("#dateAchat").val(),
            avance_updt: $("#avance").val(),
            reste_udpt: $("#reste").val(),
            prixParMois_updt: $("#prix_par_mois").val(),
            etat_updt: $("#etat").val(),
            traite_updt: $("#traite").val(),
            prixAssurance_updt: $("#prixAssurance").val(),
            dateFinEchehance_updt: $("#dtFinEchehance").val(),
          },
          dataType: "json",
          success: function (data) {
            console.log(data);
            success_update();
            location.reload();
          },
          error: function (err) {
            console.log(err);
          },
        });
      });
    });
  });
  function update_charges() {}
});
// Get the input field and table
var input = document.getElementById("searchInput");
var table = document.getElementById("myTable");

// Add an event listener to the input field
input.addEventListener("keyup", function () {
  searchTableNEW();
});

// Function to perform the search
// function searchTable() {
//   var query = input.value.toLowerCase();
//   var rows = table.getElementsByTagName("tr");

//   // Loop through all table rows
//   for (var i = 0; i < rows.length; i++) {
//     var matricule = rows[i]
//       .getElementsByTagName("td")[0]
//       .innerText.toLowerCase();
//     var dateAchat = rows[i]
//       .getElementsByTagName("td")[1]
//       .textContent.toLowerCase();
//     var avance = rows[i]
//       .getElementsByTagName("td")[2]
//       .textContent.toLowerCase();
//     var reste = rows[i].getElementsByTagName("td")[3].textContent.toLowerCase();
//     var Montantglobal = rows[i]
//       .getElementsByTagName("td")[4]
//       .textContent.toLowerCase();
//     var prixParMois = rows[i]
//       .getElementsByTagName("td")[5]
//       .textContent.toLowerCase();
//     var etat = rows[i].getElementsByTagName("td")[6].textContent.toLowerCase();
//     var traite = rows[i]
//       .getElementsByTagName("td")[7]
//       .textContent.toLowerCase();
//     var prixAssurance = rows[i]
//       .getElementsByTagName("td")[8]
//       .textContent.toLowerCase();
//     var dateFinEchehance = rows[i]
//       .getElementsByTagName("td")[9]
//       .textContent.toLowerCase();

//     // Check if any of the columns match the search query
//     if (
//       matricule.indexOf(query) > -1 ||
//       dateAchat.indexOf(query) > -1 ||
//       avance.indexOf(query) > -1 ||
//       reste.indexOf(query) > -1 ||
//       Montantglobal.indexOf(query) > -1 ||
//       prixParMois.indexOf(query) > -1 ||
//       etat.indexOf(query) > -1 ||
//       traite.indexOf(query) > -1 ||
//       prixAssurance.indexOf(query) > -1 ||
//       dateFinEchehance.indexOf(query) > -1
//     ) {
//       rows[i].style.display = "";
//     } else {
//       rows[i].style.display = "none";
//     }
//   }
// }
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
      $(rows[i]).children()[0].innerHTML == "Matricule"
        ? (rows[i].style.display = "")
        : null;
    }
  }
}

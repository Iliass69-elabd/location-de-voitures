var speed = 50;
function incNbrRec(i, endNbr, elt) {
  if (i <= endNbr) {
    elt.innerHTML = i;
    setTimeout(function () {
      //Delay a bit before calling the function again.
      incNbrRec(i + 1, endNbr, elt);
    }, speed);
  }
}
function show_client_infos() {
  var myrequest = new XMLHttpRequest();
  myrequest.open("POST", "action.php", false);
  myrequest.setRequestHeader(
    "Content-type",
    "application/x-wwW-form-urlencoded"
  );
  var myid = document.getElementById("idclient").value;
  myrequest.send("id_client_profile=" + myid);

  // console.log(myresult);

  if (myrequest.responseText) {
    var myresult = JSON.parse(myrequest.responseText);
    console.log(myresult);
    if (Object.keys(myresult).length > 0) {
      window.client = myresult.client;
      window.reservations = myresult.reservations;
      console.log(reservations);
      window.voitures = myresult.voitures;
      window.agence = myresult.agence;

      window.facture = myresult.facture;
      console.log(facture);
      window.nbr_reviews = myresult.nbr_reviews;
      window.nbr_infractions = myresult.nbr_infractions;
      document.getElementById("name").value = window.client[0][2];
      document.getElementById("lastname").value = window.client[0][1];
      document.getElementById("client_name").innerText =
        window.client[0][2] + " " + window.client[0][1];
      document.getElementById("ville").value = window.client[0][7];
      document.getElementById("email").value = window.client[0][4];
      document.getElementById("password").value = window.client[0][5];
      document.getElementById("ad1").innerText = window.agence[0][3];
      document.getElementById("ad2").innerText = window.agence[0][2];
      document.getElementById("ad3").innerText = "0" + window.agence[0][4];
      document.getElementById("ad4").innerText = window.agence[0][5];
      document.getElementById("ad5").innerText = window.agence[0][9];
      document.getElementById("ad6").innerText = window.agence[0][8];
      document.getElementById("ad7").innerText = window.agence[0][7];
      var table = document.getElementById("tbody");
      table.innerHTML = "";
      var counter = 0;
      for (let i = 0; i < window.reservations.length; i++) {
        table.innerHTML += `
                <tr>
                    <td>${window.reservations[i].debut_res}</td>
                    <td>${window.reservations[i].fin_res}</td>
                    
                    <td>${window.reservations[i].duree}</td>
                    <td>${window.reservations[i].price}</td>
                   
                    <td><button type='button' matv='${window.reservations[i].matricule_voiture_reserver}' idreservation='${window.reservations[i].id_reserve}'  class='Details'>Détails</button> <button idreservation_facture='${window.reservations[i].id_reserve}'  class="facture_btn">Facture</button></td>
                </tr>
                `;
        counter = counter + 1;
      }
      console.log(counter);
      var nb_res = document.getElementById("nb_res");
      var nb_comments = document.getElementById("nb_comments");
      var nb_infractions = document.getElementById("nb_infractions");
      var endNbr_res = Number(window.reservations.length);
      var endNbr_com = Number(window.nbr_reviews.length);
      var endNbr_inf = Number(window.nbr_infractions.length);
      var i = 0;
      incNbrRec(i, endNbr_res, nb_res);
      incNbrRec(i, endNbr_com, nb_comments);
      incNbrRec(i, endNbr_inf, nb_infractions);

      var btn2 = document.querySelectorAll(".Details");

      var btn3 = document.querySelectorAll(".facture_btn");
      for (let i = 0; i < btn2.length; i++) {
        btn2[i].onclick = showdetails;
      }
      for (let i = 0; i < btn3.length; i++) {
        btn3[i].onclick = showfacture;
      }
    }
    if (window.reservations.length <= 0) {
      var table = document.getElementById("tbody");
      console.log(table);
      table.innerHTML = "<tr><td colspan='6'> Vide</td></tr>";
    }
  }
}

window.onload = show_client_infos();

var modal = document.getElementById("myModal");

var btn = document.getElementById("myBtn");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function () {
  modal.style.display = "block";
};

span.onclick = function () {
  modal.style.display = "none";
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
    text: "Email déje exist",
  });
}
function update_infos() {
  let id_c = document.form_client_infos.id.value;
  let prenom = document.form_client_infos.name.value;
  let nom = document.form_client_infos.lastname.value;
  let ville = document.form_client_infos.ville.value;
  let email = document.form_client_infos.email.value;
  let password = document.form_client_infos.password.value;
  var request = new XMLHttpRequest();
  request.open("POST", "action.php", false);
  request.setRequestHeader("Content-type", "application/x-wwW-form-urlencoded");
  // alert(id_c + prenom + nom + ville + email + password);
  request.send(
    "id_client_update=" +
      id_c +
      "&&prenom_client_update=" +
      prenom +
      "&&nom_client_update=" +
      nom +
      "&&ville_client_update=" +
      ville +
      "&&email_client_update=" +
      email +
      "&&password_client_update=" +
      password
  );
  // alert(request.responseText);
  if (request.responseText == "updated") {
    success_update();
    modal.style.display = "none";
    show_client_infos();
  } else {
    error_update();
    modal.style.display = "none";
  }
}

document.getElementById("update_btn_client").onclick = update_infos;

// __________ start details model _________________

var modal2 = document.getElementById("myModal2");

var btn2 = document.querySelectorAll(".Details");

var span2 = document.getElementsByClassName("close2")[0];

function showdetails(e) {
  document.getElementById("details_form").reset();
  let idrres = e.target.getAttribute("idreservation");
  let matv = e.target.getAttribute("matv");
  var reservation = window.reservations
    ? window.reservations.find((r) => r[0] == idrres)
    : null;
  var voiture = window.voitures
    ? window.voitures.find((v) => v[0] == matv)
    : null;
  if (reservation) {
    document.getElementById("date_debut").value = reservation[1];
    document.getElementById("date_fin").value = reservation[2];
    document.getElementById("matricule").value = reservation[3];
    document.getElementById("marque").value = voiture[2];
    document.getElementById("duree").value = reservation[7];
    document.getElementById("prix").value = reservation[8];
    document.getElementById("Prix_unitaire").value = reservation[11];
    document.getElementById("2conducteur").value = reservation[10];
  }
  modal2.style.display = "block";
}
function showfacture(e) {
  document.getElementById("details_form").reset();
  let idrres = e.target.getAttribute("idreservation_facture");

  // let matv = e.target.getAttribute("matv");
  var facture = window.facture
    ? window.facture.find((f) => f[10] == idrres)
    : null;
  // var voiture = window.voitures
  //   ? window.voitures.find((v) => v[0] == matv)
  //   : null;
  console.log(facture);
  if (facture) {
    document.getElementById("fac1").innerText = facture[0];
    document.getElementById("fac2").innerText = facture[1];
    document.getElementById("int").innerText = facture[3];
    document.getElementById("ht1").innerText = facture[14];
    document.getElementById("ht2").innerText = facture[4];
    document.getElementById("ht3").innerText = facture[22];
    document.getElementById("ht4").innerText = facture[7];
    document.getElementById("HT").innerText = facture[7];
    document.getElementById("TVA").innerText = facture[8];
    document.getElementById("totalTTC").innerText = facture[9];
    document.getElementById("ht5").innerText = facture[5];
  }
  // var facture = document.querySelector(".facture_container");
  // html2pdf().from(facture).save("facture.pdf");
  window.print()
  // modal2.style.display = "block";
}
for (let i = 0; i < btn2.length; i++) {
  btn2[i].onclick = showdetails;
}
span2.onclick = function () {
  modal2.style.display = "none";
};

// __________ start details model _________________

window.onclick = function (e) {
  if (e.target.id == "close-eye") {
    document.getElementById("eye").innerHTML =
      '<i id="open-eye" class="fa-regular fa-eye"></i';
    document.getElementById("password").setAttribute("type", "password");
  } else if (e.target.id == "open-eye") {
    document.getElementById("eye").innerHTML =
      '<i id="close-eye" class="fa-regular fa-eye-slash"></i>';
    document.getElementById("password").setAttribute("type", "text");
  }
  if (e.target == modal) {
    modal.style.display = "none";
  }
  if (e.target == modal2) {
    modal2.style.display = "none";
  }
};

var infos = [];
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { showStatisticProfile: $("#idclient").val() },
    dataType: "json",
    success: function (data, status) {
      console.log(status);
      //   console.log(data.message);
      infos = [...data.message];
      Thechartbar();
    },
  });
});

function Thechartbar() {
  const labels = [];
  const amount = [];
  infos.filter((elt) => {
    labels.push(elt.Month);
    amount.push(elt.Number);
  });
  const ctx = document.getElementById("myChartbar");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Réservations",
          data: amount,
          backgroundColor: [
            "rgba(255, 99, 132)",
            "rgba(255, 159, 64)",
            "rgba(255, 205, 86)",
            "rgba(75, 192, 192)",
            "rgba(54, 162, 235)",
            "rgba(153, 102, 255)",
            "rgba(201, 203, 207)",
          ],
          borderColor: [
            "rgb(255, 99, 132,1)",
            "rgb(255, 159, 64,1)",
            "rgb(255, 205, 86,1)",
            "rgb(75, 192, 192,1)",
            "rgb(54, 162, 235,1)",
            "rgb(153, 102, 255,1)",
            "rgb(201, 203, 207,1)",
          ],
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      plugins: {
        datalabels: {
          color: "black",
        },
      },
      textColor: "white",
    },
  });
}

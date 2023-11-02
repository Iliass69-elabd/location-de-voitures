// reservation w historique
/* --------------------------------------- RESERVATION --------------------------------------- */
var infos = [];
var notf = [];
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { showStatistic: "statistic" },
    dataType: "json",
    success: function (data, status) {
      triggerNotif();
      // console.log(status);
      infos = [...data.message];
      Thechartbar();
      Thechartline();
      Thechartpie1();
      Thechartpie2();
      Thechartpie3();
    },
  });
});

function Thechartbar() {
  const labels = [];
  const amount = [];
  infos.filter((elt) => {
    labels.push(elt.month);
    amount.push(elt.amount);
  });
  const ctx = document.getElementById("myChartbar");

  new Chart(ctx, {
    type: "bar",
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
function Thechartline() {
  // alert("function mzyana katji");
  const labels = [];
  const amount = [];
  infos.filter((elt) => {
    labels.push(elt.month);
    amount.push(elt.amount);
  });
  const ctx = document.getElementById("myChartline");

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
function Thechartpie1() {
  // alert("function mzyana katji");
  const labels = [];
  const amount = [];
  infos.filter((elt) => {
    labels.push(elt.month);
    amount.push(elt.amount);
  });
  const ctx = document.getElementById("myChartpie1");

  new Chart(ctx, {
    type: "doughnut",
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
function Thechartpie2() {
  // alert("function mzyana katji");
  const labels = [];
  const amount = [];
  infos.filter((elt) => {
    labels.push(elt.month);
    amount.push(elt.amount);
  });
  const ctx = document.getElementById("myChartpie2");

  new Chart(ctx, {
    type: "doughnut",
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
function Thechartpie3() {
  // alert("function mzyana katji");
  const labels = [];
  const amount = [];
  infos.filter((elt) => {
    labels.push(elt.month);
    amount.push(elt.amount);
  });
  const ctx = document.getElementById("myChartpie3");

  new Chart(ctx, {
    type: "doughnut",
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
/* ----------------------------------------- STATISTICS ----------------------------------------- */
// Gain
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalGain: "totalGain" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getGain(data.message[0].Total);
    },
    error: function (err) {
      console.log(err);
    },
  });
});

// Reservation
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalRes: "totalRes" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getTotalRes(data.messagee[0].TotalReserver);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Client
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalClient: "totalClient" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getTotalClient(data.messageee[0].Clients);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Client reserved
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalClientRes: "totalClientRes" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getTotalClientRes(data.messageeee[0].ClientReserver);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Client non reserved
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalClientNonRes: "totalClientNonRes" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getTotalClientNonRes(data.messages[0].ClientNonReserver);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Voiture
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalVoiture: "totalVoiture" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getTotalVoiture(data.messagess[0].Voitures);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Voiture reserver
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalVoitureRes: "totalVoitureRes" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getTotalVoitureRes(data.messagesss[0].VoitureReserver);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Voiture non reserver
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { totalVoitureNonRes: "totalVoitureNonRes" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getTotalVoitureNonRes(data.messag[0].VoitureNonReserver);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Employer
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { Employer: "Employer" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getemploye(data.messagt[0].TotalEmployer);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
// Price Réparation
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { priceRep: "priceRep" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message);
      getReparation(data.messagtt[0].TotalReparation);
    },
    error: function (err) {
      console.log(err);
    },
  });
});

function getGain(result) {
  $("#totg").html(result);
}
function getTotalRes(result) {
  $("#numres").html(result);
}
function getTotalClient(result) {
  $("#numcl").html(result);
}
function getTotalClientRes(result) {
  $("#numclres").html(result);
}
function getTotalClientNonRes(result) {
  $("#numclnres").html(result);
}
function getTotalVoiture(result) {
  $("#numv").html(result);
}
function getTotalVoitureRes(result) {
  $("#numvres").html(result);
}
function getTotalVoitureNonRes(result) {
  $("#numvnres").html(result);
}
function getemploye(result) {
  $("#emp").html(result);
}
function getReparation(result) {
  $("#dep").html(result);
}

/* -------------------------------- NOTIFICATIONS -------------------------------- */

$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { numNotif: "notifs" },
    dataType: "json",
    success: function (data) {
      var numNot = data.message[0].Numero;
      // console.log(numNot);
      indicator(numNot);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
function indicator(ind) {
  $("#badge").html(ind);
  var modal = document.getElementById("myMDL");
  var btn = document.getElementById("myBTN");
  var span = document.getElementsByClassName("close-notif")[0];
  btn.onclick = function () {
    modal.style.display = "block";
  };
  span.onclick = function () {
    modal.style.display = "none";
  };
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
}
$(document).ready(function () {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { msgNotif: "notifmsgs" },
    dataType: "json",
    success: function (data) {
      notf = [...data.message];
      // console.log(notf);
      messageNotif();
    },
    error: function (err) {
      console.log(err);
    },
  });
});
function seende() {
  var indd = parseInt(document.getElementById("badge").innerHTML) - 1;
  $("#badge").html(indd);
  // document.getElementById("notfff").remove();
}
function deleteRow(button) {
  var row = button.parentNode.parentNode;
  var table = row.parentNode;
  table.removeChild(row);
}
function messageNotif() {
  notf.map((elt) => {
    $(".notcnt").append(`
    ${
      elt.cfr != 0
        ? ` 
      <tr class="notfff">
        <td name = "idNotf" id="idd" value="${elt.ID}">${elt.ID}</td>
        <td>${elt.MSG.replace(/\d+/g,'')}</td>
        <td> 
          <a href="../view/manage_reservation.php?client=${elt.client}" > <button class="notif-check"  id="lastConfirm" value="${elt.cfr}" name ="confirme" onclick="deleteRow(this)">
            Confirmer
            </button>
          </a>
        </td>
      </tr> 
          `
      : `<tr class="notfff">
            <td name = "idNotf" id="idd" value="${elt.ID}">${elt.ID}</td>
            <td>${elt.MSG}</td>
            <td> 
                <a href="../view/car_management.php?matricul=${elt.matricul}" ><button class="notif-check"  id="seen" value="${elt.ID}" name ="seen" onclick="deleteRow(this)">
                  Voir
                </button></a>
            </td>
        </tr> `
        }
       `);
  });
  console.log(notf);
}
// $(document).on("click", "#confirmAD", function (e) {
//   // console.log(e.target.value);
//   $.ajax({
//     type: "POST",
//     url: "./action.php",
//     data: { confirmAD: e.target.value },
//     dataType: "json",
//     success: function (data) {
//       console.log(data.message);
//       // console.log(e.target.value);
//       seende();
//     },
//     error: function (err) {
//       console.log(err);
//     },
//   });
// });
// $(document).on("click", ".seen", function (e) {
//   let target = $(e.target).hasClass("seen")
//     ? e.target
//     : $(e.target).parents(".seen")[0];
//   console.log(e.target.value);
//   $.ajax({
//     url: "./action.php",
//     type: "POST",
//     data: { seen: target.value },
//     dataType: "json",
//     success: function () {
//       console.log("khdm");
//       seende();
//       $(target).parents(".notfff")[0].remove();
//     },
//     error: function (err) {
//       console.log(err);
//     },
//   });
// });
function triggerNotif() {
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { notiff: "notiff" },
    dataType: "json",
    success: function () {
      console.log("khdm");
    },
    error: function (err) {
      // console.log(err);
    },
  });
}

// function alerted() {
//   $.ajax({
//     url: "./action.php",
//     type: "POST",
//     data: {},
//     dataType: "json",
//     success: function (data) {},
//     error: function (err) {},
//   });
// }

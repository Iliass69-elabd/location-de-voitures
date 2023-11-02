var notf = [];
// $(document).on("click", "[name='confirme']", function (e) {
//   $.ajax({
//     type: "POST",
//     url: "./action.php",
//     data: { confirm: e.target.value },        HADI ILA ZMLAT DIR LIHA DELETEROW() WHENNI SOU9
//     dataType: "json",
//     success: function (data) {
//       console.log(data.message);
//       console.log(e.target.value);
//       seende();
//       // window.location.href = "../view/manage_reservation_secretaire.php";
//     },
//     error: function (err) {
//       console.log(err);
//     },
//   });
// });
$(document).on("click", "#lastConfirm", function (e) {
  console.log(e.target.value);
  $.ajax({
    url: "./action.php",
    type: "post",
    data: { seen: e.target.value },
    dataType: "json",
    success: function (data) {
      console.log("mcha khona !");
      // showInfos(data.message);
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
    data: { msgNotif: "notifmsgs" },
    dataType: "json",
    success: function (data) {
      notf = [...data.message];
      console.log(notf);
      message_reservation();
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
    data: { numNotif: "notifs" },
    dataType: "json",
    success: function (data) {
      var numNot = data.message[0].Numero;
      console.log(numNot);
      indicator(numNot);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
$(document).on("click", "[name='seen']", function (e) {
  // console.log($("#seen").val());
  $.ajax({
    url: "./action.php",
    type: "POST",
    data: { seen: e.target.value },
    dataType: "json",
    success: function () {
      console.log("khdm");
      console.log($("[name='seen']").val());
      seende();
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
    data: { numnum: "numnum" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message[0].num);
      // indicator(data.message[0].num);
    },
    error: function (err) {
      console.log(err);
    },
  });
});
function message_reservation() {
  notf.map((elt) => {
    $("#notiftb").append(`
    ${
      elt.cfr != 0
        ? ` 
    <tr class="notif">
        <td id="indicator" style="display:none;">${elt.ID}</td>
        <td id="message">${elt.MSG.replace(/\d+/g,'')} </td>
        <td>
            <a href="../view/manage_reservation_secretaire.php?client=${elt.client}">
                <button class="notif-check stt"  id="lastConfirm" value="${elt.cfr}" name ="confirme"  onclick="deleteRow(this)">
                  Confirme
                </button>
            </a> 
          </td>
      </tr>
                `
      : `
      <tr class="notif">
        <td id="indicator" style="display:none;">${elt.ID}</td>
        <td id="message">${elt.MSG} </td>
        <td>
              <a href="../view/car_management_reservation.php?matricul=${elt.matricul}"><button class="notif-check"  id="seen" value="${elt.ID}" name ="seen" onclick="deleteRow(this)">
                Go To
              </button>
              </a>
        </td>
      </tr>`
            }
        
    `);
  });
}

function numRes() {}
// function message_reservation() {
//   notf.map((elt) => {
//     $("#notiftb").append(`
//     ${
//       elt.cfr != 0
//         ? `
//     <tr class="notif">
//         <td id="indicator">${elt.ID}</td>
//         <td id="message">${elt.MSG} </td>
//         <td>
//         ${
//           elt.cfr != 0
//             ? `<button class="notif-check"  id="confirm" value="${elt.cfr}" name ="confirme" onclick="deleteRow(this)">
//             Confirme
//             </button>`
//             : `<button class="notif-check"  id="seen" value="${elt.ID}" name ="seen" onclick="deleteRow(this)">
//           mark as read
//           </button>`
//         }
//         </td>
//     </tr>`
//         : ""
//     }
//     `);
//   });
// }
function deleteRow(button) {
  var row = button.parentNode.parentNode;
  var table = row.parentNode;
  table.removeChild(row);
}
function seende() {
  var indd = parseInt(document.getElementById("indicc").innerHTML) - 1;
  $("#indicc").html(indd);
  // document.getElementById("notfff").remove();
}
// Get the modal
function indicator(ind) {
  $("#indicc").html(ind);
  var modal = document.getElementById("myModal");
  var btn = document.getElementById("myBtn");
  var span = document.getElementsByClassName("close")[0];
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

var cars = [];
$(document).ready(function () {
  $("#md").hide();
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
    var myvalue = "show_table_car";
    var request = new XMLHttpRequest();
    request.open("POST", "action.php", false);
    request.setRequestHeader(
      "Content-type",
      "application/x-wwW-form-urlencoded"
    );
    request.send("show_car=" + myvalue);
    // document.getElementById("tbody").innerHTML = request.responseText;
  }

  // function chercher_voiture(e) {
  //   var voiture = e.target.value;
  //   var request = new XMLHttpRequest();
  //   request.open("POST", "action.php", false);
  //   request.setRequestHeader(
  //     "Content-type",
  //     "application/x-wwW-form-urlencoded"
  //   );
  //   request.send("chercher_une_voiture=" + voiture);
  //   document.getElementById("tbody").innerHTML = request.responseText;
  // }
  // document.getElementById("chercher_une_voiture").onkeyup = chercher_voiture;

  // -------------------------------------------------- SEARCH ----------------------------------------------
  var input = document.getElementById("chercher_une_voiture");
  var table = document.getElementById("myTable");

  // Add an event listener to the input field
  input.addEventListener("input", function () {
    searchTableNEW();
  });

  function searchTableNEW() {
    var query = input.value.toLowerCase();
    console.log(query);
    var rows = table.getElementsByTagName("tr");

    for (var i = 0; i < rows.length; i++) {
      var cells = rows[i].getElementsByTagName("td");
      var found = false;
      // console.log(rows[i]);
      for (var j = 0; j < cells.length; j++) {
        var cellText = cells[j].innerText || cells[j].textContent;
        console.log(cellText);
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
  // $(input).trigger("input");
  
  // function show_and_alerts() {
  //     show();
  //     if (document.getElementById("message").innerHTML == 1) {
  //         success_update();
  //     } else if (document.getElementById("message").innerHTML == 2) {
  //         error_update();
  //     }
  // }
  // document.getElementsByTagName("body").onload = show_and_alerts();
  // _____________________update  ____________________________________

  var modal = document.getElementById("myModal");

  var span = document.getElementsByClassName("close")[0];
  function showmodal(id) {
    document.getElementById("myModal").style.display = "block";
    var staff_info = new XMLHttpRequest();
    staff_info.open("POST", "action.php", false);
    staff_info.setRequestHeader(
      "Content-type",
      "application/x-wwW-form-urlencoded"
    );
    staff_info.send("matricule=" + id);
    document.getElementById("myform").innerHTML = staff_info.responseText;
  }

  span.onclick = function () {
    document.getElementById("myModal").style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      document.getElementById("myModal").style.display = "none";
    }
  };

  // _____________________update  ____________________________________

  // _________________________Add________________________________

  // var modal2 = document.getElementById("myModal2");
  // var btn = document.getElementById("myBtn");
  // var span2 = document.getElementsByClassName("close2")[0];
  // // document.getElementById("myBtn").onclick = function () {
  // //   console.log("wa hassan");
  // // modal2.style.display = "block";
  // // };
  // $(document).on("click", "#myBtn", function () {
  //   console.log("works properly");
  //   modal2.style.display = "block";
  // });

  // $(document).on("click", "#myBtn", () => {
  //   $("close2").show();
  // });
  // span2.onclick = function () {
  //   modal2.style.display = "none";
  // };
  // window.onclick = function (event) {
  //   if (event.target == modal2) {
  //     modal2.style.display = "none";
  //   }
  // };

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
      text: "Quelque chose est mal passé",
    });
  }

  function show_and_alerts() {
    show();
    if (document.getElementById("message").innerHTML == 1) {
      success_update();
    } else if (document.getElementById("message").innerHTML == 2) {
      error_update();
    } else if (document.getElementById("message").innerHTML == 3) {
      success_add();
    } else if (document.getElementById("message").innerHTML == 4) {
      error_add();
    }
  }
  document.getElementsByTagName("body").onload = show_and_alerts();
  // _________________________Add________________________________

  // ____________ delete________________

  function success_delete() {
    Swal.fire({
      icon: "success",
      title: "Supprimer avec succées",
      showConfirmButton: false,
      timer: 1500,
    });
  }
  function error_delete() {
    Swal.fire({
      icon: "error",
      title: "Error...",
      text: "La voiture peut être occupé On ne peut pas la supprimer !",
    });
  }

  var modal3 = document.getElementById("myModal3");

  var span3 = document.getElementsByClassName("close3")[0];
  function showmodal_delet(id) {
    modal3.style.display = "block";
    var car_info = new XMLHttpRequest();
    car_info.open("POST", "action.php", false);
    car_info.setRequestHeader(
      "Content-type",
      "application/x-wwW-form-urlencoded"
    );
    car_info.send("matricule_supprimer=" + id);
    document.getElementById("myp_del").innerHTML = car_info.responseText;
  }
  span3.onclick = function () {
    modal3.style.display = "none";
  };
  window.onclick = function (event) {
    if (event.target == modal3) {
      modal3.style.display = "none";
    }
  };

  function supprimer_voiture(id) {
    var matricule_to_delete = id;
    var request_to_delete = new XMLHttpRequest();
    request_to_delete.open("POST", "action.php", false);
    request_to_delete.setRequestHeader(
      "Content-type",
      "application/x-wwW-form-urlencoded"
    );
    request_to_delete.send("matricule_to_delete=" + matricule_to_delete);
    // alert(request_to_delete.responseText)
    if (request_to_delete.responseText == "deleted") {
      success_delete();
      modal3.style.display = "none";
      show();
    } else {
      error_delete();
    }
  }

  // _______________accessoire_______________________

  var modal_accessoire = document.getElementById("myModal_accessoire");

  var btn_accessoire = document.getElementById("myBtn_accessoire");

  var span_accessoire = document.getElementsByClassName("close_accessoire")[0];

  btn_accessoire.onclick = function () {
    modal_accessoire.style.display = "block";
  };

  span_accessoire.onclick = function () {
    modal_accessoire.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal_accessoire) {
      var modal_accessoire = document.getElementById("myModal_accessoire");
      modal_accessoire.style.display = "none";
    }
  };

  // _______________________________________

  var btn_update = document.querySelector("#myBtn_update");

  var span_update = document.getElementsByClassName("close_update")[0];

  // console.log(btn_update);
  // btn_update.onclick = function () {
  //     modal_update.style.display = "block";
  // };
  document.onclick = (e) => {
    //   console.log(e.target.getAttribute("class"));
    if (e.target.id == "myBtn_update") {
      var modal_update = document.getElementById("myModal_update");
      modal_update.style.display = "block";
    } else if (e.target.getAttribute("class") == "close_update") {
      var modal_update = document.getElementById("myModal_update");
      modal_update.style.display = "none";
    }
  };

  // span_update.onclick = function () {
  //     modal_update.style.display = "none";
  // };
  var modal_update = document.getElementById("myModal_update");
  window.onclick = function (event) {
    if (event.target == modal_update) {
      modal_update.style.display = "none";
    }
  };
  // `

  $.ajax({
    url: "./action.php",
    type: "post",
    data: { show_car: "chill" },
    dataType: "json",
    success: function (data) {
      // console.log(data.message[0].matricul);
      // document.getElementById("tbody").innerHTML;
      cars = [...data.message];
      // console.log(cars[0].matricul);
      cars.map((item) => {
        $("#tbody").append(`<tr>
        <td id="${item.matricul}">${item.matricul}</td>
        <td>${item.mark_voi}</td>
        <td>${item.capacity_voi}</td>

        <td>${item.price}</td>

        <td><img src='${item.picture_car}' alt='your browser is not suported'/></td>

        <td>
          <button  value='${item.matricul}' id="cars_u" class='update cars_u btn btn-primary'>Détails</button>
          <button value='${item.matricul}' id="cars_d" class='delete cars_d btn btn-danger'>Supprimer</button>
          <button value='${item.matricul}' class='papier btn btn-success' >Info Papier</button>
          <button value='${item.matricul}' class='adpapier btn btn-secondary' >Ajouter Papier</button>
        </td>
      </tr>`);
      
      });
      searchTableNEW();
      // alert("Please");
      // document.getElementById("tbody").innerHTML = trs;
    },
    error: function () {},
  });

  $(document).on("click", ".update", (e) => {
    let matt = e.target.value;
    showmodal(matt);
  });

  $(document).on("click", ".delete", (e) => {
    let matt = e.target.value;
    showmodal_delet(matt);
  });

  $(document).on("click", ".delete_car", (e) => {
    let matt = e.target.value;
    supprimer_voiture(matt);
  });
  var btttn = document.querySelectorAll(".papier");

  btn.onclick = function () {};

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
  // console.log(btttn);
  function error_papier() {
    Swal.fire({
      icon: "error",
      title: "Error...",
      text: "Remplisser d'abord les papiers!",
    });
  }
  $(document).on("click", ".papier", (e) => {
    $("#setupdt").show();
    $("#setadd").hide();
    // console.log(e.target);
    var span = document.getElementsByClassName("cls")[0];
    $("#md").show();
    if (span) {
      span.onclick = function () {
        $("#md").hide();
      };
    }
    $.ajax({
      url: "./action.php",
      type: "POST",
      data: { showMAT: e.target.value },
      dataType: "json",
      success: function (data) {
        // console.log(data.message);
        try {
          const {
            date_carte_grise,
            date_vidange,
            date_visite_technique,
            date_assurance,
            date_retour,
            matricule_voiture,
          } = data.message;
          !date_carte_grise ||
          !date_vidange ||
          !date_visite_technique ||
          !date_assurance ||
          !date_retour ||
          !matricule_voiture
            ? error_papier()
            : updateInfos(
                date_carte_grise,
                date_vidange,
                date_visite_technique,
                date_assurance,
                date_retour,
                matricule_voiture
              );
        } catch (error) {
          console.error(error);
        }
      },
      error: function (err) {
        console.log(err);
      },
    });
  });
  $(document).on("click", ".adpapier", (e) => {
    $("#setupdt").hide();
    $("#setadd").show();
    // console.log(e.target);
    var span = document.getElementsByClassName("cls")[0];
    $("#md").show();
    if (span) {
      span.onclick = function () {
        $("#md").hide();
      };
    }
    document.getElementById("matricule").value = e.target.value;
    $(document).on("click", "#setadd", function () {
      $.ajax({
        url: "./action.php",
        type: "POST",
        data: {
          addMAT: e.target.value,
          crt: document.getElementById("carteGriz").value,
          dv: document.getElementById("vidange").value,
          dvt: document.getElementById("vtech").value,
          da: document.getElementById("assurance").value,
          dr: document.getElementById("ret").value,
        },
        dataType: "json",
        success: function (data) {
          console.log(data.message);
        },
        error: function (err) {
          console.log(err);
        },
      });
    });
  });
  function updateInfos(crtg, dv, dvt, da, dr, mt) {
    document.getElementById("carteGriz").value = crtg;

    document.getElementById("vidange").value = dv;
    document.getElementById("vtech").value = dvt;
    document.getElementById("assurance").value = da;
    document.getElementById("ret").value = dr;
    document.getElementById("matricule").value = mt;
  }
  $(document).on("click", "#setupdt", function () {
    $.ajax({
      url: "./action.php",
      type: "POST",
      data: {
        actt: "tfo",
        crt: document.getElementById("carteGriz").value,
        dv: document.getElementById("vidange").value,
        dvt: document.getElementById("vtech").value,
        da: document.getElementById("assurance").value,
        dr: document.getElementById("ret").value,
        mt: document.getElementById("matricule").value,
      },
      dataType: "json",
      success: function (data) {
        console.log("Modified successfully");
        confirm_notif(e.target.value);
      },
      error: function (err) {},
    });
  });
  function confirm_notif(et) {
    $.ajax({
      url: "./action.php",
      type: "POST",
      data: { confirmVoi: et },
      dataType: "json",
      success: function (data) {
        // console.log(data);
        console.log("dazt notif voi");
      },
      error: function (err) {
        console.log(err);
      },
    });
  }
});

// ____________________________________________

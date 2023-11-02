// window.addEventListener("scroll", function () {
//   var scroll = document.querySelector(".scrolltop");
//   scroll.classList.toggle("avtive", window.scrollY > 400);
// });
// function scrollToTop() {
//   window.scrollTo({
//     top: 0,
//     behavior: "smooth",
//   });
// }

function success() {
  Swal.fire({
    icon: "success",
    title: "E-mail envoyé avec succès",
    showConfirmButton: false,
    timer: 1500,
  });
}
function error() {
  Swal.fire({
    icon: "error",
    title: "Error...",
    text: "Quelque chose s'est mal passé",
  });
}
document.getElementById("button_email").onclick = function () {
  var fullname = document.email_form.fullname.value;
  var email = document.email_form.email.value;
  var sujet = document.email_form.sujet.value;
  var message = document.email_form.message.value;
  var send_mail = new XMLHttpRequest();
  send_mail.open("POST", "../MODEL/envoyer_email.php", false);
  send_mail.setRequestHeader(
    "Content-type",
    "application/x-wwW-form-urlencoded"
  );
  send_mail.send(
    "fullname=" +
      fullname +
      "&&email=" +
      email +
      "&&sujet=" +
      sujet +
      "&&message=" +
      message
  );
  if (send_mail.responseText == "send") {
    success();
    document.email_form.reset();
  } else {
    error();
  }
};

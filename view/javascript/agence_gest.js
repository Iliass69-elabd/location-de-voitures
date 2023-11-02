function sucess_update() {
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
    var myvalue = "show_table_agence";
    var request = new XMLHttpRequest();
    request.open("POST", "action.php", false);
    request.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    request.send("show_agence=" + myvalue);
    
    document.getElementById("tbody").innerHTML = request.responseText;
}
function show_and_alerts(){
    show();
    if(document.getElementById("message").innerHTML==1){
        sucess_update();
    }else if(document.getElementById("message").innerHTML==2){
        error_update();
    }
}

document.getElementsByTagName("body").onload=show_and_alerts();



function get_info(id){
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var request = new XMLHttpRequest();
    request.open("POST",'action.php',false);
    request.setRequestHeader(
        "Content-type",
        "application/x-wwW-form-urlencoded"
    );
    request.send("id_agence="+id);
    
    document.getElementById('myform_update_a').innerHTML=request.responseText;
}

var modal = document.getElementById("myModal");


document.onclick = function(e){
    if(e.target.getAttribute("class")=="close"){
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }
}
window.onclick = function (event) {
    if (event.target.id == "myModal") {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }
};





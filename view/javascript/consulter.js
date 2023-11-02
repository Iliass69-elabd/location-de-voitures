$(document).ready(function () {
    $(".image_to_show").on("click", function (e) {
        let src = e.target.src;
        $(".main_show_div").html(`<img class='main_img' src='${src}' alt=''>`);
    });
    $(document).on("click", "#main_video", function (e) {
        console.log("suiiiiiiiiiiiiiiiiiii");
        let src_video = e.target.src;
        $(
            ".main_show_div"
        ).html(`<video width="" class="show_video_" height="" controls autoplay>
            <source
                src='${src_video}'
                type="video/mp4"
            />
            Your browser does not support the video tag.
        </video>`);
    });
    $(document).on("click", "#clicked_div", function (e) {
        let src_video = $(e.target).siblings(0).children(0).attr("src");
        console.log(src_video);
        $(
            ".main_show_div"
        ).html(`<video width="" class="show_video_" height="" controls autoplay>
            <source
                src='${src_video}'
                type="video/mp4"
            />
            Your browser does not support the video tag.
        </video>`);
    });
    var facture = document.querySelector(".facture_container");
    html2pdf().from(facture).save("facture.pdf");
});

var modal = document.getElementById("myModal");

var btn = document.getElementById("myBtn");

var span = document.getElementsByClassName("close")[0];

if (btn) {
    btn.onclick = function () {
        modal.style.display = "block";
    };
}

if (span) {
    span.onclick = function () {
        modal.style.display = "none";
    };
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};
$(document).on("click", "[name='reserverMTN']", function () {
    $(".modal").css("display", "none");
});

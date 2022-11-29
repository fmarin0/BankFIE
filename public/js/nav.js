function openMenu(){
    if (document.getElementById('body-menu').style.display === '' || document.getElementById('body-menu').style.display === "none") {
        document.getElementById('body-menu').style.display = "grid";
    } else {
        document.getElementById('body-menu').style.display = "none";
    }
}
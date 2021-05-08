function accordion_daftarklien(){
    var acc = document.getElementsByClassName("daftarklien-item-kategori");
    var i;
    for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
        } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        } 
    });
    }
}

var myAcc = document.getElementById("vdkstyle-accordion");
if(myAcc){
    accordion_daftarklien();
}
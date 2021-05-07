<?php
///shortcode daftarklien
add_shortcode('vd-daftar-klien','showdaftar_klien');
function showdaftar_klien(){
    ob_start();   
    echo show_dataklien();
    return ob_get_clean();
}
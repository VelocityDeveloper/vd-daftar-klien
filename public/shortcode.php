<?php
///shortcode daftarklien
add_shortcode('vd-daftar-klien','showdaftar_klien');
function showdaftar_klien($atts){
    ob_start();  

    $atribut = shortcode_atts( array(
        'style'     => '',
        'kategori'  => '',
        'paket'     => '',
    ), $atts );

    echo show_dataklien($atribut);

    return ob_get_clean();
}
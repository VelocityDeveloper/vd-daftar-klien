<?php
$VDklienklien       = new VDklienklien();
$VDklienkategori    = new VDklienkategori();
$datakategori       = $VDklienkategori->get("WHERE type='kategori' ORDER BY name ASC");
$datapaket          = $VDklienkategori->get("WHERE type='paket' ORDER BY name ASC");

//create array
$arekategori        = [];
foreach ($datakategori as $key => $value) {
    $arekategori[$value['name']] = $value['id'];
}
$arepaket           = [];
foreach ($datapaket as $key => $value) {
    $arepaket[$value['name']] = $value['id'];
}

$array = 'www.hkbpperkembangan.org (Paket F)+www.gkijefsi.or.id (Paket G)+www.renungankristenterkini.com (Paket APK Custom)+www.wadimubarak.com (Paket G)+www.pakmkusu.org (Paket G)+www.pastoralkonselinggki.com (Paket G)+www.gsjakads.com (Paket G)+www.hajiplusumrohsunnah.com (Paket F)+www.galeri-haji.com (Paket G)+www.bintangaqiqah.com (Paket G)+www.gtq-albukhari.com (Paket F)+www.arofahmina.co.id+www.webkita.net (Paket F)+www.kajianahadpagipdmpati.com (Paket F)';

$array = explode("+",$array);

// echo '<pre>';
// print_r($array);
// echo '</pre>';

foreach ($array as $key => $value) {
    $text = $value;
    preg_match('#\((.*?)\)#', $text, $match);
    $paket = $match[1];

    $ada = explode("(",$value);
    $web = $ada[0];
    $web = str_replace(' ', '', $web);
    $paketkode = isset($arepaket[$paket])?$arepaket[$paket]:'';

    echo '<table class="wp-list-table widefat fixed striped tags">';
    echo '<tr>';
        echo '<td>'.$web.'</td>';
        echo '<td>'.$paket.'</td>';
        echo '<td>'.$paketkode.'</td>';
    echo '</tr>';
    echo '</table>';
    
    // $getweb = $VDklienklien->get("WHERE nama = '$web' ");
    // if(!$getweb) {
    //     $VDklienklien->add($web,37,$paketkode);
    //     echo 'berhasil = '.$web.'<br><br>';
    // }
}

?>

<script>
// jQuery(function($){
// var nn;
//  $('#contents-right ol').each(function(n,i){
//      nn += '|';
    
//      $(this).find('li').each(function(x,z){
//         nn += $(this).text()+'+';
//      });
//     nn += '\n\n\n\n';
// });
// console.log(nn);
// });
</script>
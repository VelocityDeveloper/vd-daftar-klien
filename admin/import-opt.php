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

$array = 'www.sampitnetradio.id (Paket G)+radiosanggamfm.com (Paket G)+www.rcct.tl (Paket Radio Streaming Custom)+www.vestgreenradio99-6fm.com (Paket Radio Streaming Custom)';

$array = explode("+",$array);

// echo '<pre>';
// print_r($array);
// echo '</pre>';

$nn = 1;
$nm = 1;
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
        echo '<td>'.$nm.'</td>';
        echo '<td>'.$web.'</td>';
        echo '<td>'.$paket.'</td>';
        echo '<td>'.$paketkode.'</td>';
    echo '</tr>';
    echo '</table>';
    
    $cat = 66;
    // $getweb = $VDklienklien->get("WHERE nama = '$web' and kategori = $cat ");
    // if(!$getweb) {
    //     $VDklienklien->add($web,$cat,$paketkode);
    //     echo 'berhasil = '.$web.'<br><br>';
    //     $nn++;
    // }
    $nm++;
}

echo '<strong>'.$nn.'</strong>';

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
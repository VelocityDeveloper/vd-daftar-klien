<?php
///shortcode daftarklien
add_shortcode('vd-daftar-klien','showdaftar_klien');
function showdaftar_klien(){
    ob_start();   
    $VDklienklien       = new VDklienklien();
    $VDklienkategori    = new VDklienkategori();
    $datakategori       = $VDklienkategori->get("WHERE type='kategori' ORDER BY name ASC");
    $datapaket          = $VDklienkategori->get("WHERE type='paket' ORDER BY name ASC");
    
    //create array
    $arekategori        = [];
    foreach ($datakategori as $key => $value) {
        $arekategori[$value['id']] = $value['name'];
    }
    $arepaket           = [];
    foreach ($datapaket as $key => $value) {
        $arepaket[$value['id']] = $value['name'];
    }


    ?>

    <div class="vd-daftar-klien show-vddaftar-klien">
        <div class="show-vddaftar-klien-inner">
            <?php foreach ($arekategori as $key => $value): ?>
                <div class="daftarklien-item" data-kategori="<?php echo $key; ?>">
                    <div class="daftarklien-item-kategori"><strong><?php echo $value; ?></strong></div>
                    <?php $getdataklien = $VDklienklien->get("WHERE kategori = $key ORDER BY nama ASC"); ?>
                    <?php if($getdataklien): ?>
                        <ol class="daftarklien-datas">
                        <?php foreach ($getdataklien as $data): ?>
                            <li><?php echo $data['nama']; ?> (<?php echo $arepaket[$data['paket']]; ?>)</li>
                        <?php endforeach; ?>
                        </ol> 
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
<?php
///show data klien
function show_dataklien($args=null){

    $VDklienklien       = new VDklienklien();
    $VDklienkategori    = new VDklienkategori();
    $atkategori         = isset($args['kategori'])&&!empty($args['kategori'])?$args['kategori']:'';
    $atpaket            = isset($args['paket'])&&!empty($args['paket'])?$args['paket']:'';
        
    $datapaket          = $VDklienkategori->get("WHERE type='paket' ORDER BY name ASC");
    $countklien         = $VDklienklien->count();
    
    //create array
    $arepaket           = [];
    foreach ($datapaket as $key => $value) {
        $arepaket[$value['id']] = $value['name'];
    }

    //create array kategori
    $arekategori            = [];
    if($atkategori):
        $getatkat           = $VDklienkategori->get("WHERE name = '$atkategori'");
        if($getatkat):
            $arekategori[$getatkat[0]['id']] = $getatkat[0]['name'];
        endif;
    else:
        $datakategori       = $VDklienkategori->get("WHERE type='kategori' ORDER BY name ASC");
        foreach ($datakategori as $key => $value) {
            $arekategori[$value['id']] = $value['name'];
        }
    endif;

    ?>

    <div class="vd-daftar-klien show-vddaftar-klien">
        <div class="caption-vddaftar-klien">
            <span><strong>Total : <?php echo $countklien; ?> Klien</strong></span>
        </div>
        <div class="show-vddaftar-klien">
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
}
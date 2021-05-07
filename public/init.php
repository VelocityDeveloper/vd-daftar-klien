<?php
///show data klien
function show_dataklien(){
        
    $VDklienklien       = new VDklienklien();
    $VDklienkategori    = new VDklienkategori();
    $datakategori       = $VDklienkategori->get("WHERE type='kategori' ORDER BY name ASC");
    $datapaket          = $VDklienkategori->get("WHERE type='paket' ORDER BY name ASC");
    $countklien         = $VDklienklien->count();
    
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
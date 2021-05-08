<?php
///show data klien
function show_dataklien($args=null){
    // print_r($args);
    $VDklienklien       = new VDklienklien();
    $VDklienkategori    = new VDklienkategori();
    $atstyle            = isset($args['style'])&&!empty($args['style'])?$args['style']:'number';
    $atkategori         = isset($args['kategori'])&&!empty($args['kategori'])?$args['kategori']:'';
    $atkategoriid       = isset($args['kategori-id'])&&!empty($args['kategori-id'])?$args['kategori-id']:'';
    $atpaket            = isset($args['paket'])&&!empty($args['paket'])?$args['paket']:'';
        
    $filpaket           = $atpaket?$VDklienkategori->get("WHERE type='paket' AND name = '$atpaket'"):'';
    $datapaket          = $VDklienkategori->get("WHERE type='paket' ORDER BY name ASC");
    $countklien         = $VDklienklien->count();
    
    //create array
    $arepaket           = [];
    foreach ($datapaket as $key => $value) {
        $arepaket[$value['id']] = $value['name'];
    }

    //create array kategori
    $arekategori            = [];
    if($atkategori || $atkategoriid):
        $getatkat           = $atkategoriid?$VDklienkategori->get("WHERE id = $atkategoriid"):$VDklienkategori->get("WHERE name = '$atkategori'");
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
        <div id="vdkstyle-<?php echo $atstyle; ?>" class="vd-style-<?php echo $atstyle; ?>">
            <div class="count-vddaftar-klien">
                <span><strong>Total : <?php echo $countklien; ?> Klien</strong></span>
            </div>
            <div class="show-vddaftar-klien">
                <?php foreach ($arekategori as $key => $value): ?>
                    <div class="daftarklien-item" data-kategori="<?php echo $key; ?>">
                        <div class="daftarklien-item-kategori"><?php echo $value; ?></div>

                        <?php         
                        $filter         = [];
                        $filter[]       = "kategori = $key";
                        if($atpaket&&$filpaket) {
                            $idpaket    = $filpaket[0]['id'];
                            $filter[]   = "paket = $idpaket";
                        }
                        $filter         = $filter?'WHERE '.implode(" and ",$filter):'';
                        $getdataklien   = $VDklienklien->get("$filter ORDER BY nama ASC");
                        // print_r($filter);
                        if($getdataklien): ?>
                            <div class="daftarklien-list">
                                <div class="daftarklien-list-klien">
                                <?php foreach ($getdataklien as $data): ?>
                                    <div class="daftarklien-item-klien">
                                        <?php echo $data['nama']; ?>
                                        <?php echo isset($arepaket[$data['paket']])?'<span class="badge-paket">'.$arepaket[$data['paket']].'</span>':''; ?>
                                    </div>
                                <?php endforeach; ?>
                                </div> 
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php
}
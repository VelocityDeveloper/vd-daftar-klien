<?php
$filtercat          = isset($_GET['filter-kategori'])?$_GET['filter-kategori']:'';
$filterpaket        = isset($_GET['filter-paket'])?$_GET['filter-paket']:'';
$geteditklien       = isset($_GET['editklien'])?$_GET['editklien']:'';
$editklien          = !empty($geteditklien)&&!isset($_POST['actionklien'])?$_GET['editklien']:'';
$hapusklien         = isset($_GET['hapusklien'])?$_GET['hapusklien']:'';
$VDklienklien       = new VDklienklien();
$VDklienkategori    = new VDklienkategori();
$datakategori       = $VDklienkategori->get("WHERE type='kategori' ORDER BY name ASC");
$datapaket          = $VDklienkategori->get("WHERE type='paket' ORDER BY name ASC");

$namaklien          = '';
$catklien           = '';
$paketklien         = '';
$idklien            = '';

//create array
$arekategori        = [];
foreach ($datakategori as $key => $value) {
    $arekategori[$value['id']] = $value['name'];
}
$arepaket           = [];
foreach ($datapaket as $key => $value) {
    $arepaket[$value['id']] = $value['name'];
}


//save data
if(isset($_POST['actionklien']) && !empty($_POST['nama'])):
    if($_POST['actionklien']=='edit'):
        $arg = [            
            'nama'      => $_POST['nama'],
            'kategori'  => $_POST['kategori'],
            'paket'     => $_POST['paket'],
        ];
        $VDklienklien->update($_POST['idklien'],$arg);
    else:
        $VDklienklien->add($_POST['nama'],$_POST['kategori'],$_POST['paket']);
    endif;
    // echo '<div id="message" class="updated"><p>Data paket berhasil diupdate</p></div>';
endif;

///edit klien
if($editklien):
    $dataget        = $VDklienklien->get("WHERE id=".$editklien);
    $idklien        = $dataget[0]['id'];
    $namaklien      = $dataget[0]['nama'];
    $catklien       = $dataget[0]['kategori'];
    $paketklien     = $dataget[0]['paket'];
endif;

//get paket
$filter = [];
$filterurl = [];
if($filterpaket) {
    $filter[]       = "paket = $filterpaket";
    $filterurl[]    = "filter-paket=$filterpaket";
}
if($filtercat) {
    $filter[]       = "kategori = $filtercat";
    $filterurl[]    = "filter-kategori=$filtercat";
}
$filter     = $filter?'WHERE '.implode(" and ",$filter):'';
$linkdaftar = $filterurl?$linkdaftar.'&'.str_replace(' ', '', implode("&",$filterurl)):$linkdaftar;

$dataklien  = $VDklienklien->get("$filter ORDER BY id DESC");
$countklien = $VDklienklien->count($filter);

?>
<div class="keloladaftar-klien">
<div id="col-container" class="wp-clearfix">
    <div id="col-left">
        <div class="col-wrap">
            <div class="form-wrap">
                <h2><?php echo !empty($editklien)?'Edit':'Tambah'; ?> klien</h2>

                <form action="" method="post">
                    <div class="form-field form-required">
                        <label for="nama">Nama</label>
                        <input name="nama" id="nama" type="text" value="<?php echo $namaklien;?>" size="40" aria-required="true" class="widefat" required>
                    </div>
                    <div class="form-field kategori-wrap">
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="postform">
                            <option value="">None</option>
                            <?php foreach ($arekategori as $key => $value) {
                                echo '<option value="'.$key.'" '.selected( $catklien,$key).'>'.$value.'</option>';
                            }?>
                        </select>
                    </div>
                    <div class="form-field paket-wrap">
                        <label for="paket">Paket</label>
                        <select name="paket" id="paket" class="postform">
                            <option value="">None</option>
                            <?php foreach ($arepaket as $key => $value) {
                                echo '<option value="'.$key.'" '.selected( $paketklien,$key).'>'.$value.'</option>';
                            }?>
                        </select>
                    </div>
                    <input name="idklien" type="hidden" value="<?php echo $idklien;?>">
                    <input name="actionklien" type="hidden" value="<?php echo !empty($editklien)?'edit':'tambah'; ?>">
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo !empty($editklien)?'Edit':'Tambah'; ?>">
                    </p>
                </form>
            </div>
        </div>
    </div>
    <div id="col-right">
        <div class="col-wrap">

            <form action="" method="get">
                <input type="hidden" name="page" value="vdklien-daftarklien-option">
                <input type="hidden" name="hal" value="daftar">
                <div class="tablenav top">
                    <div class="alignleft actions bulkactions">
                        <label for="filter-kategori" class="screen-reader-text">Filter Kategori</label>
                        <select name="filter-kategori" id="filter-kategori">
                            <option value="">Pilih Kategori</option>                            
                            <?php foreach ($arekategori as $key => $value) {
                                echo '<option value="'.$key.'" '.selected( $filtercat,$key).'>'.$value.'</option>';
                            }?>
                        </select>
                        <label for="filter-paket" class="screen-reader-text">Filter Paket</label>
                        <select name="filter-paket" id="filter-paket">
                            <option value="">Pilih Paket</option>                            
                            <?php foreach ($arepaket as $key => $value) {
                                echo '<option value="'.$key.'" '.selected( $filterpaket,$key).'>'.$value.'</option>';
                            }?>
                        </select>
                        <input type="submit" id="doaction" class="button action" value="Filter">
                    </div>
                    <div class="tablenav-pages one-page">
                        <span class="displaying-num"><?php echo $countklien;?> items</span>
                    </div>
                </div>
            </form>

            <table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <th style="width: 40px;">No</th><th>Nama</th><th>Kategori</th><th>Paket</th><th style="width: 45px;"></th>
                </thead>
                <tbody>                
                    <?php $nm = 1;?>
                    <?php foreach($dataklien as $data): ?>
                        <tr class="vdtr vdtr-<?php echo $data['id'];?>" data-id="<?php echo $data['id'];?>">
                            <td style="width: 40px;"><?php echo $nm;?></td>
                            <td><?php echo $data['nama'];?></td>
                            <td><?php echo $arekategori[$data['kategori']];?></td>
                            <td><?php echo $arepaket[$data['paket']];?></td>
                            <td style="width: 45px;">                            
                                <a href="<?php echo $linkdaftar ;?>&editklien=<?php echo $data['id'];?>"><span class="dashicons dashicons-edit btn-edit"></span></a>
                                <a href="<?php echo $linkdaftar ;?>&hapusklien=<?php echo $data['id'];?>"><span class="dashicons dashicons-trash btn-delete"></span></a>
                            </td>
                        </tr>
                    <?php $nm++;?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        
        </div>
    </div>
</div>
</div>
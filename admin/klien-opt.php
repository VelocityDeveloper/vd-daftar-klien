<?php
$paged              = isset($_GET['paged'])?$_GET['paged']:1;
$kliensearch        = isset($_GET['klien-search'])?$_GET['klien-search']:'';
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

if($kliensearch):
    $filter     = "WHERE nama like '%$kliensearch%'";
    $linkdaftar = $linkdaftar.'&klien-search='.$kliensearch;
endif;

$post_per_page  = 50;
$offset         = ($paged - 1)*$post_per_page;
$dataklien      = $VDklienklien->get("$filter ORDER BY id DESC LIMIT $post_per_page OFFSET $offset");
$countklien     = $VDklienklien->count($filter);
$max_num_pages  = ceil($countklien/ $post_per_page);

$Navlinknext    = ($max_num_pages > $paged)?$linkdaftar.'&paged='.$paged+1:$linkdaftar;
$Navlinkprev    = (1 > $paged)?$linkdaftar.'&paged='.$paged+1:$linkdaftar;
?>

<div class="keloladaftar-klien">

    <form class="search-form wp-clearfix" method="get">
        <input type="hidden" name="page" value="vdklien-daftarklien-option">
        <input type="hidden" name="hal" value="daftar">
        <p class="search-box">
            <label class="screen-reader-text" for="klien-search-input">Cari Klien</label>
            <input type="search" id="klien-search-input" name="klien-search" value="<?php echo $kliensearch; ?>">
            <input type="submit" id="search-submit" class="button" value="Cari Klien">
        </p>
    </form>

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
                        <div class="tablenav-pages">
                            <span class="displaying-num"><?php echo $countklien;?> items</span>
                            <span class="pagination-links">
                                <a class="first-page" href="<?php echo $linkdaftar;?>&paged=1"><span class="screen-reader-text">First page</span><span aria-hidden="true">«</span></a>
                                <a class="prev-page" href="<?php echo $Navlinkprev;?>"><span class="screen-reader-text">Previous page</span><span aria-hidden="true">‹</span></a>
                                <span class="paging-input">
                                    <label for="current-page-selector" class="screen-reader-text">Current Page</label>
                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="<?php echo $paged; ?>" size="1" aria-describedby="table-paging">
                                    <span class="tablenav-paging-text"> of <span class="total-pages"><?php echo $max_num_pages; ?></span></span>
                                </span>
                                <a class="next-page" href="<?php echo $Navlinknext;?>"><span class="screen-reader-text">Next page</span><span aria-hidden="true">›</span></a>
                                <a class="last-page" href="<?php echo $linkdaftar;?>&paged=<?php echo $max_num_pages; ?>"><span class="screen-reader-text">Last page</span><span aria-hidden="true">»</span></a>
                            </span>
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
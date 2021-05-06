<?php
$geteditkat         = isset($_GET['editkategori'])?$_GET['editkategori']:'';
$editkategori       = !empty($geteditkat)&&!isset($_POST['namekategori'])?$_GET['editkategori']:'';
$hapuskategori      = isset($_GET['hapuskategori'])?$_GET['hapuskategori']:'';
$VDklienkategori    = new VDklienkategori();
$namakategori       = '';
$idkategori         = '';


//delete kategori
if(isset($hapuskategori) && !empty($hapuskategori)):
    $VDklienkategori->delete($hapuskategori);
endif;

//save kategori
if(isset($_POST['namekategori']) && !empty($_POST['namekategori'])):
    if($_POST['action']=='edit'):
        $VDklienkategori->update($_POST['idkategori'],$_POST['namekategori']);
    else:
        $VDklienkategori->add($_POST['namekategori'],$_POST['typekategori']);
    endif;
    // echo '<div id="message" class="updated"><p>Data kategori berhasil diupdate</p></div>';
endif;

///editkategori
if($editkategori):
    $dataget = $VDklienkategori->get("WHERE id=".$editkategori);
    $namakategori   = $dataget[0]['name'];
    $idkategori     = $dataget[0]['id'];
endif;

//get kategori
$datakategori = $VDklienkategori->get("WHERE type='kategori' ORDER BY name ASC");
?>

<div id="kelola-kategori" class="meta-box-sortables ui-sortable">
    <div class="postbox">
        <h2 class="hndle ui-sortable-handle">
            <span>Kategori</span>
        </h2>
        <div class="inside">

            <h3><?php echo !empty($editkategori)?'Edit':'Tambah'; ?> Kategori</h3>

            <form action="" method="post">
                <div class="form-field">
                    <label for="namekategori">Nama Kategori</label>
                    <input name="namekategori" id="namekategori" type="text" value="<?php echo $namakategori;?>" size="40" aria-required="true" required>
                </div>
                <input name="typekategori" type="hidden" value="kategori">
                <input name="idkategori" type="hidden" value="<?php echo $idkategori;?>">
                <input name="action" type="hidden" value="<?php echo !empty($editkategori)?'edit':'tambah'; ?>">
                <p>
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo !empty($editkategori)?'Edit':'Tambah'; ?>">
                </p>
            </form>
            <hr>
            <table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Jumlah</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $nm = 1;?>
                    <?php foreach($datakategori as $data): ?>
                        <tr class="vdkat-tr vdkat-tr-<?php echo $data['id'];?>" data-id="<?php echo $data['id'];?>">
                            <td><?php echo $nm;?></td>
                            <td><?php echo $data['name'];?></td>
                            <td><?php echo $data['count'];?></td>
                            <td>
                                <a href="<?php echo $linkkelola ;?>&editkategori=<?php echo $data['id'];?>"><span class="dashicons dashicons-edit btn-edit"></span></a>
                                <a href="<?php echo $linkkelola ;?>&hapuskategori=<?php echo $data['id'];?>"><span class="dashicons dashicons-trash btn-delete"></span></a>
                            </td>
                        </tr>
                    <?php $nm++;?>
                    <?php endforeach; ?>
                </tbody>
            </table>        
        </div>
    </div>
</div>
<?php
$geteditpaket       = isset($_GET['editpaket'])?$_GET['editpaket']:'';
$editpaket          = !empty($geteditpaket)&&!isset($_POST['namepaket'])?$_GET['editpaket']:'';
$hapuspaket         = isset($_GET['hapuspaket'])?$_GET['hapuspaket']:'';
$VDklienkategori    = new VDklienkategori();
$namapaket          = '';
$idpaket            = '';


//delete paket
if(isset($hapuspaket) && !empty($hapuspaket)):
    $VDklienkategori->delete($hapuspaket);
endif;

//save paket
if(isset($_POST['namepaket']) && !empty($_POST['namepaket'])):
    if($_POST['action']=='edit'):
        $VDklienkategori->update($_POST['idpaket'],$_POST['namepaket']);
    else:
        $VDklienkategori->add($_POST['namepaket'],$_POST['typepaket']);
    endif;
    // echo '<div id="message" class="updated"><p>Data paket berhasil diupdate</p></div>';
endif;

///editpaket
if($editpaket):
    $dataget = $VDklienkategori->get("WHERE id=".$editpaket);
    $namapaket   = $dataget[0]['name'];
    $idpaket     = $dataget[0]['id'];
endif;

//get paket
$datapaket = $VDklienkategori->get("WHERE type='paket' ORDER BY name ASC");
?>

<div id="kelola-paket" class="meta-box-sortables ui-sortable">
    <div class="postbox">
        <h2 class="hndle ui-sortable-handle">
            <span>Paket</span>
        </h2>
        <div class="inside">

            <h3><?php echo !empty($editpaket)?'Edit':'Tambah'; ?> paket</h3>

            <form action="" method="post">
                <div class="form-field">
                    <label for="namepaket">Nama paket</label>
                    <input name="namepaket" id="namepaket" type="text" value="<?php echo $namapaket;?>" size="40" aria-required="true" required>
                </div>
                <input name="typepaket" type="hidden" value="paket">
                <input name="idpaket" type="hidden" value="<?php echo $idpaket;?>">
                <input name="action" type="hidden" value="<?php echo !empty($editpaket)?'edit':'tambah'; ?>">
                <p>
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo !empty($editpaket)?'Edit':'Tambah'; ?>">
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
                    <?php foreach($datapaket as $data): ?>
                        <tr class="vdpak-tr vdpak-tr-<?php echo $data['id'];?>" data-id="<?php echo $data['id'];?>">
                            <td><?php echo $nm;?></td>
                            <td><?php echo $data['name'];?></td>
                            <td><?php echo $data['count'];?></td>
                            <td>
                                <a href="<?php echo $linkkelola ;?>&editpaket=<?php echo $data['id'];?>"><span class="dashicons dashicons-edit btn-edit"></span></a>
                                <a href="<?php echo $linkkelola ;?>&hapuspaket=<?php echo $data['id'];?>"><span class="dashicons dashicons-trash btn-delete"></span></a>
                            </td>
                        </tr>
                    <?php $nm++;?>
                    <?php endforeach; ?>
                </tbody>
            </table>        
        </div>
    </div>
</div>
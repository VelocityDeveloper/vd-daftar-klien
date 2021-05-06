<?php
$hal            = isset($_GET['hal'])?$_GET['hal']:'';
$linkadmin      = get_home_url().'/wp-admin/options-general.php?page=vdklien-daftarklien-option';
$linkkelola     = get_home_url().'/wp-admin/options-general.php?page=vdklien-daftarklien-option&hal=kelola';
$linkdaftar     = get_home_url().'/wp-admin/options-general.php?page=vdklien-daftarklien-option&hal=daftar';
?>

<div class="wrap wrap-vddaftar-klien">
    <h1 class="wp-heading-inline">Kelola Daftar Klien</h1>
    <hr class="wp-header-end">
    <br/>
    <a class="page-title-action" href="<?php echo $linkadmin;?>&hal=daftar">Daftar Klien</a>
    <a class="page-title-action" href="<?php echo $linkadmin;?>&hal=kelola">Kelola Kategori & Paket</a>

    <br/>
    <hr class="wp-header-end">
    <br/>

    <?php if($hal=='kelola'):?>
        <div id="poststuff">
            <div class="widget-liquid-left wp-clearfix js">
                <?php require_once('kategori-opt.php'); ?>
            </div>
            <div class="widget-liquid-right">    
                <?php require_once('paket-opt.php'); ?>
            </div>
        </div>
    <?php else:?>
        <div id="klien-opt">
            <?php require_once('klien-opt.php'); ?>
        </div>
    <?php endif;?>

</div>
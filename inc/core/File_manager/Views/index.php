
<?php 
$request = \Config\Services::request();
if ( !$request->isAJAX() ) {
?>
    <?php 
        _e( $this->extend('Backend\Stackmin\Views\index'), false);
    ?>

    <?php echo $this->section('content') ?>
    <?php _ec( $this->include('Core\Bulk_post\Views\sidebar'), false);?>
    <div class="main-wrapper flex-grow-1 n-scroll d-flex <?php _e( str_replace("_", "-", $id) )?>" data-loading="false">
    <?php _e( $this->include('Core\File_manager\Views\sidebar'), false);?>    
    <?php echo $content ?>
     
    </div>

    <?php echo $this->endSection() ?>

<?php }else{ ?>

    <?php echo $content ?>

<?php } ?>
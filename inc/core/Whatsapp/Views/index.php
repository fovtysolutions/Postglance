<?php 
$request = \Config\Services::request();
if ( !$request->isAJAX() ) {
?>
    <?php 
        _ec( $this->extend('Backend\Stackmin\Views\index'), false);
    ?>

    <?php echo $this->section('content') ?>
    <?php echo view_cell('Core\Whatsapp\Controllers\Whatsapp::sidebar') ?>

    <div class="main-wrapper flex-grow-1 n-scroll">
        <?php
        $stats = db_get("wa_total_sent_by_month", TB_WHATSAPP_STATS, ["team_id" => get_team("id")]);
        $permissions = (int)permission("whatsapp_message_per_month");
        ?>

        <?php if ($stats && $stats->wa_total_sent_by_month >= $permissions): ?>
        <div class="container pt-5">
            <div class="alert alert-danger d-flex align-items-center">
                <div class="fs-40 me-3"><i class="fad fa-exclamation-circle"></i></div>
                <div>
                    <div class="fw-bold"><?php _e("All activities will stop automatically.")?></div>
                    <?php _e("You have exceeded the maximum number of messages you can send per month.")?>
                </div>
            </div>
        </div>
        <?php endif ?>

        <?php echo $content ?>
    </div>

    <?php echo $this->endSection() ?>

<?php }else{ ?>

    <?php echo $content ?>

<?php } ?>
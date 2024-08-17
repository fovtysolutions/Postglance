<div class="container my-5">
    <?php if (!empty( $items )): ?>
        
        <?php foreach ($items as $key => $value): ?>
            
            <?php _ec( $value['data']['html'] )?>

        <?php endforeach ?>

    <?php endif ?>
    <div class="m-t-25">
        <button type="submit" class="btn btn-primary"><?php _e('Save')?></button>
    </div>
</div>
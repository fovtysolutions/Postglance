<div class="container px-4 py-4">
    <div class="row">
        <?php if (!empty( $result )): ?>
            
            <?php foreach ($result as $key => $value): ?>

                <?php if ( isset($value['data']['html']) ): ?>
                    <?php _ec( $value['data']['html'] )?>
                <?php endif ?>
                
            <?php endforeach ?>

        <?php endif ?>
    </div>
</div>
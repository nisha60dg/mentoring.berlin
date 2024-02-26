<?php if (isset($products) && !empty($products)) { ?>
        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-sm-4">
                    <div class="card text-bg-primary mb-3">
                        <div class="card-header bg-primary" style="color:white;background-color:#003893 !important;"><?= $product->product_title ?></div>
                        <div class="card-header"><?= $product->excerpt ?></div>
                        <div class="card-body" style="max-height:50rem;">
                            <h5 class="card-title"><?= $product->short_description ?></h5>
                            <p class="card-text"><?= $product->description ?></p>
                            <a href="<?= get_permalink(1207) ?>.?product_id=<?= $product->id ?>" class="btn btn-primary" style="text-decoration:none;color:white;background-color:#003893 !important;"><?=$product->product_price>0?'Paid Plan':'Free Plan'?></a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php } ?>
<?= $this->extend("App\Views\home") ?>
<?= $this->section('main') ?>
    <?= $this->section('javascript') ?>
    <?= $this->endSection() ?>


    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h6>Indicator & Robot Shop</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($item as $key => $value) { ?>
                        
                    <div class="col-md-4">
                        <img src="<?php echo $value->images;?>" style="width: 100%;">
                        <h6><?php echo $value->name;?></h6>
                        <p><?php echo $value->description;?></p>
                        <hr>
                        <?php foreach (posts_options($value->id) as $k => $v) { ?>
                            <h6><?php echo $v->options_name?> : <?php echo $v->options_value?></h6>
                        <?php } ?>
                        
                        <div>
                            <a href="/signal/shopinfo/<?php echo $value->id;?>" class="btn btn-primary">Info</a>
                            <a href="<?php echo $value->url_customs;?>" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
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
                    <div class="col-md-4">
                        <div>
                            <a href="/signal/shopinfo/a" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
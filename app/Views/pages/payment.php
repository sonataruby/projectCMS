<?= $this->extend("App\Views\home") ?>
<?= $this->section('main') ?>
    <?= $this->section('javascript') ?>
    <?= $this->endSection() ?>


    <div class="container-fluid py-4">
        
        <?php echo components("payment",$invoice);?>
    </div>

<?= $this->endSection() ?>
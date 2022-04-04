<?= $this->extend("App\Views\admin\layout") ?>
<?= $this->section('main') ?>

<form action="<?php echo admin_url("settings/config");?>" method="post">
<div class="card">
    <div class="card-header border-bottom"><h6>Settings</h6></div>
    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-2 col-form-label">Site Name</div>
            <div class="col-10">
              <input name="config[site_name]" type="text" value="<?php echo $data->site_name;?>" class="form-control">
            </div>
        </div>


        <div class="mb-3 row">
            <div class="col-sm-2 col-form-label">Site Description</div>
            <div class="col-sm-10">
              <textarea name="config[site_description]" type="text" class="form-control"><?php echo $data->site_description;?></textarea>
            </div>
        </div>



        <div class="mb-3 row">
            <div class="col-sm-2 col-form-label">Site Keywork</div>
            <div class="col-sm-10">
              <textarea name="config[site_keyword]" type="text" class="form-control"><?php echo $data->site_keyword;?></textarea>
            </div>
        </div>



        <div class="mb-3 row">
            <div class="col-sm-2 col-form-label">Site Image</div>
            <div class="col-sm-10">
              <input name="config[site_image]" type="file" class="form-control">
            </div>
        </div>



        <div class="mb-3 row">
            <div class="col-sm-2 col-form-label">Site Icon</div>
            <div class="col-sm-10">
              <input name="config[site_icon]" type="file" class="form-control">
            </div>
        </div>


        <div class="mb-3 row">
            <div class="col-sm-2 col-form-label">Social Tiwter</div>
            <div class="col-sm-10">
              <input name="config[site_tiwter]" type="text" value="<?php echo $data->site_tiwter;?>" class="form-control">
            </div>
        </div>


        <div class="mb-3 row">
            <div class="col-sm-2 col-form-label">Social Facebook</div>
            <div class="col-sm-10">
              <input name="config[site_facebook]" type="text" value="<?php echo $data->site_facebook;?>" class="form-control">
            </div>
        </div>



    </div>
    <div class="card-footer border-top">
        <button type="submit" class="btn btn-sm btn-primary">Save Confirm</button>
    </div>
</div>
</form>

<?= $this->endSection() ?>
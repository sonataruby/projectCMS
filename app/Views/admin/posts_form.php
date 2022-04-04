<?= $this->extend("App\Views\admin\layout") ?>
<?= $this->section('main') ?>
<?= $this->section('javascript') ?>
<link rel="stylesheet" type="text/css" href="/assets/editer/summernote.css">
<link rel="stylesheet" type="text/css" href="/assets/editer/summernote-lite.css">
<script src="/assets/editer/summernote.js" referrerpolicy="origin"></script>
<script>

  $(document).ready(function() {
      $('.summernote').summernote({
        height: 550
      });
    });
  </script>
<?= $this->endSection() ?>

<form action="<?php echo admin_url("posts/createdata/".$data->id);?>" method="post">
<div class="card">
    <div class="card-header pb-0 border-bottom">
              <div class="d-lg-flex">
                <div>
                  <h5 class="mb-0">All Products</h5>
                  <p class="text-sm mb-0">
                    A lightweight, extendable, dependency-free javascript HTML table plugin.
                  </p>
                </div>
                <div class="ms-auto my-auto mt-lg-0 mt-4">
                    <button type="submit" class="btn btn-outline-primary btn-sm mb-0">
                      Public Data
                    </button>
                </div>
              </div>
            </div>
    <div class="card-body">

        <div class="row">
            <div class="col-7">
                
                <div class="mb-3 row">
                    <div class="col-12 col-form-label">Name</div>
                    <div class="col-12">
                      <input name="form[name]" type="text" value="<?php echo $data->name;?>" class="form-control">
                    </div>
                </div>

                

                <div class="mb-3 row">
                    <div class="col-sm-12 col-form-label">Description</div>
                    <div class="col-sm-12">
                      <textarea name="form[description]" type="text" class="form-control"><?php echo $data->description;?></textarea>
                    </div>
                </div>



                <div class="mb-3 row">
                    <div class="col-sm-12 col-form-label">Contents</div>
                    <div class="col-sm-12">
                      <textarea name="form[contents]" type="text" class="form-control summernote"><?php echo $data->contents;?></textarea>
                    </div>
                </div>


            </div>
            <div class="col-sm-5">

                <div class="mb-3 row">
                    <div class="col-sm-12 col-form-label">Tag's</div>
                    <div class="col-sm-12">
                      <input name="form[tags]" type="text" value="<?php echo $data->tags;?>" class="form-control">
                    </div>
                </div>



                <div class="mb-3 row">
                    <div class="col-sm-12 col-form-label">Image</div>
                    <div class="col-sm-12">
                      <input name="form[site_image]" type="file" class="form-control">
                    </div>
                </div>

            </div>
        </div>


    </div>
    <div class="card-footer border-top">
        <button type="submit" class="btn btn-sm btn-primary">Public Data</button>
    </div>
</div>
</form>

<?= $this->endSection() ?>
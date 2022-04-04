<?= $this->extend("App\Views\admin\layout") ?>
<?= $this->section('main') ?>

      
<div class="card">
    <div class="table-responsive">
         <div class="dataTable-container">

          	<table class="table table-flush dataTable-table" id="datatable-search">
                <thead class="thead-light">
                  <tr>
                  	<th data-sortable="" style="width: 14.6805%;"><a href="#" class="dataTable-sorter">Id</a></th>
                  	<th data-sortable="" style="width: 16.3212%;"><a href="#" class="dataTable-sorter">Date</a></th>
                  	<th data-sortable="" style="width: 16.2349%;"><a href="#" class="dataTable-sorter">Status</a></th>
                  	<th data-sortable="" style="width: 19.6028%;"><a href="#" class="dataTable-sorter">Customer</a></th>
                  	<th data-sortable="" style="width: 22.3661%;"><a href="#" class="dataTable-sorter">Product</a></th>
                  	<th data-sortable="" style="width: 10.7945%;"><a href="#" class="dataTable-sorter">Revenue</a></th>
                  </tr>
                </thead>
            
          	</table>


      	</div>
  	</div>
</div>


<?= $this->endSection() ?>
<!-- Button trigger modal -->
<button type="button" class="<?php echo $class;?>" data-bs-toggle="modal" data-bs-target="#CreatePost">
  <?php echo $text;?>
</button>

<!-- Modal -->
<div class="modal fade" id="CreatePost" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update VIP Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 class="mb-0 text-start">Time Select</h6>
        <select class="form-select" aria-label="Default select example">
          <option selected>Open this select menu</option>
          <option value="1">1 Month</option>
          <option value="2">3 Month</option>
          <option value="3">6 Month</option>
          <option value="3">12 Month</option>
          <option value="3">24 Month</option>
        </select>
        <h6 class="mb-0 text-start">Payment Method</h6>
        <select class="form-select" aria-label="Default select example">
          <option selected>Open this select menu</option>
          <option value="1">Paypal</option>
          <option value="2">BTC</option>
          <option value="3">USDT</option>
          <option value="3">Smart Token</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>

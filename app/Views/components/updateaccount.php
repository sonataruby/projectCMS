<!-- Button trigger modal -->
<button type="button" class="<?php echo $class;?>" data-bs-toggle="modal" data-bs-target="#updateAccount">
  <?php echo $text;?>
</button>

<!-- Modal -->
<div class="modal fade" id="updateAccount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="post" action="/signal/updateaccount">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update VIP Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 class="mb-0 text-start">Time Select</h6>
        <select class="form-select" name="timeline">
          <option selected>Open this select menu</option>
          <option value="1">1 Month</option>
          <option value="2">3 Month</option>
          <option value="3">6 Month</option>
          <option value="12">12 Month</option>
          <option value="24">24 Month</option>
        </select>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php if(has_permission("admin")){ ?>
<!-- Button trigger modal -->
<button type="button" class="<?php echo $class;?>" data-bs-toggle="modal" data-bs-target="#shareSignal">
  <?php echo $text;?>
</button>

<!-- Modal -->
<div class="modal fade" id="shareSignal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Share Signal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body test-start">
        
        <div class="mb-3">
          <label class="form-label">Chart</label>
          <input type="text" class="form-control">
        </div>

        <div class="row mb-3"> 
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">Type</label>
                <select class="form-select shareSignalType">
                  <option value="buy">Buy</option>
                  <option value="sell">Sell</option>
                </select>
              </div>
          </div>
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">Symbol</label>
                <input type="text" class="form-control">
              </div>
          </div>
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">Timefream</label>
                <select class="form-select">
                  <option value="M30">M30</option>
                  <option value="H1">H1</option>
                  <option value="H4">H4</option>
                  <option value="D1">D1</option>
                </select>
              </div>
          </div>

        </div>

        <div class="text-start">
          <label class="form-label">Stoploss</label>
          <input type="text" class="form-control shareSignalSL">
        </div>

        <div class="row mb-3">
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">Open</label>
                <input type="text" class="form-control shareSignalOpen">
              </div>
          </div>
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">DCA 1</label>
                <input type="text" class="form-control">
              </div>
          </div>
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">DCA 2</label>
                <input type="text" class="form-control">
              </div>
          </div>

        </div>


        


        <div class="row mb-3">
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">TP 1</label>
                <input type="text" class="form-control">
              </div>
          </div>
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">TP 2</label>
                <input type="text" class="form-control">
              </div>
          </div>
          <div class="col-4">
              <div class="text-start">
                <label class="form-label">TP 3</label>
                <input type="text" class="form-control">
              </div>
          </div>

        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Public</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
      const calcPriceSystem = () =>{
        var shareSignalType = $(".shareSignalType").val();
        var shareSignalSL = $(".shareSignalSL").val();
        var shareSignalOpen = $(".shareSignalOpen").val();
        var zone = Math.abs(shareSignalOpen - shareSignalSL);
        //var _dig = shareSignalOpen.slipt(".")[1];
        var _dig = 3;
        var dca1,dca2, tp1,tp2,tp3;
        if(shareSignalType == "buy"){
            tp1 = shareSignalOpen + zone * 1.68;
            tp2 = shareSignalOpen + zone * 2.68;
            tp3 = shareSignalOpen + zone * 3.68;
        }
        if(shareSignalType == "sell"){
            tp1 = shareSignalOpen - zone * 1.68;
            tp2 = shareSignalOpen - zone * 2.68;
            tp3 = shareSignalOpen - zone * 3.68;
        }
        $(".takeProfit input").eq(1).val(tp1);
        $(".takeProfit input").eq(2).val(tp2);
        $(".takeProfit input").eq(3).val(tp3);
      }
      $(".shareSignalSL").on("keyup", function(){
          calcPriceSystem();
      });
      $(".shareSignalSL").on("keyup", function(){
          calcPriceSystem();
      });

      $(".shareSignalType").on("change", function(){
          calcPriceSystem();
      });

  });
</script>
<?php } ?>
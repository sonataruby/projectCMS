<?= $this->extend("App\Views\home") ?>
<?= $this->section('main') ?>
    <?= $this->section('javascript') ?>

    <script src="/assets/js/push/push.js?v=2.0.2"></script>
    <script src="/assets/js/socket.io.js?v=2.0.2"></script>
    <script type="text/javascript">



      
      var socket = io("https://expressiq.co", {
        withCredentials: false,
        extraHeaders: {
          "username": "<?php echo user_id();?>"
        }
      });

      socket.on("signal create", function (data) {
        
        var html = `<tr>
                      <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-${data.type == "buy" ? "info" : "danger"} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-${data.type == "buy" ? "up" : "down"}"></i></button>
                            <div class="d-flex flex-column">
                              <h6 class="mb-1 text-dark text-sm">${data.symbol}</h6>
                              <span class="text-xs">${moment().format('D MMM, YYYY')}</span>
                            </div>
                          </div>
                          
                      </td>
                      <td>${data.open}</td>
                      <td>${data.sl}</td>
                      <td>${data.tp}</td>
                      <td>${moment().format('D MMM, YYYY')}</td>
                    </tr>`;
        if($("#tablesignal tbody tr").length > 0){
            $("#tablesignal tbody tr:first").before(html);
        }else{
          $("#tablesignal tbody").append(html);
        }
        if($("#tablesignal tbody tr").length > 5){
          $("#tablesignal tbody tr:last").remove();
        }

        const audio = new Audio("/assets/sound/qcodes_3.mp3" );
        audio.play();

        Push.create(data.symbol + ' Signal', {
          body: data.type + ' '+data.symbol + ' '+data.open,
          timeout: 4000,
          onClick: function () {
              console.log("Fired!");
              window.focus();
              this.close();
          },
          vibrate: [200, 100, 200, 100, 200, 100, 200]
        });

      });
    socket.on("signal finish", function (data) {
        
        var html = `<li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-${data.type == "buy" ? "info" : "danger"}  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-${data.type == "buy" ? "up" : "down"}"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">${data.symbol} ${data.type} ${data.open} </h6>
                      <span class="text-xs">${moment(data.opentime).format('D MMM, YYYY')} - ${moment(data.close_time).format('D MMM, YYYY')}</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-${data.profit_pip > 0  ? "info text-gradient" : (data.profit_pip < 0 ? "danger text-gradient" : "secondary")} text-sm font-weight-bold">
                    ${data.profit_pip > 0  ? "+" : (data.profit_pip < 0 ? "" : ":")} ${data.profit_pip} pip(s) | $${data.profit_usd}
                  </div>
                </li>`;
        if($("#orderComplete ul li").length > 0){
            $("#orderComplete ul li:first").before(html);
        }else{
          $("#orderComplete ul").append(html);
        }
        if($("#orderComplete ul li").length > 10){
          $("#orderComplete ul li:last").remove();
        }
        const audio = new Audio("/assets/sound/qcodes_3.mp3" );
        audio.play();

        Push.create(data.symbol + ' Signal', {
          body: 'Close '+data.symbol + ' '+data.type+' at '+data.close_at,
          timeout: 4000,
          onClick: function () {
              console.log("Fired!");
              window.focus();
              this.close();
          },
          vibrate: [200, 100, 200, 100, 200, 100, 200]
        });

        $(".totalsignal").html(Number(data.sl_total) + Number(data.tp_total));
        $(".pipswin").html(data.tp_total_pips);
        $(".piploss").html(data.tp_total_pips);
        $(".usdwin").html("$"+data.usd_total);
        
      });

    (function(){
        setInterval(function(){
            var html =`<ins class="adsbygoogle" style="display:inline-block;width:100%;height:250px" data-ad-client="ca-pub-4099957745291159" data-ad-slot="1384479382"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>`;
          $(".adsbygoogle").html(html);
        },600000);
    })();
    </script>

    
    <?= $this->endSection() ?>


    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-xl-6 mb-xl-0 mb-4">
              <div class="card bg-transparent shadow-xl">
                <div class="overflow-hidden position-relative border-radius-xl" style="background-image: url('/assets/img/ivancik.jpg');">
                  <span class="mask bg-gradient-dark"></span>
                  <div class="card-body position-relative z-index-1 p-4">
                    <i class="fas fa-wifi text-white p-2"></i> Server connect
                    <h5 class="text-white mt-2 mb-2 pb-2">Smart AI. System trading pro all symbol</h5>
                    <p>Trading time 1-14h GMT +2</p>
                    <div class="d-flex">
                      <div class="d-flex">
                        <div class="me-4">
                          <p class="text-white text-sm opacity-8 mb-0">ECN Broker</p>
                          <h6 class="text-white mb-0">Open Account</h6>
                        </div>
                        <div>
                          <p class="text-white text-sm opacity-8 mb-0">Pro Broker</p>
                          <h6 class="text-white mb-0">Open Account</h6>
                        </div>
                      </div>
                      <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                        <img class="w-40 mt-2 border-radius-lg bg-white p-3" src="/assets/img/logo-ct-dark.png" alt="logo">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="row">
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Signal</h6>
                      <span class="text-xs">Total Number Order</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0 totalsignal"><?php echo ($report->sl_total + $report->tp_total);?></h5>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fab fa-paypal opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Win</h6>
                      <span class="text-xs">Total Pips Win</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0 pipswin"><?php echo ($report->tp_total_pips);?></h5>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fab fa-paypal opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Loss</h6>
                      <span class="text-xs">Total Pips SL</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0 piploss"><?php echo ($report->sl_total_pips);?></h5>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mt-md-0 mt-4">
                  <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fab fa-paypal opacity-10"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">USD</h6>
                      <span class="text-xs">Total USD</span>
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0 usdwin">$<?php echo ($report->usd_total);?></h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
      </div>
      <div class="row">
        <div class="col-lg-7 mt-4">
          
          
            <div class="row mb-3">
              <div class="col-lg-3 col-md-6">
                <div class="card card-body mb-3">
                  <div class="d-flex justify-content-between">
                      <div>Order  <h6 class="mb-0"><?php echo ($report->daily->numsig);?></h6></div>
                      <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                      </div>
                  </div>
                  
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card card-body mb-3">
                  <div class="d-flex justify-content-between">
                      <div>Win  <h6 class="mb-0"><?php echo ($report->daily->win);?> <span class="text-xs">pips</span></h6></div>
                      <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card card-body mb-3">
                  <div class="d-flex justify-content-between">
                      <div>Loss  <h6 class="mb-0"><?php echo ($report->daily->loss);?> <span class="text-xs">pips</span></h6></div>
                      <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card card-body mb-3">
                  <div class="d-flex justify-content-between">
                      <div>USD  <h6 class="mb-0"><?php echo ($report->daily->usd);?> $</h6></div>
                      <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          
            <div class="card mb-3">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-6 d-flex align-items-center">
                  <h6 class="mb-0">Real Signal Daily</h6>
                </div>
                <div class="col-6 text-end">
                  
                  <?php echo components("updateaccount",['text' => '<i class="fas fa-plus"></i>&nbsp;&nbsp;Update VIP', 'class' => 'btn bg-gradient-dark mb-0']);?>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="tablesignal">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Symbol</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Open</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stoploss</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Take Profit</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if(count($data) == 0){
                      ?>
                    <tr>
                      <td colspan="5" class="text-center">No Signal avalible</td>
                    </tr>
                      <?php
                    }
                    foreach($data as $item){?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-<?php echo $item->type == "buy" ? "info" : "danger";?> mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-<?php echo $item->type == "buy" ? "up" : "down";?>"></i></button>
                            <div class="d-flex flex-column">
                              <h6 class="mb-1 text-dark text-sm"><?php echo $item->symbol;?></h6>
                              <span class="text-xs"><?php echo $item->opentime;?></span>
                            </div>
                          </div>
                          
                      </td>
                      <td><?php echo $item->open;?></td>
                      <td><?php echo $item->sl;?></td>
                      <td><?php echo $item->tp;?></td>
                      <td class="text-right"><?php echo $item->status_pips;?> pip | <?php echo $item->status_usd;?>$ <button class="btn btn-icon-only btn-rounded btn-outline-primary mb-0 me-3 btn-sm  align-items-center justify-content-center"><i class="fas fa-arrow-right"></i></button></td>
                    </tr>
                    <?php } 
                    
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card">
              <div class="card-header pb-0 px-3">
                <div class="row">
                  <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Real Signal Week</h6>
                  </div>
                  <div class="col-6 text-end">
                    
                    <?php echo components("admin\create_signal",['text' => '<i class="fas fa-plus"></i>&nbsp;&nbsp;Share Signal', 'class' => 'btn bg-gradient-dark mb-0']);?>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <?php 
                    if(count($week) == 0){
                      ?>
                    <div class="col-md-12 text-center">
                        <h6 class="mb-1 text-dark text-sm">No Signal Avalible</h6>
                        <span class="text-xs">Wait time open</span>
                    </div>
                      <?php
                   }?>
                  <?php foreach($week as $item){?>
                    <div class="col-md-3">
                        <div class="border border-<?php echo $item->type == "buy" ? "info" : "danger";?> border-radius-xl p-1">
                        <div class="bg-gradient-<?php echo $item->type == "buy" ? "info" : "danger";?> border-radius-xl text-white shadow-primary p-2">
                          <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-light mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-<?php echo $item->type == "buy" ? "up" : "down";?>"></i></button>
                            <div class="d-flex flex-column">
                              <h6 class="mb-1 text-dark text-sm"><?php echo $item->symbol;?></h6>
                              <span class="text-xs"><?php echo $item->opentime;?></span>
                            </div>
                          </div>
                        </div>
                        
                        <div>
                          Open : <?php echo $item->open;?><br>
                          SL : <?php echo $item->sl;?><br>
                          TP : <?php echo $item->tp;?>
                        </div>
                        </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
          </div>


        </div>
        <div class="col-lg-5 mt-4">
          <div class="card mb-4 adsbygoogle">
            
          
          </div>
          <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Last Complete</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                  <i class="far fa-calendar-alt me-2"></i>
                  <small><?php echo date('m-d-Y h:i:s A');?></small>
                </div>
              </div>
            </div>
            <div class="card-body pt-4 p-3">
              
              <ul class="list-group" id="orderComplete">

                <?php foreach($finish as $item){ ?>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-<?php echo $item->type == "buy" ? "info" : "danger";?> mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-<?php echo $item->type == "buy" ? "up" : "down";?>"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm"><?php echo $item->symbol;?> <?php echo strtoupper($item->type);?> (<?php echo strtoupper($item->close_type);?>) : <?php echo $item->close_at;?></h6>
                      <span class="text-xs"><?php echo date("d-m h:i A",$item->opentime);?> - <?php echo date("d-m h:i A",$item->close_time);?></span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-<?php echo $item->profit_pip > 0 ? "info text-gradient " : ($item->profit_pip < 0 ? "danger text-gradient " : "secondary");?> text-sm font-weight-bold">
                    <?php echo $item->profit_pip > 0 ? "+" : ($item->profit_pip < 0 ? "" : ":");?> <?php echo $item->profit_pip;?> pip(s) | $<?php echo $item->profit_usd;?>
                  </div>
                </li>
                <?php } ?>
              </ul>
              
            </div>
          </div>
        </div>
      </div>
     
    </div>

<?= $this->endSection() ?>
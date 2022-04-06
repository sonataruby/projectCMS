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
        
        var html = `<tr class="live-${data.message_id}">
                      <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-${data.type == "buy" ? "info" : "danger"} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-${data.type == "buy" ? "up" : "down"}"></i></button>
                            <div class="d-flex flex-column">
                              <h6 class="mb-1 text-${data.type == "buy" ? "info" : "danger"} text-sm">${data.symbol} [${String(data.type).toUpperCase()}] - <b style="font-size:10px;">(New)</b></h6>
                              <span class="text-xs">${moment().format('D MMM, YYYY')}</span>
                            </div>
                          </div>
                          
                      </td>
                      <td>${data.open}</td>
                      <td>${data.sl}</td>
                      <td>${data.tp}</td>
                      <td class="text-end price-${data.message_id}">0.0</td>
                    </tr>`;
        if(data.timefream == "M5" || data.timefream == "M1"){
            if($("#tablesignal tbody tr").length > 0){
              $("#tablesignal tbody tr:first").before(html);
            }else{
              $("#tablesignal tbody").append(html);
            }
            if($("#tablesignal tbody tr").length > 5){
              $("#tablesignal tbody tr:last").remove();
            }
        }else{
            if($("#tablesignalWeek tbody tr").length > 0){
              $("#tablesignalWeek tbody tr:first").before(html);
            }else{
              $("#tablesignalWeek tbody").append(html);
            }
            if($("#tablesignalWeek tbody tr").length > 5){
              $("#tablesignalWeek tbody tr:last").remove();
            }
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
      var html =`<ins class="adsbygoogle" style="display:inline-block;width:100%;height:250px" data-ad-client="ca-pub-4099957745291159" data-ad-slot="1384479382"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>`;
      $(".adsbygoogle").html(html);
    });
    socket.on("signal finish", function (data) {
        
        var html = `<tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <button class="btn btn-icon-only btn-rounded btn-outline-${data.type == "buy" ? "info" : "danger"} mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-${data.type == "buy" ? "up" : "down"}"></i></button>
                          <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark text-sm">${data.symbol} [${String(data.type).toUpperCase()}]</h6>
                            <span class="text-xs"><?php echo date("d-m h:i A",$item->close_time);?></span>
                          </div>
                        </div>
                      </td>
                      <td>${String(data.close_type).toUpperCase()}</td>
                      <td>${data.close_at}</td>
                      <td class="text-end">
                        <div class="text-${data.profit_pip > 0 ? "info text-gradient" : (data.profit_pip < 0 ? "danger text-gradient " : "secondary")} text-sm font-weight-bold">
                        ${data.profit_pip  > 0 ? "+" : (data.profit_pip < 0 ? "" : ":")} ${data.profit_pip} pip(s) | $${data.profit_usd}
                      </div>
                      </td>
                    </tr>`;
        if($("#orderComplete tbody tr").length > 0){
            $("#orderComplete tbody tr:first").before(html);
        }else{
          $("#orderComplete tbody").append(html);
        }
        if($("#orderComplete tbody tr").length > 10){
          $("#orderComplete tbody tr:last").remove();
        }
        $("tr.live-"+data.message_id).remove();
        
        const audio = new Audio("/assets/sound/qcodes_3.mp3" );
        audio.play();
        /*
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
        */

        $(".totalsignal").html(Number(data.sl_total) + Number(data.tp_total));
        $(".pipswin").html(data.tp_total_pips);
        $(".piploss").html(data.tp_total_pips);
        $(".usdwin").html("$"+data.usd_total);
        
      });

    socket.on("signal price", function (data) {
        for (var i = 0; i < data.length; i++) {
          var color = "text-success";
          var prefix = "+";
          if(Number(data[i].usd) < 0) {
            color = "text-danger";
            prefix = "";
          }
          
          $(".price-"+data[i].id+" h6").parent().attr("class","d-flex flex-column "+color);
          $(".price-"+data[i].id+" h6").html(prefix+data[i].usd+"$");
          $(".price-"+data[i].id+" span").html(prefix+data[i].pips+" pip");
        }
        
    });

    (function(){
        setInterval(function(){
            var html =`<ins class="adsbygoogle" style="display:inline-block;width:100%;height:250px" data-ad-client="ca-pub-4099957745291159" data-ad-slot="1384479382"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>`;
          $(".adsbygoogle").html(html);
         
        },600000);
    })();


     (function(){
        setInterval(function(){
            var getTime = $(".closetime");
            getTime.each((item) => {
                var finishTime = $(item).text();
                //alert(finishTime);
            });
         
        },6000);
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
                    <p>Trading time 1-14h GMT +2 | <?php echo date('m-d-Y H:i A');?></p>
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
                    <tr class="live-<?php echo $item->message_id;?>">
                      <td>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-<?php echo $item->type == "buy" ? "info" : "danger";?> mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-<?php echo $item->type == "buy" ? "up" : "down";?>"></i></button>

                            <div class="d-flex flex-column">
                              <h6 class="mb-1 text-sm text-<?php echo $item->type == "buy" ? "info" : "danger";?>"><?php echo $item->symbol;?> [<?php echo strtoupper($item->type);?>]</h6>
                              <span class="text-xs"><?php echo $item->opentime;?></span>
                            </div>
                          </div>
                          
                      </td>
                      <td><?php echo $item->open;?></td>
                      <td><?php echo $item->sl;?></td>
                      <td><?php echo $item->tp;?></td>
                      <td class="text-end price-<?php echo $item->message_id;?>">

                        <div class="d-flex flex-column">
                          <h6 class="mb-1 text-dark text-sm"><?php echo $item->status_usd;?>$</h6>
                          <span class="text-xs"><?php echo $item->status_pips;?> pip</span>
                        </div>
                      </td>
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


                <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="tablesignalWeek">
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
                    if(count($week) == 0){
                      ?>
                    <tr>
                      <td colspan="5" class="text-center">No Signal avalible</td>
                    </tr>
                      <?php
                    }
                    foreach($week as $item){?>
                    <tr class="live-<?php echo $item->message_id;?>">
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="mb-0 me-3 d-flex align-items-center justify-content-center"><?php echo fxImage($item->symbol);?></div>
                            
                            <div class="d-flex flex-column">
                              <h6 class="mb-1 text-sm text-<?php echo $item->type == "buy" ? "info" : "danger";?>"><?php echo $item->symbol;?> [<?php echo strtoupper($item->type);?>]</h6>
                              <span class="text-xs"><?php echo $item->opentime;?></span>
                            </div>
                          </div>
                          
                      </td>
                      <td><?php echo $item->open;?></td>
                      <td><?php echo $item->sl;?></td>
                      <td><?php echo $item->tp;?></td>
                      <td class="text-end price-<?php echo $item->message_id;?>">

                        <div class="d-flex flex-column">
                          <h6 class="mb-1 text-dark text-sm"><?php echo $item->status_usd;?>$</h6>
                          <span class="text-xs"><?php echo $item->status_pips;?> pip</span>
                        </div>
                      </td>
                    </tr>
                    <?php } 
                    
                    ?>
                  </tbody>
                </table>
              </div>

                
              </div>
          </div>


        </div>
        <div class="col-lg-5 mt-4">
          <div class="card mb-4 adsbygoogle">
            
            <a href="https://one.exness.link/a/tjm6vjm6">
          <img src="https://d3dpet1g0ty5ed.cloudfront.net/EN_0821_INDICES_DEVICE_Want_better_indice_320x50px.jpg" width="100%" class="border-radius-xl"  alt="" />
        </a>
          </div>
          <div class="card mb-4">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="col-md-6">
                  <h6 class="mb-0">Last Complete</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                  <i class="far fa-calendar-alt me-2"></i>
                  <small><?php echo date('d-m h:i A');?></small>
                </div>
              </div>
            </div>
            <div class="card-body pt-4 p-3">
              
              <table class="table align-items-center mb-0" id="orderComplete">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Symbol</th>
                      <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Close</th>
                      
                      <th class="text-secondary opacity-7">Profit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($finish as $item){ ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <button class="btn btn-icon-only btn-rounded btn-outline-<?php echo $item->type == "buy" ? "info" : "danger";?> mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-<?php echo $item->type == "buy" ? "up" : "down";?>"></i></button>
                          <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark text-sm"><?php echo $item->symbol;?> <?php echo strtoupper($item->type);?></h6>
                            <span class="text-xs closetime"><?php echo date("d-m h:i A",$item->close_time);?></span>
                          </div>
                        </div>
                      </td>
                      <td><?php echo strtoupper($item->close_type);?></td>
                      <td><?php echo $item->close_at;?></td>
                      <td class="text-end">
                        <div class="text-<?php echo $item->profit_pip > 0 ? "info text-gradient " : ($item->profit_pip < 0 ? "danger text-gradient " : "secondary");?> text-sm font-weight-bold">
                        <?php echo $item->profit_pip > 0 ? "+" : ($item->profit_pip < 0 ? "" : ":");?> <?php echo $item->profit_pip;?> pip(s) | $<?php echo $item->profit_usd;?>
                      </div>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
              </table>
              
              
            </div>
          </div>
        </div>
      </div>
     
    </div>

<?= $this->endSection() ?>
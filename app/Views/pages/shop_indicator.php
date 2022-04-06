<?= $this->extend("App\Views\home") ?>
<?= $this->section('main') ?>
    <?= $this->section('javascript') ?>
    <?= $this->endSection() ?>


    <div class="container-fluid py-4">
        <div class="card mb-3">
            <div class="card-header border-bottom">
                <h6>Indicator & Robot Shop</h6>
            </div>
            <div class="card-body">

            	<div class="row">
                <div class="col-xl-5 col-lg-6 text-center">
                  <img class="w-100 border-radius-lg shadow-lg mx-auto" src="/assets/img/fx/smartindicator.jpg" alt="chair">
                  
                  <!-- Root element of PhotoSwipe. Must have class pswp. -->
                  <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                    <!-- Background of PhotoSwipe.
It's a separate element, as animating opacity is faster than rgba(). -->
                    <div class="pswp__bg"></div>
                    <!-- Slides wrapper with overflow:hidden. -->
                    <div class="pswp__scroll-wrap">
                      <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                      <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                      <div class="pswp__container">
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                      </div>
                      <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                      <div class="pswp__ui pswp__ui--hidden">
                        <div class="pswp__top-bar">
                          <!--  Controls are self-explanatory. Order can be changed. -->
                          
                          <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                          <!-- element will get class pswp__preloader--active when preloader is running -->
                          <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                              <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                          <div class="pswp__share-tooltip"></div>
                        </div>
                        <div class="pswp__caption">
                          <div class="pswp__caption__center"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5 mx-auto">
                  <h3 class="mt-lg-0 mt-4">Smart Indicator</h3>
                  <div class="rating">
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                  </div>
                  <br>
                  <h6 class="mb-0 mt-3">Price</h6>
                  <h5>$50/Account</h5>
                  <span class="badge badge-success">In Stock</span>
                  <br>
                  <label class="mt-4">Description</label>
                  <ul>
                    <li>System user AI API</li>
                    <li>Can trade all symbol</li>
                    <li>Working all timefream</li>
                    <li>Easy Sutup</li>
                  </ul>
                  <form action="/signal/buysmartindicator" method="post">
                    <div class="row mt-4">
                      <div class="col-lg-12">
                        MT4 ID
                        <input type="number" name="meta_id" required class="form-control">
                      </div>
                    </div>
                  <div class="row mt-4">
                    
                    <div class="col-lg-5">
                      <button class="btn btn-primary mb-0 mt-lg-auto w-100" type="submit" name="button">Buy Now</button>
                    </div>
                  </div>
                  </form>
                </div>
              </div>

                
            </div>

        </div>
        
    </div>

<?= $this->endSection() ?>
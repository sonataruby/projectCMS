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
                  <img class="w-100 border-radius-lg shadow-lg mx-auto" src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/product-thumb.jpg" alt="chair">
                  <div class="my-gallery d-flex mt-4 pt-2" itemscope="" itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
                    <figure class="ms-2 me-3" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                      <a href="/assets/img/product-thumb-1.jpg" itemprop="contentUrl" data-size="500x600">
                        <img class="w-100 min-height-100 max-height-100 border-radius-lg shadow" src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/product-thumb-1.jpg" alt="Image description">
                      </a>
                    </figure>
                    
                  </div>
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
                  <h3 class="mt-lg-0 mt-4">Apple Bundle</h3>
                  <div class="rating">
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star" aria-hidden="true"></i>
                    <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                  </div>
                  <br>
                  <h6 class="mb-0 mt-3">Price</h6>
                  <h5>$1,419</h5>
                  <span class="badge badge-success">In Stock</span>
                  <br>
                  <label class="mt-4">Description</label>
                  <ul>
                    <li>The most beautiful curves of this swivel stool adds an elegant touch to any environment</li>
                    <li>Memory swivel seat returns to original seat position</li>
                    <li>Comfortable integrated layered chair seat cushion design</li>
                    <li>Fully assembled! No assembly required</li>
                  </ul>
                  
                  <div class="row mt-4">
                    <div class="col-lg-5">
                      <button class="btn btn-primary mb-0 mt-lg-auto w-100" type="button" name="button">Buy Now</button>
                    </div>
                  </div>
                </div>
              </div>

                
            </div>

        </div>
        <?php echo components("payment",[""]);?>
    </div>

<?= $this->endSection() ?>
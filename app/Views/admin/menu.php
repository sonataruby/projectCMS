<ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="/">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="/chat">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Chat & Lead Offer</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo admin_url("billing");?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Billing</span>
          </a>
        </li>
        
        

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#AccountManagerMenu" class="nav-link active" aria-controls="AccountManagerMenu" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <i class="ni ni-ungroup text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Member Controller</span>
          </a>
          <div class="collapse" id="AccountManagerMenu">
            <ul class="nav ms-4">
              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("account");?>">
                  
                  <span class="nav-link-text ms-1">Account Manager</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("account");?>">
                  
                  <span class="nav-link-text ms-1">Groups</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("account");?>">
                  
                  <span class="nav-link-text ms-1">Permission</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("account");?>">
                  
                  <span class="nav-link-text ms-1">Role</span>
                </a>
              </li>


            </ul>
          </div>
        </li>


        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#ContentsMenu" class="nav-link active" aria-controls="ContentsMenu" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <i class="ni ni-ungroup text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Contents</span>
          </a>
          <div class="collapse" id="ContentsMenu">
            <ul class="nav ms-4">
              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("posts");?>">
                  
                  <span class="nav-link-text ms-1">Posts</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("category");?>">
                  
                  <span class="nav-link-text ms-1">Category</span>
                </a>
              </li>


              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("tags");?>">
                  
                  <span class="nav-link-text ms-1">Tag's</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("pages");?>">
                  
                  <span class="nav-link-text ms-1">Pages</span>
                </a>
              </li>


              <li class="nav-item">
                <a class="nav-link " href="<?php echo admin_url("posttype");?>">
                  
                  <span class="nav-link-text ms-1">Posts Type</span>
                </a>
              </li>

            </ul>
          </div>
        </li>


        <li class="nav-item">
          <a class="nav-link " href="<?php echo admin_url("settings");?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-cog text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Settings</span>
          </a>
        </li>
        
        
</ul>
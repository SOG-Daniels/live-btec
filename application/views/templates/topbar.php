<?php 
    $imgPath = $this->session->userdata('imgPath');
    // echo "<pre>";
    // print_r($GLOBALS);
    // echo "</pre>";
  
?>
<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4  shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
            
          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="POST" action="<?php echo base_url();?>search">
            <div class="input-group">
              <input type="hidden" name="action" value="search">
              <input type="text" class="form-control bg-light border-0 small applicant" name="name" placeholder="Search for a Client..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a> 
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search" method="POST" action="<?php echo base_url();?>search">
                  <div class="input-group">
                    <input type="hidden" name="action" value="search">
                    <input type="text" class="form-control bg-light border-0 small" name="name" placeholder="Search for a Client..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span  id="notification-count">

                </span>
                <?php 
                    // if (isset($GLOBALS['activeNotificationCount']) && $GLOBALS['activeNotificationCount'] > 0){
                    //   echo '
                    //   <span class="badge badge-danger badge-counter">'.(($GLOBALS['activeNotificationCount'] <= 9)? $GLOBALS['activeNotificationCount'] : '+9').'</span>
                    //   ';
                    // }
                ?>
              </a>
               <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in " aria-labelledby="alertsDropdown" style=" max-height: 600px;
    overflow-y: auto;">
                <h6 class="dropdown-header">
                  Notifications
                </h6>
                <span id="notification-list" > 
                </span>
                <?php 

                // echo date("Y-m-d");
                // echo "<pre>";
                // print_r($notifications);
                // echo "</pre>";

                  // if (!empty($GLOBALS['notifications'])){
                  //   //has notifications
                  //   foreach ($GLOBALS['notifications'] as $notification){
                  //     $date = new DateTime($notification['created_on']);
                  //     echo '
                      
                  //       <a id="notice-'.$notification['event_id'].'"class="dropdown-item d-flex align-items-center notification '.(($notification['was_clicked'] == 1)? 'bg-light': '').'" href="'.base_url().'view-notification/'.$notification['id'].'" >
                  //         <div class="mr-3">
                  //           <div class="icon-circle '.$notification['icon_background_color'].'">
                  //             <i class="'.$notification['icon'].' text-white"></i>
                  //           </div>
                  //         </div>
                  //         <div>
                  //           <div class="small text-gray-500">'.$date->format('F j, Y').'</div>
                  //           '.$notification['notice_title'].' 
                  //         </div>
                  //       </a>
                  //     ';
                  //   }

                  // }else{
                  //   //no notifications
                  //   echo '
                  //   <a class="dropdown-item d-flex align-items-center" href="#">
                  //     <div class="mr-3">
                  //       <div class="icon-circle bg-info">
                  //         <i class="fas fa-info text-white"></i>
                  //       </div>
                  //     </div>
                  //     <div>
                  //       <div class="small text-gray-500">'.date('F j, Y').'</div>
                  //       No notifications you are up to date!
                  //     </div>
                  //   </a>
                  //   ';
                  // }
                ?>
              <h6 class="dropdown-footer">
                  
                </h6>
          <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ucwords($name); ?></span>
                <img class="img-profile rounded-circle" src="<?php echo (isset($imgPath))? base_url().$imgPath : base_url().'upload/default_profile_img.png' ; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo site_url('profile'); ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <!-- <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div  id="page-content" class="container-fluid">
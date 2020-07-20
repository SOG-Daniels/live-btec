
<?php  
$actions = $this->session->userdata('action');
// print_r($actions);
$active = (isset($active))? $active : ' '; 

?>
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion " id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo site_url('dashboard'); ?>">
        
        <div class="sidebar-brand-icon rounded bg-white">
          <!-- <i class="fas fa-laugh-wink"></i> -->
          <img src="<?php echo base_url();?>assets/img/BTEC_Logo.png" alt="BTEC Logo" width="57px" height="55px" overflow="hidden">
        </div>
        <div class="sidebar-brand-text mx-3">Unit of beltraide</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php echo ($active === 'dashboard')? 'active' : ' ';?>">
        <a class="nav-link" href="<?php echo site_url('dashboard') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
     
      <?php 
        if (in_array(1, $actions)){
          echo '
         <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Applicants
      </div>  <li class="nav-item '.(($active === 'addClient')? 'active' : ' ').'">
          
            <a class="btn btn-link nav-link " href="'.site_url('register-applicant').'" >
              <i class="fas fa-fw fa-user-plus "></i>
              <span>Add Applicant</span>
            </a>
          </li>
          ';
        }
      ?>
      <?php 
        if (in_array(5, $actions)){
          echo '
          <li class="nav-item '.(($active === 'applicants')? 'active' : ' ').'">
          
            <a class="btn btn-link nav-link " href="'.site_url('enrolled-list').'" >
              <i class="fas fa-fw fa-users "></i>
              <span>Enrolled List</span>
            </a>
          </li>
          ';
        }
      ?>


      <!-- Nav Item - Tables -->
      <?php 
        
        if (in_array(2, $actions)){
          echo '
          <!-- Divider -->
          <hr class="sidebar-divider">

          <!-- Heading -->
          <div class="sidebar-heading">
            Clients
          </div>
              <li class="nav-item '.(($active === "clientList")? "active" : " ").'">
                <a class="nav-link" href="'.site_url('client-list').'">
                  <i class="fas fa-fw fa-table "></i>
                  <span>Client List</span></a>
              </li>
              ';
        }
      ?>
      <!-- Nav Item - Pages Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
          </div>
        </div>
      </li> -->

      <!-- Divider -->
       <?php 
        if (in_array(3, $actions) || in_array(4, $actions)){
          echo '
          <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
            System Users
            </div>
            <!-- Nav Item - Tables --> 
          ';
        }

     
        if (in_array(3, $actions)){
          echo '
            <li class="nav-item">
            <a class="btn btn-link nav-link'.(($active === 'addUser')? '' : '').'" href="#" data-target="#addUserModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" >
              <i class="fas fa-fw fa-user-plus"></i>
              <span>Add User</span>
            </a>
            </li>';
        }
          ?>
        <?php

        if (in_array(4, $actions)){

          echo '
          <!-- Nav Item - Tables -->
          <li class="nav-item '.(($active === 'userList')? 'active' : ' ').'">
            <a class="nav-link" href="'.site_url('user-list').'">
              <i class="fas fa-fw fa-table "></i>
              <span>User List</span></a>
          </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
            
            ';

        }
        ?>
    <!-- displaying report option on sidebar -->
        <?php

        if (in_array(10, $actions)){
          echo '
          
          <!-- Heading -->
          <div class="sidebar-heading">
            Generate Report
          </div>
              <li class="nav-item '.(($active === "report")? "active" : " ").'">
                <a class="nav-link" href="'.site_url('report').'">
                  <i class="fas fa-fw fa-table "></i>
                  <span>Create Report</span></a>
              </li>
          <!-- Divider -->
          <hr class="sidebar-divider">

              ';
        }
        ?>
      <!-- Nav Item - Tables -->
      <?php 
        
        if (in_array(9, $actions)){
          echo '

          <!-- Heading -->
          <div class="sidebar-heading">
            Program Settings
          </div>
              <li class="nav-item '.(($active === "programSetup")? "active" : " ").'">
                <a class="nav-link" href="'.site_url('program-setup').'">
                  <i class="fas fa-fw fa-cog "></i>
                  <span>Program Setting</span></a>
              </li>
          <!-- Divider -->
          <hr class="sidebar-divider">
              ';
        }

      ?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
     

    </ul>
 <!-- End of Sidebar -->
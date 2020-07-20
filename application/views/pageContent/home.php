<?php 
    // flashdata('message') will only be available once, i.e. its a temporary variable that will be deleted if 
    // the page is reloaded again
    // echo "<pre>";
    // print_r($this->session->userdata());
    // echo "</pre>";
    echo (!empty($this->session->flashdata('message')))? $this->session->flashdata('message') : ' '; 
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<!-- <div class="row">

    <!- Earnings (Monthly) Card Example ->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow-lg h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </div>
    </div>
-->
<div class="row col-12 justify-content-center " >
    
    
    <div class="card shadow">
        <div class="card-body p-4">
            <div id="g-calendar" style="width: 100%;" class="table-responsive">
            </div>

        </div>
    </div>
</div>

<!-- End of Content Row -->
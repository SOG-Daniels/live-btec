<?php 
  echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');
  $actions = $this->session->userdata('action');
  // echo json_encode($cList);
  // echo '<pre>';
  // print_r($cList);
  // echo '</pre>';
?>
<h1 class="h3 mb-2 text-gray-800">Client List</h1>

<!-- styling for the more icon on clients list -->
<style>
  td.details-control {
    text-align:center;
    color:forestgreen;
    cursor: pointer;
  }
  tr.shown td.details-control {
    text-align:center; 
    color:red;
  }
</style>
<!-- DataTales Example -->
<div class="card shadow-lg mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-5 col-md-6">
        <h6 class=" font-weight-bold text-primary">Clients</h6>
      </div>
      <div  class="col-7 col-md-6 d-flex justify-content-end">
        <?php 
          echo (in_array(1, $this->session->userdata('action'))?' 
          <a class="btn btn-primary btn-sm" href="'.base_url().'register-applicant" >
            <i class="fas fa-fw fa-user-plus"></i>
            Add Client
          </a>
          
          ' : '');

        ?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
    <table class="table table-striped" width="100%" class="display" id="dataTable" cellspacing="0">
      <thead class="thead-dark">
          <tr>
              <th></th>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>DOB</th>
              <th>Email</th>
              <th>Phone #</th>
              <?php 
              echo (in_array(2,$actions ) || in_array(7,$actions))? '<th class="text-center">Profile</th>' : '';
              ?>
          </tr>
      </thead>
      <tfoot>
          <tr>
              <th></th>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>DOB</th>
              <th>Email</th>
              <th>Phone #</th>
              <?php 
              echo (in_array(2,$actions ) || in_array(7,$actions))? '<th class="text-center">Profile</th>' : '';
              ?>
          </tr>
      </tfoot>
      </table>
    </div>
  </div>
</div>
<script>

var clist = { "data" : <?php echo json_encode($cList, JSON_HEX_TAG); ?> };
console.log ('client data below');
console.log(clist.data);
// creating view and edit links
var hasView = <?php echo (in_array(2,$this->session->userdata('action')))? 1 : 0;?>;
var hasEdit = <?php echo (in_array(7,$this->session->userdata('action')))? 1 : 0; ?>;
var i;
for (i = 0; i < clist.data.length; i++) {

    var proList = (clist.data[i].bpo === null)? '': clist.data[i].bpo;
    proList += (clist.data[i].bartending === null)? '': ', '+clist.data[i].bartending;
    proList += (clist.data[i].barbering === null)? '': ', '+clist.data[i].barbering;
    proList += (clist.data[i].child_care === null)? '': ', '+clist.data[i].child_care;
    proList += (clist.data[i].computer_basics === null)? '': ', '+clist.data[i].computer_basics;
    proList += (clist.data[i].event_planning === null)? '': ', '+clist.data[i].event_planning;
    proList += (clist.data[i].front_desk === null)? '': ', '+clist.data[i].front_desk;
    proList += (clist.data[i].home_health === null)? '': ', '+clist.data[i].home_health;
    proList += (clist.data[i].house_keeping === null)? '': ', '+clist.data[i].house_keeping;
    proList += (clist.data[i].landscaping === null)? '': ', '+clist.data[i].landscaping;
    proList += (clist.data[i].life_guard === null)? '': ', '+clist.data[i].life_guard;
    proList += (clist.data[i].nail_tech === null)? '': ', '+clist.data[i].nail_tech;
    proList += (clist.data[i].wait_staff === null)? '': ', '+clist.data[i].wait_staff;
    proList += (clist.data[i].admin_assistant === null)? '': ', '+clist.data[i].admin_assistant;

    //adding view and edit links 
    var merge = {
    profile : ((hasView == 1)? '<a href ="<?php echo base_url()?>'+'client-info/'+clist.data[i].id+'">View</a>' : "")+
     ((hasEdit == 1)?'&nbsp&nbsp'+'<a href ="<?php echo base_url()?>'+'edit-client-info/'+clist.data[i].id+'">Edit</a>': "")
    ,
    programs: proList,
    };
    clist.data[i].profile = merge.profile;  
    clist.data[i].programs  = merge.programs;

  
}
//code continues in the datatable-demo.js
//  console.log(clist.data);
</script>
          
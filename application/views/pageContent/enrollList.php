<?php 

  $actions = $this->session->userdata('action');
  echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');


?>
<h1 class="h3 mb-2 text-gray-800">Enrolled List</h1>

<!-- DataTales Example -->
<div class="card shadow-lg mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class=" col-12 col-md-8">
        <h6 class="m-0 font-weight-bold text-primary">Trainees</h6>
      </div>
      <div class="col-12 col-md-4 d-flex justify-content-end">
        <?php 
          echo (in_array(1, $this->session->userdata('action'))?' 
        <a class="btn btn-link btn-primary btn-sm text-light" href="'.base_url().'register-applicant" >
          <i class="fas fa-fw fa-user-plus"></i>
          <span>Add Applicant</span>
        </a>' : '' );
        ?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
    <table class="table table-striped" width="100%" class="display" id="enrolledList" cellspacing="0">
      <thead class="thead-dark">
          <tr>
              <th>#</th>
              <th>Name</th>
              <th>
              <form action="<?php echo base_url();?>" id="trainingList" method="POST">
                  <span class="form-group">
                      <select class="form-control" name="program" id="enrolledProgram" style="width: 100%;" >
                      <option  data-content="All Programs" value="1"  >All Programs</option>
                      <option  data-content="Introduction to Barbering" value="barbering" >Introduction to Barbering</option>
                      <option  data-content="Administrative Assistant" value="admin_assistant" >Administrative Assistant</option>
                      <option  data-content="Bartending" value="bartending" >Bartending</option>
                      <option  data-content="Business Process Outsourcing" value="bpo" >Business Process Outsourcing</option>
                      <option  data-content="Child Care Training" value="child_care" >Child Care Training</option>
                      <option  data-content="Computer's for Everydy Use" value="computer_basics" >Computer's For Everyday Use</option>
                      <option  data-content="Event Palnning" value="event_planning" >Event Planning</option>
                      <option  data-content="Front Desk Training" value="front_desk" >Front Desk Training</option>
                      <option  data-content="Home Health Training" value="home_health" >Home Health Training</option>
                      <option  data-content="House Keeping" value="house_keeping" >House Keeping</option>
                      <option  data-content="Landscaping" value="landscaping" >Landscaping</option>
                      <option  data-content="Life Guard Training" value="life_guard" >Life Guard Training</option>
                      <option  data-content="Nail Tech" value="nail_tech" >Nail Tech</option>
                      <option  data-content="Wait Staff Training" value="wait_staff" >Wait Staff Training</option>
                      </select>
                  </span>
                </form>
              </th>
              <th>Enrolled In </th>
              <th>DOB</th>
              <th>Phone #</th>
              <?php echo (in_array(6, $actions))? '<th>Grades</th>' : '';?>
              <?php echo (in_array(2, $actions) || in_array(7, $actions))? '<th class="text-center">Profile</th>' : '';?>
              
          </tr>
      </thead>
      <tbody id="enrolledListBody">
        <?php  

            // foreach ($enrolledList as $array => $key){
            //   foreach ($key as $data){
               
            //     echo '<tr>';
            //       echo '
            //             <th>'.$data['id'].'</th>
            //             <th>'.$data['first_name'].' '.$data['last_name'].'</th>
            //             <th>'.$data['programme'].'</th>
            //             <th>'.$data['enrolled_in'].'</th>
            //             <th>'.$data['dob'].'</th>
            //             <th>'.$data['mobile_phone'].'</th>
            //             <th><a href="'.base_url().'view-client-grade/'.$data['id'].'">View</a></th>
            //             <th>
            //             <a href="'.base_url().'client-info/'.$data['id'].'">View</a>&nbsp
            //             <a href="'.base_url().'edit-client-info/'.$data['id'].'">Edit</a>
            //             </th>
            //             ';
            //       echo '</tr>';


            //   }


            // }


        ?>

      </tbody>
      <tfoot class="thead-dark">
          <tr>
              <th>#</th>
              <th>Name</th>
              <th>Program</th>
              <th>Enrolled In </th>
              <th>DOB</th>
              <th>Phone #</th>
              <?php echo (in_array(6, $actions)? '<th>Grades</th>' : '');?>
              <?php echo (in_array(2, $actions) || in_array(7, $actions))? '<th class="text-center">Profile</th>' : '';?>
              
          </tr>
      </tfoot>
      </table>
    </div>
  </div>
</div>
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
<script>
var clist;
var data = <?php echo json_encode($enrolledList, JSON_HEX_TAG); ?>;

//checking privileges
var hasGradeEdit = <?php echo (in_array(6,$this->session->userdata('action')))? 1 : 0;?>;
var hasView = <?php echo (in_array(2,$this->session->userdata('action')))? 1 : 0;?>;
var hasEdit = <?php echo (in_array(6,$this->session->userdata('action')))? 1 : 0; ?>;

//setting base_url
var url = "<?php echo base_url()?>";

//loads data to the table
createList(data, url, hasGradeEdit, hasEdit, hasView);


</script>
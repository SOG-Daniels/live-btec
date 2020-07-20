<?php 
//  displaying any message 
 echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');
?>
<h1 class="h3 mb-2 text-gray-800">Settings</h1>
  <div class="row">
    <div class="col-12 col-md-5">
      <!-- DataTales Example -->
      <div class="card shadow-lg mb-4">
        <div class="card-header py-3">
          <div class="row">
            <div class=" col-12 col-md-9">
              <h5 class="m-0 font-weight-bold text-primary">Program/Training Assesment Names</h5>
            </div>
            <div class="col-12 col-md-3 d-flex justify-content-end">
              <button id="saveProSettings" class="btn btn-success btn-sm " type="submit" form="assesNames">
                <i class="fas fa-1x fa-save"></i>
                Save
              </button>
            <!-- <input type="hidden" class="btn btn-link btn-primary" id="triggerConfirmModal" data-toggle="modal" data-target="#modalProgramConfirm"> -->
            </div>
          </div>
        </div>
        <div class="card-body">
          <form id="assesNames" action="<?php echo base_url() ;?>save-assesment-names/" method="POST">
            <label class="font-weight-bold ">Choose a training:</label>
            <!-- <div class="row"> -->
              <span class="form-group">
                  <select class="form-control" name="program" id="programs" style="width: 100%;" >
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
                <br>
                <div id="assesments">
                  <?php 
                    $count = 1;
                    for ($i = 1;$i <= 5; $i++){
                      if (!empty($programInfo['Assesment'.$i])){
                        //splitting the grade data 
                        $assesName = explode(',', $programInfo['Assesment'.$i]);
                        
                        // loading the grade names for the default program selected i.e. introduction to bartending
                        echo '
                          
                          <div id="asses-input'.$i.'" class="row"> 
                            
                            <div class="col-12 col-md-12">
                              <label class="font-weight-bold">Assesment Name:</label>
                              <div class="input-group">
                                <input type="text" class="form-control" name="assesmentName[]" id="assesment1" placeholder="Enter a name...." value="'.$assesName[0].'" required>
                                <span class="input-group-append ">
                                  <span class="input-group-text bg-danger remove-grade"><i class="fa fa-minus text-white"></i></span>
                                </span>
                              </div>
                            </div>
                          </div>
                          
                          ';   
                          $count++;          
                        

                      }
                      // introduction to bartending doesnt have any grade names set yet
                      // so we display a input field requesting to add a grade
                      if ($count === 1){
                        echo '
                          
                          <div id="asses-input'.$count.'" class="row"> 
                            
                            <div class="col-12 col-md-12">
                              <label class="font-weight-bold">Assesment Name:</label>
                              <div class="input-group">
                                <input type="text" class="form-control" name="assesmentName[]" id="assesment1" placeholder="Enter a name..." required>
                                <span class="input-group-append ">
                                  <span class="input-group-text bg-danger remove-grade"><i class="fa fa-minus text-white"></i></span>
                                </span>
                              </div>
                            </div>
                          </div>
                          
                          ';
                          $count++;
                      }
                      

                      
                    }
                  ?>
                </div>
              <!-- </div> -->
                <div class="pt-2 d-flex justify-content-end">
                  <button class="btn btn-link add-more-asses"><i class="fa fa-plus"></i> Add Assesment</button>
                </div>
            </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-7">
      <div class="card shadow-lg mb-4">
        <div class="card-header">
          <div class="row">
            <div class=" col-12 col-md-9">
              <h5 class="m-0 font-weight-bold text-primary">Calendar Event Label</h5>
            </div>
            <div class="col-12 col-md-3 d-flex justify-content-end">
            <button id="saveEventLabels" class="btn btn-success btn-sm " type="submit" form="eventLabelForm">
              <i class="fas fa-1x fa-save"></i>
              Save
            </button>
            <!-- <input type="hidden" class="btn btn-link btn-primary" id="triggerConfirmModal" data-toggle="modal" data-target="#modalProgramConfirm"> -->
            </div>
          </div>
        </div>
        <div class="card-body">
        <form id="eventLabelForm" action="<?php echo base_url();?>save-event-labels/" method="POST">
        <div class="alert alert-secondary" role="alert">
          <span><i class="fa fa-info-circle"></i></span> Enable notification so Users get notified upon events added or updated
          for a particular label. (COMING SOON)
        </div>
        <span id="eventLabels">
        <?php 
            $num = 1;
            if (!empty($eventLabels)){
              foreach ($eventLabels as $val){
                
                  echo '
                  <div class="row">
                    <div class="col-12 col-md-4">
                      <div class="form-check pt-2">
                        <input type="checkbox" name="labels[label'.$num.'][sendEmail]" class="form-check-input" value="1" '.(($val['sendEmail'] == 1)? 'checked' : '').'>
                        <label class="form-check-label">Enable Notification</label>
                      </div>
                    </div>
                    <div class="col-12 col-md-8">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                          <input type="hidden" name="labels[label'.$num.'][id]" value="'.$val['id'].'">
                          <input class="from-control eventColor" type="color" id="" name="labels[label'.$num.'][color]" value="'.$val['color'].'">
                          </span>
                        </div>
                        <input type="text" class="form-control" aria-label="Event Label" name="labels[label'.$num.'][name]" value="'.$val['label'].'" required>
                        <div class="input-group-append">
                              <span class="input-group-text bg-danger remove-event-label"><i class="fa fa-minus text-white"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  ';
                  $num++;
              }

            }else{

                echo '
                <div class="row">
                  <div class="col-12 col-md-4">
                      <div class="form-check pt-2">
                        <input type="checkbox" name="labels[label'.$num.'][sendEmail]" class="form-check-input" value="1">
                        <label class="form-check-label">Enable Email Notice</label>
                      </div>
                    </div>
                  <div class="col-12 col-md-12">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                        <input class="from-control eventColor" type="color" name="labels[label'.$num.'][color]" value="">
                        </span>
                      </div>
                      <input type="text" class="form-control" aria-label="Event Label" name="labels[label'.$num.'][name]" value="" required>
                      <div class="input-group-append">
                            <span class="input-group-text bg-danger remove-event-label"><i class="fa fa-minus text-white"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                ';

            }
            
        ?>
        </span>
        </form>
        <div class="pt-2 d-flex justify-content-end">
          <button class="btn btn-link add-new-label"><i class="fa fa-plus"></i> Add New Label</button>
        </div>
        </div>
      </div>
    </div>
  </div>
          <script type="text/javascript">

            //Global Variable used in customJS
            var assesNameForm; 

            var labelNum = <?php echo $num; ?>;

            $(document).ready(function(){

              assesNameForm = $('#assesNames').serialize();//saving the current state of the form
              
              // setting the input count of assesments names
              setInputCount(<?php echo $count;?>);


            });
            
          </script>
          

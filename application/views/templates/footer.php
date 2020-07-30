<!-- End of Page Content -->
</div>
<!-- /.container-fluid -->
</div>

<!-- END OF MAIN CONTENT-->
<?php 

  $isLogin = (isset($isLogin))? $isLogin : 0;

  // lets not display the footer when  the login page is displayed 
  if (!$isLogin){

    echo '
      <footer class="bg-white">
              <div class="container my-auto">
                <div class="copyright text-center my-auto">
                  <span>Copyright &copy; BELTRAIDE '.date('Y').'</span>
                </div>
              </div>
      </footer>
    
    ';

  }

?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- button that scrolls to the top  -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- START OF MODALS -->

<!-- Modal for adding Users -->
 <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="exampleModalLabel">Add a User</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form role="form" action="<?php echo base_url()?>add-user" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" class="form-control" name="fname" id="fname" placeholder="John..." required>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="johndoe@gmail.com..." required>
              </div>
              
              <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="number" class="form-control" name="phone" id="phone" placeholder="6687434..." required>
              </div>
              <!-- <div class="form-group">
                <label for="fname">Username:</label>
                <input type="text" class="form-control" name="uname" id="uname" placeholder="Pudge..." required>
              </div> -->

            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" class="form-control" name="lname" id="lname" placeholder="Doe..." required>
              </div>
                <label class="" for="last_name">Privilege:</label>
              <div class="form-group offset-1">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label>Select All</label>
              </div>
              <div class="form-group" id="privileges">
              <?php 

                $allPrivi = $this->session->userdata('allPrivi');
                $html = '';
                $count = 1;
                                        
                foreach($allPrivi as $priviData){
                    
                    if ($count & 1){
                        //count is odd
                        $html.= '
                        <div class="row offset-1">
                            <div class="col-12 col-md-5 form-check">
                                <input class="form-check-input action" type="checkbox" name="privileges[]" value="'.$priviData['id'].'" id="privi'.$priviData['id'].'" >
                                <label class="form-check-label" for="'.$priviData['name'].'">
                                    '.$priviData['name'].'
                                </label>
                            </div>
                        ';

                    }else{
                        //count is even
                        $html .='
                            <div class="col-12 col-md-5 form-check">
                                <input class="form-check-input action" type="checkbox" name="privileges[]" value="'.$priviData['id'].'" id="privi'.$priviData['id'].'" >
                                <label class="form-check-label" for="'.$priviData['name'].'">
                                    '.$priviData['name'].'
                                </label>
                            </div>
                        </div>
                        ';

                    }
                    $count++;
                }
                if ($count-1 & 1){
                    $html .='
                        </div>
                    ';
                }
               
                echo $html;

              ?>
            
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit">Add User</a>
        </div>
        </form>
      </div>
    </div>
  </div>
<!-- confirmation modal for saving a report -->
<div class="modal fade" id="saveReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="exampleModalLabel">Create a Report Name.</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form id="saveReportForm" action="<?php echo base_url()?>save-report" method="post">
        <div class="modal-body">
          <!-- <input id="query" type="hidden" name="query" value=""> -->
          <textarea id="query" name="query" style="display:none;"><?php echo (isset($query)? $query : '');?></textarea>
          <label class="font-weight-bold">Name the Report:</label>
          <input class="form-control" type="text" name="reportName" required>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
          <button class="btn btn-success" id="confirmSaveReport">Save Report</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!-- confirmation modal for removing enrolled client -->
 <div class="modal fade" id="unenrollClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="exampleModalLabel">Unenroll Client from the Program?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure that you want to unenroll user from the program?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" href="#" id="confirmClientUnenroll">CONFIRM</a>
        </div>
      </div>
    </div>
  </div>
<!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" href="<?php echo site_url('logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>
<!-- Removing Existin Report confirmation Modal-->
 <div class="modal fade" id="removeReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        
          <h5 class="modal-title text-dark" id="exampleModalLabel">Are you sure you want to remove the Existing Report?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "DELETE" if you want to remove the Existing Report.</div>
        
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a id="confirmReportDelete" href="#" class="btn btn-link btn-danger text-white" >DELETE</a>
        </div>
       
      </div>
    </div>
  </div>
<!-- User Delete  Modal-->
 <div class="modal fade" id="modalUserDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        
          <h5 class="modal-title text-dark" id="exampleModalLabel">Are you sure you want to remove this User?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "DELETE" below to confirm removal of User.</div>
        
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a id="confirmUserDelete" href="#" class="btn btn-link btn-danger text-white" >DELETE</a>
        </div>
       
      </div>
    </div>
  </div>
<!-- Program completion Confimation Modal-->
 <div class="modal fade" id="modalProgramConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        
          <h5 class="modal-title text-dark" id="confirmprogramcom">Are you sure you're ready to submit?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "CONFIRM" below to confirm Client Completion.</div>
        
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a id="confirmProgComp" href="#" class="btn btn-link btn-primary text-white" >CONFIRM</a>
        </div>
       
      </div>
    </div>
  </div>

  <!-- event info/description  Modal -->
<div class="modal fade" id="eventDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title text-primary" id="d-modalTitle">Event </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="saveEventForm">
      <div class="modal-body">
        <input type="hidden" id="eventId" name="eventId" value="">

        <label for="Description" class="font-weight-bold">Start Date: </label>
        <span id="d-startDate" class="text-primary"> </span>
        <br>

        <label for="Description" class="font-weight-bold">End Date: </label>
        <span id="d-endDate" class="text-primary"> </span> 
          <label for="endDate" class="font-weight-bold d-block">Event Type: </label>
          <div class="form-group">
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="color" value="#ff8000" id="ff8000">
                    <span style="color: #ff8000">Default Event</span>
              </label>
            </div>
          <?php 

            if (!empty($eventLabels)){
              
              foreach ($eventLabels as $key => $array){
                $id = str_replace('#', '', $array['color']);
                echo '
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" id="'.$id.'" class="form-check-input" name="color" value="'.$array['color'].'" >
                      <span style="color: '.$array['color'].'">'.$array['label'].'</span>
                    </label>
                  </div>
                
                ';
                
              }

            }
          ?>
           
          </div>

        <label for="Title" class="font-weight-bold">Title: </label>
        <input type="text" id="d-title" name="title" value="" class="form-control">

        <br>
        <label for="Description" class="font-weight-bold">Description: </label>
        <!-- <input id="d-description" type="text" name="description" class="form-control" value=""> -->
        <textarea id="d-description" type="text" name="description" class="form-control" value="">
         </textarea>
        <br>
        
        <label for="createdBy" class="font-weight-bold">Created By: </label>
        <span id='d-createdBy'  ></span>
        <br>
        <label for="updatedBy" class="font-weight-bold">Updated By: </label>
        <span id='d-updatedBy'  ></span>

      </div>
    </form>
      <div class="modal-footer justify-content-between">
         
            <button type="button" id="deleteEvent" class="btn btn-danger">Delete</button>
            <button type="button" id="saveEvent" class="btn btn-primary ">Save</button>
          
      </div>
    </div>
  </div>
</div>

<!-- calendar modal Modal-->
 <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        
          <h4 class="modal-title text-dark">Create an Event</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form id="eventForm" >
        <div class="modal-body">
          <div class="form-group">
          <label for="startDate" class="font-weight-bold">Start Date: </label>
          <span id="info-startDate" class="text-primary"> </span>
          <br>

          <label for="endDate" class="font-weight-bold">End Date: </label>
          <span id="info-endDate" class="text-primary"> </span>

          <label for="endDate" class="font-weight-bold d-block">Event Type: </label>
          <div class="form-group">
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="color" value="#ff8000" checked>
                    <span style="color: #ff8000;">Event</span>
              </label>
            </div>
          <?php 

            if (!empty($eventLabels)){

              foreach ($eventLabels as $key => $array){
                echo '
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="color" value="'.$array['color'].'" >
                      <span style="color: '.$array['color'].';">'.$array['label'].'</span>
                    </label>
                  </div>
                
                ';
                
              }

            }
          ?>
           
          </div>
            <label class="font-weight-bold" for="eTitle">Event Title:</label>
            <input class="form-control" type="text" id="eTitle" name="title" placeholder="Enter the an event name..." required>
            <br>
            <input class="form-control" id="startDate" type="hidden" name="startDate" value="">
            <input class="form-control" id="endDate" type="hidden" name="endDate" value="">
            <label class="font-weight-bold" for="eTitle">Event Description:</label>
            <textarea class="form-control" id="eDescription" name="description" placeholder="Enter a description..." ></textarea>
          
          </div>
        </div>
        </form>
        
        <div class="modal-footer">
          <a class="btn btn-secondary text-white" type="button" data-dismiss="modal">Cancel</a>
          <button id="add-cal-event"  class="btn btn-primary">Add Event</button>
        </div>
       
      </div>
    </div>
  </div>
  <!-- Notification Details modal -->
  <!-- <div class="modal fade" id="notice-detail-modal" tabindex="-1" role="dialog" aria-labelledby="notice-detail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-primary" id="notice-detail-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="notice-detail-body" class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!- <button type="button" class="btn btn-primary">Save changes</button> ->
        </div>
      </div>
    </div>
  </div> -->

<!-- !END OF MODALS -->
  
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-fileinput-master/js/fileinput.min.js"></script>
  <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script> -->
  <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/locales/LANG.js"></script> -->
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-fileinput-master/themes/fas/theme.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url()?>assets/js/sb-admin-2.min.js"></script>

  <!-- JQuery JS file used for autocomplete feature -->
  <!-- <script src="<?php echo base_url()?>assets/js/jquery-3.4.1.min.js"></script> -->
  
  <!-- Data Tables plugins -->
  <script src="<?php echo base_url()?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

  <!-- scripts are for datatables to export as PDF -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->

  <!-- script is for the datatables to export as Excel -->
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <!-- <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script> -->

  <!-- Script for column visibility option and copy on datatables -->
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>

  <!-- data picker custom javascript -->
  <!-- <script src="<?php //echo base_url()?>assets/js/bootstrap-datepicker.js"></script> -->
  
  <!-- Summernote plugin -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
  
  <!-- JQuery plugins JS file for autocomplete feature -->
  <script src="<?php echo base_url()?>assets/js/jquery-ui.js"></script>

  <!-- FullCalendar plugins-->
  <script src='<?php echo base_url();?>assets/vendor/fullcalendar/core/main.js'></script>
  <script src='<?php echo base_url();?>assets/vendor/fullcalendar/daygrid/main.js'></script>
  <script src='<?php echo base_url();?>assets/vendor/fullcalendar/interaction/main.js'></script>
  <script src='<?php echo base_url();?>assets/vendor/fullcalendar/timegrid/main.js'></script>
  <script src='<?php echo base_url();?>assets/vendor/fullcalendar/bootstrap/main.js'></script>
  <script src='<?php echo base_url();?>assets/vendor/fullcalendar/list/main.js'></script>

  <!-- Fullcalendar googleCalendar library -->
  <script src="<?php echo base_url()?>assets/vendor/fullcalendar/google-calendar/main.js"></script>

  <!-- FUllCalendar with google calendar custom script -->
  <script src="<?php echo base_url()?>assets/js/gCalendar.js"></script>

  
  <!-- JS file for input files -->
  <script src="<?php echo base_url()?>assets/js/jQuery-file-upload-master.js"></script>
  
  <script type="text/javascript">
      //declaring global variable
      var base_url = "<?php echo base_url(); ?>";
      var calEventId = <?php echo (isset($calEventId)? $calEventId : 0)?>
      
      var PRIVI_SIZE = <?php echo (!empty($this->session->userdata('allPrivi'))? count($this->session->userdata('allPrivi')) : 0);?>;


      //setting up autocomplete by stating the controller that will perform the search
      //the autocomplete plugin will always submit it as a GET method reason being for having the '?' after the 'search'
      $(document).ready(function(e){
        
          //autocompletes search bar
          $( ".applicant" ).autocomplete({
            source: "<?php echo site_url('search?');?>"
          });

          //calling notifcation count update every 1 seconds
          setInterval(function(){
            get_notification_count();
          },
          1000);
      });
     
  </script>
    
</body>
</html>
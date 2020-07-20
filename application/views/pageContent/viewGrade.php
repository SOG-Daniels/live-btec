<?php 
// uncomment the print_r() below to see the program data being passed for the user
// echo "<pre>";
//     print_r($programInfo); 
// echo "</pre>";
 echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');
?>

<a href="<?php echo base_url().'client-info/'.$programInfo[0]['client_id']; ?>" class="btn btn-link "><i class="fa fa-arrow-left"></i> Go back to View Client Profile</a>
          <!-- DataTales Example -->
          <div class="card shadow-lg mb-4">
            <div class="card-header py-3">
              <div class="row">
                <div class=" col-12 col-md-9">
                  <h5 class="m-0 font-weight-bold text-primary"><?php echo $programInfo[0]['programme'] ?></h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                  <div class="col-12 col-md-5">
                        <div class="text-center">
                        <img src="<?php echo isset($programInfo[0]['imgPath'])? base_url().$programInfo[0]['imgPath'] : base_url()."upload/default_profile_img.png";?>" class="avatar rounded img-thumbnail" width="300" height="350">
                        <br>
                        <?php echo '<h3 class="pt-2 text-dark">'.ucwords($programInfo[0]['first_name'].' '.$programInfo[0]['last_name']).'</h3>';?>
                        </div>
                        <h6>
                            <small class="font-weight-bold text-primary">
                            PERSONAL INFORMATION
                            <hr>    
                            </small>        
                        </h6>
                    <div  class="rounded" style="background-color: #F5F5F5 ;">
                    <div class="row pl-4 pt-3">
                        <div class="col-6 ">
                            <div class="form-group">
                                <label for="my-input" class="font-weight-bold d-block " >DoB:</label>
                                <?php echo (isset($programInfo[0]['dob']))? $programInfo[0]['dob'] : 'N/A' ;?>
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="form-group">
                                <label for="my-input" class="font-weight-bold d-block " >Gender:</label>
                                <?php echo (isset($programInfo[0]['gender']))? $programInfo[0]['gender'] : 'N/A' ;?>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row pl-4">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label for="email" class="font-weight-bold d-block " >Email:</label>
                                <?php echo $programInfo[0]['email'];?>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label for="mobile_phone" class="font-weight-bold d-block " >District:</label>
                                <?php echo (isset($programInfo[0]['district']))? $programInfo[0]['district'] : 'N/A' ;?>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row pl-4">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label for="my-input" class="font-weight-bold d-block " >City/Town/Village:</label>
                                <?php echo (isset($clientData[0]['ctv']))? $clientData[0]['ctv'] : 'N/A' ;?>
                            </div>
                        </div>
                        <div class="col-6 col-md-5">
                            <div class="form-group">
                                <label for="mobile_phone" class="font-weight-bold d-block " >Street:</label>
                                <?php echo (isset($clientData[0]['street']))? $clientData[0]['street'] : 'N/A' ;?>
                            </div>
                        </div>
                    
                    </div>

                    <div class="row pl-4">
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label for="mobile_phone" class="font-weight-bold d-block " >Phone Number:</label>
                                <?php echo (isset($programInfo[0]['mobile_phone']))? $programInfo[0]['mobile_phone'] : 'N/A' ;?>
                            </div>
                        </div>
                        <div class="col-6 col-md-5">
                            <div class="form-group">
                                <label for="my-input" class="font-weight-bold d-block " >Home Phone #:</label>
                                <?php echo (isset($programInfo[0]['home_phone']))? $programInfo[0]['home_phone'] : 'N/A' ;?>
                            </div>
                        </div>
          
                    </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-7">
                    <h6>
                        <small class="font-weight-bold text-primary">
                        PROGRAM ASSESMENTS 
                        <hr>    
                        </small>        
                    </h6>
                

                    <div id="assesments"  class="rounded" style="background-color: #F5F5F5 ;">
                      <div class="row pl-3 pr-3 pt-3">
                    <?php 
                    if (!empty($programInfo[0]['Assesment1'])){
                      for ($i = 1;$i <= 5; $i++){

                        if (isset($programInfo[0]['Assesment'.$i])){

                          //spliting assesment data 
                          $assesment = explode(',', $programInfo[0]['Assesment'.$i]);

                          echo '
                            
                          <div class="form-group col-6 col-md-6">
                            <div id="asses-input'.$i.'"> 
                                <label class="font-weight-bold">'.$assesment[0].':</label>
                                  <input type="hidden" name="assesName[]" value = "'.$assesment[0].'">
                                  <span> '.(isset($assesment[1])? $assesment[1]: '' ).'<span>
                            </div>
                          </div>
                            
                            ';   

                        }
                        

                        
                      }
                    }else{
                      
                      echo '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h5>
                        <strong><i class="fa fa-2x fa-exclamation-mark"></i>Notice: </strong> No grades available!.
                        <h5>
                        </div>
                      
                      
                      ';
                    }

                    ?>
                      </div> 
                    </div>
                    <br>
                    <h6>
                        <small class="font-weight-bold text-primary">
                        ADDITIONAL INFO 
                        <hr>    
                        </small>        
                    </h6>
                    <div  class="rounded" style="background-color: #F5F5F5 ;">
                        <div class="row pl-3 pr-3 pt-3">
                            <div class="form-group col-12 col-md-6 ">
                            <label class="font-weight-bold d-block">Pre-Test AVG:</label>
                            <span><?php echo $programInfo[0]['pre_test_avg'];?></span>
                            </div>
                            <div class="form-group col-12 col-md-6 ">
                            <label class="font-weight-bold d-block">Final Average:</label>
                            <span><?php echo $programInfo[0]['final_grade'];?></span>
                            </div>
                            <div class="form-group col-12 col-md-6 ">
                            <label class="font-weight-bold d-block">Course Status:</label>
                            <span><?php echo $programInfo[0]['status'];?></span>
                            </div>
                            <div class="form-group col-12 col-md-6">
                            <label class="font-weight-bold">Graduated On:</label>
                            <span><?php echo $programInfo[0]['graduated_on'];?></span>
                            </div>

                        </div>
                        <div class="form-group col-12">                   
                        <label for="my-textarea" class="font-weight-bold d-block">notes:</label>
                    
                        <textarea id="viewNotes" class="form-control" ></textarea>
                        <br>
                        </div>
                    </div>
                  </div>
                  </div>
                

            </div>
          </div>
          <script type="text/javascript">

            var notes = document.getElementById('viewNotes');
            notes.innerText = '<?php echo isset($programInfo[0]['notes'])? str_replace('\'', '\\\'',$programInfo[0]['notes']): '';?>';

            
            
          </script>
          


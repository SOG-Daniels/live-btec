<?php 
    // displaying a message
    echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');
    $actions = $this->session->userdata('action');
    $ssn = isset($clientData[0]['ssn'])? $clientData[0]['ssn']: 0;
    // echo "<pre>";
    // print_r($clientData);
    // echo "</pre>";
    // echo "<pre>";
    // print_r($programList);
    // echo "</pre>";
    // echo validation_errors();// echo's validation errors made that were stated in the controller for the form
    // echo (isset($addClientMessage))? $addClientMessage : ' ';
 ?>
<a href="<?php echo base_url().'client-info/'.$clientData[0]['id']; ?>" class="btn btn-link "><i class="fa fa-arrow-left"></i> Go to View Client Profile</a>
<div class="card shadow-lg mb-3">
    <div class="card-header py-3">
    <?php
        //@param 1 action location when form is submitted
        //@param 2 attributes for the form tag
        echo form_open_multipart('update-client-info/'.$clientData[0]['id'].'');//so the validations stated in the controller take effect
    ?>    
    <input type="hidden" name="is_enrolled" value="<?php echo (isset($clientData[0]['is_enrolled'])?  $clientData[0]['is_enrolled'] : '')?>">
    <div class="row">
        <div class="col-12 col-md-6">
    <h1 class="h4 mb-2 text-gray-800">Update Client</h1>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-end">
            <button  id="updateClient" class="btn btn-sm btn-success " type="submit"><i class=" fa fa-check"></i> Apply Changes</button>
        </div>
    </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col col-md-6"><!--left col-->
                <div class="text-center">
                    <img id="profilePic" src="<?php echo base_url().((isset($clientData[0]['imgPath']))? $clientData[0]['imgPath'] : 'upload/default_profile_img.png'); ?>" class="avatar rounded img-thumbnail" alt="avatar" width="350" hight="400">
                    <br>
                    
                    <div class="p-image pt-2">
                        <a href="#" id="upload-client-img" class="btn btn-link">
                        <i class="fa fa-camera "></i> Upload Image
                        </a>&nbsp;
                        <span id="remove-img">
                            <a  href="#" id="remove-client-img" class="btn btn-link text-danger" style="<?php echo (($clientData[0]['profile_img_id'] == 1 || empty($clientData[0]['profile_img_id']))? 'display: none': '' ); ?>" >
                            <i class="fa fa-trash"></i> Remove Image
                            </a>
                        </span>
                        <input class="client-img-upload" name="clientImg" type="file" accept="image/*" style="display: none;"/>
                        <input type="hidden" id="imgId" name="imageId" value="<?php echo (($clientData[0]['profile_img_id'] != 1)? $clientData[0]['profile_img_id'] : 1);?>"/>
                    </div>
                </div>
                <br>
                
                <!-- <form class="form" action="<?php //echo base_url()?>register-client" method="post" id="clientInfoForm"> -->
                <input type="hidden" name="action" value="updateClient">
                <input type="hidden" name="userIdent" value="<?php echo $this->session->userdata('userIdentity');?>">

                    <h6>
                        <small class="font-weight-bold text-primary">
                        PERSONAL INFORMATION
                        <hr>    
                        </small>        
                    </h6>
                    <!--Start of personal information form   -->
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">First Name:</label>
                            <input type="text" class="form-control" name="fname" id="fname" value="<?php echo (isset($clientData[0]['first_name'])? $clientData[0]['first_name']: '')?>"  required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Last Name:</label>
                            <input type="text" class="form-control" name="lname" id="lname" value="<?php echo (isset($clientData[0]['last_name'])? $clientData[0]['last_name']: '')?>"  required>
                        </div>
                        <div class="col-12 form-group">
                            <label for="last_name" class="font-weight-bold">Middle Name:</label>
                            <input type="text" class="form-control" name="mname" id="mname" value="<?php echo (isset($clientData[0]['middle_name'])? $clientData[0]['middle_name']: '')?>">
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col col-mb-6">
                            <label for="maritalStatus" class="font-weight-bold">Gender:</label>
                            <div class="form-group pl-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="M" required  <?php echo ((isset($clientData[0]['gender']) && $clientData[0]['gender'] === 'M')? 'checked': '')?>>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="F" <?php echo ((isset($clientData[0]['gender']) && $clientData[0]['gender'] === 'F')? 'checked': '')?>>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col col-mb-6">
                            <label for="dob" class="font-weight-bold">DOB:</label>
                            <input class="form-control" name="dob" type="date" value="<?php echo (isset($clientData[0]['dob'])? $clientData[0]['dob']: '')?>" id="" required>
                        </div>
                    </div>
                    <label for="maritalStatus" class="font-weight-bold">Marital Status:</label>
                    <div class="col-12 col-mb-6">
                           <div class="form-group">
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="maritalStatus" id="single" value="Single" required <?php echo ((isset($clientData[0]['marital_status']) && $clientData[0]['marital_status'] === 'Single')? 'checked': '')?>>
                                    <label class="form-check-label" for="single">Single</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="maritalStatus" id="married" value="Married" <?php echo ((isset($clientData[0]['marital_status']) && $clientData[0]['marital_status'] === 'Married')? 'checked': '')?>>
                                    <label class="form-check-label" for="married">Married</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="maritalStatus" id="commonLaw" value="Common-Law" <?php echo ((isset($clientData[0]['marital_status']) && $clientData[0]['marital_status'] === 'Common-Law')? 'checked': '')?>>
                                    <label class="form-check-label" for="commonLaw">Common-Law</label>
                                </div>
                           </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                                <label for="country" class="font-weight-bold">Country:</label>
                                <input type="text" class="form-control" name="country" id="country" value="<?php echo (isset($clientData[0]['country'])? $clientData[0]['country']: '')?>" required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="exampleFormControlSelect1" class="font-weight-bold">District</label>
                            <select class="form-control" name="district" id=""  onfocus='this.size=6;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <option <?php echo ((isset($clientData[0]['district']) && $clientData[0]['district'] === 'Corozal')? 'selected': '')?> >Corozal</option>
                                <option <?php echo ((isset($clientData[0]['district']) && $clientData[0]['district'] === 'Orange Walk')? 'selected': '')?>>Orange Walk</option>
                                <option <?php echo ((isset($clientData[0]['district']) && $clientData[0]['district'] === 'Cayo')? 'selected': '')?>>Cayo</option>
                                <option <?php echo ((isset($clientData[0]['district']) && $clientData[0]['district'] === 'Belize')? 'selected': '')?>>Belize</option>
                                <option <?php echo ((isset($clientData[0]['district']) && $clientData[0]['district'] === 'Stann Creek')? 'selected': '')?> >Stann Creek</option>
                                <option <?php echo ((isset($clientData[0]['district']) && $clientData[0]['district'] === 'Toledo')? 'selected': '')?> >Toledo</option>
                            </select>
                        </div>
                    </div>
                    <div class=" row form-group">
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">City/Town/Village:</label>
                            <input type="text" class="form-control" name="ctv" id="ctv" value="<?php echo (isset($clientData[0]['ctv'])? $clientData[0]['ctv']: '')?>" required>
                        </div>
                        <div class="col-12 col-md-6">
                                <label for="first_name" class="font-weight-bold">SSN:</label>
                                <!-- <input type="text" class="form-control" name="ssn" id="ssn" data-format="*** *** ***" data-mask="000 000 000" > -->
                                <input type="text" class="form-control" name="ssn" id="ssn" pattern="^\d{3}-\d{3}-\d{3}$" data-format="***-***-***" data-mask="###-###-###" placeholder="000 123 456..."  value="<?php echo ($ssn == '000000000' || $ssn == 0)? '000-000-000' : $ssn;?>">
                                <!-- <input type="text" class="form-control" name="ssn" id="ssn" > -->
                        </div> 
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">Home Phone #:</label>
                            <input type="number" class="form-control" name="homePhone" id="" value="<?php echo (isset($clientData[0]['home_phone'])? $clientData[0]['home_phone']: '')?>" >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">Mobile Phone #:</label>
                            <input type="number" class="form-control" name="mobilePhone" id="" value="<?php echo (isset($clientData[0]['mobile_phone'])? $clientData[0]['mobile_phone']: '')?>" required>
                        </div>
                    </div> 
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="street" class="font-weight-bold">Street Address:</label>
                            <input type="text" class="form-control" name="street" id="" value="<?php echo (isset($clientData[0]['street'])? $clientData[0]['street']: '')?>" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">Email:</label>
                            <input type="text" class="form-control" name="email" id="" value="<?php echo (isset($clientData[0]['email'])? $clientData[0]['email']: '')?>"  required>
                        </div>
                   </div> 
                   <br>
                   <h6>
                        <small class="font-weight-bold text-primary">
                        CURRENT WORK INFORMATION
                        <hr>    
                        </small>        
                    </h6>
                   <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="companyName" class="font-weight-bold">Company Name:</label>
                            <input type="text" class="form-control" name="company_name" id="" value="<?php echo (isset($clientData[0]['employed_at'])? $clientData[0]['employed_at']: '')?>" >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="position" class="font-weight-bold">Position/Job Title:</label>
                            <input type="text" class="form-control" name="postion" id="" value="<?php echo (isset($clientData[0]['em_position'])? $clientData[0]['em_position']: '')?>" required>
                        </div>
                    </div> 
                  
                   <br>
                   <h6>
                        <small class="font-weight-bold text-primary">
                        EDUCATION INFORMATION
                        <hr>    
                        </small>        
                    </h6>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="edName" class="font-weight-bold">Institution Name:</label>
                            <input type="text" class="form-control" name="ed_name" id="" value="<?php echo (isset($clientData[0]['ed_name'])? $clientData[0]['ed_name']: '')?>" >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="schoolLevel" class="font-weight-bold">Highest Level of Education:</label>
                            <input type="text" class="form-control" name="ed_degree" id="" value="<?php echo (isset($clientData[0]['ed_degree'])? $clientData[0]['ed_degree']: '')?>" required>
                        </div>
                    </div> 
                    
            <!--End of personal information col -->
            </div><!--/col-4-->
            <div class="col col-md-6 mt-5">
                    
                    <h6>
                        <small class="font-weight-bold text-primary">
                        EMERGENCY CONTACT INFORMATION
                        <hr>
                        </small>        
                    </h6>
                    
                    <div class="row mb-1 ">
                        <div class="col-12 col-md-6 form-group">
                            <label for="ecName" class="font-weight-bold">Emerg. Contact Name:</label>
                            <input type="text" class="form-control" name="ecName" id="" value="<?php echo (isset($clientData[0]['ec_name'])? $clientData[0]['ec_name']: '')?>"required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="ecNumber" class="font-weight-bold">Emerg. Contact Number:</label>
                            <input type="number" class="form-control" name="ecNumber" id="" value="<?php echo (isset($clientData[0]['ec_number'])? $clientData[0]['ec_number']: '')?>" required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="ecRelation" class="font-weight-bold">Emerg. Contact Relationship:</label>
                            <input type="text" class="form-control" name="ecRelation" value="<?php echo (isset($clientData[0]['ec_relation'])? $clientData[0]['ec_relation']: '')?>" required>
                        </div>
                    </div>
                    <br>
                    <h6>
                        <small class="font-weight-bold text-primary">
                        PERSONAL REFERENCES
                        <hr>
                        </small>        
                    </h6>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">Name <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="text" class="form-control" name="refName1" id="" value="<?php echo (isset($clientData[0]['ref_name1'])? $clientData[0]['ref_name1']: '')?>" required>
                        </div>
                        <div class="col-12 col-md-6 from-group">
                            <label for="last_name" class="font-weight-bold">Address <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="text" class="form-control" name="refAddress1" id="" value="<?php echo (isset($clientData[0]['ref_address1'])? $clientData[0]['ref_address1']: '')?>" required>
                        </div>
                        <div class="col-12 col-md-6 form-group" >
                            <label for="first_name" class="font-weight-bold">City <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="text" class="form-control" name="refCity1" id="" value="<?php echo (isset($clientData[0]['ref_city1'])? $clientData[0]['ref_city1']: '')?>" required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Phone Number <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="number" class="form-control" name="refPhone1" id="" value="<?php echo (isset($clientData[0]['ref_phone1'])? $clientData[0]['ref_phone1']: '')?>"  required>
                        </div>
                    </div>
                    <hr>
                    <div class="row" >
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">Name <small class="font-weight-bold">Ref#2: (optional)</small></label>
                            <input type="text" class="form-control" name="refName2" id="" value="<?php echo (isset($clientData[0]['ref_name2'])? $clientData[0]['ref_name2']: '')?>">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Address <small class="font-weight-bold">Ref#2: (optional)</small></label>
                            <input type="text" class="form-control" name="refAddress2" id="" value="<?php echo (isset($clientData[0]['ref_address2'])? $clientData[0]['ref_address2']: '')?>">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">City <small class="font-weight-bold">Ref#2: (optional)</small></label>
                            <input type="text" class="form-control" name="refCity2" id="" value="<?php echo (isset($clientData[0]['ref_city2'])? $clientData[0]['ref_city2']: '')?>">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Phone Number <small class="font-weight-bold">Ref#2: (optional)  </small></label>
                            <input type="number" class="form-control" name="refPhone2" id="" value="<?php echo (isset($clientData[0]['ref_phone2'])? $clientData[0]['ref_phone2']: '')?>" >
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">Name <small class="font-weight-bold">Ref#3: (optional)</small></label>
                            <input type="text" class="form-control" name="refName3" id="" value="<?php echo (isset($clientData[0]['ref_name3'])? $clientData[0]['ref_name3']: '')?>">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Address <small class="font-weight-bold">Ref#3: (optional)</small></label>
                            <input type="text" class="form-control" name="refAddress3" id="" value="<?php echo (isset($clientData[0]['ref_address3'])? $clientData[0]['ref_address3']: '')?>">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">City <small class="font-weight-bold">Ref#3: (optional)</small></label>
                            <input type="text" class="form-control" name="refCity3" id="" value="<?php echo (isset($clientData[0]['ref_city3'])? $clientData[0]['ref_city3']: '')?>">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Phone Number <small class="font-weight-bold">Ref#3: (optional)</small></label>
                            <input type="number" class="form-control" name="refPhone3" id="" value="<?php echo (isset($clientData[0]['ref_phone3'])? $clientData[0]['ref_phone3']: '')?>" >
                        </div>
                    </div>
                    <br>
                    <h6>
                        <small class="font-weight-bold text-primary">
                        TRAINING PROGRAM TAKEN
                        <hr>
                        </small>        
                    </h6>
                        <?php 
                            $count = 0;

                            foreach ($programList as $program => $data ){
                                if(isset($data[0]['programme'])){
   
   
                                    
                                    echo '
                                    
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="trainings" class="font-weight-bold">Training:</label>
                                                    <select class="form-control"  id="trainings" disabled>
                                                    <option  value="'.$program.'">'.$data[0]['programme'].'</option>
                                                    
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="col-12 col-md-3">
                                                <label for="PreTest" class="font-weight-bold">Status:</label>
                                                <input type="text" class="form-control"  id="preTestAvg" value="'.(isset($data[0]['status'])? $data[0]['status']: '').'" disabled>
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <label for="PreTest" class="font-weight-bold">Year Enrolled:</label>
                                                <input type="number" class="form-control"  id="enrolledIn" value="'.(isset($data[0]['enrolled_in'])? $data[0]['enrolled_in']:'').'" disabled>
                                            </div>
                                            
                    
                                        </div>
                                    
                                    
                                    
                                    
                                    
                                    ';
                                    $count++;
                                }
                            }
                            if ($count == 0){
                                echo '
                                <label for="none" class="font-weight-bold pl-2">NONE</label>

                                ';
                            }




                        ?>

                    <br>
                    <h6>
                        <small class="font-weight-bold text-primary">
                        ADD A NEW TRAINING PROGRAM (Optional)
                        <hr>
                        </small>        
                    </h6>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="trainings" class="font-weight-bold">Trainings:</label>
                                <select class="form-control" name="<?php echo 'programList[newProgram][program]';?>" id="trainings"  onfocus='this.size=7;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <?php
                                //listing out all the options (programs) that the user has not taken. 
                                echo '<option value="none" selected>none</option>';
                                echo (!empty($programList['barbering'][0]))? '' : '<option  value="barbering">Introduction to Barbering</option>';
                                echo (!empty($programList['bartending'][0]))? '' : '<option  value="bartending">Bartending</option>';
                                echo (!empty($programList['admin_assistant'][0]))? '' : '<option  value="admin_assistant">Administrative Assistant</option>';
                                echo (!empty($programList['bpo'][0]))? '' : '<option  value="bpo">Business Process Outsourcing</option>';
                                echo (!empty($programList['child_care'][0]))? '' : '<option  value="child_care">Child Care Training</option>';
                                echo (!empty($programList['computer_basics'][0]))? '' : '<option  value="computer_basics">Computer\'s For Everyday Use</option>';
                                echo (!empty($programList['event_planning'][0]))? '' : '<option  value="event_planning">Event Planning</option>';
                                echo (!empty($programList['front_desk'][0]))? '' : '<option  value="front_desk">Front Desk Training</option>';
                                echo (!empty($programList['home_health'][0]))? '' : '<option  value="home_health">Home Health Training</option>';
                                echo (!empty($programList['house_keeping'][0]))? '' : '<option  value="house_keeping">House Keeping</option>';
                                echo (!empty($programList['landscaping'][0]))? '' : '<option  value="landscaping">Landscaping</option>';
                                echo (!empty($programList['life_guard'][0]))? '' : '<option  value="life_guard">Life Guard Training</option>';
                                echo (!empty($programList['nail_tech'][0]))? '' : '<option  value="nail_tech">Nail Tech</option>';
                                echo (!empty($programList['wait_staff'][0]))? '' : '<option  value="wait_staff">Wait Staff Training</option>';
                                ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="font-weight-bold">Course Status:</label>
                            <select class="custom-select" name="<?php echo 'programList[newProgram][status]';?>" id="courseStatus" onfocus='this.size=4;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <option selected value="Enrolled" checked>Enrolled</option>
                                <option value="Completed">Completed</option>
                                <option value="Dropped">Dropped</option>
                                <option value="Participated">Participated</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="PreTest" class="font-weight-bold">Pre-Test Avg:</label>
                            <input type="number" class="form-control" name="<?php echo 'programList[newProgram][preTestAvg]';?>" id="preTestAvg" placeholder="" >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="PreTest" class="font-weight-bold">Year Enrolled:</label>
                            <input type="number" class="form-control" name="<?php echo 'programList[newProgram][enrolled_in]';?>" id="enrolledIn" value="<?php echo date('Y'); ?>" >
                        </div>
                      

                    </div>
                    
                </form>
            </div><!--/col-8-->
        </div><!--/row-->
    </div>
</div><!--/end of card-->




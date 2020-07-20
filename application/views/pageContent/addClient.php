<?php

    $erros = validation_errors();
    if(isset($errors)){
        echo '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5><strong><i class="fa fa-2x fa-frown"></i> </strong>
            '.$errors.'
        </div>
        ';
    }
 
 echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');

 ?>
<div class="card shadow-lg mb-3">
    <div class="card-header py-3">
    <?php
        //@param 1 action location one form is submitted
        //@param 2 attributes for the form tag
        echo form_open_multipart('register-applicant');
        //form_open_multipart becase we will be passing a file object aswell
    ?>    
    <input type="hidden" name="action" value="addClient">
    <div class="row">
        <div class="col-12 col-md-8">
            <h1 class="h4 mb-2 text-gray-800">Application Form</h1>
        </div>
        <div class="col-12 col-md-4 d-flex justify-content-end">
            <button  id="addClient" class="btn btn-sm btn-primary " type="submit"><i class=" fa fa-user-plus"></i> Add Applicant</button>
        </div>
    </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col col-md-6"><!--left col-->
                <div class="text-center">
                    <img id="appli-img" src="<?php echo base_url()?>upload/default_profile_img.png" class="avatar rounded img-thumbnail" alt="avatar" width="55%" height="60%">
                    <br>
                    <?php //echo isset($clientName)? '<h3 class=" ">'.$clientName.'</h3>' : 'Client Image'; ?>
                    <div class="p-image pt-2">
                        <a href="#" id="upload-client-img">
                        <i class="fa fa-camera "></i> Upload Image
                        </a>
                        <a class="btn btn-ink text-danger" id="remove-appli-img" style="display: none"><i class="fa fa-trash"></i> Remove Image</a>
                        <input class="client-img-upload" name="clientImg" type="file" accept="image/*" style="display: none;"/>
                        
                    </div>
                </div>
                <br>
                
                <!-- <form class="form" action="<?php //echo base_url()?>register-client" method="post" id="clientInfoForm"> -->
                    <!-- <input type="hidden" name="userIdent" value="<?php //echo $this->session->userdata('userIdentity'); ?>"> -->
                    <h6>
                        <small class="font-weight-bold text-primary">
                        PERSONAL INFORMATION
                        <hr>    
                        </small>        
                    </h6>
                    <!--Start of personal information form   -->
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold d-block">First Name:</label>
                            <input type="text" class="form-control" name="fname" id="fname" placeholder="Danielson..."  required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold d-block">Last Name:</label>
                            <input type="text" class="form-control" name="lname" id="lname" placeholder="Correa..."  required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Middle Name:</label>
                            <input type="text" class="form-control" name="mname" id="mname" placeholder="Linito..." >
                        </div>
                        <div class="col col-mb-6">
                            <label for="dob" class="font-weight-bold">DOB:</label>
                            <input class="form-control" name="dob" type="date" value="" id="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-mb-6">
                            <label for="maritalStatus" class="font-weight-bold">Gender:</label>
                            <div class="form-group pl-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="M" checked>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="F">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label for="maritalStatus" class="font-weight-bold">Marital Status:</label>
                    <div class="col-12 col-mb-6">
                           <div class="form-group">
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="maritalStatus" id="single" value="Single" checked>
                                    <label class="form-check-label" for="single">Single</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="maritalStatus" id="married" value="Married">
                                    <label class="form-check-label" for="married">Married</label>
                                </div>
                                <div class="form-check form-check-inline ">
                                    <input class="form-check-input" type="radio" name="maritalStatus" id="commonLaw" value="Common-Law" >
                                    <label class="form-check-label" for="commonLaw">Common-Law</label>
                                </div>
                           </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                                <label for="country" class="font-weight-bold">Country:</label>
                                <input type="text" class="form-control" name="country" id="country" placeholder="Belize..."  required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="exampleFormControlSelect1" class="font-weight-bold">District</label>
                            <select class="form-control" name="district"  onfocus='this.size=6;' onblur='this.size=1;' onchange='this.size=1; this.blur();' >
                                <option>Corozal</option>
                                <option>Orange Walk</option>
                                <option>Cayo</option>
                                <option>Belize</option>
                                <option>Stann Creek</option>
                                <option>Toledo</option>
                            </select>
                        </div>
                    </div>
                    <div class=" row form-group">
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">City/Town/Village:</label>
                            <input type="text" class="form-control" name="ctv" id="ctv" placeholder="Ladyville Village..." required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="street" class="font-weight-bold">Street Address:</label>
                            <input type="text" class="form-control" name="street" id="" placeholder="54 Quilter Avenue..."  required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">Home Phone #:</label>
                            <input type="number" class="form-control" name="homePhone" id="" placeholder="2555454..." >
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">Mobile Phone #:</label>
                            <input type="number" class="form-control" name="mobilePhone" id="" placeholder="6687434..."  required>
                        </div>
                    </div> 
                    <div class="row form-group">
                        <div class="col-12 col-md-6">
                                <label for="first_name" class="font-weight-bold">SSN:</label>
                                <!-- <input type="text" class="form-control" name="ssn" id="ssn" placeholder="000123456..." > -->
                                <input type="text" class="form-control" name="ssn" id="ssn" pattern="^\d{3}-\d{3}-\d{3}$" data-format="***-***-***" data-mask="###-###-###" value="000-000-000">
                                <!-- <input type="text" class="form-control" name="ssn" id="ssn" data-format="*** *** ***" data-mask="--- --- ---" > -->
                        </div> 
                        <div class="col-12 col-md-6">
                            <label for="first_name" class="font-weight-bold">Email:</label>
                            <input type="text" class="form-control" name="email" id="" placeholder="danielsoncorrea@gmail.com..."  required>
                        </div>
                   </div> 
                   <br>
                   <h6>
                        <small class="font-weight-bold text-primary">
                        CURRENT WORK INFO (Optional)
                        <hr>
                        </small>        
                    </h6>
                    
                    <div class="row mb-1">
                        <div class="col-12 col-md-6">
                            <label for="companyName" class="font-weight-bold">Company Name:</label>
                            <input type="text" class="form-control" name="company_name" id="" placeholder="BELTRAIDE..." required>
                        </div>
                        <div class="col-12 col-md-6" >
                            <label for="position" class="font-weight-bold">Position/Job Title:</label>
                            <input type="text" class="form-control" name="position" placeholder="Junior Developer..."  required>
                        </div>
                    </div>

            <!--End of personal information col -->
            </div><!--/col-4-->
            <div class="col col-md-6 mt-5">
                   <h6>
                        <small class="font-weight-bold text-primary">
                        EDUCATION INFORMATION
                        <hr>
                        </small>        
                    </h6>
                    
                    <div class="row mb-1">
                        <div class="col-12 col-md-6">
                            <label for="edName" class="font-weight-bold">Institution Name:</label>
                            <input type="text" class="form-control" name="ed_name" id="" placeholder="University of Belize..." required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="schoolLevel" class="font-weight-bold">Highest Level of Education:</label>
                            <input type="text" class="form-control" name="ed_degree" id="" placeholder="Associates..." required>
                            
                        </div>
                        
                    </div>
                    <br> 
                    <h6>
                        <small class="font-weight-bold text-primary">
                        EMERGENCY CONTACT INFORMATION
                        <hr>
                        </small>        
                    </h6>
                    
                    <div class="row mb-1 ">
                        <div class="col-12 col-md-6 form-group">
                            <label for="ecName" class="font-weight-bold">Emergency Contact Name:</label>
                            <input type="text" class="form-control" name="ecName" id="" placeholder="Abelino Correa..." required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="ecNumber" class="font-weight-bold">Emergency Contact Number:</label>
                            <input type="number" class="form-control" name="ecNumber" id="" placeholder="6687434..."  required>
                        </div>
                        <div class="col-12 col-md-12 form-group">
                            <label for="ecRelation" class="font-weight-bold">Emergency Contact Relationship:</label>
                            <input type="text" class="form-control" name="ecRelation" id="" placeholder="Father..." required>
                        </div>
                    </div>
                    <br>
                    <h6>
                        <small class="font-weight-bold text-primary">
                        PERSONAL REFERENCES
                        <button id="remove-ref" class="btn btn-link btn-sm text-danger"><i class="fa fa-minus"></i></button>
                        <button id="add-more-ref" class="btn btn-link btn-sm text-primary"><i class="fa fa-plus"></i></button>
                        <hr>
                        </small> 
                    </h6>
                    <span id="personalRef">
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">Name <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="text" class="form-control" name="refName1" id="" placeholder="Daniels..." required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Address <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="text" class="form-control" name="refAddress1" id="" placeholder="56 Quilter Avenue..." required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">City <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="text" class="form-control" name="refCity1" id="" placeholder="Belize..." required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Phone Number <small class="font-weight-bold">Ref#1:</small></label>
                            <input type="number" class="form-control" name="refPhone1" id="" placeholder="6687434..."  required>
                        </div>
                    </div>
                    </span>
                    <span id="ref2" style="display: none;">
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">Name <small class="font-weight-bold">Ref#2:</small></label>
                            <input type="text" class="form-control" name="refName2" id="" placeholder="">
                        </div>
                        <div class="col-12 col-md-6 form-group" class="font-weight-bold">
                            <label for="last_name" class="font-weight-bold">Address <small class="font-weight-bold">Ref#2:</small></label>
                            <input type="text" class="form-control" name="refAddress2" id="" placeholder="">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">City <small class="font-weight-bold">Ref#2:</small></label>
                            <input type="text" class="form-control" name="refCity2" id="" placeholder="">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Phone Number <small class="font-weight-bold">Ref#2:</small></label>
                            <input type="number" class="form-control" name="refPhone2" id="" placeholder="" >
                        </div>
                    </div>
                    </span>
                    <span id="ref3" style="display: none;">
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">Name <small class="font-weight-bold">Ref#3:</small></label>
                            <input type="text" class="form-control" name="refName3" id="" placeholder="" >
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Address <small class="font-weight-bold">Ref#3:</small></label>
                            <input type="text" class="form-control" name="refAddress3" id="" placeholder="">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="first_name" class="font-weight-bold">City <small class="font-weight-bold">Ref#3:</small></label>
                            <input type="text" class="form-control" name="refCity3" id="" placeholder="">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="last_name" class="font-weight-bold">Phone Number <small class="font-weight-bold">Ref#3:</small></label>
                            <input type="number" class="form-control" name="refPhone3" id="" placeholder="" >
                        </div>
                    </div>
                    </span>
                    <br>
                    <h6>
                        <small class="font-weight-bold text-primary">
                        TRAINING PROGRAM
                        <hr>
                        </small>        
                    </h6>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label  for="trainings" class="font-weight-bold">Trainings:</label>
                                <select class="form-control" name="program" id="trainings" onfocus='this.size=7;' onblur='this.size=1;' onchange='this.size=1; this.blur();' >
                                <option  value="barbering">Introduction to Barbering</option>
                                <option  value="admin_assistant">Administrative Assistant</option>
                                <option  value="bartending">Bartending</option>
                                <option  value="bpo">Business Process Outsourcing</option>
                                <option  value="child_care">Child Care Training</option>
                                <option  value="computer_basics">Computer's For Everyday Use</option>
                                <option  value="event_planning">Event Planning</option>
                                <option  value="front_desk">Front Desk Training</option>
                                <option  value="home_health">Home Health Training</option>
                                <option  value="house_keeping">House Keeping</option>
                                <option  value="landscaping">Landscaping</option>
                                <option  value="life_guard">Life Guard Training</option>
                                <option  value="nail_tech">Nail Tech</option>
                                <option  value="wait_staff">Wait Staff Training</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="font-weight-bold">Course Status:</label>
                            <select class="custom-select" name="status" id="courseStatus" onfocus='this.size=4;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>
                                <option selected value="Enrolled" checked>Enrolled</option>
                                <option value="Completed">Completed</option>
                                <option value="Dropped">Dropped</option>
                                <option value="Participated">Participated</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="PreTest" class="font-weight-bold">Pre-Test Avg:</label>
                            <input type="number" class="form-control" name="preTestAvg" id="preTestAvg" placeholder="" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="PreTest" class="font-weight-bold">Year Enrolled:</label>
                            <input type="number" class="form-control" name="enrolled_in" id="enrolledIn" value="<?php echo date('Y'); ?>" required>
                        </div>
            
                    </div>
                
                </form>
            </div><!--/col-8-->
        </div><!--/row-->
    </div>
</div><!--/end of card-->



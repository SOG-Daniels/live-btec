<?php 
    $imgPath = $this->session->userdata('imgPath');
    echo (isset($message))? $message : '';
    // echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : ' ');
    
    // echo "<pre>";
    // print_r($profileData);
    // print_r($this->session->userdata());
    // echo "</pre>";
// ?>
<div class="card shadow-lg mb-3">
    <div class="card-header py-3">
        <?php echo isset($name)? '<h3 class="d-inline ">'.$name.'</h3>' : 'Profile'; ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4"><!--left col-->
                <form id="upload-img-form">
                    <input type="hidden" name="userId" value="<?php  echo $this->session->userdata('userid'); ?>"> 
                    <input type="hidden" name="imgId" value="<?php  echo $profileData['profile_img_id']; ?>"> 
                    <input type="hidden" name="fullName" value="<?php  echo $profileData['fname'].$profileData['lname']; ?>"> 
                    
                    <div class="text-center">
                    <img id="user-Profile-Pic" src="<?php echo isset($imgPath)? base_url().$imgPath: base_url()."upload/default_profile_img.png";?>" class="avatar rounded img-thumbnail" width="300px" height="400px">
                    <div class="p-image">
                        <a class="btn btn-link" href="#" id="upload-img" >
                        <i class="fa fa-camera "></i> Upload Image
                        </a>
                        <a href="#" id="remove-user-img" class="btn btn-link text-danger" style="<?php echo (($profileData['profile_img_id'] == 1)? 'display: none': '' ); ?>" >
                        <i class="fa fa-trash"></i> Remove Image
                        </a>
                        <input class="file-upload" name="profileImg" type="file" accept="image/*" style="display: none;"/>
                        
                    </div>
                </form>
              
                </div>
                <br>

            </div><!--/col-3-->
            <div class="col-12 col-md-8">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "data-toggle="tab" href="#changePass" role="tab" aria-controls="changePass" aria-selected="false">Change Password</a>
                    </li>
                </ul>

                
            <div class="tab-content" id="profileTabContent">
                <div class="tab-pane fade show active" id="profile">
                    <br>
            <form class="form" action="<?php echo base_url()?>update-profile" method="post" id="profileForm">
                        
                        <div class="row form-group">
                            <div class="col-12 col-md-6">
                                <label for="first_name" class="font-weight-bold">First Name:</label>
                                <input type="text" class="form-control" name="fname" id="fName" placeholder="" value="<?php echo (isset($profileData['fname']))? $profileData['fname'] : ''; ?>">
                            </div>
                            <div class="col-12 col-md-6 ">
                                <label for="last_name" class="font-weight-bold">Last Name:</label>
                                <input type="text" class="form-control" name="lname" id="lName" placeholder="" value="<?php echo (isset($profileData['lname']))? $profileData['lname'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <!-- <div class="col-12 col-md-6">
                                <label for="first_name" class="font-weight-bold">Username:</label>
                                <input type="text" class="form-control" name="username" id="address" value="<?php echo (isset($profileData['username']))? $profileData['username'] : ''; ?>">
                            </div> -->
                            <div class="col-12 col-md-6">
                                <label for="first_name" class="font-weight-bold">Phone #:</label>
                                <input type="number" class="form-control" name="phone" id="phoneNum" value="<?php echo (isset($profileData['phone']))? $profileData['phone'] : ''; ?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="last_name" class="font-weight-bold d-block" >Email:</label>
                                <span><?php echo(isset($profileData['email'])? $profileData['email']: '');?></span>
                                <!-- <input type="text" class="form-control" name="email" id="last_name" placeholder="someEmail@sog.com..." title="enter your email if any."> -->
                            </div>
                        </div>
                        </form>
                        <br>
                        <span class="float-right d-inline">
                            <button id="editProfile" class="btn btn-sm btn-primary " type="submit"><i class=" fa fa-edit"></i> Edit</button>
                            <button id="saveProfileInfo" style="display:none;" class="btn btn-sm btn-success " type="hidden"><i class=" fa fa-check"></i> Save</button>
                        </span>

                    <!-- </form> -->
                
                </div><!--/tab-pane-->
                
                <div class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab" id="changePass">
                    <br>
                    <form class="form" action="<?php echo base_url()?>change-my-password" method="post" id="registrationForm">
                    <input class="form-control" type="hidden" name="change-pass" value="1">
                       <div class="alert alert-warning" role="alert">
                           <i class="fa fa-exclamation-triangle"></i>
                           New password length must be 8 characters including a upper, lower case letter and a number
                           
                       </div>
                        <div class="row col-12 col-md-6 offset-md-1">
                            <label for="password" class="font-weight-bold">Old Password:</label>
                            <input type="password" class="form-control" name="oldPass" id="oldPass" placeholder="*******" title="enter your password." required>
                        </div>
                        <br>                        
                        <div class="row col-12 col-md-6 offset-md-1">
                            <label for="password2" class="font-weight-bold">New Password:</label>
                            <input type="password" class="form-control" name="newPass" id="newPass" placeholder="*******" title="enter your password2." required>
                        </div>
                        <div id="passRequirement" class=" row col col-md-6 ml-md-5"></div>
                        <br>
                        <div class="row col-12 col-md-6 offset-md-1">
                            <label for="password2" class="font-weight-bold">Confirm New Password:</label>
                            <input type="password" class="form-control" name="confirmPass" id="confirmPass" placeholder="*******" title="enter your password2." required>
                        </div>
                        <div class="registrationFormAlert row col col-md-6 ml-md-5" id="divCheckPasswordMatch">

                        </div>
                        <br>
                        <div class="row col-12 offset-md-1">
                            <button class="btn btn-md btn-primary " id="change-pass-btn" type="submit" disabled><i class=""></i> Change Password</button>
                        </div>
                            
                    </form>
                    </div><!--/tab-pane-->
                </div><!--/col-9-->
            </div><!--/row-->
        </div>
    </div>
</div><!--/end of card-->

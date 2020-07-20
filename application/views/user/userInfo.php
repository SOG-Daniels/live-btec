<?php
    // echo "<pre>";
    // print_r($userData);
    // echo "</pre>";
    $action = $this->session->userdata('action');
?>
<div class="card shadow-lg mb-3">
    <div class="card-header py-3">
        <span class="float-right d-inline">
            <?php
                echo ($userData['status'] == 0)? '<button id="activateUser" class="btn btn-sm btn-success"><i class="fa fa-recycle"></i> Activate User</button>' : '' ;
                
                echo (in_array(8, $action)? '
            <button id="editUser" class="btn btn-sm btn-primary " type="submit"><i class=" fa fa-edit"></i> Edit</button>
                ' : '');
            ?>  
            <button id="saveUserInfo" style="display:none;" class="btn btn-sm btn-success " type="hidden"><i class=" fa fa-check"></i> Save</button>
        </span>
<h1 class="h4 mb-2 text-gray-800">User Information</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4"><!--left col-->
                <form id="upload-img-form-2">
                    <input type="hidden" name="userId" value="<?php  echo $userData['id'] ?>"> 
                    <input type="hidden" name="imgId" value="<?php  echo $userData['profile_img_id']; ?>"> 
                    <input type="hidden" name="fullName" value="<?php  echo $userData['fname'].$userData['lname']; ?>"> 
                    
                    <div class="text-center">
                    <img src="<?php echo isset($userData['imgPath'])? base_url().$userData['imgPath'] : base_url()."upload/default_profile_img.png";?>" class="avatar rounded img-thumbnail" width="250" height="300">
                    <div class="p-image">
                        <a class="btn btn-link" href="#" id="upload-img-2" >
                        <i class="fa fa-camera "></i> Upload Image
                        </a>
                        <a href="#" id="remove-user-img-2" class="btn btn-link text-danger" style="<?php echo (($userData['profile_img_id'] == 1)? 'display: none': '' ); ?>" >
                        <i class="fa fa-trash"></i> Remove Image
                        </a>
                        <input class="file-upload-2" name="profileImg" type="file" accept="image/*" style="display: none;"/>
                        
                    </div>
                </form>
                </div>
                <br>
            </div><!--/col-3-->
            <div class="col-12 col-md-8">
                <form class="form" action="<?php echo base_url().'update-user-profile';?>" method="post" id="userInfoForm">
                        
                        <input type="hidden" id="base" value="<?php echo base_url(); ?>">
                       <input type="hidden" name="action" value="saveUserInfo"> 
                       <input type="hidden" name="userId" value="<?php echo (isset($userData['id'])? $userData['id'] : ' ');  ?>"> 
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First name:</label>
                                    <input type="text" class="form-control" name="fname" id="fname"  value = "<?php echo (isset($userData['fname']))? $userData['fname'] : ' ';?>" required>
                                </div>
                                
                                    <!-- <div class="col-12 col-md-6">
                                        <label for="first_name">Username:</label>
                                        <input type="text" class="form-control" name="username" id="username" value = "<?php //echo (isset($userData['username']))? $userData['username'] : ' ';?>" required>
                                    </div> -->
                                <div class="form-group">
                                    <label for="last_name">Email:</label>
                                    <!-- <p>SOmeEmail@somemail.com</p> -->
                                    <input type="text" class="form-control" name="email"  value = "<?php echo (isset($userData['email']))? $userData['email']: ' ';?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="first_name">Phone #:</label>
                                    <input type="number" class="form-control" name="phone" id="phone" value = "<?php echo (isset($userData['phone']))? $userData['phone'] : ' ';?>" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                
                                <div class="form-group">
                                    <label for="last_name">Last name:</label>
                                    <input type="text" class="form-control" name="lname" id="lname" value = "<?php echo (isset($userData['lname']))? $userData['lname'] : ' ';?>" required>
                                </div>
                                    <?php 
                                        $action = array();
                                        // extracting the privileges from the userdata associative array 
                                        foreach ($userData['action'] as $key => $val){
                                            foreach ($val as $key => $data){
                                                array_push($action, $data);
                                            }
                                        }
                                        
                                        //displaying privilege checkboxes
                                        $html = '
                                        <div class="form-group" >
                                            <label class="" for="last_name">Priviledge:</label>
                                        ';
                                        $count = 1;
                                        
                                        foreach($allPrivi as $priviData){
                                            
                                            if ($count & 1){
                                                //count is odd
                                                $html.= '
                                                <div class="row offset-1">
                                                    <div class="col-12 col-md-5 form-check">
                                                        <input class="form-check-input action" type="checkbox" name="privilege[]" value="'.$priviData['id'].'" id="privil'.$priviData['id'].'" '.( (isset($action) && in_array($priviData['id'], $action) )? 'checked' : '').' disabled>
                                                        <label class="form-check-label" for="'.$priviData['name'].'">
                                                            '.$priviData['name'].'
                                                        </label>
                                                    </div>
                                                ';

                                            }else{
                                                //count is even
                                                $html .='
                                                    <div class="col-12 col-md-5 form-check">
                                                        <input class="form-check-input action" type="checkbox" name="privilege[]" value="'.$priviData['id'].'" id="privil'.$priviData['id'].'"'.( (isset($action) && in_array($priviData['id'], $action))? 'checked' : '').' disabled>
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
                                        echo $html.'</div>';
                                    ?>
                            </div>
                        </div>
                    <!-- </form> -->
                    </form>
                </div><!--/col-9-->
            </div><!--/row-->
        </div>
    <?php 
        if ($userData['status'] == 0){
            echo '
                <form id="activationForm" action="'.base_url().'activate-user"> 
                <input type="hidden" name="userId" value="'.$userData['id'].'" />


                </form>

            ';
        }
    ?>
    </div><!--/end of card-->
    <script>    
        $(document).ready(function(){
            get_UserInfoFormData();
        });

    </script>

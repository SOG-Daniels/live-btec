<?php 
// // uncomment the print_r() below to see the program data being passed for the user
// echo "<pre>";
//     print_r($programInfo); 
//     print_r($existingDocs); 
// echo "</pre>";
// echo "<pre>";
//     print_r($this->session->userdata()); 
// echo "</pre>";
//displaying error message
 echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : '');
?>
<a href="<?php echo base_url().'client-info/'.$programInfo[0]['client_id']; ?>" class="btn btn-link "><i class="fa fa-arrow-left"></i> Go to View Client Profile</a>
<div class="card shadow-lg">
    <?php
        //@param 1 action location one form is submitted
        //@param 2 attributes for the form tag
        echo form_open_multipart(base_url().'client-program-update');
    ?>    

        <input type="hidden" name="programId" value="<?php echo $programInfo[0]['id']?>">
        <input type="hidden" name="program" value="<?php echo $programInfo[0]['program']?>">
        <input type="hidden" name="clientId" value="<?php echo $programInfo[0]['clientId']?>">
        <input type="hidden" name="slug" value="<?php echo $programInfo[0]['slug']?>">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h5 class="m-0 font-weight-bold text-primary">Client Management</h5>
                </div>
                <div class="col-12 col-md-4 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex">
                <div class="col-12 col-md-5">
                    <div class="text-center">
                        <img src="<?php echo isset($programInfo[0]['imgPath'])? base_url().$programInfo[0]['imgPath'] : base_url()."upload/default_profile_img.png";?>" class="avatar rounded img-thumbnail" width="50%" height="auto">
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
                <br>
                <div class="col-12 col-md-7">
                    <h6>
                        <small class="font-weight-bold text-primary">
                        MANAGE PROGRAM DATA
                        <hr>    
                        </small>        
                    </h6>
                    <div  class="rounded pt-3 pl-3 pr-3 pb-1" style="background-color: #F5F5F5 ;">
                    
                        <!-- <div class="form-group">
                            <label class="font-weight-bold" for="customFile">Upload a Certificate:</label>
                            <div class="custom-file">
                                <input type="hidden" name="oldCertificate" value="<?php //echo ((!empty($programInfo[0]['certificate']))? $programInfo[0]['certificate'] : '' ); ?>">
                                <input type="file" class="form-control certificate-file-input" name="certificateFile" id="customFile" accept="application/pdf"  >
                                <label class="custom-file-label" for="customFile"><?php //echo ((!empty($programInfo[0]['certificate']))? $programInfo[0]['certificate'] : 'Upload a PDF...' ); ?> </label>
                            </div>
                        </div> -->
                        
                        <div class="form-group" style="display: <?php echo (in_array(12, $this->session->userdata('action'))? 'block' : 'none')?>;">
                            <label class="font-weight-bold" for="my-select">Employable Status:</label>
                            <select id="my-select" class="form-control" name="isEmployable">
                                <option value="1" <?php echo ($programInfo[0]['is_employable'] == 1)? 'selected': '';?> >Is Employable</option>
                                <option value="0" <?php echo ($programInfo[0]['is_employable'] == 0)? 'selected': '';?> >Not Employable</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="my-textarea" class="font-weight-bold">Notes:</label>
                            <textarea id="programNotes" name="notes" ></textarea>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </form>
</div>
<br>
<div class="card shadow-lg">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">File Management</h5>
    </div>
    <div class="card-body">
       <div class="row">
           <div class="col-12 col-md-12">
                <div class="file-loading">
                    <input id="input-fa" name="input-fa[]" type="file" accept=".jpg,.png,application/pdf,.docx,.ppt" multiple>
                </div>
           </div>
       </div> 
    </div>
</div>
<br>

<div class="card shadow-lg" style="display: <?php echo ((in_array(13, $this->session->userdata('action')) || in_array(14, $this->session->userdata('action')))? 'block': 'none')?>;">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Comments</h5>
    </div>
    <div class="card-body">
        <div class="form-group" style="display: <?php echo (in_array(13, $this->session->userdata('action')) ? 'block': 'none')?>;">
            <div class="row ">
                <div class="col-4 col-md-1" >
                    <img class="rounded-circle" src="<?php echo base_url().$this->session->userdata('imgPath');?>" alt="Profile Pic" width="75%" hight="auto">
                </div>
                    <label for="profileName" class="font-weight-bold d-block d-md-none pt-3"><?php echo $this->session->userdata('name');?></label>
                <div class="col-12 col-md-11" >
                    <form id="commentForm" action="<?php echo base_url();?>enter-comment" >
                    <label for="profileName" class="font-weight-bold d-none d-md-block pt-3 pt-md-0"><?php echo $this->session->userdata('name');?></label>
                    <span id="commentEdit" style="display: none;" >(Edit)</span>  
                    <div class="row pt-1">
                        <input type="hidden" name="clientId" value="<?php echo $programInfo[0]['client_id']?>">
                        <input type="hidden" name="programId" value="<?php echo $programInfo[0]['id']?>">
                        <input type="hidden" name="programName" value="<?php echo $programInfo[0]['program']?>">
                        <input type="hidden" name="userId" value="<?php echo $this->session->userdata('userid');?>">
                        <input type="hidden" id="commentId" value="">
                        <div class="col-9 col-md-10">
                            <!-- <input type="text" name="comment" class="form-control d-inline" >  -->
                            <textarea id="comment" name="comment" rows="1" class="form-control" required></textarea>
                        
                        </div>
                        <div class="d-flex">
                            <button id="postComment" class="btn btn-primary btn-md justify-content-end">Post</button>
                            <span id="editBtn" class="pt-1" style="display: none;">
                                <button id="updateComment" class="btn btn-primary btn-sm" type="button">Update</button>
                                <button id="cancelEdit" class="btn btn-secondary btn-sm" type="button">Cancel</button>
                            </span>
                        </div>
                    </div>
                    <!-- <input type="text" name="comment" class="" style="border: none; border-bottom: 2px solid grey;" width="70" >  -->
                    
                    </form>
                </div>
            </div>
        </div>
        
        <?php 
        if (in_array(13, $this->session->userdata('action')) || in_array(14, $this->session->userdata('action'))){
            //user can create comments or view comments
            foreach ($comments as $commentData){
                $actions = '';
                if(!empty($commentData)){

                    $actions = '
                    <button value="'.$commentData['id'].'" class="btn btn-link text-primary btn-sm editComment"><i class="fa fa-edit"></i>Edit</button>
                    <button value="'.$commentData['id'].'" class="btn btn-link text-danger btn-sm deleteComment"><i class="fa fa-trash"></i>Delete</button>
                    
                    ';
                    echo '
                        <div class="row">
                            <div class="col-4 col-md-1" >
                                <img class="rounded-circle" src="'.base_url().$commentData['userProfilePic'].'" alt="Profile Pic" width="75%" hight="auto">
                            </div>
                                <label for="profileName" class="font-weight-bold d-block d-md-none pt-1">'.$commentData['fname'].' '.$commentData['lname'].''.($commentData['userId'] === $this->session->userdata('userid')? '<br>'.$actions : '').'</label>
                                <div class="col-12 col-md-11" >
                                <label for="profileName" class="font-weight-bold d-none d-md-block pt-3 pt-md-0">'.$commentData['fname'].' '.$commentData['lname'].''.($commentData['userId'] === $this->session->userdata('userid')? $actions : '').'</label>
                                <p id="'.$commentData['id'].'" class="pl-3 pl-md-0">
                                    '.$commentData['comment'].'
                                </p>

                            </div>
                        </div>
                        <br>
                    ';
                }

            }

            
        }


        ?>
        
    </div>
</div>
<script type="text/javascript">
        var notes = document.getElementById('programNotes');
        notes.innerText = '<?php echo isset($programInfo[0]['notes'])? str_replace('\'', '\\\'',$programInfo[0]['notes']): '';?>';

        //used inside the jQuery-file-upload-master js file
        var slug = '<?php echo $programInfo[0]['programme'].'/'.$programInfo[0]['id'].'/'.$programInfo[0]['clientId'];?>';
        var base_url = '<?php echo base_url();?>';
        var existingDocs = <?php echo json_encode($existingDocs);?>;
        
</script>
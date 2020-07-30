<?php 
//user privileges
$actions = $this->session->userdata('action');

$personalInfo = ((isset($clientData[0]))? $clientData[0] : array());
$programs = ((isset($clientData['programs']))? $clientData['programs'] : array());
$mname = (isset($personalInfo['middle_name']))? $personalInfo['middle_name'].' ': '';
$name = (isset($personalInfo['first_name']) && isset($personalInfo['last_name']))? ucfirst($personalInfo['first_name']).' '.ucfirst($mname).ucfirst($personalInfo['last_name']) : '' ;

if (isset($clientData[0]['gender'])){
    $clientData[0]['gender'] = ($clientData[0]['gender'] == 'M')? 'Male' : 'Female';
}

?>
<h1 class="h3 mb-2 text-gray-800">Client Information</h1>

<div class="card shadow-lg mb-3">
    <div class="card-header py-3">
        <div class="row">
        <div class="col-12 col-md-8">
                <?php echo '<h4 class="m-0 text-primary">'.$name.'</h4>';?>
        </div>
        <div  class="col-12 col-md-4 d-flex justify-content-end">
            <?php 
                if (in_array(7, $this->session->userdata('action'))){
                    echo '
                        <a class="btn btn-primary btn-sm" href="'.base_url().'edit-client-info/'.$clientData[0]['id'].'" >
                        <i class="fas fa-fw fa-edit"></i>
                        Edit Profile
                        </a>
                    
                    ';
                }
            ?>
        </div>
        </div>
    
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6"><!--left col-->
                <div class="text-center">
                <img src="<?php echo isset($personalInfo['imgPath'])? base_url().$personalInfo['imgPath'] : base_url()."upload/default_profile_img.png";?>" class="avatar rounded img-thumbnail" width="350" height="400">
                <br>
                </div>
                <br>
            <h6>
                <small class="font-weight-bold text-primary">
                PERSONAL INFORMATION
                <hr>    
                </small>        
            </h6>
            <div class="rounded" style="background-color: #F5F5F5 ;" >
            <div class="row pl-4 pt-3" >
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="my-input" class="font-weight-bold d-block " >DoB:</label>
                        <?php echo (isset($clientData[0]['dob']))? $clientData[0]['dob'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="my-input" class="font-weight-bold d-block " >Gender:</label>
                        <?php echo (isset($clientData[0]['gender']))? $clientData[0]['gender'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="my-input" class="font-weight-bold d-block " >Marital Status:</label>
                        <?php echo (isset($clientData[0]['marital_status']))? $clientData[0]['marital_status'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="email" class="font-weight-bold d-block " >Email:</label>
                        <?php echo $clientData[0]['email'];?>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Phone Number:</label>
                        <?php echo (isset($clientData[0]['mobile_phone']))? substr_replace($clientData[0]['mobile_phone'], '-', 3, 0) : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="form-group">
                        <label for="my-input" class="font-weight-bold d-block " >Home Phone #:</label>
                        <?php echo (isset($clientData[0]['home_phone']))? substr_replace($clientData[0]['home_phone'], '-', 3, 0) : 'N/A' ;?>
                    </div>
                </div>
  
            </div>
            
            <div class="row pl-4">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="my-input" class="font-weight-bold d-block " >Country</label>
                        <?php echo (isset($clientData[0]['country']))? $clientData[0]['country'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >District:</label>
                        <?php echo (isset($clientData[0]['district']))? $clientData[0]['district'] : 'N/A' ;?>
                    </div>
                </div>
            
            </div>
            <div class="row pl-4">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="my-input" class="font-weight-bold d-block " >City/Town/Village:</label>
                        <?php echo (isset($clientData[0]['ctv']))? $clientData[0]['ctv'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Street:</label>
                        <?php echo (isset($clientData[0]['street']))? $clientData[0]['street'] : 'N/A' ;?>
                    </div>
                </div>
            
            </div>
            
            </div>
            <br>
            <h6>
                <small class="font-weight-bold text-primary">
                WORK INFORMATION
                <hr>    
                </small>        
            </h6>
            <div class="rounded" style="background-color: #F5F5F5 ;" >
            <div class="row pl-4 pt-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                            <label for="companyName" class="font-weight-bold d-block " >Company Name:</label>
                        <?php echo (isset($clientData[0]['employed_at']) && $clientData[0]['employed_at'] != '')? $clientData[0]['employed_at'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                            <label for="position" class="font-weight-bold d-block ">Position/Job Title:</label>
                        <?php echo (isset($clientData[0]['em_position']) &&  $clientData[0]['em_position'] != '')? $clientData[0]['em_position'] : 'N/A' ;?>
                    </div>
                </div>
  
            </div>
            </div>
            <br>
            <h6>
                <small class="font-weight-bold text-primary">
                EDUCATION INFORMATION
                <hr>    
                </small>        
            </h6>
            <div class="rounded" style="background-color: #F5F5F5 ;" >
            <div class="row pl-4 pt-3">
                <div class="col-12 col-md-6">
                    <div class="form-group" >
                            <label for="edName" class="font-weight-bold d-block " >Institution Name:</label>
                        <?php echo (isset($clientData[0]['ed_name']) && $clientData[0]['ed_name'] != '')? $clientData[0]['ed_name'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                            <label for="schoolLevel" class="font-weight-bold d-block " >Highest Level of Education</label>
                        <?php echo (isset($clientData[0]['ed_degree']) &&  $clientData[0]['ed_degree'] != '')? $clientData[0]['ed_degree'] : 'N/A' ;?>
                    </div>
                </div>
  
            </div>
            </div>
            </div><!--/col-12 col-md-6-->
            <div class="col-12 col-md-6 ">
            
            <br>
            <h6>
                <small class="font-weight-bold text-primary">
                EMERGENCY CONTACT INFORMATION
                <hr>    
                </small>        
            </h6>
            <div class="rounded" style="background-color: #F5F5F5 ;" >
            <div class="row pl-4 pt-3">
                <div class="col-12 col-md-6 form-group">
                    <label for="ecName" class="font-weight-bold d-block">Emerg. Contact Name:</label>
                        <?php echo (isset($clientData[0]['ec_name']))? $clientData[0]['ec_name'] : 'N/A' ;?>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="ecNumber" class="font-weight-bold d-block">Emerg. Contact Number:</label>
                        <?php echo (isset($clientData[0]['ec_number']))? substr_replace($clientData[0]['ec_number'], '-', 3, 0) : 'N/A' ;?>
                </div>
                <div class="col-12 col-md-6 form-group">
                    <label for="ecRelation" class="font-weight-bold d-block">Emerg. Contact Relationship:</label>
                        <?php echo (isset($clientData[0]['ec_relation']))? $clientData[0]['ec_relation'] : 'N/A' ;?>
                </div>
  
            </div>
            </div>
            <br>
            <h6>
                <small class="font-weight-bold text-primary">
                REFERENCE #1
                <hr>    
                </small>        
            </h6>
            <div class="rounded" style="background-color: #F5F5F5 ;" >
            <div class="row pl-4 pt-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Name:</label>
                        <?php echo (isset($clientData[0]['ref_name1']))? $clientData[0]['ref_name1'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Address:</label>
                        <?php echo (isset($clientData[0]['ref_address1']))? $clientData[0]['ref_address1'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Contact #:</label>
                        <?php echo (isset($clientData[0]['ref_phone1']))? substr_replace($clientData[0]['ref_phone1'], '-', 3, 0) : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >City:</label>
                        <?php echo (isset($clientData[0]['ref_city1']))? $clientData[0]['ref_city1'] : 'N/A' ;?>
                    </div>
                </div>
            </div>
            </div>
            <br>
            <h6>
                <small class="font-weight-bold text-primary">
                REFERENCE #2
                <hr>    
                </small>        
            </h6>
            <div class="rounded" style="background-color: #F5F5F5 ;"> 
            <div class="row pl-4 pt-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Name:</label>
                        <?php echo (isset($clientData[0]['ref_name2']) && $clientData[0]['ref_name2'] != '')? $clientData[0]['ref_name2'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Address:</label>
                        <?php echo (isset($clientData[0]['ref_address2']) && $clientData[0]['ref_address2'] != '' )? $clientData[0]['ref_address2'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Contact #:</label>
                        <?php echo (isset($clientData[0]['ref_phone2']) && $clientData[0]['ref_phone2'] != '')? substr_replace($clientData[0]['ref_phone2'], '-', 3, 0) : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >City:</label>
                        <?php echo (isset($clientData[0]['ref_city2']) && $clientData[0]['ref_city2'] != '')? $clientData[0]['ref_city2'] : 'N/A' ;?>
                    </div>
                </div>
            
            </div>
            </div>
            <br>
            <h6>
                <small class="font-weight-bold text-primary" >
                REFERENCE #3
                <hr>    
                </small>        
            </h6>
            <div class="rounded" style="background-color: #F5F5F5 ;"> 
            <div class="row pl-4 pt-3">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Name:</label>
                        <?php echo (isset($clientData[0]['ref_name3']) && $clientData[0]['ref_name3'] != '')? $clientData[0]['ref_name3'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Address:</label>
                        <?php echo (isset($clientData[0]['ref_address3']) && $clientData[0]['ref_address3'] != '')? $clientData[0]['ref_address3'] : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >Contact #:</label>
                        <?php echo (isset($clientData[0]['ref_phone3']) && $clientData[0]['ref_phone3'] != '')? substr_replace($clientData[0]['ref_phone3'], '-', 3, 0) : 'N/A' ;?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="mobile_phone" class="font-weight-bold d-block " >City:</label>
                        <?php echo (isset($clientData[0]['ref_city3']) && $clientData[0]['ref_city3'] != '')? $clientData[0]['ref_city3'] : 'N/A' ;?>
                    </div>
                </div>
            
            </div>
            </div>
            </div><!--/col-8-->
        </div><!--/row-->
        <br>
        <div class="row">
            <div class="col col-md ml-2">
                <div id="programs">
                <?php
                
                    // preparing to list all the tables that are the programs the client has taken 

                    $tableName = '';
                    $tableHead = '
                        <table class="table table-striped table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Pre Test Avg.</th>
                                <th>Final Grade</th>
                                <th>Enrolled On</th>
                                <th>Program Status</th>
                                <th>Graduated On</th>
                                <th>Notes</th>
                                <th># of Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    // <th>Certificate</th>
                    $tableContent = '';
                    $html = '';

                    foreach ($programs as $program => $data){
                        
                        // print_r($data);
                        $tableContent = '';

                        if (!empty($data)){
                            foreach($data as $val){

                                //snippet of the notes
                                $noteSnippet = '';
                                if (isset($val['notes']) && $val['notes'] != ''){
                                    $noteArray = preg_split('/\s+/', $val['notes']);
                                    $count = 1;
                                    foreach ($noteArray as $key => $word){
                                        if($count <= 7){
                                            $noteSnippet .= $word.' ';
                                        }
                                        $count++;
                                    }
                                    $noteSnippet .= '...';
                                }else{
                                    $noteSnippet = 'N/A';
                                }

                                // setting grade view link that will submit the form 
                                $grade = (in_array(6, $actions)? '
                                <form id="viewGradeForm" action="'.base_url().'view-client-grade/'.str_replace('\'','',str_replace(' ', '-',trim($val['programme']))).'/'.$val['client_id'].'" method="POST" class="d-inline">
                                    <input type="hidden" name="year" value="'.$val['enrolled_in'].'">
                                    <input type="hidden" name="status" value="'.$val['status'].'">
                                    <input type="submit"  class="btn btn-link pt-1" value="View Grades">
                                </form>
                                     
                                ' : '');

                                // setting mangae client link
                                $manageClient = (in_array(11, $actions)? '
                                <a href="'.base_url().'manage-client/'.str_replace('\'', '', str_replace(' ', '-',trim($val['programme']))).'/'.$val['id'].'">Manage Client</a>
                                     
                                ' : '');

                                if($val['status'] == 'Enrolled'){
                                
                                    //setting manage client grade link
                                    $grade = (in_array(6, $actions)? '
                                    <a href="'.base_url().'manage-client-grade/'.str_replace('\'', '', str_replace(' ', '-',trim($val['programme']))).'/'.$val['client_id'].'">Mange Grades</a>
                                        
                                    ' : '');
                                }
                                $tableName = '
                                    <h4 class="font-wieght-bold d-inline">
                                    '.(($val['status'] == 'Enrolled')?'Currently Enrolled in ' : '').'
                                    '.$val['programme'].'
                                    </h4>
                                    &nbsp;
                                    '.$grade.'
                                    &nbsp;
                                    '.$manageClient.'
                                    <hr>
                                ';
                                $tableContent.=' 
                                
                                <tr>
                                <td>'.$val['client_id'].'</td>
                                <td>'.$val['pre_test_avg'].'</td>
                                <td>'.$val['final_grade'].'</td>
                                <td>'.$val['enrolled_in'].'</td>
                                <td>'.$val['status'].'</td>
                                <td>'.$val['graduated_on'].'</td>
                                <td>'.$noteSnippet.'</td>
                                <td>'.$val['commentCount'].'</td>
                                </tr>
                                
                                ';
                            }
                            $html .= $tableName.$tableHead.$tableContent.'
                                
                            </tbody>
                        </table>
                        <br>';      
                        }
                        
                    }
                    echo $html;
                    // <td>'.((!empty($val['certificate']))? 
                    //     '<a href="'.base_url().'upload/certificates/'.$val['certificate'].'" download="'.$clientData[0]['first_name'].'_'.''.$clientData[0]['last_name'].'_Certificate">Download</a>' :
                    //     'N/A').'
                    // </td>


                ?>                   
                </div>
            </div>
        </div>
    </div>
</div><!--/end of card-->



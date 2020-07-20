<div class="card shadow-lg">
        <div class="card-header">
        <h5 class="card-title h4 mb-2 text-gray-800">Search Result for "<em class="text-primary"><?php echo $searchValue?></em>"</h5>
        </div>
    <div class="card-body">
<?php 
        // echo "<pre>";
        // print_r($clientInfo);
        // echo "</pre>";
      
    if (!empty($clientInfo) && $clientInfo != FALSE){

        
        // getting each idividual array inside of $clientInfo
        foreach($clientInfo as $array){

            $view = (in_array(2, $this->session->userdata('action'))? '        
                <a class="btn btn-secondary btn-sm" href="'.base_url().'client-info/'.$array['id'].'"><i class="fa fa-eye"></i> View</a>
                ': '');
            $edit = (in_array(7, $this->session->userdata('action'))? '
                <a class="btn btn-primary btn-sm" href="'.base_url().'edit-client-info/'.$array['id'].'"><i class="fa fa-edit"></i> Edit</a>
            ' : '');

            echo ' 
            
                <div class="card">
                    <div class="card-header">
                        <h5 class="pt-2 d-md-inline">'.ucfirst($array['first_name']).' '.ucfirst($array['last_name']).'</h5>
                        <span class="float-right">
                        '.$view.$edit.'
                        <span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 d-flex justify-content-center pb-2">
                                <img class="rounded" src="'.$array['img_path'].'" alt="Profile Picture" width="70%" hight="55%">
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="row">
                                    <div class="col-12 col-md-6 form-group">
                                        <label for="my-input" class="font-weight-bold d-block ">Email:</label>
                                        '.(isset($array['email'])? $array['email'] : 'N/A').'
                                    </div>
                                    <div class="col-12 col-md-6 form-group">
                                        <label for="my-input" class="font-weight-bold d-block " >Mobile Phone #:</label>
                                        '.(isset($array['mobile_phone'])? substr_replace($array['mobile_phone'], '-', 3, 0) : 'N/A').'
                                    </div>
                                    <div class="col-12 col-md-6 form-group">
                                        <label for="my-input" class="font-weight-bold d-block ">Address:</label>
                                        '.(isset($array['address'])? $array['address'] : 'N/A').'
                                    </div>
                                    <div class="col-12 col-md-6 form-group">
                                        <label for="my-input" class="font-weight-bold d-block " >Gender:</label>
                                        '.(isset($array['gender'])? $array['gender'] : 'N/A').'
                                    </div>
                                    <div class="col-12 col-md-6 form-group">
                                        <label for="my-input" class="font-weight-bold d-block ">Emerg. Contact #:</label>
                                        '.(isset($array['ec_number'])? substr_replace($array['ec_number'], '-', 3, 0) : 'N/A').'
                                    </div>
                                    <div class="col-12 col-md-6 form-group">
                                        <label for="my-input" class="font-weight-bold d-block " >Emerg. Contact Relation:</label>
                                        '.(isset($array['ec_relation'])? $array['ec_relation'] : 'N/A').'
                                    </div>
                                </div>
                                 
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            
            ';            
        }


    }else{
        // the array cameback empty
        echo ' 
        
                <p class="card-text">There was no client by the name of , "'.$searchValue.'" found.</p>
        
        
        ';
    }



?>

    </div>
</div>
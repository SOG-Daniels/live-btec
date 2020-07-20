<?php
    // echo "<pre>";
    // print_r($reportData);
    // echo "</pre>";
?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-12 col-md-8">
            <h5 class="m-0 font-weight-bold text-primary"><?php echo (isset($reportInfo['display_name']) )? $reportInfo['display_name'] : 'Report Result';?></h5>
            
            </div>
            <div class="col-12 col-md-4">
                <span class="d-flex justify-content-end">
                    <?php 
                        echo (isset($saveBtn) && !empty($reportData))? $saveBtn : '';
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="reportDataTable" width="100%" cellspacing="0">

                <thead class="thead-dark">
                <tr>
                    <?php 
                        if (!empty($reportData)){
                            // setting table column names
                            foreach ($reportData[0] as $key => $val){
                                
                                echo  '<th>'.ucfirst($key).'</th>';
                                
                            }
                        }

                        
                        
                    ?>
                </tr>
                </thead>
                
                <tbody>
                <?php 


                if (!empty($reportData)){
                    
                    foreach ($reportData as $key => $array){
                       
                        // setting row results
                        echo '<tr>';
                        foreach ($array as $key => $val){

                            if ($key == 'Employable'){
                                echo ' 
                                    <td>'.(($val == 1)? 'Yes': 'No').'</td>
                                
                                ';

                            }else{

                                echo ' 
                                    <td>'.$val.'</td>
                                
                                ';

                            }
                        }
                        echo '</tr>';
                    

                    }
                }else{
                    echo "<tr class='text-center'>";
                    echo 'There are no records available for this report';
                    echo "</tr>";

                }

                ?>
                
                
                
                </tbody>
            </table>
        </div>
        
    </div>
</div>
<?php echo (isset($userListMessage))? $userListMessage : ' ';
  // echo "<pre>";
  // print_r($userList);
  // echo "</pre>";
  echo (!empty($this->session->flashdata('message'))? $this->session->flashdata('message') : ' ');
?>
<h1 class="h3 mb-2 text-gray-800">User List</h1>

          <!-- DataTales Example -->
          <div class="card shadow-lg mb-4">
            <div class="card-header py-3">
              <div class="row">
                <div class=" col-5 col-md-6">
                  <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                </div>
                <div class="col-7 col-md-6 d-flex justify-content-end">
                <?php 
                if (in_array(3, $this->session->userdata('action'))){
                  echo '<button class="btn btn-primary btn-sm" data-target="#addUserModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" >
                  <i class="fas fa-fw fa-user-plus"></i>
                  <span>Add User</span>
                </button>';
                }
                ?>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="userDataTable" width="100%" cellspacing="0">
      
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Full Name</th>
                      <th>Email </th>
                      <th>Created By</th>
                      <th>Created On</th>
                      <th>Updated By</th>
                      <th>Updated On</th>
                      <th>Profile</th>
                      <th><?php echo (in_array(3, $this->session->userdata('action')) && in_array(8, $this->session->userdata('action')))? 'Action':''; ?></th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  <?php 

                    if (isset($userList)){

                      
                      foreach($userList as $key => $array){

                        $html = '
                        
                          <tr>
                          <td>'.$array->id.'</td>
                          <td>'.$array->fname.' '.$array->lname.'</td>
                          <td>'.$array->email.'</td>
                          <td>'.$array->created_by.'</td>
                          <td>'.$array->created_on.'</td>
                          <td>'.(($array->updated_by == NULL)? 'N/A': $array->updated_by).'</td>
                          <td>'.(($array->updated_on == NULL)? 'N/A' : $array->updated_on).'</td>
                          <td><a class="btn btn-link viewUser" href="'.site_url().'user-info/'.$array->id.'">View </a></td>
                        
                        ';
                        
                        if (in_array(3, $this->session->userdata('action')) && in_array(8, $this->session->userdata('action'))){

                          if ($array->status == 1){
                            $html .='
                                  <td><a id="removeUser" class="btn btn-link text-danger" href="'.site_url().'remove-user/'.$array->id.'" data-toggle="modal" data-target="#modalUserDelete" >Delete </a></td>
                            ';
                          }else{
                            $html .='
                          <form id="activationForm" action="'.base_url().'activate-user" style="display: none;"> 
                          <input type="hidden" name="userId" value="'.$array->id.'" />


                          </form>

                            <td><button id="activateUser" class="btn btn-link text-success"> Activate</button></td>
                            ';

                          }
                        }
                        echo $html.'</tr>';
                      }
                      

                    }

                  ?>
                   
                  
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
<script>
var clist = [];//defining clist so that it does not trigger an error in datatables script upon loading of document
</script>
          
<?php 

class Verification extends CI_Controller{

    // data members
    protected $userEmail;


    // end of data members
    function __contruct(){

        parent::__construct();//calling parent contructor
        //loading session library
        // $this->load->library('session');
        //loading models
        $this->load->model('user_model'); 
        
    }
    // validiation if the user will be able to login or not 
    public function login(){
        
        $data['title'] = 'Login';
        $data['isLogin'] = 1;

        if ( $this->session->has_userdata('userid') ){
            //if session is set lets go to the dashboard 
            redirect('dashboard');

        }else{
            // if login button was clicked
            if(($this->input->post('action')) === 'login'){
                
                $email = $this->input->post('email', TRUE);//second parameter enables XSS Protection
                $pass = $this->input->post('pass', TRUE);
                
                // checking user cridentials
                $result = $this->validation_model->get_user($email, $pass);
                
                if($result === FALSE){
                    // if password and email do not match then we simply print out an error 
                    $data['message'] = '<div class="alert alert-danger" role="alert">
                    Please make sure email and password are correct
                    </div>';

                    $this->session->set_flashdata('message', $data['message']);//setting a message that will only be flashed once to the UI
                    redirect('login');
                   
                }else{

                    // phpinfo();
                    // print_r($result);
                    //passwords matched so we will create a session and assign to it some values
                    $name = $result['fname'].' '.$result['lname'];
                    $userIdentiy = $result['fname'][0].$result['lname'];
                    
                    

                    //setting sessions 
                    $this->session->set_userdata('userIdentity', strtoupper($userIdentiy));
                    $this->session->set_userdata('userid', $result['id']);
                    $this->session->set_userdata('name', $name);
                    $this->session->set_userdata('email', $result['email']);
                    $this->session->set_userdata('imgPath', $result['path']);
                    $this->session->set_userdata('imgId', $result['profile_img_id']);
                    //print_r($this->session->userdata());
                    $actions = array();

                    //setting the privileges to the action array
                    foreach ($result[0] as $key => $arr){
                        foreach ($arr as $key => $val){
                           array_push($actions, $val);
                        }
                    }
                    $allPrivi = $this->user_model->get_all_privileges();

                    //setting user actions/privileges as a session
                    $this->session->set_userdata('action', $actions);
                    
                    // setting all privileges in the session array
                    $this->session->set_userdata('allPrivi', $allPrivi);
                    
                    redirect('dashboard');
                }
            }
            else{
                // // loading the login
                $this->load->view('templates/header', $data);
                $this->load->view('pageContent/login', $data);
                $this->load->view('templates/footer',$data);
               

            }

        }
    }
    // function destroys all session 
    public function logout(){
        
        // checks if there is a session in order to clear the session
        if($this->session->userdata('userid')){
           
            //destroying session 
            // $this->session->unset_userdata($this->session->all_userdata());
            $this->session->sess_destroy();

        }
        $data['title'] = 'Login';
        $data['isLogin'] = 1;

        $this->load->view('templates/header', $data);
        $this->load->view('pageContent/login', $data);
        $this->load->view('templates/footer',$data);

        
    }
    //resets the current password with the new password provided
    public function reset_password(){

        if(!empty($this->input->post()) && !empty($this->input->post('action'))){  

            $newPass = trim($this->input->post('newPass'));
            $confirmPass = trim($this->input->post('confirmPass'));
            $data['message'] = '';

            if($newPass === $confirmPass){
                
                $result = $this->validation_model->get_token_info($this->input->post('resetId'), $this->input->post('token'));
                
                //getting user id 
                $user = $this->validation_model->get_user_by_email($result->email);

                if ($user == FALSE){

                    log_message('debug', 'get_user_by_email() returned false in the verifaction controller change_password()');
                    echo 'error: check log folder';

                }else{
                    
                    $oldToken = (isset($result->token))? $result->token : md5($this->input->post('token'));

                    //setting new password
                    $passwordChangeResult = $this->validation_model->set_new_pass($user->id, $confirmPass);

                    if ($passwordChangeResult == FALSE){
                        //error occured 
                        log_message('debug', 'set_new_pass returned false in change_password() verification controller');
                        $data['message'] .= '<div class="alert alert-danger" role="alert">
                        Password was not changed
                        </div>';
                        
                    }else{
                        $data['message'] .= '<div class="alert alert-success" role="alert">
                        Please login with your new password
                        </div>';
                        
                        $result = $this->validation_model->disable_token($this->input->post('resetId'), $oldToken);

                        if ($result === FALSE){
                            log_message('debug', 'Unable to disable_token in change_password() verification controller');
                        }

                    }
                    $this->session->set_flashdata('message', $data['message']);
                    redirect('login');
                    
                }
            }
        }else{

            redirect('login');
            
        }

    }
    // Will send an email to change change password once user email is in th system
    public function change_password($resetPassID = NULL, $token = NULL){
        
        $data['title'] = 'Change Password';

        $timeInSeconds = date('U');

        $result = $this->validation_model->get_token_info($resetPassID, $token);

        // will execute once when the link is clicked and token has not expired
        if(isset($resetPassID) && isset($token) && !empty($result)){
        
            if ($timeInSeconds <= $result->expiring_date){
                //token still active

                $data['resetId'] = $resetPassID;
                $data ['token'] = $token;

                $this->load->view('templates/header', $data);
                $this->load->view('pageContent/changePass', $data);
                $this->load->view('templates/footer');

            }else{

                $data['title'] = 'Expired Token';
                
                $result = $this->validation_model->disable_token($resetPassID, $result->token);

                $this->load->view('templates/header', $data);
                $this->load->view('pageContent/expiredToken', $data);
                $this->load->view('templates/footer');
            }
        }else{
            redirect('login');
        }



    }
    // will send an email to the users email address with a password reset link 
    public function send_reset_request(){

        $email = (!empty($this->input->post('email'))? trim($this->input->post('email')) : '');
        $userFound = $this->validation_model->get_user_by_email($email);
        $data['message'] = '';
         
        if($userFound != FALSE && isset($email)){
            //email exist

            $hasExistingToken = $this->validation_model->find_token_by_email($email);

            $currentTimeInSec = date('U');

            if (!empty($hasExistingToken) && $currentTimeInSec <= $hasExistingToken->expiring_date){
                //has an active token already
                $data['message'] = '<div class="alert alert-warning" role="alert">
                You already recieved a token. Please check your email follow the instructions.
                </div>';

            }else{
                // print_r($hasExistingToken);
                if (isset($hasExistingToken->id) && $currentTimeInSec > $hasExistingToken->expiring_date){
                    //remove expired link
                    $result = $this->validation_model->disable_token($hasExistingToken->id, $hasExistingToken->token);
                    
                    if ($result == FALSE){
                        log_message('debug', 'Token was not disabled. Error: disable_token() inside email controller.');
                    }
                }

                //no existing token available
                
                //alpahnumeric random string is returned
                $token = random_string('alnum', 10);

                // date('U') give the date in seconds and we add 30 min in seconds to it 
                $expires = date('U') + 1800;

                $result = $this->validation_model->set_pass_reset($email, $token, $expires);
                
                if ($result !== FALSE){
                    
                    $this->custom_email->set_subject('Reset Password');
                    $mess = 'To reset your password <a href="'.base_url().'change-password/'.$result.'/'.$token.'">Click Here</a><br>
                            The link will expire in 30 minutes';

                    $emailResult = $this->custom_email->send_email($email, $mess);

                    if ($emailResult){
                        
                        $data['message'] = '<div class="alert alert-success" role="alert">
                        Please check your email for further instructions. The reset link will expire in 30 minutes.
                        </div>';
                    
                    }else{

                        $data['message'] = '<div class="alert alert-danger" role="alert">
                        Sorry, we could not send the email please try again later.
                        </div>';
                    }

                }else{
                    log_message('debug', 'Error when tring to set_pass_reset() in Email controller, returns: '.$result);
                }

            }

        }else{

            $data['message'] = '<div class="alert alert-danger" role="alert">
            Email Address is not in the system!
            </div>';

        }
        
        // calling the request email form 
        $this->request_email($data);   

    }
    // Function will display a form that ask for email so that they can change password
    public function request_email($data = NULL){

        $data['title'] = 'Forgot Password';

        $this->form_validation->set_rules('email', 'trim|required|max_length[150]');

        $this->load->view('templates/header', $data);
        $this->load->view('pageContent/forgotPass', $data);
        $this->load->view('templates/footer');
        
    }

  

    


}


?>
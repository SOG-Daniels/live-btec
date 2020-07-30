<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // defined('BASEPATH') OR exit('No direct script access allowed');
    // Main Controller manages all the users functionality 
    // meaning, all the users are able to do in the system
    class Main extends CI_Controller{

        //start of data Members//

            protected $data;
            protected $userId;
            protected $username;
            protected $user_actions;
            protected $message;
            protected $programTables;
            protected $userIdent;
            protected $viewQuery;
            protected $notifications;
            protected $activeNotificationCount; 
        //end of data members//

        public function __construct(){
           

            //calls parent contructor and executes what ever is in it. THis is not needed if no construct
            //is created in the child class i.e. the User class
            parent::__construct();

            //loading library
            // $this->load->library('session');
            $this->load->library('custom_email');

            //loading models
            $this->load->model('user_model'); 
            $this->load->model('client_model'); 
            $this->load->model('report_model'); 
            $this->load->model('validation_model'); 

            // echo "<pre>";
            // print_r($this->session->userdata());
            // echo "</pre>";
            // initializing datamembers with session data 
            $this->userId =  $this->session->userdata('userid');
            $this->data['name'] = $this->session->userdata('name');
            $this->user_actions = $this->session->userdata('action');
            $this->userIdent = $this->session->userdata('userIdentity');// signature i.e. first letter name and lastname of current user

            // keeps track of programs as slugs and as table name 
            $this->programTables = array(
                'Introduction-to-Barbering' => 'barbering',
                'Bartending' => 'bartending',
                'Business-Process-Outsourcing' => 'bpo',
                'Child-Care-Training' => 'child_care',
                'Computers-For-Everyday-Use' => 'computer_basics',
                'Event-Planning' => 'event_planning',
                'Front-Desk-Training' => 'front_desk',
                'Home-Health-Training' => 'home_health',
                'House-Keeping' => 'house_keeping',
                'Landscaping' => 'landscaping',
                'Life-Guard-Training' => 'life_guard',
                'Nail-Tech' => 'nail_tech',
                'Wait-Staff-Training' => 'wait_staff',
                'Administrative-Assistant' => 'admin_assistant'
            );
            
            //gets notifcations and sets them to the protected datamembers
            // $this->get_user_notifications();
            
            // $GLOBALS['notifications'] = $this->notifications;
            // $GLOBALS['activeNotificationCount'] = $this->activeNotificationCount;

        }
        /**
         * updated the notifcation in that it was clicked 
         * 
         * @access    public
         * @param     notificationId The id of the notification 
         *
         * @return    NONE 
         */ 
        public function notification_clicked($notificationId = NULL){
            
            if( $this->is_session_set()){
                //setting clicked status to notification

                $set = array(
                    'was_clicked' => 1
                );
                $where = array(
                    'id' => $notificationId
                );
                if(!$this->user_model->update_notification($set, $where)){
                    log_message('debug', 'Update_notification returned false when called in notification_clicked controller method');
                    echo 0;
                }else{
                    echo $notificationId;
                }
                
            }else{
                // //sesion is not set 
                // redirect('login');
                echo -1;
            }
        }
        /**
         * get_dashboard() loads the home view 
         * 
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */ 
        public function get_user_notifications(){
            
            if( $this->is_session_set()){
                
                $this->notifications = $this->user_model->get_all_user_notifications($this->userId);
                $this->activeNotificationCount = 0;
                
                foreach ($this->notifications as $notification){
                    //loping to find all active notifications
                    if ($notification['was_clicked'] == 0){
                        $this->activeNotificationCount++;
                    }
                }
                $data['notifications'] = $this->notifications;
                $data['activeNotificationCount'] = $this->activeNotificationCount;

                echo json_encode($data);

            }else{
                //sesion is not set 
                // redirect('login');
                echo -1;
            }
        }
        /**
         * get_dashboard() loads the home view 
         * 
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */ 
        public function get_dashboard(){//$calEventId = NULL){
    
            if( $this->is_session_set()){
               
                // $this->data['notifications'] = $this->notifications;
                // $this->data['activeNotificationCount'] = $this->activeNotificationCount;
                $this->data['title'] = 'Dashboard';// title of page
                $this->data['active'] = 'dashboard';// setting the dashboard as current option on sidebar
                $this->data['name'] = $this->session->userdata('name');// name of the users that logged 
                $this->data['eventLabels'] = $this->user_model->get_event_labels();
                $this->data['calEventId'] = 0; 
                
                if (isset($calEventId)){
                    $this->data['calEventId'] = $calEventId;
                }

                //displaying the homepage
                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/sidebar', $this->data);
                $this->load->view('templates/topbar', $this->data);
                $this->load->view('pageContent/home', $this->data);//pageContent
                $this->load->view('templates/footer', $this->data);
                

            }else{
                //sesion is not set 
                redirect('login');
            }
        }
        /**
         * profile() displays all info the system has on the user on a view 
         * 
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */ 
        public function profile(){

            if($this->is_session_set()){

                $this->data['title'] = 'Profile';
                $this->data['name'] = $this->session->userdata('name');

                //getting the current users info 
                $result = $this->user_model->get_user_info($this->session->userdata('userid'));

                if ($result === FALSE){
                    //something went wrong trying to get the users info from the modal

                    log_message('debug', 'user_model->get_user_info returned false');// logging error

                    $this->session->set_flashdata('message',
                    '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-frown"></i> Error:</strong>
                        Cannot get your info from the system, please try again later or ask an IT personnel for help.<h5>
                        </div>
                    
                    '
                    ); 
                    redirect('dashboard');
                }

                $this->data['profileData'] = $result;

                //setting the title of the page
                $this->data['title'] = 'profile';

                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/sidebar', $this->data);
                $this->load->view('templates/topbar', $this->data);
                $this->load->view('pageContent/profile', $this->data);
                $this->load->view('templates/footer', $this->data);

            }else{
                //session not set call login page 
                redirect('login');
            }

        }
        /**
         * Will call and populate the view that displays all the applicants in the system
         * 
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */ 
        public function view_enrolled_list(){

            if($this->is_session_set() && in_array(5, $this->user_actions)){
            
                $this->data['title'] = 'Enrolled List';
                $this->data['active'] = 'applicants';

                $this->data['selected'] = '1';
            
                if (!empty($this->input->post('program'))){
                    //echo "<pre>";
                    //echo jason_encode($this->input->post());
                    //echo "</pre>";
                    // Passing the post values with xxs filterig to the get_enrolled_list model
                    $this->data['enrolledList'] = array($this->client_model->get_enrolled_list($this->input->post('program', TRUE)));
                    $this->data['enrolledList']['selected'] = $this->input->post('program');
                    $this->data['enrolledList']['hasGradeEdit'] = (in_array(6,$this->session->userdata('action')))? 1 : 0;
                    $this->data['enrolledList']['hasView'] = (in_array(2,$this->session->userdata('action')))? 1 : 0;
                    $this->data['enrolledList']['hasEdit'] = (in_array(6,$this->session->userdata('action')))? 1 : 0;
                    $this->data['enrolledList']['base_url'] = base_url();

                    echo json_encode($this->data['enrolledList'],JSON_HEX_TAG);//providing the data to the ajax request;
                    // $data['selected'] = $this->input->post('program');
                    
                }else{

                    $this->data['enrolledList'] = $this->client_model->get_enrolled_list();
                    
                    $this->load->view('templates/header', $this->data);
                    $this->load->view('templates/sidebar', $this->data);
                    $this->load->view('templates/topbar', $this->data);
                    $this->load->view('pageContent/enrollList', $this->data);
                    $this->load->view('templates/footer', $this->data);
                    
                }
            }else{
                // session not set call login page 
                redirect('login');
            }

        }

        // displays the list of clients registered into the system.
        public function view_clients(){
            
            if($this->is_session_set() && in_array(2, $this->user_actions)){


                $this->data['title'] = 'Client List';
                $this->data['active'] = 'clientList';
                $this->data['cList'] = $this->client_model->get_client_list();
            
                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/sidebar', $this->data);
                $this->load->view('templates/topbar', $this->data);
                $this->load->view('pageContent/clients', $this->data);
                $this->load->view('templates/footer', $this->data);

            }else{
                // session not set call login page 
                redirect('login');
            }

        }
        /* sets the grade names to the specified client
        *
        * @access    public
        * @param     clientId 
        * @param     program  the name of the table we will get the name for  
        *
        * @return    NONE
        */    
        public function set_grade_name($clientId = NULL, $program = NULL){
        
            //checking if session is set
            if ($this->is_session_set()){

                if ($clientId != NULL){
                                            
                    //get grade name for an enrolled client 
                    $result = $this->client_model->get_program_grades_names($program);

                    if ($result === FALSE){
                        log_message('debug', 'get_program_grades_names inside client_model returned false');
                    }
                    if (!isset($result['Assesment1'])){
                        // NO enrolled clients with grade name

                        $result = array();

                        //getting grade name from completed clients
                        $result = $this->client_model->get_program_grades_names($program, 'Completed');
                    
                    
                    }
                    if (isset($result['Assesment1']) && trim($result['Assesment1']) != ''){
                        //assesment names were found
                        $result3 = $this->client_model->set_program_grades_names($clientId, $program, $result);
                        if( $result3 === FALSE ){
                            log_message('debug', 'set_program_grades_names inside client_model returned false');
                        }

                        log_message('debug', 'Success');
                    }


                }

            }else{
                redirect('login');
            }
        }

        /**
         * Adds a client to the system and enrolles them
         * 
         *
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */ 
        public function add_client(){


            if($this->is_session_set() && in_array(1, $this->user_actions)){
                // session is set allow access to add clients
                $this->data['active'] = 'test';//setting menu option addclient to be highlighted on the sidebar

                // form validation of input attributes 
                $this->form_validation->set_rules('fname', 'First Name:', 'required|trim');
                $this->form_validation->set_rules('lname', 'Last Name:', 'required|trim');
                $this->form_validation->set_rules('mname', 'Middle Name:', 'trim');
                
                $this->form_validation->set_rules('country', 'Country:', 'required|trim');
                $this->form_validation->set_rules('ctv', 'City/Town/Village:', 'required|trim');
                $this->form_validation->set_rules('ssn', 'SSN:', 'trim');
                $this->form_validation->set_rules('homePhone', 'Home Phone #:', 'trim');
                $this->form_validation->set_rules('mobilePhone', 'Mobile Phone #:', 'required|trim');
                $this->form_validation->set_rules('street', 'Street Address:', 'required|trim');
                
                $this->form_validation->set_rules('ecName', 'Emergency Contact Name:', 'required|trim');
                $this->form_validation->set_rules('ecNumber', 'Emergency Contact Number:', 'required|trim');
                $this->form_validation->set_rules('ecRelation', 'Emergency Contact Relation:', 'required|trim');
                
                $this->form_validation->set_rules('company_name', 'Company Name:', 'required|trim');
                $this->form_validation->set_rules('position', 'Position/Job Title:', 'required|trim');
                
                $this->form_validation->set_rules('ed_name', 'Insititution Name:', 'required|trim');
                $this->form_validation->set_rules('ed_degree', 'Highest level of Education:', 'required|trim');
                
                $this->form_validation->set_rules('refName1', 'Name Ref#1:', 'required|trim');
                $this->form_validation->set_rules('refAddress1', 'Address Ref#1:', 'required|trim');
                $this->form_validation->set_rules('refCity1', 'City Ref#1:', 'required|trim');
                $this->form_validation->set_rules('refPhone1', 'Phone Ref#1:', 'required|trim');

                $this->form_validation->set_rules('refName2', 'Name Ref#2:', 'trim');
                $this->form_validation->set_rules('refAddress2', 'Address Ref#2:', 'trim');
                $this->form_validation->set_rules('refCity2', 'City Ref#2:', 'trim');
                $this->form_validation->set_rules('refPhone2', 'Phone Ref#2:', 'trim');

                $this->form_validation->set_rules('refName3', 'Name Ref#3:', 'trim');
                $this->form_validation->set_rules('refAddress3', 'Address Ref#3:', 'trim');
                $this->form_validation->set_rules('refCity3', 'City Ref#3:', 'trim');
                $this->form_validation->set_rules('refPhone3', 'Phone Ref#3:', 'trim');

                $this->form_validation->set_rules('preTestAvg', 'Address Ref#3:', 'trim');
                $this->form_validation->set_rules('enrolled_on', 'Year Enrolled:', 'trim');
                
                //data that will be passed to the view
                $this->data['title'] = 'Add Client';
                $this->data['active'] = 'addClient';


                // user submitted the form with data 
                if(!empty($this->input->post()) && $this->input->post('action') === 'addClient' && $this->form_validation->run() === TRUE){
                // echo "<pre>";
                // print_r($this->input->post());
                // echo "</pre>";
                    // checking if a profile pic was set
                    $hasImgFile = (!empty($_FILES['clientImg']['name']))? 1 : 0;
                    
                    // filtering post input 
                    $post = $this->input->post(NULL, TRUE);

                    $clientId = $this->client_model->enter_client($post, $hasImgFile);

                    if ( $clientId === -1){
                        
                        // client exsits
                        $this->data['addClientMessage'] = '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-frown"></i> Notice:</strong>
                            Client has already been entered into the system, refer to the clients table please.<h5>
                            </div>
                        ';


                    }else if ( $clientId ){
                        //Client was created

                        $this->data['addClientMessage'] = '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-smile"></i> Success</strong>, Client has be registers!<h5>
                            </div>
                        ';
                    
                        //Checking if an image was uploaded to insert it to the database. 
                        if ($hasImgFile){

                            $newFileName = $post['fname'].'_'.$post['lname'].'_'.time();
                            
                            $config['upload_path'] = './upload/';
                            $config['allowed_types'] = 'jpg|png';
                            $config['file_name'] = $newFileName;

                            // you can set image size restriction
                            // $config['max_size'] = 2000;
                            // $config['max_width'] = 1500;
                            // $config['max_height'] = 1500;
                    
                            $this->load->library('upload', $config);

                            // uploading the image to the uploads folder
                            if($this->upload->do_upload('clientImg')){
                                
                                $uploadInfo = $this->upload->data();
                                $filename = $uploadInfo['file_name'];

                                $result = $this->client_model->set_client_profile_pic($clientId, $filename);

                                if ($result === FALSE){
                                    //setting client pic failed
                                    $this->data['addClientMessage'] = '
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5><strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong>
                                    Client was added but was unable to upload image!<h5>
                                    </div>
                                    ';

                                }

                            }else{
                                //client pic was not uploaded to the upload folder
                                $this->data['addClientMessage'] = '
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5><strong><i class="fa fa-2x fa-frown"></i> We\'re sorry!</strong>
                                Client was added but was unable to upload image!<h5>
                                </div>
                                ';
                                //logs upload errors
                                log_message('debug', $this->upload->display_errors());
                            }

                        }
                        
                        // client is enrolled so we will assign grade names to the program enrolled
                        // if ( $this->input->post('preTestAvg') >= 70){

                            $program = $this->input->post('program');
                            
                            //***** NOTICE: Uncommenting the if statement means that users will be automatically enrolled based on preTestAvg ****/
                            //setting grades
                            $this->set_grade_name($clientId, $program);
                        
                        // }
                        


                    }else{

                        $this->data['addClientMessage'] = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-frown"></i> Opps!</strong>
                        Unable to add the client at the moment!<h5>
                        </div>
                        ';
                        

                    }
                    // setting one-time message
                    $this->session->set_flashdata('message',$this->data['addClientMessage']);
                    redirect('register-applicant');
                

                }else{
                    // no submitions have been made yet 

                    // Display the form 
                    $this->load->view('templates/header', $this->data);
                    $this->load->view('templates/sidebar', $this->data);
                    $this->load->view('templates/topbar', $this->data);
                    $this->load->view('pageContent/addClient');
                    $this->load->view('templates/footer', $this->data);
                }
            
            
            }else{
                // session not set call login page 
                redirect('login');
            }

            
            
        }
        /** 
         * set_client_pic() saves the image file uploaded and updates clients image profile id
         *
         * @access    public
         * @param     post cotains input data from form submittion
         * @param     clientId the id of the client we are setting a profile pic for
         *
         * @return    NONE 
         */ 

        public function set_client_pic($post = NULL, $clientId = NULL){
                if (!empty($post)){
                    //print_r($post);

                    $newFileName = $post['fname'].'_'.$post['lname'].'_'.time();
                    
                    $config['upload_path'] = './upload/';
                    $config['allowed_types'] = 'jpg|png';
                    $config['file_name'] = $newFileName;
            
                    $this->load->library('upload', $config);

                    //uploading file to the upload folder
                    if($this->upload->do_upload('clientImg')){
                        
                        $uploadInfo = $this->upload->data();
                        $filename = $uploadInfo['file_name'];

                        $result = $this->client_model->update_client_profile_pic($clientId, $filename);

                        if ($result === FALSE){
                            //update was not successful
                            log_message('debug','update_client_profile_pic returned false when updating client profile');
                            return FALSE;
                
                        }

                        return TRUE;

                    }else{
                        log_message('debug', 'Unable to upload image file to upload folder');
                        return FALSE;
                    }
                }

        }
        /**
         * displayes the update client page and handles the updating of that update request 
         *
         * @access    public
         * @param     clientId
         *
         * @return    NONE 
         */
        public function update_client($clientId = NULL){
            if ($this->is_session_set() && in_array( 1, $this->user_actions)){
                // session is set and has privilege to update users
                $this->data['title'] = 'Update Client';
                
                if ($this->input->post('action') === 'updateClient'){
                    $post = $this->input->post(NULL, TRUE);//filtering the post, enabling XSS filtering 

                    $imgRemoved = 0;

                    //An image was uploaded
                    if (!empty($_FILES['clientImg']['name']) ){
                        //set new profile pic
                        $result3 = $this->set_client_pic($post, $clientId);

                    }else{
                        $imgRemoved = $this->input->post('imageId');
                    }
                    $post['enrollCount'] = $this->input->post('is_enrolled') + (($this->input->post('programList')['newProgram']['program'] != 'none')? 1 : 0);
                    
                    //calling models to update applicant information 
                    $result = $this->client_model->update_client_info($clientId, $post, $imgRemoved, );
                    
                    //For setting client in a program
                    $result2 = TRUE;

                    // users added client to a program
                    if ($this->input->post('programList')['newProgram']['program'] != 'none'){
                        
                        //setting client in program
                        $result2 = $this->client_model->set_client_in_program($clientId, $this->input->post('programList')['newProgram']);
                        
                        //setting client grade names 
                        // if ($this->input->post('programList')['newProgram']['preTestAvg'] >= 70){
                            //passing clientId and program name
                            $this->set_grade_name($clientId, $this->input->post('programList')['newProgram']['program']);
                        // }
                    }
                    
                    if ($result){
                        // setting success message 
                        $message = '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-smile"></i> Success!</strong> Client was updated.<h5>
                        </div>
                        ';

                        if ($result2 === FALSE){
                            // setting error message
                            $message = '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-frown"></i> We\'re Sorry!</strong> Could not enroll client into the program.<h5>
                            </div> 
                            ';
                            log_message('debug', 'set_client_in_program failed when called inside update_client in the user controller');
                        }
                        
                    }else{

                        $message = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-frown"></i> We\'re Sorry!</strong> Some of the changes were not saved.<h5>
                        </div>
                        ';
                    }
                    //setting message to page
                    $this->session->set_flashdata('message',$message);
                    redirect('edit-client-info/'.$clientId) ;

                }else{

                    //getting display data
                    $clientData = $this->client_model->get_personal_info($clientId);
                    $programList = $this->client_model->get_program_list($clientId);
                

                    // form validation of input attributes 
                    $this->form_validation->set_rules('fname', 'First Name:', 'required|trim');
                    $this->form_validation->set_rules('lname', 'Last Name:', 'required|trim');
                    $this->form_validation->set_rules('mname', 'Middle Name:', 'trim');
                    // $this->form_validation->set_rules('mname', '', 'trim');
                    $this->form_validation->set_rules('country', 'Country:', 'required|trim');
                    $this->form_validation->set_rules('ctv', 'City/Town/Village:', 'required|trim');
                    $this->form_validation->set_rules('ssn', 'SSN:', 'required|trim');
                    $this->form_validation->set_rules('homePhone', 'Home Phone #:', 'trim');
                    $this->form_validation->set_rules('mobilePhone', 'Mobile Phone #:', 'required|trim');
                    $this->form_validation->set_rules('street', 'Street Address:', 'required|trim');
                    
                    $this->form_validation->set_rules('ecName', 'Emergency Contact Name:', 'required|trim');
                    $this->form_validation->set_rules('ecNumber', 'Emergency Contact Number:', 'required|trim');
                    $this->form_validation->set_rules('ecRelation', 'Emergency Contact Relation:', 'required|trim');
                    
                    $this->form_validation->set_rules('refName1', 'Name Ref#1:', 'required|trim');
                    $this->form_validation->set_rules('refAddress1', 'Address Ref#1:', 'required|trim');
                    $this->form_validation->set_rules('refCity1', 'City Ref#1:', 'required|trim');
                    $this->form_validation->set_rules('refPhone1', 'Phone Ref#1:', 'required|trim');

                    $this->form_validation->set_rules('refName2', 'Name Ref#2:', 'trim');
                    $this->form_validation->set_rules('refAddress2', 'Address Ref#2:', 'trim');
                    $this->form_validation->set_rules('refCity2', 'City Ref#2:', 'trim');
                    $this->form_validation->set_rules('refPhone2', 'Phone Ref#2:', 'trim');

                    $this->form_validation->set_rules('refName3', 'Name Ref#3:', 'trim');
                    $this->form_validation->set_rules('refAddress3', 'Address Ref#3:', 'trim');
                    $this->form_validation->set_rules('refCity3', 'City Ref#3:', 'trim');
                    $this->form_validation->set_rules('refPhone3', 'Phone Ref#3:', 'trim');

                    $this->form_validation->set_rules('preTestAvg', 'Address Ref#3:', 'trim');
                    $this->form_validation->set_rules('enrolled_on', 'Year Enrolled:', 'trim');

                    // Result was returned 
                    if ($clientData !== FALSE && $programList !== FALSE){

                        $this->data['clientData'] = $clientData;
                        $this->data['programList'] = $programList;

                    }

                    $this->load->view('templates/header', $this->data);
                    $this->load->view('templates/sidebar', $this->data);
                    $this->load->view('templates/topbar', $this->data);
                    $this->load->view('pageContent/updateClient', $this->data);
                    $this->load->view('templates/footer', $this->data);

                }

            }else{
                redirect('login');
            }
        }    
        /**
         * add_user() will return users back to the dashboard/home providing a success or failure message
         *
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */    
        public function add_user(){

            
            if($this->is_session_set() && in_array(3, $this->user_actions)){
                // session is set allow access to add clients

                $post = $this->input->post(NULL, TRUE);//returns all post items with XSS filter

                // setting title to the view
                $this->data['title'] = 'Add User';
                
                if (!empty($post) && $post !== NULL ){
                    
                    $oneTimePass = $this->generate_random_pass();
                    $post['password'] = $oneTimePass;

                    $result = $this->user_model->enter_user($post);
                    
                    if($result === FALSE){
                        $this->message = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5>
                        <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> The user was not added to the system! 
                        <h5>
                        </div>
                        ';
                        
                    }elseif ($result === TRUE){
                        
                        //creating a token
                        $token = random_string('alnum', 10);

                        //30 min in seconds
                        $expires = date('U') + 1800;

                        $result = $this->validation_model->set_pass_reset($post['email'], $token, $expires);

                        if ($result != FALSE){
                            //preparing email
                            $sub = 'Welcome '.$post['fname'].' '.$post['lname'].' to the BTEC Family!';
                            $mess = 'To access the BTEC System you can <a href="'.base_url().'change-password/'.$result.'/'.$token.'">click here</a> to enter a new password.
                            Thank you have a nice day. 
                            ';
                            $this->custom_email->set_subject($sub);
                            $result = $this->custom_email->send_email($post['email'], $mess);

                            if($result){

                                $this->message = '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5><strong><i class="fa fa-2x fa-smile"></i> Success!</strong>  The user was added to the System and has been notified via email!<h5>
                                </div>
                                ';

                            }else{

                                $this->message = '   
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5>
                                <strong><i class="fa fa-2x fa-exclamation-triangle"></i> Whoops!</strong> The user was added to the system but not notified via Email! <br>
                                User Default Password is <strong>'.$oneTimePass.'</strong>
                                <h5>
                                </div>
                                ';
                            }


                        }else{
                            //token was not set
                            $this->message = '   
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>
                            <strong><i class="fa fa-2x fa-exclamation-triangle"></i> Whoops!</strong> The user was added to the system but not notified via Email! <br>
                            User Default Password is <strong>'.$oneTimePass.'</strong>
                            <h5>
                            </div>
                            ';

                        }
                    }else{
                        //user Exists
                        $this->message = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> The user is already in the system please <a href="'.base_url().'user-info/'.$result.'">check here</a> to view their profile.<h5>
                        </div>
                        ';
                        
                    }
                    $this->session->set_flashdata('message', $this->message);
                    redirect('dashboard');
                }else{
                    //post is not set
                    redirect('dashboard');
                }

                
            }else{
                // session not set call login page 
                redirect('login');
            }

        }
        // This function will display all the users in the system in a table
        public function view_users(){

            if($this->is_session_set() && in_array(4, $this->user_actions)){
                // session is set allow access to view users 

                $this->data['title'] = 'User List';
                $this->data['name'] = $this->session->userdata('name');
                $this->data['active'] = 'userList';

                $result = $this->user_model->get_user_list();
                
                if ($result === FALSE){

                    $this->data['userListMessage'] = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5>
                    <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> Unable to display users. 
                    <h5>
                    </div>
                    ';

                }else{
                    $this->data['userList'] = $result;
                }
            
                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/sidebar', $this->data);
                $this->load->view('templates/topbar', $this->data);
                $this->load->view('pageContent/users', $this->data);
                $this->load->view('templates/footer', $this->data);

            }else{
                // session not set call login page 
                redirect('login');
            }
        

        }
        // Functions displays information the system has on the user
        public function view_user_profile($userId = NULL){
            
            if($this->is_session_set() && in_array(4, $this->user_actions) ){
                //Session is set user can view_user_profile

                if ($userId !== NULL){
                    
                    // getting user data from user_model 
                    $result = $this->user_model->get_user_info($userId);
                    $allPrivi = $this->user_model->get_all_privileges();

                    if($result === FALSE){
                        
                        echo 'Unable to retrieve user data';
                        log_message('debug', 'get_user_info() returned false from user_model');

                    }else{

                        //data to be used on the view
                        $this->data['userData'] = $result;
                        $this->data['title'] = 'User Details';
                        $this->data['allPrivi'] = $allPrivi;
                        $this->data['name'] = $this->session->userdata('name');

                        // display the data on the view     
                        $this->load->view('templates/header', $this->data);
                        $this->load->view('templates/sidebar', $this->data);
                        $this->load->view('templates/topbar', $this->data);
                        $this->load->view('user/userInfo', $this->data);
                        $this->load->view('templates/footer', $this->data);

                    }



                }else{
                    echo "Cannot view the profile at the moment";
                }



            }else{
                // session not set call login page
                redirect('login');
            }


        }
        /**
         * Will add user based on the id the hidden input value had
         *
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */    
        public function update_user_profile(){
            if( $this->is_session_set() && in_array(4, $this->user_actions)){
                
                //going to update the user profile
                if ($this->input->post('action') === 'saveUserInfo' && !empty($this->input->post('userId'))){
                
                    $postData = $this->input->post(NULL, TRUE);//Enabling XSS filtering

                    $result = $this->user_model->update_user_info($postData);
                    $result2 = $this->user_model->set_user_update_info($this->input->post('userId', TRUE), $this->userIdent);

                    if ($result2 === FALSE){
                        log_message('debug', 'set_user_update_info() returned false, unable to set updated_on and updated by');
                    }
                    if ($result === FALSE){
                        echo 'Opps! some of modifications have not been saved!';
                    }else{
                        echo 'Success! Profile is updated.';
                    }
                    

                }

            }else{
                echo 'didnt work';
            }

        }
        /**
         * View_client_profile() loads a view with the requested clients info  
         *
         * @access    public
         * @param     clientId the id of the client we want to view
         *
         * @return    NONE 
         */    
        // shows a more detailed description of what the system has on the user
        public function view_client_profile($clientId = NULL){

            if( $this->is_session_set() && in_array(2, $this->user_actions)){
                //Session is set user can view client profile 

                //Data array will be passed to the view
                $this->data['title'] = 'Client Details';
                $this->data['name'] = $this->session->userdata('name');
                $this->data['clientData'] = $this->client_model->get_client_profile($clientId);

                if ($this->data['clientData'] === 0){
                    $this->data['message'] = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5>
                        <strong><i class="fa fa-2x fa-frown"></i> Notice:</strong> Unable to find client. 
                        <h5>
                        </div>
                        ';
                    $this->session->set_flashdata('message', $this->data['message']);
                    redirect('dashboard'); 
                
                }else{

                    // display the data on the view     
                    $this->load->view('templates/header', $this->data);
                    $this->load->view('templates/sidebar', $this->data);
                    $this->load->view('templates/topbar', $this->data);
                    $this->load->view('user/clientInfo', $this->data);
                    $this->load->view('templates/footer', $this->data);
                }

            }else{

                redirect('login');
            }



        }
        /**
         * Will  remove the profile image of a users based on the userId coming in from the post method
         *
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */    
        public function remove_profile_pic(){
            
            if( $this->is_session_set()){
                

                if (!empty($this->input->post('imgId')) && !empty($this->input->post('userId')) ){
                    //post is sending the data we want

                    //Checking if the user does not have the default image set as their profile pic
                    if ($this->input->post('imgId') !== 1){

                        $result = $this->user_model->set_default_profile_pic($this->input->post('userId'), $this->input->post('imgId'));
                        
                        if ($result === FALSE){
                            echo 'Unable to remove your profile image. Try again later.';
                        }else{
                            
                            // checking if user is changing their profile pic 
                            if ($this->input->post('userId') === $this->session->userdata('userid')){

                                //re-initializing the session
                                $this->session->set_userdata('imgPath','upload/default_profile_img.png');
                                $this->session->set_userdata('imgId', 1);

                            }
                            echo 1;
                            log_message('debug','Success! Profile picture removed.');
                        }

                    }else{

                        log_message('debug','No profile pic is set to remove');
                    }

                }else{
                    // no post data sent
                    log_message('debug','No post data sent to remove_profile_pic inside User controller');
                    
                }

            }else{
                redirect('login');
            }
        
        }
        /**
         * Will update the current users profile 
         *
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */    
        public function update_my_profile(){
        
            if( $this->is_session_set()){
                
                $userid = $this->session->userdata('userid');
                $postData = $this->input->post(NULL, TRUE);

                $result = $this->user_model->update_user_profile($userid, $postData);

                if ($result === FALSE){

                    echo "Failed to save changes";

                }else{

                    echo "Successfully updated your profile!";
                }

                

            }else{
                // session not set call login page 
                redirect('login');
            }
        }
        /**
         * change_profile_pic() changes the profile pic of the user using the system
         *
         * @access    public
         * @param     NONE
         *
         * @return    String states its success or failure as a string to the ajax request 
         */    
        public function change_profile_pic(){
            
            if ($this->is_session_set()){


                if(!empty($_FILES['profileImg']['name']) && !empty($this->input->post('userId')) ){
                    
                    //creating a file name for the image uploaded
                    $newFileName = $this->input->post('fullName').'_'.time();
                    
                    $config['upload_path'] = './upload/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = $newFileName;
            
                    //loading the upload library and setting the configurations made above
                    $this->load->library('upload', $config);

                    //uploading the file to the upload_path, returns true if successful
                    if($this->upload->do_upload('profileImg')){
                        
                        $uploadInfo = $this->upload->data();

                        $filename = $uploadInfo['file_name'];

                        $userId = $this->input->post('userId');

                        $result = $this->user_model->set_profile_pic($userId, $filename);

                        if ($result === FALSE){

                            echo "Profile Image was not updated";
                            
                        }else{
                            // checking if the update is not being done by an admin i.e. user updating his/her profile pic
                            if ($this->input->post('userId') === $this->session->userdata('userid')){
                                $this->session->set_userdata('imgPath', 'upload/'.$filename);
                                $this->session->set_userdata('imgId', $result);//result hold the id of the new profile pic 
                            }

                            echo "Profile Image was updated!";

                        }

                    }else{
                        echo $this->upload->display_errors();
                    }



                }else{
                    echo 'no files uploaded';
                }

            }else{

                redirect('login');
            }

        }
        /**
         * checks if the session is set for a ajax request
         *
         * @access    public
         * @param     NONE
         *
         * @return    Boolean 
         */    
        
        public function js_session_check(){

            if ( isset($this->userId) ){

                echo 1;

            }else{

                echo 0;
            }

        }

        /**
         * is_session_set() checks if users session is set
         *
         * @access    public
         * @param     NONE
         *
         * @return    Boolean 
         */    
        
        public function is_session_set(){

            if (isset($this->userId)){   // 
                //echo('session data for userid is present');
                return TRUE;

            }else{
            //echo('session data for userid is missing');
                return FALSE;
            }

        }
        /**
         * Creates a new comment
         *
         * @access    public
         * @param     program the name of the program table
         * @param     programId the id of the program 
         *
         * @return    echo/redirect echo for a jquery post 
         */    
        public function create_comment($program = NULL, $programId = NULL){

            if( $this->is_session_set()){

                if (in_array(11, $this->user_actions) && !empty($this->input->post())){
                    //post was recieved
                    $result = $this->client_model->set_client_comments($this->input->post(NULL, TRUE));

                    if ($result === FALSE){
                        echo 0;
                    }else{
                        //comment was created
                        echo 1;
                    }



                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('dashboard');
            }

        }
        /**
         * Allows users to edit their comment  
         *
         * @access    public
         *
         * @return    echo indicates wheather the update was successful to a jquery post 
         */    
        public function update_comment(){

            if( $this->is_session_set()){

                if (in_array(11, $this->user_actions) && !empty($this->input->post())){
                    
                    $result = $this->client_model->update_comment($this->input->post('id'), $this->input->post('comment', TRUE));

                    if ($result === FALSE){
                        echo 0;
                    }else{
                        echo 1;
                    }

                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('dashboard');
            }

        }
        /**
         * Removes a specified comment  
         *
         * @access    public
         * @param     program the name of the program table
         * @param     programId the id of the program 
         *
         *       
         */    
        public function delete_comment(){

            if( $this->is_session_set()){

                if (in_array(11, $this->user_actions) && !empty($this->input->post())){
                    //post was recieved
                    $result = $this->client_model->remove_comment($this->input->post('id'));

                    if ($result === FALSE){
                        echo 0;
                    }else{
                        //comment was created
                        echo 1;
                    }



                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('dashboard');
            }

        }
        /**
         * Inserts a new client files entered in the client management view
         *
         * @access    public
         * @param     NONE
         *       
         */    
        public function upload_client_doc($programName = NULL, $programId = NULL, $clientId){

            if( $this->is_session_set() && in_array(11, $this->user_actions)){
                
                $out = $preview = $config = $error = [];
                if (!empty($_FILES) && array_key_exists($programName, $this->programTables)){

                    $input = 'input-fa'; 
                    $totalFileCount = count($_FILES[$input]['name']);

                   // echo '<pre>'.print_r($_FILES).'</pre>';

                    for ($i = 0; $i < $totalFileCount; $i++){
                        
                        // Define new $_FILES array - $_FILES['file']
                        $fileName = $_FILES['file']['name'] = $_FILES[$input]['name'][$i];// the file name
                        $fileType = $_FILES['file']['type'] = $_FILES[$input]['type'][$i]; // the file type
                        $_FILES['file']['tmp_name'] = $_FILES[$input]['tmp_name'][$i]; //the file temp name
                        $_FILES['file']['error'] = $_FILES[$input]['error'][$i];// the file errors
                        $fileSize = $_FILES['file']['size'] = $_FILES[$input]['size'][$i]; // the file size

                        //removing spaces from file name
                        $fileName = preg_replace('/\s+/', '_', $fileName);

                        //creating a file name for the image uploaded
                        $tempFileName = explode('.',$fileName);
                        $newFileName = $tempFileName[0].'_'.time().'.'.$tempFileName[1];
                   
                        // Set preference
                        $config['file_name'] = $newFileName;
                        $config['max_size'] = '10000'; // max_size in kb
                        $config['upload_path'] = './upload/docs/';
                        $config['allowed_types'] = '*';
                        // $config['allowed_types'] = 'gif|jpg|png';
                        // $config['allowed_types'] = 'jpg|jpeg|png|pdf|docx|ppt|';
                
                        //loading the upload library and setting the configurations made above
                        $this->load->library('upload', $config);

                        //uploading the file array we created
                        if($this->upload->do_upload('file')){
                            $uploadInfo = $this->upload->data();
                           
                            $filePath = 'upload/docs/'.$newFileName;
                            $userId = $this->session->userdata('userId');

                            $data = array(
                                'programId' => $programId,
                                'clientId' => $clientId,
                                'filePath' => $filePath,
                                'fileType' => $fileType,
                                'fileSize' => $fileSize,
                                'tableName' => $this->programTables[$programName]
                            );

                            $fileId = $this->client_model->insert_doc($data);

                            if ($fileId === FALSE){
                                log_message('debug', 'client_model->insert_doc returned false inside uploade_client_doc located in the main controller');
                                $out['error'] = "Something when wrong trying to upload ".$newFileName;
                            }else{
                                $type = explode('/', $fileType);
                                //setting up upload async
                                $preview[] = base_url().$filePath;
                                $config[] = [
                                    'key' => $fileId,
                                    'caption' => $newFileName,
                                    'type' =>  (($type[0] == 'image')? $type[0] : $type[1]),
                                    'size' => $fileSize,
                                    'downloadUrl' => base_url().$filePath,
                                    'url' => base_url().'remove-file/'.$fileId 
                                ];
                                
                            }
                        }else{
                            log_message('debug', 'File upload error in uploade_client_doc in the main controller');
                            $out['error'] = 'codeigniter says: '.$this->upload->display_errors();
                        }
                    }
                }else{
                   $out = [];
                }

                if(!empty($preview)){
                    //setting initialPreview and preview config
                    $out = [
                        'initialPreview' => $preview,
                        'initialPreviewConfig' => $config
                    ];
                }

                echo json_encode($out);          
            
            }else{
                $out['error'] = 'Please refresh the page!';
                echo json_encode($out);
            }

        }
        /**
         * Removes a specified comment  
         *
         * @access    public
         * @param     program the name of the program table
         * @param     programId the id of the program 
         *       
         */    
        public function remove_client_doc(){
            $out = [];
            if( $this->is_session_set() && in_array(11, $this->user_actions)){
                if(!empty($this->input->post('key'))){
                    $docId = $this->input->post('key');

                    if ( $docId != NULL){
                        //files were submitted
                        $isDocDeleted = $this->client_model->remove_doc($docId);

                        if ($isDocDeleted === FALSE){
                                log_message('debug', 'Something went wrong while remove_client_doc() inside main controller');
                                $out['error'] = 'Something went wrong trying to remove the file! Please try again later.';
                        }else{
                            //success
                            $out['key'] = $docId;
                            echo json_encode($out); 
                        }

                    }else{
                        log_message('debug', 'a valid docId was not submitted for remove_client_doc() inside main controller');
                        $out['error'] = 'no valid Id was submitted';
                        echo jason_encode($out);
                    }

                }else{
                    log_message('debug', 'Post was not recieved in remove_client_doc inside the main controller');
                }
            }else{
                $out['error'] = 'Please refresh the page!';
                echo json_encode($out);
            }

        }
        /**
         * Allows users to manage client documents for a  program
         * 
         * @access    public
         * @param     program the name of the program table
         * @param     programId the id of the program 
         *
         *       
         */    
        public function get_client_doc($program = NULL, $clientId = NULL){

            if($this->is_session_set() && in_array(11, $this->user_actions)){

                if (array_key_exists($program, $this->programTables) ){
                    $clientDocs = $this->client_model->get_client_docs($clientId, $this->programTables[$program]);
                    
                    $preview = $config = [];
                    // $input = 'input-fa';
                    
                    foreach ($clientDocs as $key => $value){

                        $filename = explode('/', $value['doc_path']);

                        $preview[] = base_url().$value['doc_path'];

                        $type = explode('/', $value['doc_type']);
                        $config[]= [
                            'caption' => $filename[2],
                            'size' => $value['size'],
                            'type' => (($type[0] == 'image')? $type[0] : $type[1]),
                            'downloadUrl' => base_url().$value['doc_path'],
                            'width' => '120px',
                            'url' => base_url().'remove-file/',
                            'key' => $value['id']
                        ];
                    }
                    $result = [
                        'initialPreview' => $preview,
                        'initialPreviewConfig' => $config
                    ];
                      
                    return $result;
                }else{
                    log_message('debug', 'Something went wrong trying to get the docs for the client in the get_client_docs method inside the main controller');
                    // program table doesn't exist
                    $this->message = '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> Program name, "'.$program.'" does not exsit.<h5>
                    </div>
                    ';

                    $this->session->set_flashdata('message', $this->message);
                    redirect('dashboard'); 

                }
            }else{
                redirect('login');
            }
        }
        /**
         * Allows users to manage client data in a program 
         *
         * @access    public
         * @param     program the name of the program table
         * @param     programId the id of the program 
         *
         *       
         */    
        public function manage_client($program = NULL, $programId = NULL){

            if( $this->is_session_set() && in_array(11, $this->user_actions)){
                
                if (array_key_exists($program, $this->programTables) ){
                
                
                    $programInfo = $this->client_model->get_program_info($this->programTables[$program], $programId);
                    
                    if ($programInfo == FALSE){
                        log_message('debug', 'get_program_info in client model returned false in main controller, "manage_client" method');
                        redirect('dashboard'); 
                    }
                    // getting client info
                    $personalInfo = $this->client_model->get_personal_info($programInfo[0]['client_id']);

                    //getting comments made to client
                    $comments = $this->client_model->get_client_comments($programInfo[0]['client_id'], $programId, $this->programTables[$program]);

                    $existingDocs = $this->get_client_doc($program, $programInfo[0]['client_id']);

                    if (empty($personalInfo[0])){
                        //user was not found
                        $this->message .= '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> There was no user found with that ID<h5>
                            </div>
                        ';
                        
                        $this->session->set_flashdata('message', $this->message);
                        redirect('dashboard'); 
                    
                    }else if( $personalInfo == FALSE){
                        // sql error occured
                        log_message('debug', 'get_client_program_info returned false, called from view_client_grade in user controller');
                        redirect('dashboard'); 
                    
                    }else{
                        //user exist
                        $this->data['title'] = "Manage Client";

                        // additional data
                        $addData['program'] = $this->programTables[$program];
                        $addData['clientId'] = $programInfo[0]['client_id'];
                        $addData['slug'] = $program.'/'.$programInfo[0]['id'];

                        $this->data['programInfo'] = array();

                        $this->data['programInfo'][0] = array_merge($personalInfo[0], $programInfo[0], $addData);
                        $this->data['existingDocs'] = $existingDocs; 
                        $this->data['comments'] = $comments; 

                        $this->load->view('templates/header', $this->data);
                        $this->load->view('templates/sidebar', $this->data);
                        $this->load->view('templates/topbar', $this->data);
                        $this->load->view('pageContent/clientManage', $this->data);
                        $this->load->view('templates/footer', $this->data);

                    }
                }else{
                        // program table doesn't exist
                        $this->message = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> Program name, "'.$program.'" does not exsit.<h5>
                        </div>
                        ';
                        
                        $this->session->set_flashdata('message', $this->message);
                        redirect('dashboard'); 
                }

            }else{
                redirect('login');
            }
        }
    
        /**
         * Will remove user from system and reload the userlist
         *
         * @access    public
         * @param     userId the ide of the user selected 
         *
         * @return    NONE
         */    
        public function update_client_program_data(){
            
            if ($this->is_session_set()){

                if (in_array(11, $this->user_actions) && !empty($this->input->post())){
                    
                    //getting current certificate name
                    $certificate = $this->client_model->get_certificate_name($this->input->post('program'), $this->input->post('programId'));
                    $certificateName = $certificate['certificate'];

                    $wasUploaded = FALSE;
                    
                    if (!empty($_FILES)){

                            $newFileName = str_replace(' ','_', $this->session->userdata('name')).'_'.time();
                            // echo $newFileName;
                            
                            $config['upload_path'] = './upload/certificates/';
                            $config['allowed_types'] = 'pdf';
                            $config['file_name'] = $newFileName;
                    
                            $this->load->library('upload', $config);

                            // uploading the image to the uploads folder
                            if($this->upload->do_upload('certificateFile')){
                                //successful upload
                                $uploadInfo = $this->upload->data();
                                $certificateName = $uploadInfo['file_name'];

                                $wasUploaded = TRUE;

                            }
                    }
                    //data for query 
                    $data = array(
                            'programId' => $this->input->post('programId'),
                            'table' => $this->input->post('program'),
                            'isEmployable' => $this->input->post('isEmployable'),
                            'notes' => ((trim($this->input->post('notes')) !== "")? $this->input->post('notes') : NULL),
                            'certificateFile' => (($certificateName != '')? $certificateName : NULL)
                    );

                    // upadting the program table
                    $result = $this->client_model->update_client_program_data($data);

                    if ($result === FALSE && $wasUploaded == TRUE){

                        //error message 
                        $this->data['message'] = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong>
                        Something went wrong while trying to save the data.<h5>
                        </div>
                        ';

                    }else{
                        //success message
                        $this->data['message'] = '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>
                            <strong><i class="fa fa-2x fa-smile"></i> Success!</strong> The program data has been updated! 
                            <h5>
                            </div>
                        ';

                    }            

                    
                    $this->session->set_flashdata('message', $this->data['message']);
                    redirect('manage-client/'.$this->input->post('slug'));

                }else{
                    redirect('dashboard');
                }
                

            }else{
                redirect('login');
            }
        }   

        /**
         * Will allow user to view clients grade 
         *
         * @access    public
         * @param     program the name of the program table
         * @param     clientId the id of the client
         *
         * @return    String An alpha numeric string 
         */    
        public function view_client_grade($program = NULL, $clientId = NULL){

            if( $this->is_session_set() && in_array(6, $this->user_actions)){
                
                if (array_key_exists($program, $this->programTables) && !empty($this->input->post())){
                
                    $this->data['title'] = "View Grades";

                    //getting program info
                    $result = $this->client_model->get_client_program_info(
                        $clientId,
                        $this->programTables[$program],
                        $this->input->post('status', TRUE),
                        $this->input->post('year', TRUE)
                    );

                    if ($result == -1){
                        // no such user was found
                        $this->message = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> There was no user found with that ID<h5>
                        </div>
                        ';
                        

                        $this->session->set_flashdata('message', $this->message);
                        redirect('enrolled-list'); 
                    
                    }else if( $result == FALSE){
                        // sql error
                        log_message('debug', 'get_client_program_info returned false, called from view_client_grade in user controller');
                        redirect('enrolled-list'); 
                    
                    }else{
                        //user exist

                        // appending the parameters to the result array as we will need it to update client grade
                        $result[0]['program'] = $this->programTables[$program];
                        $result[0]['clientId'] = $clientId;
                        $result[0]['slug'] = $program.'/'.$clientId;

                        if ($result === FALSE){
                            $result = 0;
                        }
                        $this->data['programInfo'] = $result;

                        $this->load->view('templates/header', $this->data);
                        $this->load->view('templates/sidebar', $this->data);
                        $this->load->view('templates/topbar', $this->data);
                        $this->load->view('pageContent/viewGrade', $this->data);
                        $this->load->view('templates/footer', $this->data);

                    }
                
                }else{

                    if (!empty($this->input->post())){

                        // post was sent but program doesnt exist
                        $this->message = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> Program name, "'.$program.'" does not exsit.<h5>
                        </div>
                        ';

                    }

                    $this->session->set_flashdata('message', $this->message);
                    redirect('enrolled-list'); 
                }
            }else{
                redirect('login');
            }
        }
        /**
         * Will allow user to view clients grade and modify them
         *
         * @access    public
         * @param     program the name of the program table
         * @param     clientId the id of the client
         *
         * @return    String An alpha numeric string 
         */    
        public function manage_client_grade($program = NULL, $clientId = NULL){

            if ($this->is_session_set() && in_array(6, $this->user_actions)){

                if (isset($program) && isset($clientId)){
                    //checking if program requested exist
                    if (array_key_exists($program, $this->programTables)){
                    
                        $this->data['title'] = "Manage Grades";

                        $result = $this->client_model->get_client_program_info($clientId, $this->programTables[$program]);
                        
                        if ($result == -1){
                            // no such user was found
                            $this->message = '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> There was no user found with that ID<h5>
                            </div>
                            ';
                            

                            $this->session->set_flashdata('message', $this->message);
                            redirect('enrolled-list'); 
                        
                        }else if( $result == FALSE){
                            // sql error
                            log_message('debug', 'get_client_program_info returned false, called from view_client_grade in user controller');
                            redirect('enrolled-list'); 
                        
                        }else{
                            //user exist

                            // appending the parameters to the result array as we will need it to update client grade
                            $result[0]['program'] = $this->programTables[$program];
                            $result[0]['clientId'] = $clientId;
                            $result[0]['slug'] = $program.'/'.$clientId;

                            if ($result === FALSE){
                                $result = 0;
                            }
                            $this->data['programInfo'] = $result;

                            $this->load->view('templates/header', $this->data);
                            $this->load->view('templates/sidebar', $this->data);
                            $this->load->view('templates/topbar', $this->data);
                            $this->load->view('pageContent/editGrade', $this->data);
                            $this->load->view('templates/footer', $this->data);

                        }
                        
                    }else{
                        // program doesnt exist
                            $this->message = '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> Program name, "'.$program.'" does not exsit.<h5>
                            </div>
                            ';
                            

                            $this->session->set_flashdata('message', $this->message);
                            redirect('enrolled-list'); 

                    }
                
                    

                }else{
                    redirect('enrolled-list');
                }



            }else{
                redirect('login');
            }
            

        }
    
        /**
         * Will generate a random password that is 7 char long containing numbers and letters
         *
         * @access    public
         * @param     NONE
         *
         * @return    String An alpha numeric string 
         */    
        public function generate_random_pass(){

            return random_string('alnum', 7); 

        }
        
    
        /**
         * Will change the current users password one the old passwords match
         *
         * @access    public
         * @param     NONE
         *
         * @return    NONE 
         */    
        public function change_pass(){

            if ($this->is_session_set()){
                
                // getting post input and performing a XSS filtering 
                $pass = $this->input->post('oldPass' , TRUE);
                $newPass = $this->input->post('confirmPass', TRUE);

                // getting data about user stored in session
                $email = $this->session->userdata('email');
                $uid = $this->session->userdata('userid');

                //calling the verificaiton model to check if users old pass is correct
                $result = $this->validation_model->get_user($email, $pass);

                if ($result === FALSE){

                    $this->data['message'] = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5>
                    <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> The old password entered is not correct. 
                    <h5>
                    </div>
                    ';
                
                    
                }else{

                    $this->data['message'] = '
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5>
                    <strong><i class="fa fa-2x fa-smile"></i> Success!</strong> Password has been changed! 
                    <h5>
                    </div>
                    ';
                    //requesting to change password
                    $result = $this->validation_model->set_new_pass($uid, $newPass);

                    if ($result === FALSE){

                        $this->data['message'] = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5>
                        <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> Unable to update password at the moment. 
                        <h5>
                        </div>
                        ';
                    }   
                }
                $this->session->set_flashdata('message', $this->data['message']);
                redirect('profile');

            }else{
                redirect('login');
            }

        }
        /**
         * Will remove user from system and reload the userlist
         *
         * @access    public
         * @param     userId the ide of the user selected 
         *
         * @return    NONE
         */    
        public function remove_user($userId = NULL){
            
            if ($this->is_session_set()){

                if (in_array(8, $this->user_actions) && $userId != NULL){

                    $result = $this->user_model->set_user_status($userId);

                    if (!$result){
                        $this->data['message'] = '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>
                            <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> Unable to remove users. 
                            <h5>
                            </div>
                        ';
                    }else{
                        $this->data['message'] = '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>
                            <strong><i class="fa fa-2x fa-smile"></i> Success!</strong> The users has been removed from the system. 
                            <h5>
                            </div>
                        ';

                    }
                    $this->session->set_flashdata('message', $this->data['message']);

                }
                
                redirect('user-list');

            }else{
                redirect('login');
            }
        }   
        /**
         * WIll update the program based on the inputs recieved 
         *
         * @access    public
         * @param     NONE 
         *
         * @return    NONE
         */    
        public function update_client_grade(){
            
            if ($this->is_session_set()){

                if (in_array(6, $this->user_actions) && !empty($this->input->post())){
                    //passing post data to client model to update info
                    $notes = $this->input->post('notes');
                    $post = $this->input->post(NULL, TRUE);
                    
                    $result = $this->client_model->update_client_grade($post, trim($notes));

                    //Below are messages that will be flashed to the view once
                    if ($result === FALSE){

                        $this->data['message'] = '
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>
                            <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> Something went wrong trying to update the grades. 
                            <h5>
                            </div>
                        ';

                    }else{
                        
                        $this->data['message'] = '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>
                            <strong><i class="fa fa-2x fa-smile"></i> Success!</strong> Updates have been saved. 
                            <h5>
                            </div>
                        ';

                        // setting updated by and update_on
                        $result2 = $this->client_model->set_client_updateGrade_info($this->input->post('clientId', TRUE),$this->input->post('program', TRUE),$this->userIdent);
                        if ($result2 == FALSE){
                            log_message('debug', 'User.php update_client_grade() : Could not ser client updated_on and updated by');
                        }

                    }

                    $this->session->set_flashdata('message', $this->data['message']);//setting a message that will only be flashed once to the UI

                    if($this->input->post('status') != "1"){
                    //  status is not enrolled so we will go to the enrolled list
                        redirect('enrolled-list');
                    
                    }else{
                    // the user is still enrolled so we will reload the same page
                        redirect('manage-client-grade/'.$this->input->post('slug'));

                    }

                }


            }else{
                redirect('login');
            }

        
        }
        /**
         * WIll update the program based on the inputs recieved 
         *
         * @access    public
         * @param     NONE 
         *
         * @return    NONE
         */    
        public function activate_user(){
            
            if (!empty($this->input->post())){
                
                $result = $this->user_model->activate_user($this->input->post('userId'), TRUE);
                if ($result == FALSE){
                    echo 'Unable to Activate User';
                    // log_message('error','Unable to activate user');
                }else{
                    echo 'Success! User has been activated.';
                }
            }else{
                
                log_message('debug', 'User.php active_user(), empty post recieved');

            }
        }
        /**
         * get get the values that are equal to the term being searched supplied by the $_GET[]
         *
         * @access    public
         * @param     NONE 
         *
         * @return    jasonEncode data that was found to be a match
         */    
        public function autocomplete_search(){

            if( $this->is_session_set() ){

                if (isset($_GET['term'])){
                    //used for the ajax that does the autocomplete
                    
                    $result = $this->user_model->get_autocomplete($_GET['term']);

                    if ($result !== FALSE){
                    
                        //looping to repart record for autocomplete
                        foreach ($result as $row)
                            $arr_result[] = $row['full_name'];//appending to array all the full_names recieved as result
                        
                        echo json_encode($arr_result);// sending results back to autocomplete plugin

                    }else{
                        log_message('debug', 'Auto complete query returned false');

                    }
                }else{

                    //search request was submitted 
                    if(!empty($this->input->post()) && $this->input->post('action') === 'search'){
                        
                        //requesting client info by passing the name with xxs filtering enabled
                        $result = $this->client_model->get_client($this->input->post('name', TRUE));
                        
                        if($result === FALSE){
                            
                            log_message('debug', 'Client_model->get_client() returned false');
                            
                            $this->data['message'] = '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5>
                                <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> Something went wrong with getting the search result. 
                                <h5>
                                </div>
                            ';

                            $this->session->set_flashdata('message', $this->data['message']);//setting a message that will only be flashed once to the UI
                            
                            redirect('dashboard');
                        }else{

                            $this->data['title'] = 'Search';
                            $this->data['clientInfo'] = $result;
                            $this->data['searchValue'] = $this->input->post('name', TRUE);

                            //loading search view
                            $this->load->view('templates/header', $this->data);
                            $this->load->view('templates/sidebar', $this->data);
                            $this->load->view('templates/topbar', $this->data);
                            $this->load->view('pageContent/search', $this->data);
                            $this->load->view('templates/footer', $this->data);
                                

                        }

                    }
                }

            }else{
                redirect('login');
            }
        }
        /* program_setup will allow admin/users to setup the grades or availability of functions
        *
        * @access    public
        * @param     NONE 
        *
        * @return    jasonEncode data that was found to be a match
        */    
        public function program_setup(){
        
            if ($this->is_session_set()){

                // checking to see if ajax has sent a post request
                if (in_array(9, $this->user_actions) && !empty($this->input->post()) && !empty($this->input->post('program'))){

                    $result = $this->client_model->get_program_grades_names($this->input->post('program'));

                    if (isset($result['Assesment1'])){
                        // grades have already been name for enrolled students
                        echo json_encode($result);

                    }else{
                        // get the most recent grade name entered 
                        echo 0;
                    }
                    
                }else{// No ajax post sent, then we will just load the default 

                    // $table = (!empty($this->input->post('program'))? $this->input->post('program') : 'barbering');
                    $this->data['programInfo'] = $this->client_model->get_program_grades_names();
                    $this->data['eventLabels'] = $this->user_model->get_event_labels();
                    
                    $this->data['title'] = "Program Setup";
                    $this->data['active'] = "programSetup";
                    
                    $this->load->view('templates/header', $this->data);
                    $this->load->view('templates/sidebar', $this->data);
                    $this->load->view('templates/topbar', $this->data);
                    $this->load->view('pageContent/programSetup', $this->data);
                    $this->load->view('templates/footer', $this->data);
                    


                }
            
            }else{
                
                redirect('login');

            }
        }
        /* Saves the calendar events allong with the colors selected for them
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function save_calendar_events_labels(){
        
            if ($this->is_session_set()){

                if(!empty($this->input->post())){

                    $input = array();

                    // //preparing data for insert
                    if (!empty($this->input->post('labels'))){
                        $input = $this->input->post('labels');

                    }else{
                        //no labels entered
                        $input = NULL;
                    }

                    $this->data['message'] = '';

                    //inserting input data 
                    if (!$this->user_model->set_event_labels($input)){
                        //error message
                        $this->data['message'] .= '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5>
                        <strong><i class="fa fa-2x fa-exclamation-mark"></i> Notice: </strong> The Calendar Event Labels were not saved.
                        <h5>
                        </div>
                        ';
                        log_message('debug', 'set_event_labels returned false when used in save_program_settings() main controller');       
                    }else{
                        // success message
                        $this->data['message'] .= '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5>
                        <strong><i class="fa fa-2x fa-smile"></i> Success!</strong> The changes made were saved for Calendar Event Labels. 
                        <h5>
                        </div>
                        ';
                    }
                    // setting message viewable only once, disapears upon page reload
                    $this->session->set_flashdata('message', $this->data['message']);
                    redirect('program-setup');

                }else{
                    redirect('program-setup');
                }
            }else{
                redirect('login');
            }
        }
        /* Saves the assesment names given to a particular program
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function save_program_assesment_names(){
        
            if ($this->is_session_set()){

                if(!empty($this->input->post()) && !empty($this->input->post('program'))){
                    $hasEnrolled = $this->client_model->get_enrolled_list($this->input->post('program'), NULL);

                    $this->data['message'] = '';
                    //checking if has enrolled client in program
                    if (!empty($hasEnrolled[0])){
                        
                        // setting program names to enrolled clients of a selected program
                        $result = $this->client_model->set_program_asses_name($this->input->post(NULL, TRUE));
        
                        //something went wrong witthe the query
                        if ($result === FALSE){

                            $this->data['message'] .= '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5>
                                <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> Something went wrong trying to update the assesment names. 
                                <h5>
                                </div>
                            ';

                        // no enrolled user in the program/training
                        }else{
                            //success message 
                            $this->data['message'] .= '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>
                            <strong><i class="fa fa-2x fa-smile"></i> Success!</strong> The changes made were saved for Program Assesments. 
                            <h5>
                            </div>
                            ';


                        }

                    }else{
                        $this->data['message'] .= '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5>
                        <strong><i class="fa fa-2x fa-exclamation-mark"></i> Notice: </strong> The training/program you have selected does not have anyone enrolled at the moment.
                        Please refer to the <a href="'.base_url().'enrolled-list"> enrolled list</a> or <a href="'.base_url().'client-list">add a client </a>
                        <h5>
                        </div>
                        ';
                    }
                    // setting message viewable only once, disapears upon page reload
                    $this->session->set_flashdata('message', $this->data['message']);
                    redirect('program-setup');

                }else{
                    redirect('program-setup');
                }
            }else{
                redirect('login');
            }
        }
        
        /* report_settings() displays the view for report setting (report.php in view)
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE 
        */    
        public function report_settings(){
        
            if ($this->is_session_set()){
                    
                $this->data['title'] = "Report settings";
                $this->data['active'] = "report";
                $result = $this->data['existingReports'] = $this->report_model->get_existing_reports();

                if($result === FALSE){
                        //query failed
                        log_message('debug', 'Could not query the records from the reports table, when called from generate_program_summary()');
                } 

                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/sidebar', $this->data);
                $this->load->view('templates/topbar', $this->data);
                $this->load->view('pageContent/report', $this->data);
                $this->load->view('templates/footer', $this->data);

            }else{
                redirect('login');
            }
        }
        /* saves the created report data as a view 
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE 
        */    
        public function save_report(){
        
            if ($this->is_session_set()){
                    
                if (!empty($this->input->post()) && in_array(10, $this->user_actions)){

                    // print_r($this->input->post());
                    $viewName = strtolower(preg_replace("/\s+/", "", $this->input->post('reportName', TRUE)));

                    //checking if report name exist
                    $reportExist = $this->report_model->get_report_info($viewName);

                    $this->message = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Sorry!</strong> Report name already exist.<h5>
                        </div>
                    ';
                    if (empty($reportExist)){


                        //creating view
                        $viewResult = $this->report_model->create_report_view($viewName, $this->input->post('query'));

                        //success message
                        $this->message = '
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-smile"></i> Success!</strong> Report was saved!<h5>
                            </div>
                        ';
                        if ($viewResult === FALSE){
                        //failed to create view
                            $this->message = '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Sorry!</strong> Something went wrong trying to save the report<h5>
                                </div>
                            ';
                            

                        }else{

                            $reportResult = $this->report_model->create_new_report($viewName, $this->input->post('reportName'));
                            
                            if ($reportResult === FALSE ){
                                //failed to create report record
                            
                                $this->message = '
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Sorry!</strong> Something went wrong trying to save the report<h5>
                                    </div>
                                ';
                                
                            }

                        }


                    }
                    
                    $this->session->set_flashdata('message', $this->message);
                    redirect('report');

                

                }else{
                    // does not have privilege
                    redirect('dashboard');
                }
            

                // $this->load->view('templates/header', $this->data);
                // $this->load->view('templates/sidebar', $this->data);
                // $this->load->view('templates/topbar', $this->data);
                // $this->load->view('pageContent/report', $this->data);
                // $this->load->view('templates/footer', $this->data);

            }else{
                redirect('login');
            }
        }
        /* Builds a query based on the post data provided to create a report
        *
        * @access    public
        * @param     reportData the data to build the report  
        *
        * @return    NONE 
        */    
        public function build_report_query($reportData = NULL, $gradeFilter = NULL){
        
            if ($this->is_session_set()){
                    
                if (in_array(10, $this->user_actions) && !empty($reportData)){
                    
                    $gradeSelect = '';
                    // part of query for grades
                    $enrolled_in = (isset($reportData['gradeOption']['enrolledOn']))? 'p.enrolled_in as `Enrolled In`' : '';
                    $graduated_on = (isset($reportData['gradeOption']['graduatedOn']))? 'p.graduated_on as `Graduated On`' : '';
                    $assesments= (isset($reportData['gradeOption']['listAssesments']))? 
                    'p.Assesment1,p.Assesment2,p.Assesment3,p.Assesment4,p.Assesment5' : 
                    '';
                    $finalAvg  = (isset($reportData['gradeOption']['finalAvg']))? 'status, p.final_grade as `Final Average`' : '';
                    $comment  = (isset($reportData['gradeOption']['notes']))? 'p.notes as `Notes`' : '';

                    //contructing grade query
                    $gradeSelect .= 
                    (!empty($enrolled_in)? $enrolled_in.',' : '').
                    (!empty($graduated_on)? $graduated_on.',' :'').
                    (!empty($assesments)? $assesments.',' : '').
                    (!empty($finalAvg)? $finalAvg.',' : '').
                    (!empty($comment)? $comment.',' : '');
                    
                    $clientSelect = '';

                    //part of query for client Info
                    $personalInfo = (isset($reportData['clientInfo']['personalInfo']))? 
                    'CONCAT(a.first_name," ",a.last_name ) as `Name`, a.gender as `Gender`, a.email as `Email`, a.mobile_phone as `Phone Number`' : '';

                    $addressInfo = (isset($reportData['clientInfo']['address']))? 
                    'a.street as `Street`, a.ctv AS `City/Town/Village`' : '';
                    
                    $emergInfo = (isset($reportData['clientInfo']['emergContactInfo']))? 
                    'a.ec_name as `Emerg. Contact Name`, a.ec_number as `Emerg. Contact Number`, a.ec_relation as `Emerg. Contact Relation`' : '';

                    $referenceInfo = (isset($reportData['clientInfo']['references']))? 
                    'a.ref_name1 as `Ref. Name #1`, a.ref_address1 as`Ref. Address #1`, a.ref_city1 as `Ref. City #1`, a.ref_phone1 as `Ref. Phone #1`,
                    a.ref_name2 as `Ref. Name #2`, a.ref_address2 as`Ref. Address #2`, a.ref_city2 as `Ref. City #2`, a.ref_phone2 as `Ref. Phone #2`,
                    a.ref_name3 as `Ref. Name #3`, a.ref_address3 as`Ref. Address #3`, a.ref_city3 as `Ref. City #3`, a.ref_phone3 as `Ref. Phone #3`' : '';
                    
                    $eduInfo = (isset($reportData['clientInfo']['eduInfo']))? 
                    'a.ed_name as `Educational Institution`, a.ed_degree as `Education Level`':'';
                    
                    $empInfo = (isset($reportData['clientInfo']['empInfo']))? 
                    'a.employed_at as `Employer` , a.em_position as `Job Title`' :'';

                    //contructing client query
                    $clientSelect .= 
                    (!empty($personalInfo)? $personalInfo.',' : '').
                    (!empty($addressInfo)? $addressInfo.',' : '').
                    (!empty($emergInfo)? $emergInfo.',' : '').
                    (!empty($referenceInfo)? $referenceInfo.',' : '').
                    (!empty($eduInfo)? $eduInfo.',' : '').
                    (!empty($empInfo)? $empInfo.',' : '');

                    $enrolled_on = (!empty($reportData['yearFilter']))? 'AND p.enrolled_in = '.$reportData['yearFilter'] : ''; 
                    
                    $limit = ($reportData['limit'] != 1)? 'ORDER BY `Final Average` DESC LIMIT '.$reportData['limit'] : '';

                    $where = 'p.status = "'.$reportData['programStatus'].'" '.$enrolled_on.' '.$gradeFilter.' '.$limit;

                    $query = 'SELECT p.programme  as `Program`  ,'.$clientSelect.$gradeSelect.(isset($empInfo)? ' is_employable as `Employable`' : '').' FROM applicants a, '.$reportData['program'].' p WHERE a.id = p.client_id AND '.$where.''; 

                    //final filtering of query
                    return str_replace(', FROM', ' FROM', $query);

                }else{
                    // does not have privilege
                    redirect('dashboard');
                }
            

            }else{
                redirect('login');
            }
        }

        /* report_settings() displays the view for report setting (report.php in view)
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE 
        */    
        public function generate_program_report(){
        
            if ($this->is_session_set()){
                    
                if (in_array(10, $this->user_actions)){
                    

                    //setting page title
                    $this->data['title'] = "Report Summary Report";
                    
                    //generate a report   
                    if ($this->input->post('action') ===  'generateReport'){
                        // Existing report

                        // echo "<pre>";
                        // print_r($this->input->post());
                        // echo "</pre>";

                        $reportInfo = $this->report_model->get_report_info($this->input->post('reportName'));
                        $result = $this->report_model->get_report_view($this->input->post('reportName'));

                        if ($result === FALSE){
                            log_message('debug', 'get_report_view returned FALSE from generate_program_summary() in user controller');
                        }

                        $this->data['reportData'] = $result;
                        $this->data['reportInfo'] = $reportInfo[0];

                    }else{
                        // creating a new report
                        if ($this->input->post('action') === 'createReport'){
                            
                            //creating a save button
                            
                            $this->data['saveBtn'] = '
                                <a href="#" id="saveReport" class="btn btn-success btn-sm " data-toggle="modal" data-target="#saveReportModal"><i class="fa fa-save"></i> Save Report</a>
                            ';
                            

                        // echo "<pre>";
                        // print_r($this->input->post());
                        // echo "</pre>";
                            // part of query for grade filtering
                            $grade = 'AND ';

                            switch ($this->input->post('gradeFilter')) {
                                case '100':
                                    $grade .= 'p.final_grade >= 100';
                                    break;
                                case '90':
                                    $grade .= 'p.final_grade BETWEEN  90 AND 99.9';
                                    break;
                                case '80':
                                    $grade .= 'p.final_grade BETWEEN  80 AND 89.9';
                                    break;
                                case '70':
                                    $grade .= 'p.final_grade BETWEEN  70 AND 79.9';
                                    break;
                                case '0':
                                    $grade .= 'p.final_grade BETWEEN  0 AND 69.9';
                                    break;
                                    
                                default:
                                    $grade = '';
                                    break;
                            }
                            

                        //building a query from our post data
                            $query = $this->build_report_query($this->input->post(), $grade);

                            
                            //executing query
                            $result = $this->report_model->run_report_query($query);
                            

                            if ($result == FALSE){
                                log_message('debug', 'run_report_query() in client model returned false');
                                $this->session->set_flashdata('message',
                                '
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5>
                                    <strong><i class="fa fa-2x fa-frown"></i> Oh Snap!</strong> An error occured while trying to create the report. 
                                    <h5>
                                    </div>
                                ');

                            }
                            $this->data['query'] = $query;
                            $this->data['reportData'] = $result;
                        }  
                    }  
                    
                    
                    $this->load->view('templates/header', $this->data);
                    $this->load->view('templates/sidebar', $this->data);
                    $this->load->view('templates/topbar', $this->data);
                    $this->load->view('pageContent/programSumReport', $this->data);
                    $this->load->view('templates/footer', $this->data);


                }else{
                    //try to access page without data or privilege set
                    redirect('dashboard');
                }
            }else{
                redirect('login');
            }
        }
    
        /* Function will uneroll a client based on the post data recieved
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function unenroll_client(){
        
            if ($this->is_session_set()){
                
                //checking if post data is set and user had the privilege to editGrade meaning they can unenroll client
                if ($this->input->post('action') === 'unEnrollClient' && in_array(6, $this->user_actions)){

                    $slug = explode('/',$this->input->post('slug'));

                    $program = $slug[0];

                    // getting table name
                    $tableName = $this->programTables[$program];
                    
                    // unenrolling client from programs
                    $result = $this->client_model->remove_enrolled_client($tableName, $this->input->post('programId'));

                    $this->message = '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-Smile"></i> Success!</strong> Client was removed from the Program.<h5>
                        </div>
                    ';
                        

                    
                    if ($result === FALSE){
                        $this->message = '
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Sorry!</strong> Something went wrong trying to unenroll client<h5>
                            </div>
                        ';

                    }
                    if (!empty($this->input->post('is_enrolled')) && $this->input->post('is_enrolled') != ''){
                        //reducing is_enrolled count
                        $enrollCount = $this->input->post('is_enrolled')-1;
                    

                        $enrollCountResult = $this->client_model->decrease_enroll_count($this->input->post('clientId'), $enrollCount);
                    
                        if($enrollCountResult == FALSE){
                            log_message('debug', 'decrease_enroll_count() returned false when called from unenroll_client() in Main controller');
                        }
                    }
                    
                    $this->session->set_flashdata('message', $this->message);
                    redirect('enrolled-list');
                    

                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('login');
            }
        }
        /* get_cal_events() call the get_cal_events model and returns a json encode response
        *
        * @access    public
        * @param     NONE 
        *
        * @return    json_encode() of the events retrieved from the user_model 
        */    
        public function get_cal_events(){
        
            if ($this->is_session_set()){
                    
            $result = $this->user_model->get_cal_events();
                
            if ($result != FALSE){

                $eventList = array();
                
                    foreach ($result as $key => $arr){
                        
                        // $arr = array();

                        $startTime = explode(' ', $arr['start']);
                        $endTime = explode(' ', $arr['end']);
                    
                        //making the event a whole day if both start and end date time are not set
                        if ($startTime[1] == '00:00:00' && $endTime[1] == '00:00:00'){
                            $arr['start'] = $startTime[0];
                            $arr['end'] = $endTime[0];
                            
                            
                        }
                        $arr['labelId'] = (isset($arr['color'])? str_replace('#', '', $arr['color']) : '');
                        $eventList[$key] = $arr;
                    }

                    // print_r($eventList);
                echo json_encode($eventList);

            }else{
                echo json_encode(0);//query did not run succesfully
            }

            }else{
                redirect('login');
            }
        }
        /* Removes an existing report  
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function remove_existing_report(){
        
            if ($this->is_session_set() && in_array(10, $this->user_actions)){
                

                if (!empty($this->input->post()) && $this->input->post('action') == 'deleteReport'){

                    // setting success message
                    $this->message = '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-smile"></i> Success!</strong> The existing report was removed.<h5>
                        </div>
                    ';
                    // removing the existing report
                    $result = $this->report_model->remove_existing_report($this->input->post('viewName'));
                
                if ($result === -1){
                    // Report cannot be deleted
                    $this->message = '
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5><strong><i class="fa fa-2x fa-exclamation-triangle"></i> Notice!</strong> The Selected Report cannot be removed. Only created reports by system users can be removed<h5>
                        </div>
                    ';
                    

                }else{

                    if($result === FALSE){
                        //query failed
                            $this->message = '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5><strong><i class="fa fa-2x fa-frown"></i> Sorry!</strong> We cannot remove the report at this time.<h5>
                                </div>
                            ';

                    }

                }
                   $this->session->set_flashdata('message', $this->message);
                   redirect('report');

                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('login');
            }
        }
        /* Calls the respective model to insert calendar events 
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function add_cal_event(){
        
            if ($this->is_session_set()){
                
                if (!empty($this->input->post())){

                    $result = $this->user_model->add_cal_event($this->input->post(NULL, TRUE));
                     
                    if ($result === TRUE){
                        //succesfully added event to calendar
                        // $labels = $this->user_model->get_event_labels();

                        // $found = false;
                        // foreach ($labels as $key => $arr){
                        //     $found = array_search($this->input->post('color'), $key);
                        //     if ($found){
                        //         $found = $key;
                        //         break;
                        //     }
                        // }
                        // if ($found['sendEmail'] == 1){
                        //     //sending email 

                        // }
                        echo 1;
                    }else{
                        echo 0;
                    }

                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('login');
            }
        }
        /* delete_cal_events() will remove an event 
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function delete_cal_event(){
        
            if ($this->is_session_set()){
                
                if (!empty($this->input->post('eventId'))){

                $result = $this->user_model->delete_cal_event($this->input->post('eventId', TRUE));
                    
                    if ($result === TRUE){
                        echo 1;
                    }else{
                        echo 0;
                    }
                    // print_r($this->input->post());

                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('login');
            }
        }
        
        /* delete_cal_events() will remove an event 
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function update_cal_event(){
        
            //checking if session is set
            if ($this->is_session_set()){

                if (!empty($this->input->post())){

                    //send update request
                    $result = $this->user_model->update_cal_event($this->input->post(NULL, TRUE));
                    
                    if ($result === TRUE){

                        $label = array();

                        //check if calendar event label notification is set
                        $labels = $this->user_model->get_event_labels();
                        
                        //finding the event label the updated event has
                        foreach ($labels as $key => $array){
                            if ($this->input->post('color') == $array['color']){
                                $label = $labels[$key];
                                break;
                            }
                        }
                        if ($label['sendNotification'] == 1){
                            //set notification
                        }
                        //setting notifications for all users
                        $users = $this->user_model->get_user_list();
                        
                        foreach ($users as $key => $user){
                            //inserting notifications for user
                            if ($user['status'] == 1){
                                $insert = array(
                                    'event_id' => $this->input->post('eventId'),
                                    'icon' => 'fas fa-calendar-alt',
                                    'icon_background_color' => 'bg-info',
                                    'notice_title' => 'A "<span style="color: '.$label['color'].';">'.$this->input->post('title').'</span>" event was updated! Click to see event.',
                                    'created_for' => $user['id']
                                );
                                $result = $this->user_model->set_notification($insert);
                                
                                if(!$result){
                                    log_message('debug', 'Notification was not set for userID: '.$user['id'].',occured in update_cal_event inside main controller');
                                }
                            }
                                
                        }
                        // echo json_encode($users);
                        // echo json_encode($label);
                        echo 1;
                    }else{
                        echo 0;
                    }

                }else{
                    redirect('dashboard');
                }

            }else{
                echo 'logged out';
            }
        }
        /* searches  based on option picked 
        *
        * @access    public
        * @param     NONE 
        *
        * @return    NONE
        */    
        public function advance_search(){
        
            //checking if session is set
            if ($this->is_session_set()){

                if (!empty($this->input->post()) && !empty($this->input->post('searchVal', TRUE)) ){
                //post was recieved
                
                $search = trim(str_replace(' ', '', $this->input->post('searchVal', TRUE)));
                $filterBy = trim(str_replace(' ', '', $this->input->post('searchBy', TRUE)));

                //where condition for query based on searchBy 
                $searchBy = '';
                switch ($filterBy) {
                    case 3:
                        $searchBy = 'a.email LIKE "%'.htmlspecialchars($search).'%"';
                        break;
                    case 2:
                        $searchBy = 'a.mobile_phone LIKE "%'.htmlspecialchars($search).'%"';
                        break;
                    case 1:
                        $searchBy = 'a.ssn LIKE "%'.htmlspecialchars($search).'%"';
                        break;
                    default:
                        $searchBy = 'CONCAT(first_name, last_name) LIKE "%'.htmlspecialchars($search).'%"';
                }

                //filter by district
                $searchBy .= ($this->input->post('district') == 'all')? '' : 'and a.country ='.'"'.$this->input->post('district').'"';

                $this->data['clientInfo'] = $this->user_model->advance_search($searchBy);
                $this->data['searchValue'] = $search;
                $this->data['title'] = 'Search Result';

                $this->load->view('templates/header', $this->data);
                $this->load->view('templates/sidebar', $this->data);
                $this->load->view('templates/topbar', $this->data);
                $this->load->view('pageContent/search', $this->data);
                $this->load->view('templates/footer', $this->data);
                    

                }else{
                    redirect('dashboard');
                }

            }else{
                redirect('login');
            }
        }
        
        
        
    }

    ?>

<?php
class User_model extends CI_Model{

    function __construct(){
        parent::__construct();

        $this->load->database();
    }
    /**
     * 
     * Function will return privileges if status is set to 1 by default if checkstatus is not set.
     *
     * @access    public
     * @param     userId is the ID of the user in the system
     * @param     checkStatus requires a 1 or 0, 1 checks status, 0 does not
     *
     * @return    Array that contains a list of all the privileges by id
     */    
    public function get_user_action($userId = NULL, $checkStatus = 1){
        
        $this->db->trans_start();
        $sql = $this->db->query('SELECT privilege_id '.(($checkStatus === 0)? ', status' : ' ').' FROM action  WHERE user_id = '.$userId.' '.(($checkStatus === 1)? 'and status = 1': '').'');
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return $sql->result_array();
        }
        
        
        return FALSE;

    }
    /**
     * 
     * Function will return all notifications pertaining to the user
     *
     * @access    public
     * @param     userId is the ID of the user in the system
     *
     * @return    Array that contains a list of all the privileges by id
     */    
    public function get_all_user_notifications($userId = NULL){
        
        $this->db->trans_start();
        $sql = $this->db->query('SELECT * FROM `notifications` n WHERE n.created_for = '.$userId.' and n.status = 1 ORDER BY `created_on` DESC');
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return $sql->result_array();
        

    }
    /**
     * 
     * Creates a notification for a user
     *
     * @access    public
     * @param     data the insert data formated for insert
     *
     * @return    boolean determines the success of the query
     */    
    public function set_notification($data = NULL){ 
        
        $this->db->trans_start();
        $this->db->insert('notifications', $data);
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
            return FALSE;
        }
        return TRUE;

    }
    /**
     * 
     * Function will return all privileges if status is 1
     *
     * @access    public
     *
     * @return    boolean determines the success of the query
     */    
    public function update_notification($set = NULL, $where = NULL){ 
        
        $this->db->trans_start();
        $this->db->update('notifications', $set, $where);
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
            return FALSE;
        }
        return TRUE;

    }
    /**
     * 
     * Function will return all privileges if status is 1
     *
     * @access    public
     *
     * @return    Array that contains a list of all the privileges by id
     */    
    public function get_all_privileges(){
        
        $this->db->trans_start();
        $sql = $this->db->query('SELECT a.id, a.name FROM privileges a WHERE status = 1');
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return $sql->result_array();
        }
        
        
        return FALSE;

    }
    /**
     * get_user_info() will return all users data that the system has excluding password
     *
     * @access    public
     * @param     NONE
     *
     * @return    Array that contains a list of all the data the user has in the system 
     */    
    public function get_user_info($userId){

        $sql = $this->db->query(
        'SELECT u.id, fname, lname, email, username, u.status, phone, profile_img_id, p.path as imgPath
        FROM users u, profile_img p WHERE u.id = '.$userId.' and u.profile_img_id = p.id and p.status = 1'
        );
        $row = $sql->num_rows();
        if ($row === 1){

            $privi = $this->get_user_action($userId);

            if ($privi === FALSE){
                return FALSE;
            }
            $result = array_merge($sql->row_array(), array('action' => $privi));
            return $result;
        }
        
        return FALSE;

    }
   
    /**
     * updates the current users profile by updating what he/she has in the system 
     *
     * @access    public
     * @param     DATA  the data that is to be updated.(data within the POST)
     *
     * @return    BOOLEAN true/flase if upate was successful or not
     */    
    public function update_user_info($data = NULL){
        
        $result = $this->update_user_profile($data['userId'], $data);
        if (!$result){//if result is false then return false
            return FALSE;
        }
        if ($data !== NULL){
            
            $currentPrivi = $this->get_user_action($data['userId'], 0);
            //print_r($data['privilege']);

            $tempPrivi = array();
            $selectedPriv = (isset($data['privilege']))? $data['privilege'] : array();
            //print_r($selectedPriv);
            $this->db->trans_start();
            
            foreach ($currentPrivi as $arr){
                if (in_array($arr['privilege_id'], $selectedPriv)){
                    if ($arr['status'] == 0){
                        // update action table set status to 1
                        $input = array (
                            'status' => 1

                        );
                        $where = array(
                            'user_id' => $data['userId'],
                            'privilege_id' => $arr['privilege_id']
                        );
                        $this->db->update('action',$input, $where );//arguments- table, set values, where

                    }

                    // echo $arr['privilege_id']."\n";
                    $key = array_search($arr['privilege_id'], $selectedPriv);//needle, haystack - arguments
                    unset($selectedPriv[$key]);

                }else{
                    if ($arr['status'] ==  1){

                        //update and set status to 0
                        $input = array (
                            'status' => 0

                        );
                        $where = array(
                            'user_id' => $data['userId'],
                            'privilege_id' => $arr['privilege_id']
                        );
                        $this->db->update('action',$input, $where );//arguments- table, set values, where
                        // $key = array_search($arr['privilege_id'], $selectedPriv);//needle, haystack - arguments
                        // unset($selectedPriv[$key]);

                    }
                }

            }
            if (!empty($selectedPriv)){
                // insert the new privilege
                foreach ($selectedPriv as $key){
                    
                    //insert new privilege
                    // echo $key." this key need to be inserted\n";
                    $input = array(

                        'user_id' => $data['userId'],
                        'privilege_id' => $key,
                        'status' => 1

                    );
                    $this->db->insert('action', $input);
                }

            }
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }

            return TRUE;

        }else{

            return FALSE;
        }

    }
    /**
     * updates the current users profile by updating what he/she has in the system 
     *
     * @access    public
     * @param     USERID the user's id that is used to identify him in the database
     * @param     DATA  the data that is to be updated.(data within the POST)
     *
     * @return    BOOLEAN true/flase if upate was successful or not
     */    
    public function update_user_profile($userid = NULL, $data = NULL){
        
        if (isset($userid) && $data !== NULL){

            $this->db->trans_start();

         
            // username = "'.$data['username'].'", 
            $query = $this->db->query('
            UPDATE users 
            SET fname = "'.$data['fname'].'", 
            lname = "'.$data['lname'].'", 
            phone = "'.$data['phone'].'" 
            WHERE id = '.$userid.'');
           
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }

            return TRUE;

        }else{

            return FALSE;
        }

    }
    /**
     * Gets all users that are within the system  
     *
     * @access    public
     * @param     NONE
     *
     * @return    Array that contains a list of all the users in the system 
     */    
    public function get_user_list(){

        $this->db->trans_start();
        $this->db->select('*');

        $query = $this->db->get('users');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){

            return FALSE;

        }else{

            return $query->result();
            
        }

    }
    public function set_user_default_pass($userId = NULL){
        
        if ($userId !== NULL){
            $defaultPass = 'Passw0rd';
            $this->db->trans_start();
            $this->db->update('users',array('password'=>md5($defaultPass)),array('id'=>$userId));
            $query = $this->db->get('users');
            $this->db->trans_complete();
            if ($this->db->trans_status === FALSE){
                return FALSE ;
            }
            return true;
            
        }

    }
    // Parameter is a Post array and that data is then loaded into the user table
    public function enter_user($data = NULL){

        if ($data !== NULL){

            // /data from form submission 
            $fname = (isset($data['fname'])? trim($data['fname']): '');
            $lname = (isset($data ['lname'])? trim($data['lname']) : '');
            $uname = (isset($data['uname'])? trim($data['uname']) : '');
            $email = (isset($data['email'])? trim($data['email']) : '');
            $phone = (isset($data['phone'])? trim($data['phone']) : '');
            
            $privileges = (!empty($data['privileges']))? $data['privileges'] : NULL;
            
            //Checking to see if user exist in the database by email
            $this->db->select('id', 'status');
            $this->db->where(array('email' => $email ));
            $query = $this->db->get('users');
            $row = $query->num_rows();
            $existingUser = $query->row();
            //$size = count($data['privileges']);
           
            if($row < 1){
                // user does not exist lets add him to the system
                
                $input = array(
                    'fname'  => $fname,
                    'lname'  => $lname,
                    // 'username'  => $uname,
                    'email'  => $email,
                    'password'  => md5($data['password']),
                    'phone'  => $phone,
                    'profile_img_id' => 1,
                    'created_by' => $this->session->userdata('userIdentity')
                    
                );  

                $this->db->trans_start();//starting transaction
                $this->db->insert('users', $input);
                $actionData['user_id'] = $this->db->insert_id();
                $actionData['status'] = 1;

                if ($privileges != NULL){

                    foreach ($data['privileges'] as $val){
                        //inserting user privileges
                        $actionData['privilege_id'] = $val;
                        $this->db->insert('action', $actionData);

                    }

                }
                $this->db->trans_complete();//ending transaction

                if($this->db->trans_status() === FALSE){//checking to see if an error occured during transaction

                    return FALSE;

                }else{

                    return TRUE;
                }

                
            }else{
                return $existingUser->id;//returning 0 to identify that user is in the system
            }
           

        }else{

            return FALSE;
        }
    }
    /**
     * Sets a the profile pic of the user to default and sets the old pic's status to 1;
     *
     * @access    public
     * @param     userId the id of the users in which the profile image belongs to
     * @param     oldImgId the old profile pic ID 
     * 
     * @return    Boolean true/false if the query was successful
     */    
    public function set_default_profile_pic($userId = NULL, $oldImgId = NULL){
        
        $this->db->trans_start();

            //setting old img status to 0 - no longer in use
            $this->db->update('profile_img',array('status' => 0), array('id' => $oldImgId));

            //setting user profile pic to default 
            $this->db->update('users',array(
                // columns to be updated
                'profile_img_id' => 1, 
                'updated_by' => $this->session->userdata('userIdentity'),
                'updated_on' => date("Y-m-d H:i:s"),
            ),
            array('id' => $userId));


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            //if a query fails then it will automatically rollback the query's
            return FALSE;
        }
        return TRUE;
    }
    /**
     * Sets the profile pic in the database's profile_img table
     *
     * @access    public
     * @param     userid the id of the users in which the profile image belongs to
     * @param     filename the name of the image file
     * 
     * @return    Boolean true/false if the query was successful
     */    
    public function set_profile_pic($userid = NULL, $filename = NULL){

            //Checking to see if user has an existing profile image other than the default
            $this->db->trans_start(); 
           
            $sql = $this->db->query(
            'SELECT u.id, profile_img_id as p_id FROM users u WHERE u.id = '.$userid.''
            );
            $result = $sql->row_array();
           
            //creating input values for query
            $input = array(
                'path' => 'upload/'.$filename ,
                'status' => 1
            );
            
            $this->db->insert('profile_img', $input);//inserting the new image 
            
            $pId = $this->db->insert_id();//getting last inserted ID i.e. id of profile_image 
            
            //assigning new image to user
            $this->db->update('users',array(
                //columns to be updated in the user table
                'profile_img_id'=>$pId,
                'updated_by' => $this->session->userdata('userIdentity'),
                'updated_on' => date("Y-m-d H:i:s"),
            ), 'id= '.$userid.''); 
            
            if ($result['p_id'] != 1){
                
                //deleting the old image by setting old image status to 0 meaning false 
                $this->db->update('profile_img',array('status'=>0), 'id= '.$result['p_id'].'');

            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }else{
                return $pId;
            }


    }
    /**
     * sets the status of a users, which indicates if the user can access the system or not.
     *
     * @access    public
     * @param     userId the id of the user selected
     * @param     status you can specify the status of the user 1 = can use the system and 0 = not being able to use the system
     *
     * @return    Boolean true/false if transaction was successful
     */    
    public function set_user_status($userId = NULL, $status = 0){
    
        $this->db->trans_start(); 

        $this->db->update('users',array('status'=>$status), 'id= '.$userId.'');
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }else{
            return TRUE;
        }
    
    }


    /**
     * function set updated_by and update_on in the user table
     *
     * @access    public
     * @param     userId the id of the user whose profile was updated
     * @param     userIdentity the signiture stamp of the user that made the update  
     * 
     * @return    Boolean true if successful, false if transaction faild
     */    
    public function set_user_update_info($userId = NULL, $userIdentity = NULL) {
        
        $this->db->trans_start();
        
        $this->db->update('users', array('updated_on' => date("Y-m-d H:i:sa") , 'updated_by' => $userIdentity), array('id' => $userId));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return TRUE;
    
    }
    /**
     * function set updated_by and update_on in the user table
     *
     * @access    public
     * @param     userId the id of the user whose profile needs to be activated
     * 
     * @return    Boolean true if successful, false if transaction faild
     */    
    public function activate_user($userId = NULL) {
    
        $this->db->trans_start();
        
        $this->db->update('users', array('status' => 1), array('id' => $userId));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return TRUE;
        
    }
    /**
     * Will query the applicants table to get alist of all the clients based on the search value
     *
     * @access    public
     * @param     search the keyword that is to be queried
     * @param     searchBy determines the column data the search should match
     * 
     * @return    Array containing all the data that matched the word
     */    
    public function get_autocomplete($search = NULL, $searchBy = NULL) {
      
        $this->db->trans_start();

           $sql = $this->db->query('
        
           SELECT 
               CONCAT(first_name," ",last_name) as full_name 
           FROM applicants a
           WHERE 
               CONCAT(first_name, last_name) LIKE "%'.trim($search).'%" 
           ORDER BY full_name ASC 
           LIMIT 
               10 
               
           ');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            
            log_message('debug', 'get_autocomplete user model function returned false');
            return FALSE;
        }

        return $sql->result_array();

    
    }
    /**
     * function querys the event and user table to get data for the calendar 
     *
     * @access    public
     * @param     NONE
     * 
     * @return    array of data for the calendar
     */    
    public function get_cal_events() {
    
        $this->db->trans_start();
        
        $sql = $this->db->query('
        SELECT e.id as id, concat(u.fname," ", u.lname) as created_by, e.color, (SELECT CONCAT(us.fname, " ", us.lname) FROM users us WHERE us.id = e.updated_by) as updated_by, e.title, e.description, e.startDate as start, e.endDate as end 
        FROM events e, users u
        WHERE e.created_by = u.id and e.status = 1
        ');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
           
            log_message('debug', 'get_cal_events user_model function returned false');
            return FALSE;
        }
        
        return $sql->result_array();
        
    }
    /**
     * Inserts into the database a new event added to the calendar 
     *
     * @access    public
     * @param     eventData an array containing the event data
     * 
     * @return    boolean 
     */    
    public function add_cal_event($eventData) {
    
        $input = array (
            'created_by' => $this->session->userdata('userid'),
            'title ' => $eventData['title'],
            'description' => $eventData['description'],
            'startDate' => $eventData['startDate'],
            'endDate' => $eventData['endDate'],
            'color' => $eventData['color'],
            'status' => 1

        );
        $this->db->trans_start();
        
        $this->db->insert('events', $input);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
           
            log_message('debug', 'add_cal_event user_model function returned false');
            return FALSE;
        }
        
        return TRUE;
        
    }
    /**
     * Sets the status of the event to zero, meaning it is no longer a valid event
     *
     * @access    public
     * @param     eventId id of the event 
     * 
     * @return    boolean 
     */    
    public function delete_cal_event($eventId) {

        $this->db->trans_start();
        
        $this->db->update('events', array('status' => 0), array('id' => $eventId));
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
           
            log_message('debug', 'delete_cal_event user_model function returned false');
            return FALSE;
        }
        
        return TRUE;
        
    }
    /**
     * updates an event 
     *
     * @access    public
     * @param     eventData post data, concerning the modifications made
     * 
     * @return    boolean 
     */    
    public function update_cal_event($eventData = NULL) {

        $set = array();



        // will be triggered if a drag and drop occurs
        if (isset($eventData['startDate']) && isset($eventData['endDate'])){

            $set['startDate'] = $eventData['startDate'];
            $set['endDate'] = $eventData['endDate'];


        }
        if(isset($eventData['color'])){
            $set['color'] = $eventData['color'];
        }

        //merging both arrays 
        $set = array_merge( $set ,  array(
            'updated_by' => $this->session->userdata('userid'),
            'title ' => $eventData['title'],
            'description' => $eventData['description']
            
        ));
        
      
        $this->db->trans_start();
        
        $this->db->update('events', $set, array('id' => $eventData['eventId']));
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
           
            log_message('debug', 'update_cal_event user_model function returned false');
            return FALSE;
        }
        
        return TRUE;
        
    }
    /**
     * Gets all event_labels create, i.e. the label's name and color code 
     *
     * @access    public
     * @param     NONE
     *
     * @return    Array that contains a list of all the data the user has in the system 
     */    
    public function get_event_labels(){

        $this->db->trans_start();

        $this->db->select('id, label, color, sendNotification');
        $this->db->where(array('status' => 1));
        $query = $this->db->get('event_labels');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }

        return $query->result_array();
    }
    /**
     * sets all labels with the respective color provied  
     *
     * @access    public
     * @param     data array containg all records to be inserted  
     *
     * @return    Array that contains a list of all the data the user has in the system 
     */    
    public function set_event_labels($data = NULL){

        $this->db->trans_start();
       
        //removes all event labels
        $this->db->update('event_labels', array('status' => 0), array('status' => 1));

        if (!empty($data)){

            foreach ($data as $key => $input){

                if (isset($input['id'])){
                    //updating existing record
                    $this->db->update('event_labels', array(
                        'color' => $input['color'],
                        'label' => $input['name'],
                        'updated_by' => $this->session->userdata('userIdentity'),
                        'updated_on' => date("Y-m-d H:i:s"),
                        'sendNotification'=> ((isset($input['sendNotification']) && $input['sendNotification'] == 1)? 1 : 0),
                        'status' => 1
                    ), array('id' => $input['id']));

                }else{
                    //new record 
                    $this->db->insert('event_labels', array(
                        'label' => $input['name'],
                        'sendNotification'=> ((isset($input['sendNotification']) && $input['sendNotification'] == 1)? 1 : 0),
                        'color' => $input['color'],
                        'created_by' => $this->session->userdata('userIdentity') 
                    ));

                }

            }


        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }

        return TRUE;
    }
    /**
     * Querys the database based for a particular client based on the searchby value provided
     *
     * @access    public
     * @param     searchBy part of the where clause in the query 
     * 
     * @return    Array containing all the data that matched the word
     */    
    public function advance_search($searchBy = NULL) {
      
        $this->db->trans_start();

           $sql = $this->db->query('
           SELECT 
               a.*, p.path as img_path
           FROM applicants a, profile_img p
           WHERE 
               a.is_client = 1 and   
            '.$searchBy.' and 
               a.profile_img_id = p.id

            LIMIT 15
               
           ');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            
            log_message('debug', 'advance_search in user model function returned false');
            return FALSE;
        }

        return $sql->result_array();

    
    }

}

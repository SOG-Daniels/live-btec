<?php 
class Validation_model extends CI_Model{

    public function __construct(){

       $this->load->database();

    }
    public function get_user($email, $pass){
        
        $sql = $this->db->query('SELECT u.id, fname, lname, email, p.path, u.profile_img_id FROM users u, profile_img p WHERE u.email = "'.$email.'" and u.password = "'.md5($pass).'" and u.profile_img_id = p.id and u.status = 1');
        $row = $sql->num_rows();
        if ($row === 1){
            
            $userData = $sql->row_array();

            //starting to get the privileges/action the user has in the system
            $sql2 = $this->db->query('SELECT a.privilege_id as actions FROM action a WHERE a.user_id = '.$userData['id'].' and a.status = 1');

            if($this->db->trans_status() === FALSE){
                return FALSE;
            }
                $action = $sql2->result_array();
                array_push($userData, $action);//pushing the privileges array to the userdata

                return $userData;
            }
        
        return FALSE;

    }
    public function get_user_by_email($email = NULL){

        $sql = $this->db->query('SELECT id FROM users u WHERE u.email = "'.$email.'" and status = 1');
        $row = $sql->num_rows();
        
        if ($row > 0){
            return $sql->row();
        }
        
        return FALSE;

        
    }
    //sets password reset token and returns the last inserted ID if succesfull
    public function set_pass_reset($email = NULL, $token = NULL, $expires = NULL ){

        $data = array(
            'email' => $email,
            'token' => md5($token),
            'expiring_date'=> $expires
        ); 

        //updating the token and expires column in the passreset table
        $this->db->trans_start();

        $this->db->insert('reset_password', $data);
        $id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE){
            return FALSE;
        }

        return $id ;

    }
    
    public function set_new_pass($userid = NULL, $newPass = NULL){

        if ($userid !== NULL and $newPass !== NULL){

            $this->db->trans_start();
            $query = $this->db->query('UPDATE users SET password = "'.md5($newPass).'" WHERE id = '.$userid.'');
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }

            return TRUE;

        }

    }
    public function get_token_info($passResetId = NULL, $token = NULL){
        
        if (isset($token)){
            
            $this->db->where(array(
                'token' => md5($token),
                'id' => $passResetId,
                'status' => 1
                )

            );
            $this->db->select('id, token, expiring_date, email');
            $sql = $this->db->get('reset_password');

            if($this->db->trans_status() == FALSE){
                return FALSE;
            }
    
            return $sql->row();
    

        }
        return FALSE;
        

    }
    // sets token status to 1, meaning it is no longer valid
    public function disable_token($passResetId = NULL, $token = NULL){
        
        $this->db->trans_start();

            
        $this->db->update('reset_password', array('status' => 0), array('id' => $passResetId, 'token' => $token));

        $this->db->trans_complete();
        if($this->db->trans_status() == FALSE){
            return FALSE;
        }

        return TRUE;

    }
    // finds a token for an email
    public function find_token_by_email($email = NULL){

        $this->db->trans_start();

        $this->db->where(array(
            'status' => 1,
            'email' => $email
        ));
        $this->db->select('id, token, expiring_date, email');
        $sql = $this->db->get('reset_password');

        $this->db->trans_complete();
        if($this->db->trans_status() == FALSE){
            return FALSE;
        }

        return $sql->row();



    }
}


?>
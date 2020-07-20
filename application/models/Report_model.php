<?php
class Report_model extends CI_Model{

    function __construct(){
        parent::__construct();

        $this->load->database();
    }

    /**
     * queries the database to get the data from the report table
     *
     * @access    public
     * @param     none  
     * 
     * @return    Boolean/Array array of records if successful, false if transaction failed
     */    
    public function get_report_info($viewName = NULL) {
   
        $this->db->trans_start();
        
        // select * from reports where view_name = $viewName
        $sql = $this->db->get_where('reports', array('view_name' => $viewName, 'status' => 1));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return $sql->result_array();
    
    }

    /**
     * queries the database to get the data from the report table
     *
     * @access    public
     * @param     none  
     * 
     * @return    Boolean/Array array of records if successful, false if transaction failed
     */    
    public function get_existing_reports() {
   
        $this->db->trans_start();
        
        // select * from reports
        $sql = $this->db->get_where('reports', array('status' => 1));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return $sql->result_array();
    
    }

    /**
     * Calls a existing view in the database
     *
     * @access    public
     * @param     none  
     * 
     * @return    Boolean/Array array of records if successful, false if transaction failed
     */    
    public function get_report_view($viewName = NULL) {
   
        $this->db->trans_start();
        
        // callign report view
        $sql = $this->db->get($viewName);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return $sql->result_array();
    
    }

    /**
     * Creates a new report view
     *
     * @access    public
     * @param     viewName name of the view  
     * 
     * @return    Boolean/Array array of records if successful, false if transaction failed
     */    
    public function create_report_view($viewName = NULL, $query = NULL) {
   
        $this->db->trans_start();
        
        $this->db->query('CREATE VIEW '.$viewName.' AS '.$query);
        // callign report view

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return TRUE;
    
    }
    /**
     * Creates a new report record
     *
     * @access    public
     * @param     viewName name of the view  
     * @param     displayName how the name should appear on the UI
     * 
     * @return    Boolean/Array array of records if successful, false if transaction failed
     */    
    public function create_new_report($viewName = NULL, $displayName = NULL) {
   
        $this->db->trans_start();
        
        // creating report record
        $this->db->insert('reports', array(
            'view_name' => $viewName,
            'display_name' => $displayName,
            'created_by' => $this->session->userdata('userIdentity')
        ));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return TRUE;
    
    }

    /**
     * queries the report table and sets status to 0 indicating it is 
     *
     * @access    public
     * @param     viewName the view name created 
     * 
     * @return    Boolean true if successful, false if transaction failed
     */    
    public function remove_existing_report($viewName = NULL) {
   
        $this->db->trans_start();

        //  checking if report is removable

        $sql = $this->db->get_where('reports', array('view_name' => $viewName));
        
        if ($sql->num_rows() < 1 ){
            //report does not exist
            return FALSE;
        }

        $result = $sql->result_array();

        if ($result[0]['created_by'] === 'INTERN'){
            return -1;
        }
        
        $this->db->update('reports', array('status' => 0), array('view_name' => $viewName));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return TRUE;
    
    }

    /**
     * Runs a query provided to the parameter
     *
     * @access    public
     * @param     query string that contains a query 
     * 
     * @return    Boolean/Array array of records if successful, false if transaction failed
     */    
    public function run_report_query($query = NULL) {
   
        
        $this->db->trans_start();
        
        $sql = $this->db->query($query);
            
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return $sql->result_array();
    
    }

    /**
     * Creates a new report view
     *
     * @access    public
     * @param     program the name of the program table  
     * @param     status sttaus of the program, completed or participated 
     * 
     * @return    Boolean/Array array of records if successful, false if transaction failed
     */    
    public function get_all_program_years($program = NULL , $status = NULL) {
   
        $this->db->trans_start();
        
        // callign report view
        $sql = $this->db->query('
            SELECT DISTINCT enrolled_in FROM '.$program.' where status = '.Status.';
            
        ');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            return FALSE;
        }
        
        return $sql->result_array();
    
    }

}
?>
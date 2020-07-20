<?php
//loading swifmailer library
require_once("./assets/swiftmailer/autoload.php");
class Custom_email {
    
    // Data members 
    protected $senderEmail;
	protected $senderName;
	protected $senderPassword;
    protected $subject;
    
    function __construct(){
        
        //initializing datamembers
		$this->set_sender_name("BTEC System");
		$this->set_sender_email("btec.calendar@gmail.com");
		$this->set_sender_password("exjpwfuqllkqejme");

    }
    //Initializes sender email
	function set_sender_email($sender){

		$this->senderEmail = $sender;
    }
    //Initializes Email senders Name
	public function set_sender_name($name){

		$this->senderName = $name;

    }
    //Initializes sender password
	public function set_sender_password($pass){

		$this->senderPassword = $pass;

    }
    //initializes subject of email
	public function set_subject($text){

		$this->subject = $text;
	}
    //Gets the sender email
	function get_sender_email(){

		return $this->senderEmail;
	}
    //gets the sender name 
	public function get_sender_name(){

		return $this->senderName;

    }
    //gets the sender password
	public function get_sender_password(){

		return $this->senderPassword;

	}
	public function get_subject(){

		return $this->subject;
	}
    
     /**
     *  Sends an email out using the swiftmailer php library
     *
     * @access    public
     * @param     recipient the email address of the reciever 
     * @param     message message for the email address
     *
     * @return    boolean
     */    
    public function send_email($recipient = NULL, $message = NULL){

        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername ($this->senderEmail)
            ->setPassword ($this->senderPassword)
            ->setStreamOptions($arrayName = array('ssl' => array('allow_self_signed' => true , 'verify_peer'=>false )));

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('BTEC System'))
            ->setFrom (array( $this->senderEmail => $this->senderName))
            ->setTo (array($recipient => 'To Whom it may concern'))
            ->setSubject ($this->subject)
            ->setBody ($message, 'text/html');

        $result = $mailer->send($message);

        return $result;
    } 

}

?>
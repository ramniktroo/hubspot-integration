<?php
include("config.php");
require "api/hubspot_api.php";
Class HupSpot {
	public function __construct() {
		$this->api = new HupSpotAPI(PRIVATE_APP_TOKEN, API_VERSIO);
		$this->init();
	}
	public function init(){
		$action = (isset($_GET["action"]) && $_GET["action"])?$_GET["action"]:"";
		if( $action == "contacts" ){
			$this->run_contacts();
		}else if( $action == "deals" ){
			$this->run_deals();
		}
	}
	/**
	 * Start import hubspot contacts
	 * 
	 * ==================== API: Add CRM records ====================
	 * 
	 * add_CRM_record($crm_type = "contacts", $body_data = array(), $is_print = false)
	 * $crm_type (require)	=> pass the record type
	 * $body_data (require)	=> pass API body parameters see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/

	public function run_contacts(){
		$is_print = false;
		//echo "run_contacts <pre>";
		$file_path = './csv/'.CONTACTS_CSV;
		if (($handle = fopen($file_path, "r")) !== false) {
			$i = 0;
	    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
	      // Assuming your CSV file has columns like email, first name, last name, etc.
	    	if($i == 0){
	    		$i++;
	    		continue;
	    	}
	      echo $email = isset($data[3])?$data[3]:"";
	      /***** check the email is not null *****/
	      if( $email != "" ){	      	
	      	$body_data = [
						"properties" => [
							//"company" => "", 
							"email" => $email, 
							"firstname" => isset($data[1])?$data[1]:"", 
							"lastname" => isset($data[2])?$data[2]:"", 
							"phone" => isset($data[4])?$data[4]:"", 
							//"website" => "biglytics.net" 
						] 
					];
					/***** Not find Contact *****/
					if(!$this->findContactsRecordByEmail($email, $is_print) ){
						//print_r($body_data);
						//echo "<br>$i ==> Not found ".$email;
						$this->api->add_CRM_record("contacts", $body_data, false);
					}	else{
		      	//echo "<br>$i ==> Found ".$email;
		      }				
	      } 
	      $i++;    
	    }
	  }

	}

	public function run_deals(){
		echo "run_deals";
	}


	/**
	 * Functions Contacts
	 **/

	 protected function getContactsRecordByEmail($email, $is_print = false){
    if($email){
      $parameters =  [
        "filterGroups" => [
          [
            "filters" => [
              [
                "value" => $email,
                "propertyName" => "email",
                "operator" => "EQ"
              ]
            ]
          ]
        ],
        "properties" => [
          "email"
        ],
        "limit" => 10,
        "after" => 0
      ];
      return $this->api->search_CRM_record("contacts", $parameters, $is_print);
    }
  }

  protected function findContactsRecordByEmail($email, $is_print = false){
    if($email){
      $contact_rs = $this->getContactsRecordByEmail($email, $is_print = false);
      if(isset($contact_rs->total) && $contact_rs->total > 0){
      	return true;
      }else{
      	return false;
      }
    }
  }

}
new HupSpot();
?>
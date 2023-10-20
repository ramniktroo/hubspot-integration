<?php
Class HupSpotAPI {
	protected $access_token;
	protected $api_version;
	protected $api_url = "";

	public function __construct( $access_token, $api_version ) {
		$this->access_token = $access_token;
		$this->api_version = $api_version;
		$this->api_url = "https://api.hubapi.com/crm/".$api_version."/";
	}

	/**
	 * ==================== API: List CRM records  ====================
	 * 
	 * list_CRM_record($crm_type = "contacts", $parameters = array(), $is_print = false)
	 * $crm_type (require)	=> pass the record type
	 * $parameters 					=> pass API parameters like limit, archived, after and properties
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/
	public function list_CRM_record( $crm_type = "contacts", $parameters = array(), $is_print = false ) {
		if(empty($parameters)){
			$parameters = array(
				"limit" => 10,
				"archived" 	=> false,
				"after"			=> 0
			);
		}		
		return $this->call("objects/".$crm_type, "GET", "", $parameters, "", $is_print);
	} //get_CRM_list

	/**
	 * ==================== API: search CRM record ====================
	 * 
	 * get_CRM_record($crm_type = "contacts", $record_id = null,  $parameters = array(), $is_print = false)
	 * $crm_type (require) 	=> pass the record type
	 * $record_id	(require)	=> pass the record id
	 * $parameters 					=> pass API parameters like archived, properties, etc. See respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/
	public function search_CRM_record( $crm_type = "contacts", $parameters = array(), $is_print = false ) {
		if($crm_type != "" && $parameters != null){					
			return $this->call("objects/".$crm_type."/search", "POST", "", "", json_encode($parameters), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Record ID is missing.");
			if($is_print){
				echo "objects/".$crm_type."/<strong>record_id</strong><br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //get_CRM_record

	/**
	 * ==================== API: Get CRM record ====================
	 * 
	 * get_CRM_record($crm_type = "contacts", $record_id = null,  $parameters = array(), $is_print = false)
	 * $crm_type (require) 	=> pass the record type
	 * $record_id	(require)	=> pass the record id
	 * $parameters 					=> pass API parameters like archived, properties, etc. See respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/
	public function get_CRM_record( $crm_type = "contacts", $record_id = null,  $parameters = array(), $is_print = false ) {
		if($record_id != "" && $record_id != null){					
			return $this->call("objects/".$crm_type."/".$record_id, "GET", "", $parameters, "", $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Record ID is missing.");
			if($is_print){
				echo "objects/".$crm_type."/<strong>record_id</strong><br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //get_CRM_record

	/**
	 * ==================== API: Add CRM records ====================
	 * 
	 * add_CRM_record($crm_type = "contacts", $body_data = array(), $is_print = false)
	 * $crm_type (require)	=> pass the record type
	 * $body_data (require)	=> pass API body parameters see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/
	public function add_CRM_record( $crm_type = "contacts", $body_data = array(), $is_print = false ) {
		if(!empty($body_data)){					
			return $this->call("objects/".$crm_type, "POST", "", "", json_encode($body_data), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Body data is missing.");
			if($is_print){
				echo "objects/".$crm_type."<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //add_CRM_record

	/**
	 * ==================== API: Update CRM records ====================
	 * 
	 * add_CRM_record($crm_type = "contacts", $body_data = array(), $is_print = false)
	 * $crm_type (require) 		=> pass the record type
	 * $record_id	(require)		=> pass the record id
	 * $body_data (require)		=> pass API body parameters see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print							=> pass true/ false for display API results
	 * 
	 **/
	public function update_CRM_record( $crm_type = "contacts", $record_id = null, $body_data = array(), $is_print = false ) {
		if(!empty($body_data) && $record_id != ""){					
			return $this->call("objects/".$crm_type."/".$record_id, "PATCH", "", "", json_encode($body_data), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Record id and Body data are required.");
			if($is_print){
				echo "objects/".$crm_type."<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //update_CRM_record

	/**
	 * ==================== API: Delete CRM records ====================
	 * 
	 * delete_CRM_record($crm_type = "contacts", $is_print = false)
	 * $crm_type (require) 		=> pass the record type
	 * $record_id	 (require)	=> pass the record id
	 * see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print							=> pass true/ false for display API results
	 * 
	 **/
	public function delete_CRM_record( $crm_type = "contacts", $record_id = null, $is_print = false ) {
		if( $record_id != ""){					
			return $this->call("objects/".$crm_type."/".$record_id, "DELETE", "", "", "", $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Record id is missing.");
			if($is_print){
				echo "objects/".$crm_type."<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //delete_CRM_record

	/**
	 * ==================== API: Create Default Associations ====================
	 * 
	 * create_CRM_associations_default($fromObjectType ,$toObjectType, $body_data , $is_print = false)
	 * $fromObjectType (require) 	=> pass the form record type
	 * $toObjectType (require) 		=> pass the to record type
	 * $body_data  (require) 			=> see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/crm/associations => "Create Default Associations"
	 * $is_print									=> pass true/ false for display API results
	 * 
	 **/
	public function create_CRM_associations_default( $fromObjectType ,$toObjectType, $body_data , $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != "" && $body_data != ""){					
			return $this->call("associations/".$fromObjectType."/".$toObjectType."/batch/associate/default", "POST", "", "", json_encode($body_data), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType and body_data are required.");
			if($is_print){
				echo "associations/".$fromObjectType."/".$toObjectType."/batch/associate/default<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //create_CRM_associations_default


	/**
	 * ==================== API: Create Default Associations ====================
	 * 
	 * create_CRM_associations_default($fromObjectType ,$toObjectType, $body_data , $is_print = false)
	 * $fromObjectType (require) 	=> pass the form record type
	 * $toObjectType (require) 		=> pass the to record type
	 * $body_data  (require) 			=> see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/crm/associations => "Create Default Associations"
	 * $is_print									=> pass true/ false for display API results
	 * 
	 **/
	public function create_CRM_associations_batch( $fromObjectType ,$toObjectType, $body_data , $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != "" && $body_data != ""){					
			return $this->call("associations/".$fromObjectType."/".$toObjectType."/batch/create", "POST", "", "", json_encode($body_data), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType and body_data are required.");
			if($is_print){
				echo "associations/".$fromObjectType."/".$toObjectType."/batch/associate/default<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //create_CRM_associations_default

	/**
	 * ==================== API: Delete Associations ====================
	 * 
	 * delete_CRM_associations($fromObjectType ,$toObjectType, $body_data , $is_print = false)
	 * $fromObjectType (require) 	=> pass the form record type
	 * $toObjectType (require) 		=> pass the to record type
	 * $body_data  (require) 			=> see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/crm/associations => "Delete batch  Associations"
	 * $is_print									=> pass true/ false for display API results
	 * 
	 **/
	public function delete_CRM_associations( $fromObjectType ,$toObjectType, $body_data , $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != "" && $body_data != ""){
			return $this->call("associations/".$fromObjectType."/".$toObjectType."/batch/archive", "POST", "", "", json_encode($body_data), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType and body_data are required.");
			if($is_print){
				echo "associations/".$fromObjectType."/".$toObjectType."/batch/archive<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //delete_CRM_associations

	/**
	 * ==================== API: Get Associations ====================
	 * 
	 * Get_CRM_associations($fromObjectType ,$toObjectType, $record_id , $is_print = false)
	 * $fromObjectType (require) 	=> pass the form record type
	 * $toObjectType (require) 		=> pass the to record type
	 * $record_id	 (require)	=> pass the record id
	 * $is_print									=> pass true/ false for display API results
	 * 
	 **/
	public function Get_CRM_associations( $fromObjectType ,$toObjectType, $record_id , $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != "" && $record_id != ""){
			$body_data =  [
		    "inputs" => [
	        ["id" => $record_id]
		    ]
			]; 				
			return $this->call("associations/".$fromObjectType."/".$toObjectType."/batch/read", "POST", "", "", json_encode($body_data), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType and record_id are required.");
			if($is_print){
				echo "associations/".$fromObjectType."/".$toObjectType."/batch/read<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //Get_CRM_associations

	/**
	 * ==================== API: list Associations ====================
	 * 
	 * list_CRM_associations($fromObjectType ,$toObjectType, $objectId , $is_print = false)
	 * $fromObjectType (require) 	=> pass the form record type
	 * $toObjectType (require) 		=> pass the to record type
	 * $objectId  (require) 			=> pass the record id
	 * $is_print									=> pass true/ false for display API results
	 * 
	 **/
	public function list_CRM_associations( $fromObjectType ,$toObjectType, $objectId, $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != "" && $objectId != ""){					
			return $this->call("objects/".$fromObjectType."/".$objectId."/associations/".$toObjectType."/?limit=500", "GET", "", "", "", $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType and objectId are required.");
			if($is_print){
				echo "objects/".$fromObjectType."/".$objectId."/associations/".$toObjectType."<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //list_CRM_associations

	/**
	 * ==================== API: Get Associations labels ====================
	 * 
	 * get_CRM_associations_labels($fromObjectType ,$toObjectType, $is_print = false)
	 * $fromObjectType (require) 	=> pass the form record type
	 * $toObjectType (require) 		=> pass the to record type 
	 * see API docs https://developers.hubspot.com/docs/api/crm/associations => "Association schema endpoints"
	 * $is_print									=> pass true/ false for display API results
	 * 
	 **/
	public function get_CRM_associations_labels( $fromObjectType ,$toObjectType, $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != ""){					
			return $this->call("associations/".$fromObjectType."/".$toObjectType."/labels", "GET", "", "", "", $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType are required.");
			if($is_print){
				echo "associations/".$fromObjectType."/".$toObjectType."/labels<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}		
	} //get_CRM_associations_labels

	/**
	 * ==================== API: Create Associations labels ====================
	 * 
	 * get_CRM_associations_labels($fromObjectType ,$toObjectType, $is_print = false)
	 * $fromObjectType (require) 	=> pass the form record type
	 * $toObjectType (require) 		=> pass the to record type
	 * $body_data  (require) 			=> see respective API in HubSpot Docs. see API docs https://developers.hubspot.com/docs/api/crm/associations => "Association schema endpoints"
	 * $is_print									=> pass true/ false for display API results
	 * 
	 **/
	public function create_CRM_associations_labels( $fromObjectType, $toObjectType, $body_data = array(), $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != "" && $body_data != "" ){					
			return $this->call("associations/".$fromObjectType."/".$toObjectType."/labels", "POST", "", "", json_encode($body_data), $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType and body_data are required.");
			if($is_print){
				echo "associations/".$fromObjectType."/".$toObjectType."/labels<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}
	} //create_CRM_associations_labels

	/**
	 * ==================== API: Delete Associations labels ====================
	 * 
	 * delete_CRM_associations_labels( $fromObjectType, $toObjectType, $associationTypeId , $is_print = false )
	 * $fromObjectType (require) 		=> pass the form record type
	 * $toObjectType (require) 			=> pass the to record type
	 * $associationTypeId (require) => see respective API in HubSpot Docs. see API docs https://developers.hubspot.com/docs/api/crm/associations => "Association schema endpoints"
	 * $is_print										=> pass true/ false for display API results
	 * 
	 **/
	public function delete_CRM_associations_labels( $fromObjectType, $toObjectType, $associationTypeId , $is_print = false ) {
		if( $fromObjectType != "" && $toObjectType != "" && $associationTypeId != "" ){					
			return $this->call("associations/".$fromObjectType."/".$toObjectType."/labels/".$associationTypeId, "DELETE", "", "", "", $is_print);
		}else{
			$responce = array("error" => true, "msg" => "Associations API parameters of fromObjectType, toObjectType and associationTypeId are required.");
			if($is_print){
				echo "associations/".$fromObjectType."/".$toObjectType."/labels<br><pre>";
				print_r($responce);
				echo "</pre>";
			}
			return json_encode($responce);
		}
	} //delete_CRM_associations_labels

	/**
	 * ==================== API: Get all Blog Posts ====================
	 * 
	 * get_blogs_posts( $fromObjectType, $toObjectType, $associationTypeId , $is_print = false )
	 * $parameters 					=> pass API parameters like limit, archived, after, createdAt, sort and properties. see API docs https://developers.hubspot.com/docs/api/cms/blog-post
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/
	public function get_blogs_posts( $parameters = array(), $is_print = false ) {
		if(empty($parameters)){
			$parameters = array(
				"limit" => 10,
				"archived" 	=> false,
				"after"			=> 0
			);
		}
		return $this->call("blogs/posts", "GET", "", $parameters, "", $is_print);		
	} //get_blogs_posts


	/**
	 * ==================== API: Get CRM record ====================
	 * 
	 * get_CRM_record($crm_type = "contacts", $record_id = null,  $parameters = array(), $is_print = false)
	 * $crm_type (require) 	=> pass the record type
	 * $record_id	(require)	=> pass the record id
	 * $parameters 					=> pass API parameters like archived, properties, etc. See respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/
	public function get_CRM_record_owners( $parameters = array(), $is_print = false ) {						
		return $this->call("owners", "GET", "", $parameters, "", $is_print);			
	} //get_CRM_record

	/**
	 * ==================== API call ====================
	 * 
	 * call( $end_point, $method, $header = array(), $parameters = array(), $body_data = array(), $is_print = false)
	 * $end_point (require) => pass the api end point, like "objects/contacts", "objects/deals"
	 * $method (require)		=> pass the api method. like GET, POST, PATCH, DELETE and PUT
	 * $header 							=> pass header args
	 * $parameters 					=> pass API parameters like archived, properties, etc. See respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $body_data						=> pass API body parameters see respective API in HubSpot Docs. https://developers.hubspot.com/docs/api/
	 * $is_print						=> pass true/ false for display API results
	 * 
	 **/
	public function call( $end_point, $method, $header = array(), $parameters = array(), $body_data = array(), $is_print = false){
		$url = $this->api_url.$end_point;
		$curl = curl_init();
		switch ($method){
		  case "POST":
		    curl_setopt($curl, CURLOPT_POST, 1);
		    if ($body_data){
		      curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
		    }
		    break;
		  case "PATCH":
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
		    if ($body_data){
		      curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
		    }
		    break;
		  case "PUT":
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		    if ($body_data){
		      curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);			 					
		    }
		    break;
		   case "DELETE":
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		    break;
		  default:
		    if ($parameters){
		      $url = sprintf("%s?%s", $url, http_build_query($parameters));
		    }
		}
		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		if(empty($header)){
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(		  
		  	'content-type: application/json', 'authorization: Bearer '.$this->access_token
			));
		}else{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header );
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		// EXECUTE:
		$result = curl_exec($curl);		
		//if(!$result && $method != "DELETE"){die("Connection Failure");}
		//print_r($result);
		curl_close($curl);
		if($is_print){
			echo $body_data;
			echo $url."<br><pre>";
			print_r($result);
			print_r(json_decode($result));
			echo "</pre>";
		}
	  return json_decode($result);
	} //call

	public function custom_api_call( $url, $method, $parameters = array(), $body_data = array(), $is_print = false){
		$url = $url;
		$curl = curl_init();
		switch ($method){
		  case "POST":
		    curl_setopt($curl, CURLOPT_POST, 1);
		    if ($body_data){
		      curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
		    }
		    break;
		  case "PATCH":
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
		    if ($body_data){
		      curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);
		    }
		    break;
		  case "PUT":
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		    if ($body_data){
		      curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data);			 					
		    }
		    break;
		   case "DELETE":
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		    break;
		  default:
		    if ($parameters){
		      $url = sprintf("%s?%s", $url, http_build_query($parameters));
		    }
		}
		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		if(empty($header)){
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(		  
		  	'content-type: application/json', 'authorization: Bearer '.$this->access_token
			));
		}else{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header );
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		// EXECUTE:
		$result = curl_exec($curl);		
		//if(!$result && $method != "DELETE"){die("Connection Failure");}
		curl_close($curl);
		if($is_print){
			echo $body_data;
			echo $url."<br><pre>";

			print_r($result);
			print_r(json_decode($result));
			echo "</pre>";
		}
	  return json_decode($result);
	} //call

}
?>
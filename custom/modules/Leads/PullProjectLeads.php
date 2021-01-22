<?php
set_time_limit(0);
ini_set('memory_limit', '512M');
require_once 'include/MVC/View/SugarView.php';
require_once('custom/modules/Users/filters/instancePackage.class.php');

    	global $app_strings;
    	global $app_list_strings;
    	################################
    	#### validate package data #####   	
    	/*
    	@added by: Ashutosh
    	@purpose : to validate package before pulling the leads
    	*/    	
    	$obinstancePackage = new instancePackage();
    	$arPackage = $obinstancePackage->getPacakgeDetails();
    	if(strtotime($arPackage['expiry_date']) < strtotime(date("Y-m-d")))  
    	{
    		sugar_die($app_strings['MSG_PACKAGE_EXPIRED_PULL_LEADS']);
    	} 
    	#### EOF validate package data ####
    	###################################
        //require_once 'include/nusoap/nusoap.php';
        global $sugar_config;

        //define the SOAP Client and point to the SOAP Server
        $soap_url = $sugar_config['soap_url'];
        if (!empty($soap_url)) {
            $client = new nusoap_client($soap_url, false);
        } else {
            sugar_die('Please configue SOAP URL');
        }

        //encrupt the instance key
        if (!getCipherText($sugar_config['validation_key'], &$stCipherText)) {
            //send encryption error
            sugar_die("Encryption Error: Error with public key.");
        }
        
        $arReqData = json_encode(array('client_url' => $sugar_config['site_url']
            , 'KEY' => base64_encode($stCipherText)            
        ));
        
        $totalLeads = $client->call('get_leads_count', array($arReqData));           
        //print_r($totalLeads); die;
        
        if(empty($totalLeads)){
			if(isset($_REQUEST['come_from'])){				
				SugarApplication::redirect("index.php?module=Leads&action=index&no_lead=true");				
			}else{
        		sugar_die('No new or modified project leads are available.');
			}
		}
        
        $maxRecord = 5;
        
        $arReqData1 = json_encode(array('client_url' => $sugar_config['site_url']
            , 'KEY' => base64_encode($stCipherText)     
            , 'LIMIT' => $maxRecord
        ));
        
        $loopCount = ceil($totalLeads/$maxRecord);        
        
       	//echo $loopCount; die;	
        
        //send my request using encrupted client key
        for($l=0; $l < $loopCount; $l++){
        //Call the funtion to get projet leads from master instance
        $result_array_json = $client->call('get_project_leads', array($arReqData1));   
        //print_r($result_array_json);
        $result_array = json_decode($result_array_json);        
        
        /*echo "<pre>";
        print_r($result_array);        
        echo "</pre>";
        die;*/
        
        //These fields should not be updated
        $restricted_fields = array('id', 'date_entered', 'assigned_user_name', 'modified_by_name', 'created_by_name', 'assigned_user_id', 'modified_user_id', 'team_set_id', 'team_name', '');

        global $beanList;
        $lead_ids = array();
        $i = 0;
        foreach ($result_array->entry_list as $results) {

            $module = $results->module_name;
            if ('Leads' == $module) {
                $lead_ids[] = $results->id;
            }

            if (!isset($beanList[$module])) {
                continue;
            }


            //Assign Bean name into $bean variable
            $bean = $beanList[$module];
            //Instance of Beans
            $focus = new $bean();

            //Assign id that comes from master instance
            $master_id = 'mi_' . strtolower($bean) . '_id';
            
            if($bean=='oss_Region'){
            	$master_id = 'mi_region_id';
            } 
            
            $restricted_fields[] = $master_id;

            //Create an array to retrieve id from client instance corrosponding to id comes from master instance
            $info = array($master_id => $results->id);
            $focus->retrieve_by_string_fields($info);

            //Check Id already exists then retrieve the records based on id else assign master id into master bean id fields
            if (!empty($focus->id)) {
                $focus->retrieve($focus->id);
            } else {
                $focus->$master_id = $results->id;

                if ($module == 'Contacts' || $module == 'Accounts') {
                    $focus->visibility = 0;
                }
            }


            //Assign values comes from master instance
            foreach ($results->name_value_list as $result) {
                if (isset($result->name)) {
                    $field_name = $result->name;
                    $field_value = $result->value;
                    if (!in_array($field_name, $restricted_fields)) {

                        //Create Relationship between Lead and Lead Client Detail
                        if ($module == 'oss_LeadClientDetail' && $field_name == 'lead_id') {
                            $leadObj = new Lead();
                            $leadObj->retrieve_by_string_fields(array('mi_lead_id' => $field_value));
                            $focus->lead_id = $leadObj->id;
                            unset($leadObj);
                        } else
                        //Create Relationship between Client and Lead Client Detail
                        if ($module == 'oss_LeadClientDetail' && $field_name == 'account_id') {
                            $clientObj = new Account();
                            $clientObj->retrieve_by_string_fields(array('mi_account_id' => $field_value));
                            $focus->account_id = $clientObj->id;
                            unset($clientObj);
                        } else

                        //Create Relationship between Contact and Lead Client Detail
                        if ($module == 'oss_LeadClientDetail' && $field_name == 'contact_id') {
                            $contactObj = new Contact();
                            $contactObj->retrieve_by_string_fields(array('mi_contact_id' => $field_value));
                            $focus->contact_id = $contactObj->id;
                            unset($contactObj);
                            //Create Relationship between Contact and Accounts
                        } else

                        if ($module == 'Contacts' && $field_name == 'account_id') {
                            $clientObj = new Account();
                            $clientObj->retrieve_by_string_fields(array('mi_account_id' => $field_value));
                            $focus->account_id = $clientObj->id;
                            unset($clientObj);                            
                        } else                         
                        if($module == 'Leads' && $field_name == 'county'){
							//$county = new oss_County();
							//$county->retrieve_by_string_fields(array('name' => $field_value, 'county_abbr' => $focus->state));
							$focus->county_id = $field_value;
						} else 
						if($module == 'Leads' && $field_name == 'bid_due_timezone'){							
							if(empty($field_value)){								 
								 $state = $app_list_strings['state_dom'][$results->name_value_list->state->value];
								 $time_zone = $app_list_strings['state_tz_dom'][$state];
								 $focus->bid_due_timezone = $time_zone;
							}else{
								$focus->bid_due_timezone=$field_value;
							}							
						} else if ($field_name == 'lead_source') {
                            $focus->lead_source = 'bb';
                        }else if ($module == 'oss_BusinessIntelligence' && $field_name == 'account_id') {
							$acc = new Account ();
							$acc->retrieve_by_string_fields ( array ('mi_account_id' => $result->value ) );
							$focus->account_id = $acc->id;
						} else if($module == 'oss_Region' && $field_name == 'account_id_c'){
							$acc = new Account();
							$acc->retrieve_by_string_fields(array('mi_account_id' => $result->value));
							$focus->account_id_c = $acc->id;
						} else  if($module == 'oss_Region' && $field_name == 'oss_classification_id_c'){
							$classificationRegion = new oss_Classification();
							$classificationRegion->retrieve_by_string_fields(array('mi_oss_classification_id' => $result->value));
							$focus->oss_classification_id_c = $classificationRegion->id;							
						
						}else if($module == 'oss_OnlinePlans' && $field_name == 'lead_id') {
						
						$leadObj = new Lead ();
						$leadObj->retrieve_by_string_fields ( array ('mi_lead_id' => $field_value ) );
						$focus->lead_id = $leadObj->id;
						unset ( $leadObj );
						} else {
                            $focus->$field_name = $field_value;
                        }
                    }
                }
               
            }	
            
            //Save the Record
          $focus->save(); 

          if($module == 'oss_Region'){
          	$Regionclassification = new oss_Classification();
          	$Regionclassification->retrieve($focus->oss_classification_id_c);          	
          	$focus->set_relationship('oss_classifion_accounts_c',array('oss_classi48bbication_ida'=> $focus->oss_classification_id_c, 'oss_classid41cccounts_idb' => $focus->account_id_c),true,false);
          	unset($Regionclassification);
          }
          

             if ($module == 'Leads') {                
                if (count($result_array->relationship_list[$i]->link_list[0]->records[0]->link_value) != 0) {
                    foreach ($result_array->relationship_list[$i]->link_list[0]->records[0]->link_value as $relationship) {
                        //foreach ($relationships as $relationship) {
                        $mi_classification_id = $relationship->value;
                        $classification = new oss_Classification(); 
                        $classification->disable_row_level_security=true;  
                                            
                        $classification->retrieve_by_string_fields(array('mi_oss_classification_id' => $mi_classification_id));
                        $classification->retrieve();                      	
                      	$focus->set_relationship('oss_classifcation_leads_c', array('oss_classi4427ication_ida'=> $classification->id, 'oss_classi7103dsleads_idb' => $focus->id), true, false);
                        
                        unset($classification);
                        //}
                    }
                }
                $i++;
            }

            if ($module == 'Accounts') {
                if (count($result_array->relationship_list[$i]->link_list[0]->records[0]->link_value) != 0) {
                    foreach ($result_array->relationship_list[$i]->link_list[0]->records[0]->link_value as $relationship) {
                        //foreach ($relationships as $relationship) {
                        $mi_classification_id = $relationship->value;
                        $classification = new oss_Classification();
                        $classification->disable_row_level_security=true;                        
                        $classification->retrieve_by_string_fields(array('mi_oss_classification_id' => $mi_classification_id));
                        $classification->retrieve(); 
                       	$focus->set_relationship('oss_classifion_accounts_c', array('oss_classi48bbication_ida'=> $classification->id, 'oss_classid41cccounts_idb' => $focus->id), true, false);
                        unset($classification);
                        //}
                    }
                }
                $i++;
            } 
            unset($focus);
        }//End Result Array Foreach
   
        //Chagne status as Pulled
        $lead_ids_json = json_encode($lead_ids);        
        $client->call('chagne_status', array($arReqData, $lead_ids_json));
        
        }
        //kill the client
        unset($client);
		

        //return of Project Lead List View
        if(isset($_REQUEST['come_from'])){
			SugarApplication::redirect("index.php?module=Leads&action=index");			
		}
    

    /**
     * function to get the encrupted text
     * 
     */
    function getCipherText($stPlainText, &$stCipherText) {

        $publicKey = getPublicKey();

        $stEncryptedText = '';

        if (openssl_public_encrypt($stPlainText, $stEncryptedText, $publicKey)) {
            $stCipherText = $stEncryptedText;
            $bReturn = true;
        } else {
            $stCipherText = $stEncryptedText;
            $bReturn = false;
        }
        //free this public key
        openssl_free_key($publicKey);

        return $bReturn;
    }

    /**
     * get public key.
     */
    function getPublicKey() {

        global $sugar_config;

        $fp = fopen($sugar_config['public_key'], 'r');
        $fpRes = fread($fp, 8192);
        $publicKey = openssl_pkey_get_public($fpRes);

        return $publicKey;
    }

?>
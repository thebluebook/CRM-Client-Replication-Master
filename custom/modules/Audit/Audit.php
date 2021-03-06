<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/master-subscription-agreement
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2012 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/

/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


require_once('modules/Audit/field_assoc.php');
require_once('custom/include/OssTimeDate.php');
    	
class Audit extends SugarBean {
	var $module_dir = "Audit";
	var $object_name = "Audit";


	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array();

	function Audit() {
		parent::SugarBean();
		$this->team_id = 1; // make the item globally accessible
	}

	var $new_schema = true;

	function get_summary_text()
	{
		return $this->name;
	}

    function create_export_query(&$order_by, &$where)
    {
    }

	function fill_in_additional_list_fields()
	{
	}

	function fill_in_additional_detail_fields()
	{
	}

	function fill_in_additional_parent_fields()
	{
	}

	function get_list_view_data()
    {
	}

    function get_audit_link()
    {

    }

   function get_audit_list()
    {

        global $focus, $genericAssocFieldsArray, $moduleAssocFieldsArray, $current_user, $timedate, $app_strings,$db;   
        $audit_list = array();
        if(!empty($_REQUEST['record'])) {
   			$result = $focus->retrieve($_REQUEST['record']);

    	if($result == null || !$focus->ACLAccess('', $focus->isOwner($current_user->id)))
    		{
    			sugar_die($app_strings['ERROR_NO_RECORD']);
    		}
		}

        if($focus->is_AuditEnabled()){
            $order= ' order by '.$focus->get_audit_table_name().'.date_created desc' ;//order by contacts_audit.date_created desc
            //Removed 
            if($focus->module_name=='Leads'){           	
            	$query = "SELECT 
    						leads_audit . *,leads.bid_due_timezone,
    						IFNULL(users.user_name, leads_audit.created_by) user_name
							FROM leads_audit
    						LEFT JOIN
    							users ON users.id = leads_audit.created_by
    						INNER JOIN
    							leads ON leads.id = leads_audit.parent_id
							WHERE
    							leads_audit.parent_id = '".$focus->id."'
								order by leads_audit.date_created desc";
            	//echo $query = "SELECT ".$focus->get_audit_table_name().".*, IFNULL(users.user_name,".$focus->get_audit_table_name().".created_by) user_name FROM ".$focus->get_audit_table_name()." LEFT JOIN users ON users.id = ".$focus->get_audit_table_name().".created_by WHERE ".$focus->get_audit_table_name().".parent_id = '$focus->id'".$order;
            }elseif($focus->module_name=='Opportunities'){
				$query = "SELECT opportunities_audit . *, users.user_name,opportunities.bid_due_timezone
							FROM
							opportunities_audit    
							INNER JOIN opportunities on opportunities.id = opportunities_audit.parent_id,
							users
								WHERE
							opportunities_audit.created_by = users.id AND opportunities_audit.parent_id = '".$focus->id."'
							order by opportunities_audit.date_created desc";
			}elseif($focus->module_name=='Accounts'){
				$query = "SELECT accounts_audit.*, IFNULL(users.user_name, accounts_audit.created_by) user_name
							FROM accounts_audit 
							LEFT JOIN users ON accounts_audit.created_by = users.id  
							WHERE  accounts_audit.parent_id = '".$focus->id."' order by accounts_audit.date_created desc";
			}elseif($focus->module_name=='Contacts'){
				$query = "SELECT contacts_audit.*, IFNULL(users.user_name, contacts_audit.created_by) user_name
							FROM contacts_audit
							LEFT JOIN users ON contacts_audit.created_by = users.id
							WHERE contacts_audit.parent_id = '".$focus->id."' order by contacts_audit.date_created desc";
			}else{
            	$query = "SELECT ".$focus->get_audit_table_name().".*, users.user_name FROM ".$focus->get_audit_table_name().", users WHERE ".$focus->get_audit_table_name().".created_by = users.id AND ".$focus->get_audit_table_name().".parent_id = '$focus->id'".$order;
            }
            
            //echo $query;

		    $result = $focus->db->query($query);
                // We have some data.
                require('metadata/audit_templateMetaData.php');
                $fieldDefs = $dictionary['audit']['fields'];
			    while (($row = $focus->db->fetchByAssoc($result))!= null) {
					// if(!ACLField::hasAccess($row['field_name'], $focus->module_dir, $GLOBALS['current_user']->id, $focus->isOwner($GLOBALS['current_user']->id))) continue;
					
					//If the team_set_id field has a log entry, we retrieve the list of teams to display
					if($row['field_name'] == 'team_set_id') {
					   $row['field_name'] = 'team_name';
					   require_once('modules/Teams/TeamSetManager.php');
					   $row['before_value_string'] = TeamSetManager::getCommaDelimitedTeams($row['before_value_string']);
					   $row['after_value_string'] = TeamSetManager::getCommaDelimitedTeams($row['after_value_string']);
					}
					
                    $temp_list = array();
                    foreach($fieldDefs as $field){
					        if(isset($row[$field['name']])) {
					        	
                                if(($field['name'] == 'before_value_string' || $field['name'] == 'after_value_string') &&
                                	(array_key_exists($row['field_name'], $genericAssocFieldsArray) || (!empty($moduleAssocFieldsArray[$focus->object_name]) && array_key_exists($row['field_name'], $moduleAssocFieldsArray[$focus->object_name])) )
                                   ) {
									
                                   $temp_list[$field['name']] = Audit::getAssociatedFieldName($row['field_name'], $row[$field['name']]);
                                   
                                } else{
                                   $temp_list[$field['name']] = $row[$field['name']];
                                }                               
                                
                                
                                if ($field['name'] == 'date_created') {
                                	$temp_list[$field['name']]=$timedate->to_display_date_time($temp_list[$field['name']]);
                                }
								 if(($field['name'] == 'before_value_string' || $field['name'] == 'after_value_string') && ($row['data_type'] == "enum" || $row['data_type'] == "multienum"))
								 {
								 	global $app_list_strings;
                                    $enum_keys = unencodeMultienum($temp_list[$field['name']]);
                                    $enum_values = array();
                                    foreach($enum_keys as $enum_key) {
									if(isset($focus->field_defs[$row['field_name']]['options'])) {
										$domain = $focus->field_defs[$row['field_name']]['options'];
                                            if(isset($app_list_strings[$domain][$enum_key]))
                                                $enum_values[] = $app_list_strings[$domain][$enum_key];
									}
                                    }
                                    if(!empty($enum_values)){
                                    	$temp_list[$field['name']] = implode(', ', $enum_values);
                                    }
									if($temp_list['data_type']==='date'){
										$temp_list[$field['name']]=$timedate->to_display_date($temp_list[$field['name']], false);
									}
								 }
								 elseif(($field['name'] == 'before_value_string' || $field['name'] == 'after_value_string') && ($row['data_type'] == "datetimecombo")) {
								 	if (!empty($temp_list[$field['name']]) && $temp_list[$field['name']] != 'NULL') {
								 	    $temp_list[$field['name']]=$timedate->to_display_date_time($temp_list[$field['name']]);
								 	    
								 	    if($row['field_name']=='bids_due' || $row['field_name'] == 'date_closed'){
								 	    	$oss_timedate = new OssTimeDate();
								 	    	$temp_list[$field['name']] = $oss_timedate->convertDBDateForDisplay($temp_list[$field['name']], $row['bid_due_timezone'],true);
								 	    }
								 	    								 	    							 	    
								 	} else {
								 		$temp_list[$field['name']] = '';
								 	}
								 }
								 elseif($field['name'] == 'field_name')
								 {
									global $mod_strings;
									if(isset($focus->field_defs[$row['field_name']]['vname'])) {
										$label = $focus->field_defs[$row['field_name']]['vname'];
										$temp_list[$field['name']] = translate($label, $focus->module_dir);
									}
								}
                        }
                    }

                    $temp_list['created_by'] = $row['user_name'];
                    $audit_list[] = $temp_list;
                }
                //print_r($audit_list);
                for($i=0;$i<sizeof($audit_list);$i++){
                
                	if($audit_list[$i]['field_name'] == "County" || $audit_list[$i]['field_name'] == "county_id"){
                		
                		$sqlCounty = "SELECT name from oss_county WHERE id = '".$audit_list[$i]['before_value_string']."'";
                		$res_beforeString = $db->query($sqlCounty);
                		$row_beforeString = $db->fetchByAssoc($res_beforeString);
                		$audit_list[$i]['before_value_string'] = $row_beforeString['name'];
                		
                		$sqlCounty = "SELECT name from oss_county WHERE id = '".$audit_list[$i]['after_value_string']."'";
                		$res_afterString = $db->query($sqlCounty);
                		$row_afterString = $db->fetchByAssoc($res_afterString);
                		$audit_list[$i]['after_value_string'] = $row_afterString['name'];
                	} 
                }            
        }
        return $audit_list;
    }

    function getAssociatedFieldName($fieldName, $fieldValue){
    global $focus,  $genericAssocFieldsArray, $moduleAssocFieldsArray;

        if(!empty($moduleAssocFieldsArray[$focus->object_name]) && array_key_exists($fieldName, $moduleAssocFieldsArray[$focus->object_name])){
        $assocFieldsArray =  $moduleAssocFieldsArray[$focus->object_name];

        }
        else if(array_key_exists($fieldName, $genericAssocFieldsArray)){
            $assocFieldsArray =  $genericAssocFieldsArray;
        }
        else{
            return $fieldValue;
        }
        $query = "";
        $field_arr = $assocFieldsArray[$fieldName];
        $query = "SELECT ";
        if(is_array($field_arr['select_field_name'])){
        	$count = count($field_arr['select_field_name']);
            $index = 1;
            foreach($field_arr['select_field_name'] as $col){
            	$query .= $col;
            	if($index < $count){
            		$query .= ", ";
            	}
            	$index++;
            }
         }
         else{
           	$query .= $field_arr['select_field_name'];
         }

         $query .= " FROM ".$field_arr['table_name']." WHERE ".$field_arr['select_field_join']." = '".$fieldValue."'";

         $result = $focus->db->query($query);
         if(!empty($result)){
         	if($row = $focus->db->fetchByAssoc($result)){
                if(is_array($field_arr['select_field_name'])){
                	$returnVal = "";
                	foreach($field_arr['select_field_name'] as $col){
            			$returnVal .= $row[$col]." ";
            		}
            		return $returnVal;
            	}
                else{
                   	return $row[$field_arr['select_field_name']];
                }
            }
        }
    }
}
?>

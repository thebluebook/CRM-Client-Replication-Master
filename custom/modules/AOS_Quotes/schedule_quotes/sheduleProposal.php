<?php


ini_set('zend_optimizerplus.dups_fix',1);

global $sugar_config, $timedate,$current_user;

require_once $sugar_config['master_config_path'];// '/vol/certificate/master_config.php';
require_once 'custom/include/master_db/mysql.class.php';
require_once 'custom/include/common_functions.php';
require_once 'custom/modules/AOS_Quotes/schedule_quotes/class.easylinkmessage.php';
require_once 'include/SugarDateTime.php';
require_once('include/modules.php');
require_once('config.php');
require_once 'include/utils.php';

global $sugar_config, $current_language, $app_list_strings, $app_strings, $locale,$mod_strings;
$language = $sugar_config['default_language'];//here we'd better use English, because pdf coding problem.

$app_list_strings = return_app_list_strings_language($language);
$app_strings = return_application_language($language);
//$mod_strings =return_mod_list_strings_language($language,'AOS_Quotes');

include("modules/AOS_Quotes/language/$language.lang.php");
include("custom/modules/AOS_Quotes/Ext/Language/$language.lang.ext.php");

/*        $user = new User();
        $user->retrieve('1');

        $current_user = $user;
*/

//get instance account number 

$obAdmin = new Administration ();
$arAdminData = $obAdmin->retrieveSettings ( 'instance', true );

//GET EASY Link Object
$obEasyLink = new easyLinkMessage ( $sugar_config ['EASY_LINK_USER_NAME'], $sugar_config ['EASY_LINK_USER_PASS'] );

  
//validate if this request is from a valid source
if(!isset($_REQUEST['salt']) || trim($_REQUEST['salt'])=='' || $_REQUEST['salt'] != md5( $sugar_config ['dbconfig'] ['db_name']) ){
	
	$stUnathorized = '###########   Unautherorized access to [HOST :'.$_SERVER['HTTP_HOST'].'[ QUERY_STRING : '.$_SERVER['QUERY_STRING'].']';
	$obEasyLink->do_log($stUnathorized,'fatal');
	die;
		
}

if (isset ( $_REQUEST ['record'] ) && trim ( $_REQUEST ['record'] ) != '') {
	$focus = new AOS_Quotes ();
	$focus->disable_row_level_security = 1;
	$focus->retrieve ( $_REQUEST ['record'] );
}
else{
	die('NOTHING TO SCHEUDE');
}


$obUser = new User();
$obUser->disable_row_level_security =1 ;
$obUser->retrieve($focus->assigned_user_id);

//get DB Object
$cdb = $obEasyLink->__getCentralDB();

$stProposalQueueId = $cdb->escape( $_REQUEST['queue_id']);

$obEasyLink->do_log('##### SCHEDULE PROPOSAL CRON [Proposal id :'.$_REQUEST['record'].'] #####');
$obEasyLink->do_log('##### SCHEDULE PROPOSAL CRON [Proposal queue id :'.$stProposalQueueId.'] #####');

/**
 * A proposal will be scheduled on following condition
 * 1) Proposal is verified
 */
 if ( $focus->proposal_verified == '1') {
 	
 	$obEasyLink->do_log('##### SCHEDULE PROPOSAL CRON #####');
 	$obEasyLink->do_log('##### '.$focus->id.' #####');
	// check if entry already exists
	$stDbName = $sugar_config ['dbconfig'] ['db_name'];
	
	// create schedule/stop date
	$obScheduleDate = new SugarDateTime ( $focus->date_time_delivery, new DateTimeZone ( 'UTC' ) );
	
	$obScheduleStopDate = new SugarDateTime ( $focus->date_time_delivery, new DateTimeZone ( 'UTC' ) );
	$obScheduleStopDate->modify ( '+1 day' );
	
	$dtScheduledGmtTime = $obScheduleDate->format ( 'Y-m-d' ) . 'T' . $obScheduleDate->format ( 'H:i:sP' );
	$dtScheduledStopGmtTime = $obScheduleStopDate->format ( 'Y-m-d' ) . 'T' . $obScheduleDate->format ( 'H:i:sP' );
	
	// get difference in days
	$iDaysDiff = ceil ( (strtotime ( $focus->date_time_delivery ) - strtotime ( $timedate->nowDb () )) / (60 * 60 * 24) );
	
	
	// check if the delivery time is in next 7 days from now
	if ($iDaysDiff <= 2 && $iDaysDiff >= 0) {
		
		$obEasyLink->do_log('##### DAYs Differnece '.$iDaysDiff.' #####');
		// schedule this proposal now
		// ###############################################
		// # RETRIEVE PROPOSAL DETAILS #####
		// ###############################################
		require_once ('include/Sugarpdf/SugarpdfFactory.php');
		include_once "custom/modules/EmailTemplates/CustomEmailTemplate.php";
		$object_map = array ();
		$obEmailTemplate = new CustomEmailTemplate ();
		$obEmailTemplate->retrieve_by_string_fields ( array (
				'name' => 'Proposal Template' 
		) );
		
		$arHTMLEmailData = $obEmailTemplate->parse_template_bean ( array (
				'subject' => $obEmailTemplate->subject,
				'body_html' => '<html><title></title><head></head><body>'.cleanSpecialChars($obEmailTemplate->body_html).'</body></html>',
				'body' => $obEmailTemplate->body 
		), 'AOS_Quotes', $focus );
		
		//get fax template
		$obEmailTemplate->retrieve_by_string_fields ( array (
				'name' => 'Proposal Fax Template'
		) );
		
		
		$arHTMLFaxCoverData = $obEmailTemplate->parse_template_bean ( array (
				'subject' => $obEmailTemplate->subject,
				'body_html' => '<html><title></title><head></head><body>'.cleanSpecialChars($obEmailTemplate->body_html).'</body></html>',
				'body' => $obEmailTemplate->body
		), 'AOS_Quotes', $focus );
		
		//check if there are lineitems 
		$product = new AOS_Products();
		$product->disable_row_level_security = true;
		$where_lineitems = " aos_products.quote_id='".$focus->id
					."' AND  (aos_products.product_type='line_items'	OR aos_products.product_type='inclusions'
		OR aos_products.product_type='exclusions' OR aos_products.product_type='alternates') ";
		$line_items = $product->get_full_list('',$where_lineitems);
		
		if(count($line_items) > 0){
			// get Proposal PDF
			
			/**
			 * proposal verisoning
			 * Hirak - 07.02.2013
			 */
			//$stFileName = 'Proposal_' . $focus->quote_num . '.pdf';
			$stFileName = $focus->name .' '.$focus->proposal_version.'.pdf';
			
			$pdf = SugarpdfFactory::loadSugarpdf ( 'Standard', 'AOS_Quotes', $focus, $object_map );
			$pdf->process ();
			$bean = $focus;
			
			$stTmpPdf = $pdf->Output ( '', 'S' );
			
			$arAttachedFiles [] = array (
					'fileName' => $stFileName,
					'content' => $stTmpPdf,
					'type' => 'PDF' 
			);
		}
			
		// Fetch all documents related with proposal
		$focus->load_relationship ( 'documents' );
		$arDocs = $focus->documents->get ();
		//echo '<pre>';print_r($focus);
		
		// Attach documents to email
		foreach ( $arDocs as $stDoc ) {
			$obDocument = loadBean ( 'Documents' );
			$obDocument->disable_row_level_security = true;
			$obDocument->retrieve ( $stDoc );
				
			//get Type of document	
			$stType = getDocumentType($obDocument->last_rev_mime_type);			
			
			$arAttachedFiles [] = array (
					'fileName' => $obDocument->filename,
					'content' => file_get_contents ( $GLOBALS ['sugar_config'] ['upload_dir'] . $obDocument->document_revision_id ),
					'type' => $stType 
			);
		}
		
		
		
		 ###################################################
		 # RETRIEVE PROPOSAL DETAILS ENDS #####
		 ###################################################
		//hirak : date : 12-10-2012
		// if email need to sent schedule an email
		if ($focus->proposal_delivery_method == 'E' || $focus->proposal_delivery_method == 'EF') {
			
			$obEasyLink->do_log('##### Email Schedule Request Initiated #####');
			
			$arEasyLinkJobSubmitEmailParams = array ();
			$arEasyLinkJobSubmitEmailParams = array (
					'MessageId' => 'BLUE_POPOSAL_VERIFY-' . $focus->id . '-' . strtotime ( date ( 'Y-m-d h:i:s' ) ),
					'BillingCode' => 'Proposal Email ' . $focus->quote_num,
					'CustomerReference' => $obEasyLink->instanceFolderName,
					'emailSubject' => '' . $arHTMLEmailData ['subject'] . ' ' . $focus->name,
					'StartTime' => $dtScheduledGmtTime,
					'StopTime' => $dtScheduledStopGmtTime,
					'email' => array (
							'toEmail' => $focus->contact_email,
							'attachments' => $arAttachedFiles,
							'emailBody' => $arHTMLEmailData ['body_html'],
							//'FromAddress' => $obUser->email1,
							'ReplyTo' => $obUser->email1,							
							'FromDisplayName' => $obUser->company_name  // $obProposal->assigned_user_name,
							)
					 
			);
			
			try {
				//prepare params for jobsubmit 
				$obEasyLink->do_log('PROPOSAL ['.$focus->id.'] sending to schedule.');
				
				$obEasyLink->wsdl = $sugar_config ['EASY_LINK_JOBSUBMIT_WSDL'];
				$obEmailScheduleResult = $obEasyLink->jobSubmitEmail ( $arEasyLinkJobSubmitEmailParams );
			
			} catch ( SoapFault $obFault ) {
				
				$obEasyLink->do_log('##### COUGHT EMAIL SCHEDULE ERROR #####');
				//log this error
				$obEasyLink->do_log( " SoapFault Error Message for Email Schedule :" . $obFault->getMessage () . ' [ERROR CODE = ' . $obFault->getCode () . ' ] ','fatal' );
				
				$arScheduleError ['name'] = $stDbName;
				$arScheduleError ['instance_db_name'] = $stDbName;
				$arScheduleError ['proposal_id'] = $focus->id;
				$arScheduleError ['instance_folder']= $obEasyLink->instanceFolderName;
				$arScheduleError ['proposal_delivery_date']= $obScheduleDate->format('Y-m-d h:i:s');
				$arScheduleError ['process_state'] = 'pending';
				 
				$columns =  implode (',',array_keys ( $arScheduleError ) );
				$values =  implode ( "','", array_values ( $arScheduleError ) );

				//update proposal status
				$stUpdateScheduleQueueSQL = "INSERT INTO oss_schedulequeue (id,date_created,date_modified,$columns) VALUES  (
				UUID(),NOW(),NOW(),'{$values}') ";
				//$GLOBALS['log']->fatal($stUpdateScheduleQueueSQL);
				$cdb->query ( $stUpdateScheduleQueueSQL );
				
				// GOT AN ERROR SEND NOTIFICATION EMAIL
				$obErrorTemplate = $obEasyLink->getEmailTemplate($focus);
				
				$stSubject = $obErrorTemplate->subject;
				$stNotificationContent = $obErrorTemplate->body_html;
					
				
				
				$arEmailIds[] =  $obUser->email1 ;
				$obEasyLink->sendNotificationEmail($arEmailIds, $stSubject,$stNotificationContent);
				
				//set proposal status as error
				$stUpdateProposalStatus = 'UPDATE oss_proposalqueue SET proposal_schedule_status ="error"  
					WHERE 
					instance_db_name="' . $stDbName . '"
					AND proposal_id ="' . $focus->id . '"
					AND proposal_schedule_status = "inprogress"	 ';

				$cdb->query($stUpdateProposalStatus);
				$obEasyLink->do_log('##### STOPPED with '.$stUpdateProposalStatus.' #####');
				exit(0);
			
			}
		}
		
		//hirak : date : 12-10-2012
		// if fax need to sentschedule Fax
		if ($focus->proposal_delivery_method == 'F' || $focus->proposal_delivery_method == 'EF') {
			
			$obEasyLink->do_log('##### SCHEDULE FAX INITIATED #####');
			// create JobSubmit Params
			$arEasyLinkJobSubmitFaxParams = array (
					'MessageId' => 'BLUE_POPOSAL_VERIFY-' . $focus->id . '-' . strtotime ( date ( 'Y-m-d h:i:s' ) ),
					'BillingCode' => 'Proposal fax ' . $focus->quote_num,
					'Phone' => $focus->contact_fax,
					'CustomerReference' => $obEasyLink->instanceFolderName,
					'StartTime' => $dtScheduledGmtTime,
					'StopTime' => $dtScheduledStopGmtTime,
					'Fax' => array (
							'Phone' => $focus->contact_fax,
							'attachments' => $arAttachedFiles,
							'CoverBody' => $arHTMLFaxCoverData ['body_html'] 
					) 
			)
			;
			
			
			try {
				
				$obEasyLink->wsdl = $sugar_config ['EASY_LINK_JOBSUBMIT_WSDL'];
				$obFaxScheduleResult = $obEasyLink->jobSubmitFAX ( $arEasyLinkJobSubmitFaxParams );
			
			} catch ( SoapFault $obFault ) {
				
				//log this error
				$obEasyLink->do_log ( " SoapFault Error Message for fax Schedule :" . $obFault->getMessage () . ' [ERROR CODE = ' . $obFault->getCode () . ' ] ','fatal' );
				
				$arScheduleError ['name'] = $sugar_config['dbconfig']['db_name'] ;
				$arScheduleError ['instance_db_name'] = $sugar_config['dbconfig']['db_name'];
				$arScheduleError ['proposal_id'] = $focus->id;
				$arScheduleError ['instance_folder']= $obEasyLink->instanceFolderName;
				$arScheduleError ['proposal_delivery_date']= $obScheduleDate->format('Y-m-d h:i:s');
				$arScheduleError ['process_state'] = 'pending';
				 
				$columns =  implode (',',array_keys ( $arScheduleError ) );
				$values =  implode ( "','", array_values ( $arScheduleError ) );
				
				//if email is sent but fax cought an error
				if (isset ( $obEmailScheduleResult->MessageResult->JobId->MRN )) {
						
					$arScheduleError ['process_state'] ='fax_error';
						
				}else{
						
					$arScheduleError ['process_state']  = 'pending';
						
				}
				//update proposal status
				$stUpdateScheduleQueueSQL = "INSERT INTO oss_schedulequeue (id,date_created,date_modified,$columns) VALUES  (
				UUID(),NOW(),NOW(),'{$values}') ";
				//$GLOBALS['log']->fatal($stUpdateScheduleQueueSQL);
				$cdb->query ( $stUpdateScheduleQueueSQL );
				
				// GOT AN ERROR SEND NOTIFICATION EMAIL
				$obErrorTemplate = $obEasyLink->getEmailTemplate($focus);
				
				$stSubject = $obErrorTemplate->subject;
				$stNotificationContent = $obErrorTemplate->body_html;				
				
				
				$arEmailIds[] =  $obUser->email1 ;
				$obEasyLink->sendNotificationEmail($arEmailIds, $stSubject,$stNotificationContent);				
				
				$obEasyLink->do_log('##### STOPPED with '.$stUpdateScheduleQueueSQL.' #####');
				
				//set proposal status as error
				$stStatus = ($arScheduleError ['process_state'] == 'fax_error')?$arScheduleError ['process_state']:'error';
				
				$stUpdateProposalStatus = 'UPDATE oss_proposalqueue SET proposal_schedule_status ="'.$stStatus.'"
				WHERE
				instance_db_name="' . $stDbName . '"
				AND proposal_id ="' . $focus->id . '"
				AND proposal_schedule_status = "inprogress"	 ';
				
				$cdb->query($stUpdateProposalStatus);
				exit(0);
			}
		}
		
		if (isset ( $obEmailScheduleResult->MessageResult->JobId->MRN )) {
			
			$arFieldMap ['easy_email_mrn'] = $obEmailScheduleResult->MessageResult->JobId->MRN;
			$arFieldMap ['easy_email_xdn'] = $obEmailScheduleResult->MessageResult->JobId->XDN;
			$arFieldMap ['proposal_schedule_status'] = 'scheduled';
			$arFieldMap ['process_stat'] = '2';
		}
		
		if (isset ( $obFaxScheduleResult->MessageResult->JobId->MRN )) {
			
			$arFieldMap ['easy_fax_mrn'] = $obFaxScheduleResult->MessageResult->JobId->MRN;
			$arFieldMap ['easy_fax_xdn'] = $obFaxScheduleResult->MessageResult->JobId->XDN;
			$arFieldMap ['proposal_schedule_status'] = 'scheduled';
			$arFieldMap ['process_stat'] = '2';
			
		}
	
	}else {
		//change state again to 0
		$stUpdateProposalStatus = 'UPDATE oss_proposalqueue SET process_stat ="0" WHERE id="'.$stProposalQueueId.'"';
		$cdb->query($stUpdateProposalStatus);
		
		//no need to scehdule this proposal stop execution		
		$obEasyLink->do_log('##### STOPPED :: proposal delivery date does not qualifies. '.$iDaysDiff.'[SQL] '.$stUpdateProposalStatus.' #####');
		exit(0);
	} 
	$obEasyLink->do_log('##### Schedule Complete #####');
	
	// $arFieldMap['proposal_schedule_status']= '';
	
	$stCheckSql = 'SELECT id
					,instance_db_name
					,proposal_id
					,easy_email_mrn
					,easy_email_xdn
					,easy_fax_mrn
					,easy_fax_xdn
					,proposal_schedule_status
					FROM oss_proposalqueue
					WHERE instance_db_name="' . $stDbName . '"
					AND proposal_id ="' . $focus->id . '"
					AND proposal_schedule_status = "inprogress"	';
	
	// check if there is any entry correspond to this proposal
	$rsResult = $cdb->query ( $stCheckSql );
	$arResult = $cdb->num_rows ( $rsResult );
	
	//mapping fields
	$arFieldMap ['instance_db_name'] = $stDbName;
	$arFieldMap ['proposal_id'] = $focus->id;
	
	// if there is a record correspond to this proposal
	if ($arResult && $arResult > 0) {
		
		// get the email MRN number
		$arResultData = $cdb->fetch_assoc($rsResult );
		$iCount = 0;
		foreach($arFieldMap as $stFieldName=>$stFieldValue)
		{
				$stSeparator = ($iCount==0)?' ':' ,';
				$stFieldsUpdate .= $stSeparator.$stFieldName.' = "'.$stFieldValue.'"';
				$iCount++;
		}
		
		$stScheduleSql = 'UPDATE oss_proposalqueue SET  ' 
						 . $stFieldsUpdate .' WHERE id = "'.$arResultData['id'].'"';
	
	} else {
		// this will be a new proposal schedule request
		$stScheduleSql = 'INSERT INTO oss_proposalqueue( id,date_created,date_modified,' 
						. implode ( ",", array_keys ( $arFieldMap ) ) . ') VALUES(
							UUID(),NOW(),NOW(),"' 
						. implode ( '","', array_values ( $arFieldMap ) ) . '" )';
	}
	
	$obEasyLink->do_log('##### SCHEDULE PROPOSAL COMPLETED SQL ['.$stScheduleSql.']#####');
	// add new row for schedule
	$cdb->query ( $stScheduleSql );

}
else{
	$obEasyLink->do_log('##### SCHEDULE PROPOSAL CRON ENDS AS the PROPOSAL IS NOT VERIFIED #####');
	
}





?>

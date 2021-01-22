<?php 
ini_set('display_errors', 1);	
//get Queue Id
if(!isset($_REQUEST['queue']) || trim($_REQUEST['queue']) ==''){
	
	die('NO QUEUE defined');
}else {
	
	$stQueue = $_REQUEST['queue'];
}

require_once 'custom/modules/AOS_Quotes/schedule_quotes/class.easylinkmessage.php';
require_once 'modules/AOS_Quotes/AOS_Quotes.php';
//get easylink calss object
$obEasyLink = new easyLinkMessage();
$cdb =$obEasyLink->__getCentralDB();

$stQueue =  $cdb->escape($stQueue);
$stQueueId =  $cdb->escape($_REQUEST['queue_id']);

switch (strtolower($stQueue)){
	
	//if the error in Schedule error queue
	case 'schedule':

		//get schedule error queue details
		$stSql = 'SELECT * FROM oss_schedulequeue WHERE id = "'.$stQueueId.'"';
		$rsResult = $cdb->query($stSql);
		
		//get details 
		$arResult = $cdb->fetch_assoc($rsResult);
		
		$obEmailTemplate = new EmailTemplate();
		
		$obProposal = new AOS_Quotes();
		$obProposal->disable_row_level_security = true;
		
		$obProposal->retrieve($arResult['proposal_id']);
		
		
		$obEmailTemplate->retrieve_by_string_fields(array('name'=>'Schedule Queue Exhausted'));
			
		$stEmailContent =  EmailTemplate::parse_template_bean($obEmailTemplate->body_html, 'AOS_Quotes', $obProposal);
		
		//set instance name
		$stEmailContent = str_replace('_INSTANCE_', $obEasyLink->instanceFolderName, $stEmailContent);
		$stSubject = str_replace('_INSTANCE_', $obEasyLink->instanceFolderName, $obEmailTemplate->subject);
		
		$obUser = new User();
		$obUser->retrieve($obProposal->assigned_user_id);
		
		$arEmailIds[] =  $obUser->email1 ;		
		$obEasyLink->sendNotificationEmail($arEmailIds, $stSubject, $stEmailContent);
		
		
						
	break;
	
	//if the error in cancel error queue
	case 'cancel':
		//get schedule error queue details
		$stSql = 'SELECT * FROM oss_cancelqueue WHERE id = "'.$stQueueId.'"';
		$rsResult = $cdb->query($stSql);
		
		//get details
		$arResult = $cdb->fetch_assoc($rsResult);
		
		$obEmailTemplate = new EmailTemplate();
		
		$obProposal = new AOS_Quotes();
		$obProposal->disable_row_level_security = true;
		
		$obProposal->retrieve($arResult['proposal_id']);
		
		
		$obEmailTemplate->retrieve_by_string_fields(array('name'=>'Cancel Queue Exhausted'));
			
		$stEmailContent =  EmailTemplate::parse_template_bean($obEmailTemplate->body_html, 'AOS_Quotes', $obProposal);
		
		//set instance name
		$stEmailContent = str_replace(array('_INSTANCE_','_EMAIL_MRN_','_FAX_MRN_'), array($obEasyLink->instanceFolderName,$arResult['easy_email_mrn'],$arResult['easy_fax_mrn']), $stEmailContent);
		
		$stSubject = str_replace('_INSTANCE_', $obEasyLink->instanceFolderName, $obEmailTemplate->subject);
		
		$obUser = new User();
		$obUser->retrieve($obProposal->assigned_user_id);
		
		$arEmailIds[] =  $obUser->email1;
		$obEasyLink->sendNotificationEmail($arEmailIds, $stSubject, $stEmailContent);
		
	break;
	
	//if the error in Easylink while sending the proposal
	case 'update':
		
	break;
	
	
	
}
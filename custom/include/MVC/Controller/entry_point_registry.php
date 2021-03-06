<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/MVC/Controller/entry_point_registry.php';

$entry_point_registry['instanceUsers'] = array('file' => 'custom/include/instance_users.php','auth' => false);
$entry_point_registry['getUserFilters'] = array('file' => 'custom/include/get_user_filters.php','auth' => false);
$entry_point_registry['setUserDeleted'] = array('file' => 'custom/include/setUserDeleted.php','auth' => false);
$entry_point_registry['updateLicense'] = array('file' => 'custom/include/oss_repair/updatelicense.php','auth' => false);
$entry_point_registry['SilentRepair'] = array('file' => 'custom/include/oss_repair/silentrepair.php','auth' => false);
$entry_point_registry['ScheduleProposal'] = array('file' => 'custom/modules/AOS_Quotes/schedule_quotes/sheduleProposal.php', 'auth' => false);
$entry_point_registry['UpdateProposals'] = array('file' => 'custom/modules/AOS_Quotes/schedule_quotes/updateProposals.php', 'auth' => false);
$entry_point_registry['ProposalDetails'] = array('file' => 'custom/modules/AOS_Quotes/schedule_quotes/ProposalDetails.php', 'auth' => false);
$entry_point_registry['QueueExhausted'] = array('file' => 'custom/modules/AOS_Quotes/schedule_quotes/QueueExhaustedEmail.php', 'auth' => false);
$entry_point_registry['ScheduleErrorProposal'] = array('file' => 'custom/modules/AOS_Quotes/schedule_quotes/ScheduleErrorProposal.php', 'auth' => false);
$entry_point_registry['GenerateQuickComposeFrame'] = array('file' => 'custom/modules/Emails/GenerateQuickComposeFrame.php', 'auth' => true);
?>
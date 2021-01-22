<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Contacts push feed', 'modules/Contacts/SugarFeeds/ContactFeed.php','ContactFeed', 'pushFeed'); 
$hook_array['before_save'][] = Array(77, 'updateGeocodeInfo', 'modules/Contacts/ContactsJjwg_MapsLogicHook.php','ContactsJjwg_MapsLogicHook', 'updateGeocodeInfo'); 
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Update Portal', 'modules/Contacts/updatePortal.php','updatePortal', 'updateUser'); 
$hook_array['after_save'][] = Array(77, 'updateRelatedMeetingsGeocodeInfo', 'modules/Contacts/ContactsJjwg_MapsLogicHook.php','ContactsJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo'); 

//$$hook_array['before_save'][] = Array(2, 'Set Modified', 'custom/modules/Contacts/ContactHooks.php','ContactHooks', 'setModified');
//$hook_array['after_ui_frame'] = Array(); 
$hook_array['process_record'][] = Array(1, 'Accounts Proview Link setup', 'custom/modules/Contacts/ContactHooks.php','ContactHooks', 'setAccountProviewLink');
//$hook_array['after_save'][] = Array(1, 'Update related bidder information', 'custom/modules/Contacts/ContactHooks.php','ContactHooks', 'updateBidderInformation');



?>
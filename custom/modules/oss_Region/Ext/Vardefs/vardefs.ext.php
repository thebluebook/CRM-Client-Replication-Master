<?php 
 //WARNING: The contents of this file are auto-generated


$dictionary['oss_Region']['fields']['name']['type'] = 'enum';
$dictionary['oss_Region']['fields']['name']['options'] = 'region_dom';

$dictionary['oss_Region']['fields']['team_set_id'] = array(
    'name' => 'team_set_id',
    'vname' => 'LBL_TEAM_SET_ID',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => '36',
    'size' => '20',
);
$dictionary['oss_Region']['fields']['team_id'] = array(
    'name' => 'team_id',
    'vname' => 'LBL_TEAM_ID',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => '36',
    'size' => '20',
);

 // created: 2020-04-30 09:09:56
$dictionary['oss_Region']['fields']['team_id']['inline_edit']=true;
$dictionary['oss_Region']['fields']['team_id']['merge_filter']='disabled';

 

 // created: 2020-04-30 09:09:47
$dictionary['oss_Region']['fields']['team_set_id']['inline_edit']=true;
$dictionary['oss_Region']['fields']['team_set_id']['merge_filter']='disabled';

 
?>
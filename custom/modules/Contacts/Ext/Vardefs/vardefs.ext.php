<?php 
 //WARNING: The contents of this file are auto-generated


$dictionary['Contact']['fields']['mi_contact_id'] = array(
    'name' => 'mi_contact_id',
    'vname' => 'LBL_MI_CONTACT_ID',
    'type' => 'varchar',
    'merge_filter' => 'enabled',
    'len' => 36,
);
$dictionary['Contact']['fields']['lead_source'] = array(
    'name' => 'lead_source',
    'vname' => 'LBL_LEAD_SOURCE',
    'type' => 'enum',
    'len' => '50',
    'options' => 'lead_source_list',
    'default' => 'bb',
	'audited' => true,
);

$dictionary['Contact']['fields']['primary_address_state']['type'] = 'enum';
$dictionary['Contact']['fields']['primary_address_state']['options'] = 'state_dom';
$dictionary['Contact']['fields']['primary_address_state']['audited'] = true;

$dictionary['Contact']['fields']['alt_address_state']['type'] = 'enum';
$dictionary['Contact']['fields']['alt_address_state']['options'] = 'state_dom';
$dictionary['Contact']['fields']['alt_address_state']['audited'] = true;

$dictionary['Contact']['fields']['first_name']['audited'] = true;
$dictionary['Contact']['fields']['last_name']['audited'] = true;
$dictionary['Contact']['fields']['account_name']['audited'] = true;
$dictionary['Contact']['fields']['account_id']['audited'] = true;

$dictionary['Contact']['fields']['visibility'] = array (
   'required' => false,
   'name' => 'visibility',
   'vname' => 'LBL_VISIBILITY',
   'type' => 'bool',
   'massupdate' => 0,
   'comments' => '',
   'help' => '',
   'importable' => 'true',
   'duplicate_merge' => 'disabled',
   'duplicate_merge_dom_value' => '0',
   'audited' => true,
   'default' => '1',
   'reportable' => false,
   'calculated' => false,
   'len' => '255',
   'size' => '20',
   ) ;

$dictionary['Contact']['fields']['account_proview_url'] = array (
		'name' => 'account_proview_url',
		'rname' => 'proview_url',
		'id_name' => 'account_id',
		'vname' => 'LBL_ACCOUNT_NAME',
		'join_name'=>'accounts',
		'type' => 'relate',
		'link' => 'accounts',
		'table' => 'accounts',
		'isnull' => 'true',
		'module' => 'Accounts',
		'dbType' => 'varchar',
		'len' => '255',
		'source' => 'non-db',
		'unified_search' => true,
		'audited' => true,
);

$dictionary['Contact']['fields']['lcd_account'] = array(
		'name' => 'lcd_account',
		'vname' => 'LBL_ACCOUNT_LEADCLIENTDETAILS_TITLE',
		'source' => 'non_db',
		'type' => 'char',
		'audited' => true,
);

//$dictionary['Contact']['fields']['primary_address_street']['len'] = 255;
//$dictionary['Contact']['fields']['primary_address_street']['audited'] = true;

$dictionary['Contact']['fields']['is_modified'] = array (
		'required' => false,
		'name' => 'is_modified',
		'vname' => 'LBL_IS_MODIFIED',
		'type' => 'bool',
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'merge_filter' => 'enabled',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => true,
		'reportable' => true,
		'calculated' => false,
		'size' => '20',
);

$dictionary['Contact']['fields']['dodge_id'] = array (
		'required' => false,
		'name' => 'dodge_id',
		'vname' => 'LBL_DODGE_ID',
		'type' => 'varchar',
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => true,
		'reportable' => true,
		'len' => '255',
		'size' => '20',
);
$dictionary['Contact']['fields']['reed_id'] = array (
		'required' => false,
		'name' => 'reed_id',
		'vname' => 'LBL_REED_ID',
		'type' => 'varchar',
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => true,
		'reportable' => true,
		'len' => '255',
		'size' => '20',
);

$dictionary['Contact']['fields']['phone_work']['type'] = 'phone';
$dictionary['Contact']['fields']['phone_work']['audited'] = true;

$dictionary['Contact']['fields']['phone_mobile']['type'] = 'phone';
$dictionary['Contact']['fields']['phone_mobile']['audited'] = true;

$dictionary['Contact']['fields']['phone_fax']['type'] = 'phone';
$dictionary['Contact']['fields']['phone_fax']['audited'] = true;

$dictionary['Contact']['fields']['onvia_id'] = array (
		'required' => false,
		'name' => 'onvia_id',
		'vname' => 'LBL_ONVIA_ID',
		'type' => 'varchar',
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => true,
		'reportable' => true,
		'len' => '255',
		'size' => '20',
);

//$dictionary['Contact']['fields']['email1']['function']=array('name' => 'getEmailAddressWidgetCustom','returns' => 'html','include'=>'custom/include/SugarEmailAddress/CustomSugarEmailAddress.php');
//$dictionary['Contact']['fields']['email1']['audited'] = true;

$dictionary['Contact']['fields']['do_not_call']['massupdate'] = 0;
$dictionary['Contact']['fields']['do_not_call']['audited'] = true;

$dictionary['Contact']['fields']['primary_address_state']['massupdate'] = 0;
$dictionary['Contact']['fields']['alt_address_state']['massupdate'] = 0;
$dictionary['Contact']['fields']['lead_source']['massupdate'] = 0;
$dictionary['Contact']['fields']['opportunity_role']['massupdate'] = 0;
$dictionary['Contact']['fields']['opportunity_role']['audited'] = true;

$dictionary['Contact']['fields']['report_to_name']['massupdate'] = 0;
$dictionary['Contact']['fields']['report_to_name']['audited'] = true;

$dictionary['Contact']['fields']['account_proview_url']['massupdate'] = 0;

$dictionary['Contact']['fields']['birthdate']['audited'] = true;
$dictionary['Contact']['fields']['title']['audited'] = true;
$dictionary['Contact']['fields']['salutation']['audited'] = true;
$dictionary['Contact']['fields']['department']['audited'] = true;

$dictionary['Contact']['fields']['primary_address_city']['audited'] = true;
$dictionary['Contact']['fields']['primary_address_postalcode']['audited'] = true;
$dictionary['Contact']['fields']['primary_address_country']['audited'] = true;

$dictionary['Contact']['fields']['alt_address_street']['audited'] = true;
$dictionary['Contact']['fields']['alt_address_city']['audited'] = true;
$dictionary['Contact']['fields']['alt_address_state']['audited'] = true;
$dictionary['Contact']['fields']['alt_address_postalcode']['audited'] = true;
$dictionary['Contact']['fields']['alt_address_country']['audited'] = true;
$dictionary['Contact']['fields']['description']['audited'] = true;


$dictionary['Contact']['fields']['classification'] = array (
		'required' => false,
		'name' => 'classification',
		'vname' => 'LBL_CLASSIFICATION',
		'type' => 'link',
		'source'=>'non-db',
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => true,
		'reportable' => true,
		'len' => '255',
		'size' => '20',
);
$dictionary['Contact']['fields']['businessintelligence'] = array(
		'name' => 'businessintelligence',
		'vname' => 'LBL_BUSINESS_INTELLIGENCE_TYPE_TITLE',
		'source' => 'non_db',
		'type' => 'bi',
		'options' => 'bi_type_dom',
		'audited' => true
);

$dictionary['Contact']['fields']['unique_identifier_id'] = array (
        'required' => false,
        'name' => 'unique_identifier_id',
        'vname' => 'LBL_UNIQUE_IDENTIFIER_ID',
        'type' => 'varchar',
        'massupdate' => 0,
        'comments' => '',
        'help' => '',
        'importable' => 'true',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => '0',
        'audited' => true,
        'reportable' => true,
        'len' => '255',
        'size' => '20',
);

$dictionary['Contact']['fields']['role'] = array (
        'required' => false,
        'name' => 'role',
        'vname' => 'LBL_ROLE',
        'type' => 'enum',
        'massupdate' => 0,
        'options' => 'contacts_role_dom',
        'comments' => '',
        'help' => '',
        'importable' => 'true',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => '0',
        'audited' => true,
        'reportable' => true,
        'len' => '255',
        'size' => '20',
);

$dictionary['Contact']['fields']['default_contact'] = array(
		'required' => false,
		'name' => 'default_contact',
		'vname' => 'LBL_DEFAULT_CONTACT',
		'type' => 'bool',
		'massupdate' => 0,
		'comments' => '',
		'help' => '',
		'importable' => false,
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => true,
		'reportable' => false,
		'calculated' => false,
		'len' => '255',
		'size' => '20',
		'default' => '0',
);
$dictionary['Contact']['fields']['phone_work_ext'] = array (
        'required' => false,
        'name' => 'phone_work_ext',
        'vname' => 'LBL_PHONE_WORK_EXT',
        'type' => 'varchar',
        'massupdate' => 0,
        'comments' => '',
        'help' => '',
        'importable' => 'true',
        'duplicate_merge' => 'disabled',        
        'audited' => true,
        'reportable' => true,
        'len' => '4',
        'size' => '4',
);
$dictionary['Contact']['fields']['international'] = array(
		'required' => false,
		'name' => 'international',
		'label' => 'LBL_INTERNATIONAL',
		'type' => 'bool',
		'default_value' => false,
		'help' => 'International Clients',
		'comment' => 'International Clients',
		'audited' => true,
		'mass_update' => false,
		'duplicate_merge' => false,
		'reportable' => true,
		'importable' => 'true',
);



// created: 2012-05-21 17:10:30
$dictionary["Contact"]["fields"]["contact_businessintelligence"] = array (
  'name' => 'contact_businessintelligence',
  'type' => 'link',
  'relationship' => 'contact_businessintelligence',
  'source' => 'non-db',
  'vname' => 'LBL_FP',
);
$dictionary['Contact']['relationships']['contact_businessintelligence'] = array(
 'lhs_module'=> 'Contacts',
 'lhs_table'=> 'contacts',
 'lhs_key' => 'id',
 'rhs_module'=> 'oss_BusinessIntelligence',
 'rhs_table'=> 'oss_businessintelligence',
 'rhs_key' => 'contact_id',
 'relationship_type'=>'one-to-many'
);

// created: 2012-05-21 17:10:30
$dictionary["Contact"]["fields"]["contact_leadclientdetail"] = array (
  'name' => 'contact_leadclientdetail',
  'type' => 'link',
  'relationship' => 'contact_leadclientdetail',
  'source' => 'non-db',
  'vname' => 'LBL_LEADCLIENTDETAILS',
);
$dictionary['Contact']['relationships']['contact_leadclientdetail'] = array(
 'lhs_module'=> 'Contacts',
 'lhs_table'=> 'contacts',
 'lhs_key' => 'id',
 'rhs_module'=> 'oss_LeadClientDetail',
 'rhs_table'=> 'oss_leadclientdetail',
 'rhs_key' => 'contact_id',
 'relationship_type'=>'one-to-many'
);

// created: 2011-11-14 11:11:29
$dictionary["Contact"]["fields"]["oss_classification_contacts"] = array (
  'name' => 'oss_classification_contacts',
  'type' => 'link',
  'relationship' => 'oss_classification_contacts',
  'source' => 'non-db',
  'vname' => 'LBL_OSS_CLASSIFICATION_CONTACTS_FROM_OSS_CLASSIFICATION_TITLE',
);


$dictionary["Contact"]["fields"]["opportunities_contacts_c"] = array (
        'name' => 'opportunities_contacts_c',
        'type' => 'link',
        'relationship' => 'opportunities_contacts_c',
        'source' => 'non-db',
        'vname' => 'LBL_OPPORTUNITIES_CONTACTS_TITLE',
);


$dictionary['Contact']['fields']['team_set_id'] = array(
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

$dictionary['Contact']['fields']['team_id'] = array(
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
	


// created: 2019-11-08 09:10:01
$dictionary["Contact"]["fields"]["oss_bidderslist_contacts"] = array (
  'name' => 'oss_bidderslist_contacts',
  'type' => 'link',
  'relationship' => 'oss_bidderslist_contacts',
  'source' => 'non-db',
  'module' => 'oss_BiddersList',
  'bean_name' => 'oss_BiddersList',
  'side' => 'right',
  'vname' => 'LBL_OSS_BIDDERSLIST_CONTACTS_FROM_OSS_BIDDERSLIST_TITLE',
);



$dictionary['Contact']['fields']['picture'] = array(
'name' => 'picture',
'label' => 'LBL_PICTURE',
'type' => 'varchar',
);


 // created: 2020-04-30 08:57:29
$dictionary['Contact']['fields']['visibility']['inline_edit']=true;
$dictionary['Contact']['fields']['visibility']['merge_filter']='disabled';
$dictionary['Contact']['fields']['visibility']['reportable']=true;

 

 // created: 2020-04-30 08:59:09
$dictionary['Contact']['fields']['default_contact']['inline_edit']=true;
$dictionary['Contact']['fields']['default_contact']['importable']='true';
$dictionary['Contact']['fields']['default_contact']['merge_filter']='disabled';
$dictionary['Contact']['fields']['default_contact']['reportable']=true;

 

 // created: 2020-04-30 08:58:49
$dictionary['Contact']['fields']['onvia_id']['inline_edit']=true;
$dictionary['Contact']['fields']['onvia_id']['merge_filter']='disabled';

 

 // created: 2019-11-28 09:45:36
$dictionary['Contact']['fields']['picture']['name']='picture';
$dictionary['Contact']['fields']['picture']['label']='LBL_PICTURE';
$dictionary['Contact']['fields']['picture']['type']='varchar';

 

 // created: 2019-11-07 07:41:25
$dictionary['Contact']['fields']['jjwg_maps_lat_c']['inline_edit']=1;

 

 // created: 2019-12-04 06:34:23
$dictionary['Contact']['fields']['lead_source']['default']='bb';
$dictionary['Contact']['fields']['lead_source']['len']=100;
$dictionary['Contact']['fields']['lead_source']['inline_edit']=true;
$dictionary['Contact']['fields']['lead_source']['options']='lead_source_list';
$dictionary['Contact']['fields']['lead_source']['comments']='How did the contact come about';
$dictionary['Contact']['fields']['lead_source']['merge_filter']='disabled';

 

 // created: 2020-04-30 08:57:13
$dictionary['Contact']['fields']['is_modified']['default']='0';
$dictionary['Contact']['fields']['is_modified']['inline_edit']=true;
$dictionary['Contact']['fields']['is_modified']['merge_filter']='disabled';

 

 // created: 2019-11-28 10:04:18
$dictionary['Contact']['fields']['photo']['inline_edit']=true;
$dictionary['Contact']['fields']['photo']['importable']='true';
$dictionary['Contact']['fields']['photo']['merge_filter']='disabled';
$dictionary['Contact']['fields']['photo']['border']='';

 

 // created: 2019-11-28 10:05:30
$dictionary['Contact']['fields']['team_id']['inline_edit']=true;
$dictionary['Contact']['fields']['team_id']['merge_filter']='disabled';

 

 // created: 2020-04-30 08:57:51
$dictionary['Contact']['fields']['mi_contact_id']['inline_edit']=true;
$dictionary['Contact']['fields']['mi_contact_id']['merge_filter']='disabled';

 

 // created: 2019-11-28 09:59:46
$dictionary['Contact']['fields']['unique_identifier_id']['required']=false;
$dictionary['Contact']['fields']['unique_identifier_id']['name']='unique_identifier_id';
$dictionary['Contact']['fields']['unique_identifier_id']['vname']='LBL_UNIQUE_IDENTIFIER_ID';
$dictionary['Contact']['fields']['unique_identifier_id']['type']='varchar';
$dictionary['Contact']['fields']['unique_identifier_id']['massupdate']=0;
$dictionary['Contact']['fields']['unique_identifier_id']['comments']='';
$dictionary['Contact']['fields']['unique_identifier_id']['help']='';
$dictionary['Contact']['fields']['unique_identifier_id']['importable']='true';
$dictionary['Contact']['fields']['unique_identifier_id']['duplicate_merge']='disabled';
$dictionary['Contact']['fields']['unique_identifier_id']['duplicate_merge_dom_value']='0';
$dictionary['Contact']['fields']['unique_identifier_id']['audited']=true;
$dictionary['Contact']['fields']['unique_identifier_id']['reportable']=true;
$dictionary['Contact']['fields']['unique_identifier_id']['len']='255';
$dictionary['Contact']['fields']['unique_identifier_id']['size']='20';
$dictionary['Contact']['fields']['unique_identifier_id']['inline_edit']=true;
$dictionary['Contact']['fields']['unique_identifier_id']['merge_filter']='disabled';

 

 // created: 2019-12-13 10:30:11
$dictionary['Contact']['fields']['international']['default']='0';
$dictionary['Contact']['fields']['international']['inline_edit']=true;
$dictionary['Contact']['fields']['international']['comments']='International Clients';
$dictionary['Contact']['fields']['international']['duplicate_merge']='disabled';
$dictionary['Contact']['fields']['international']['duplicate_merge_dom_value']='0';
$dictionary['Contact']['fields']['international']['merge_filter']='disabled';

 

 // created: 2019-11-07 07:41:26
$dictionary['Contact']['fields']['jjwg_maps_geocode_status_c']['inline_edit']=1;

 

 // created: 2020-04-30 08:58:11
$dictionary['Contact']['fields']['dodge_id']['inline_edit']=true;
$dictionary['Contact']['fields']['dodge_id']['merge_filter']='disabled';

 

 // created: 2019-11-28 10:01:32
$dictionary['Contact']['fields']['phone_work_ext']['required']=false;
$dictionary['Contact']['fields']['phone_work_ext']['name']='phone_work_ext';
$dictionary['Contact']['fields']['phone_work_ext']['vname']='LBL_PHONE_WORK_EXT';
$dictionary['Contact']['fields']['phone_work_ext']['type']='varchar';
$dictionary['Contact']['fields']['phone_work_ext']['massupdate']=0;
$dictionary['Contact']['fields']['phone_work_ext']['comments']='';
$dictionary['Contact']['fields']['phone_work_ext']['help']='';
$dictionary['Contact']['fields']['phone_work_ext']['importable']='true';
$dictionary['Contact']['fields']['phone_work_ext']['duplicate_merge']='disabled';
$dictionary['Contact']['fields']['phone_work_ext']['audited']=true;
$dictionary['Contact']['fields']['phone_work_ext']['reportable']=true;
$dictionary['Contact']['fields']['phone_work_ext']['len']='4';
$dictionary['Contact']['fields']['phone_work_ext']['size']='4';
$dictionary['Contact']['fields']['phone_work_ext']['inline_edit']=true;
$dictionary['Contact']['fields']['phone_work_ext']['duplicate_merge_dom_value']='0';
$dictionary['Contact']['fields']['phone_work_ext']['merge_filter']='disabled';

 

 // created: 2019-11-07 07:41:25
$dictionary['Contact']['fields']['jjwg_maps_lng_c']['inline_edit']=1;

 

 // created: 2019-12-04 06:00:21
$dictionary['Contact']['fields']['role']['options']='contacts_role_dom';

 

 // created: 2019-11-07 07:41:26
$dictionary['Contact']['fields']['jjwg_maps_address_c']['inline_edit']=1;

 

 // created: 2020-04-30 08:58:29
$dictionary['Contact']['fields']['reed_id']['inline_edit']=true;
$dictionary['Contact']['fields']['reed_id']['merge_filter']='disabled';

 

 // created: 2019-11-28 10:06:58

 
?>
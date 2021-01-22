<?php
$searchdefs ['Opportunities'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
      'favorites_only' => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'account_name' => 
      array (
        'name' => 'account_name',
        'default' => true,
        'width' => '10%',
      ),
      'amount' => 
      array (
        'name' => 'amount',
        'default' => true,
        'width' => '10%',
      ),
      'assigned_user_id' => 
      array (
        'name' => 'assigned_user_id',
        'type' => 'enum',
        'label' => 'LBL_ASSIGNED_TO',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
        'default' => true,
        'width' => '10%',
      ),
      'sales_stage' => 
      array (
        'name' => 'sales_stage',
        'default' => true,
        'width' => '10%',
      ),
      'lead_source' => 
      array (
        'name' => 'lead_source',
        'default' => true,
        'width' => '10%',
      ),
      'date_closed' => 
      array (
        'name' => 'date_closed',
        'default' => true,
        'width' => '10%',
      ),
      'lead_start_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_LEAD_START_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_start_date',
      ),
      'lead_end_date' => 
      array (
        'type' => 'date',
        'label' => 'LBL_LEAD_END_DATE',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_end_date',
      ),
      'lead_city' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_LEAD_CITY',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_city',
      ),
      'lead_state' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_LEAD_STATE',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_state',
      ),
      'lead_county' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_LEAD_COUNTY',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_county',
      ),
      'lead_square_footage' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_LEAD_SQUARE_FOOTAGE',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_square_footage',
      ),
      'lead_project_status' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_LEAD_PROJECT_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_project_status',
      ),
      'lead_structure' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_LEAD_STRUCTURE',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_structure',
      ),
      'zone_name' => 
      array (
        'type' => 'enum',
        'label' => 'LBL_OSS_ZONE_OPPORTUNITIES_1_FROM_OSS_ZONE_TITLE',
        'width' => '10%',
        'default' => true,
        'name' => 'zone_name',
      ),
      'lead_contact_no' => 
      array (
        'type' => 'varchar',
        'label' => 'LBL_LEAD_CONTACT_NO',
        'width' => '10%',
        'default' => true,
        'name' => 'lead_contact_no',
      ),
      'current_user_only' => 
      array (
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
        'name' => 'current_user_only',
      ),
      'favorites_only' => 
      array (
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'width' => '10%',
        'default' => true,
        'name' => 'favorites_only',
      ),
      'is_archived' => 
      array ('name' => 'include_archive_open_only', 'label' => 'LBL_INCLUDE_ARCHIVE', 'type' => 'bool'),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
;
appendFieldsOnViews($editView=array(),$detailView=array(),$searchdefs['Opportunities'],$listViewDefs=array(),$searchFields=array(),'Opportunities','SearchDefs');
?>
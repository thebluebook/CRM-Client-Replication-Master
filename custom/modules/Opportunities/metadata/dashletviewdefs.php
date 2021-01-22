<?php
$dashletData['OpportunitiesDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'opportunity_type' => 
  array (
    'default' => '',
  ),
  'team_id' => 
  array (
    'default' => '',
  ),
  'sales_stage' => 
  array (
    'default' => '',
  ),
  'assigned_user_id' => 
  array (
    'default' => '',
  ),
);
$dashletData['OpportunitiesDashlet']['columns'] = array (
  'name' => 
  array (
    'width' => '35',
    'label' => 'LBL_OPPORTUNITY_NAME',
    'link' => true,
    'default' => true,
  ),
  'account_name' => 
  array (
    'width' => '35',
    'label' => 'LBL_ACCOUNT_NAME',
    'default' => true,
    'link' => false,
    'id' => 'account_id',
    'ACLTag' => 'ACCOUNT',
  ),
  'amount_usdollar' => 
  array (
    'width' => '15',
    'label' => 'LBL_AMOUNT_USDOLLAR',
    'default' => true,
    'currency_format' => true,
  ),
  'date_closed' => 
  array (
    'width' => '15',
    'label' => 'LBL_DATE_CLOSED',
    'default' => true,
    'defaultOrderColumn' => 
    array (
      'sortOrder' => 'ASC',
    ),
  ),
  'opportunity_type' => 
  array (
    'width' => '15',
    'label' => 'LBL_TYPE',
  ),
  'lead_source' => 
  array (
    'width' => '15',
    'label' => 'LBL_LEAD_SOURCE',
  ),
  'sales_stage' => 
  array (
    'width' => '15',
    'label' => 'LBL_SALES_STAGE',
  ),
  'probability' => 
  array (
    'width' => '15',
    'label' => 'LBL_PROBABILITY',
  ),
  'date_entered' => 
  array (
    'width' => '15',
    'label' => 'LBL_DATE_ENTERED',
  ),
  'date_modified' => 
  array (
    'width' => '15',
    'label' => 'LBL_DATE_MODIFIED',
  ),
  'created_by' => 
  array (
    'width' => '8',
    'label' => 'LBL_CREATED',
  ),
  'assigned_user_name' => 
  array (
    'width' => '8',
    'label' => 'LBL_LIST_ASSIGNED_USER',
  ),
  'next_step' => 
  array (
    'width' => '10',
    'label' => 'LBL_NEXT_STEP',
  ),
);
<?php
 // created: 2019-11-07 14:57:42
$layout_defs["Accounts"]["subpanel_setup"]['oss_businessintelligence_accounts'] = array (
  'order' => 100,
  'module' => 'oss_BusinessIntelligence',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_OSS_BUSINESSINTELLIGENCE_ACCOUNTS_FROM_OSS_BUSINESSINTELLIGENCE_TITLE',
  'get_subpanel_data' => 'oss_businessintelligence_accounts',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
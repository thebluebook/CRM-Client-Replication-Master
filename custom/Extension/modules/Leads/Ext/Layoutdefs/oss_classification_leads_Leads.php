<?php
// created: 2011-11-03 14:05:19
$layout_defs["Leads"]["subpanel_setup"]["oss_classification_leads"] = array (
  'order' => 100,
  'module' => 'oss_Classification',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_OSS_CLASSIFICATION_LEADS_FROM_OSS_CLASSIFICATION_TITLE',
  'get_subpanel_data' => 'oss_classification_leads',
  'top_buttons' => 
  array (
    /*0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),*/
    0 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
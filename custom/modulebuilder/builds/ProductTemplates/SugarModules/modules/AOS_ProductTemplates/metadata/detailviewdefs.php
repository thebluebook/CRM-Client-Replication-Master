<?php
$module_name = 'AOS_ProductTemplates';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'website',
            'label' => 'LBL_WEBSITE',
          ),
          1 => 
          array (
            'name' => 'date_available',
            'label' => 'LBL_DATE_AVAILABLE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'tax_class',
            'studio' => 'visible',
            'label' => 'LBL_TAX_CLASS',
          ),
          1 => 
          array (
            'name' => 'qty_in_stock',
            'label' => 'LBL_QTY_IN_STOCK',
          ),
        ),
        3 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'weight',
            'label' => 'LBL_WEIGHT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'mft_part_num',
            'label' => 'LBL_MFT_PART_NUM',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'vendor_part_num',
            'label' => 'LBL_VENDOR_PART_NUM',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'studio' => 'visible',
            'label' => 'LBL_CURRENCY',
          ),
          1 => 
          array (
            'name' => 'support_name',
            'label' => 'LBL_SUPPORT_NAME',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'cost_price',
            'label' => 'LBL_COST_PRICE',
          ),
          1 => 
          array (
            'name' => 'support_contact',
            'label' => 'LBL_SUPPORT_CONTACT',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'markup_inper',
            'label' => 'LBL_MARKUP_INPER',
          ),
          1 => 
          array (
            'name' => 'support_description',
            'label' => 'LBL_SUPPORT_DESCRIPTION',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'discount_price',
            'label' => 'LBL_DISCOUNT_PRICE',
          ),
          1 => 
          array (
            'name' => 'support_term',
            'studio' => 'visible',
            'label' => 'LBL_SUPPORT_TERM',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'quantity',
            'label' => 'LBL_QUANTITY',
          ),
          1 => '',
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'total_cost',
            'label' => 'LBL_TOTAL_COST',
          ),
          1 => 
          array (
            'name' => 'pricing_formula',
            'label' => 'LBL_PRICING_FORMULA',
          ),
        ),
        12 => 
        array (
          0 => 'description',
          1 => 
          array (
            'name' => 'quickbook_type',
            'studio' => 'visible',
            'label' => 'LBL_QUICKBOOK_TYPE',
          ),
        ),
      ),
    ),
  ),
);
;
?>

<?php
$dictionary['oss_ProposalTracker']['fields']['proposal_id'] = array(
    'name' => 'proposal_id',
    'vname' => 'LBL_PROPOSAL_NAME',
    'type' => 'char',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => true,
    'reportable' => true,
    'len' => '36',
);

$dictionary['oss_ProposalTracker']['fields']['proposal_name'] = array(
    'required' => false,
    'source' => 'non-db',
    'name' => 'proposal_name',
    'vname' => 'LBL_PROPOSAL_NAME',
    'type' => 'relate',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'len' => '255',
    'size' => '20',
    'id_name' => 'proposal_id',
    'ext2' => 'AOS_Quotes',
    'module' => 'aos_quotes',
    'rname' => 'name',
    'quicksearch' => 'enabled',
    'studio' => 'visible',
);

$dictionary["oss_ProposalTracker"]["fields"]["proposal_proposal_tracker"] = array (
  'name' => 'proposal_proposal_tracker',
  'type' => 'link',
  'relationship' => 'proposal_proposal_tracker',
  'source' => 'non-db',
  'vname' => 'LBL_PROPOSAL_NAME',
);

$dictionary['oss_ProposalTracker']['relationships']['proposal_proposal_tracker'] = array(
    'lhs_module'=> 'AOS_Quotes', 'lhs_table'=> 'aos_quotes', 'lhs_key' => 'id',
    'rhs_module'=> 'oss_ProposalTracker', 'rhs_table'=> 'oss_proposaltracker', 'rhs_key' => 'proposal_id',
    'relationship_type'=>'one-to-many'
);

?>

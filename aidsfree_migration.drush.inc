<?php
/**
 * @file
 * Command-line tools to aid migration from d7 to d8.
 */
use \Drupal\node\NodeTypeInterface;
use \Drupal\field\Entity\FieldStorageConfig;
use \Drupal\field\Entity\FieldConfig;

function aidsfree_migration_add_body_field(NodeTypeInterface $type, $label = 'Body'){
  drupal_set_message(t('Hello world!'));
}
function list_node_types(){
  $types = [];
  $nodeTypes =  \Drupal\node\Entity\NodeType::loadMultiple();

  foreach ($nodeTypes as $nodeType){
    array_push($types, $nodeType->id());
    //$field_storage = FieldStorageConfig::loadByName($nodeType->id(), 'description');
    //var_dump($field_storage);die();
    $field = FieldConfig::loadByName('node_type', $nodeType->id(), 'body');
    if (empty($field)) {
      echo 'I was created';
      $field = FieldConfig::create([
          //'field_storage' => $field_storage,
          'field_name' => 'body',
          'entity_type' => 'node_type',
          'bundle' => $nodeType->id(),
          'label' => $nodeType->label(),
          'settings' => array('display_summary' => TRUE),
      ]
      );
      $field->save();
    }
    echo $nodeType->label();
    die();
  }
  //echo count($types);
}
function aidsfree_migration_drush_command() {
  $items['aidsfree_migration-create-body-field'] = [
    'description' => 'creates body field for node types migrated from d7.',
    'aliases' => ['ambf'],
  ];

  return $items;
}

function drush_aidsfree_migration_create_body_field(){
  //node_add_body_field();
  list_node_types();
}
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
  }
  return $types;
}
function add_field_body($type){
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
  }
  //echo count($types);
}
function aidsfree_migration_drush_command() {
  $items['aidsfree_migration-create-body-field'] = [
    'description' => 'creates body field for node types migrated from d7.',
    'aliases' => ['ambf'],
  ];
  $items['aidsfree_migration-create-node-type'] = [
    'description' => 'creates a node type.',
    'aliases' => ['amnt']
  ];

  return $items;
}

function drush_aidsfree_migration_create_body_field(){
  $nodeTypes =  \Drupal\node\Entity\NodeType::loadMultiple();

  foreach ($nodeTypes as $key => $nodeType){
    $field = FieldConfig::loadByName('node', $nodeType->id(), 'body');
    if (empty($field)){
      FieldConfig::create([
        'field_name' => 'body',
        'entity_type' => 'node',
        'bundle' => $nodeType->id(),
        'label' => 'body',
        'field_type' => 'text_long',
        'widget' => []
      ])->save();
      //var_dump($nodeType->id(). ' has no body field');
    }
  }
}

function drush_aidsfree_migration_create_node_type(){
  /*\Drupal\node\Entity\NodeType::create([
    'name' => 'Chemistry',
    'type' => 'chemisty',
    'description' => 'Custom node type to display molecular modules.'
  ])->save();

  FieldConfig::create([
    'field_name' => 'body',
    'entity_type' => 'node',
    'status' => TRUE,
    'bundle' => 'chemisty',
    'label' => 'body',
    'field_type' => 'text_long',
    'widget' => []
  ])->save();*/
  $nodeTypes = list_node_types();
  if (!in_array('aboutgdfgdg', $nodeTypes)){
    throw new \Drupal\aidsfree_migration\Exception\MissingNodeTypeException('about');
  }
}
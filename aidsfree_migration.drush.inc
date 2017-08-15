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

function list_paragraph_types(){
  $paragraphs = [];
  $paragraphTypes = \Drupal\paragraphs\Entity\ParagraphsType::loadMultiple();
  foreach ($paragraphTypes as $paragraph){
    array_push($paragraphs, $paragraph->id());
  }
  return $paragraphs;
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
  $items['aidsfree_migration-create-paragraph-field'] = [
    'description' => 'creates a paragraph field.',
    'aliases' => ['ampf']
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
    }
  }
}

function drush_aidsfree_migration_create_node_type(){
  var_dump(list_paragraph_types());
}
function drush_aidsfree_migration_create_paragraph_field(){
  //$paragraphTypes = \Drupal\paragraphs\Entity\ParagraphsType::loadMultiple();

  $parag = \Drupal\paragraphs\Entity\ParagraphsType::create([
    'id' => 'physics',
    'label' => 'physics',
  ])->save();
  $pp_field_storage = FieldStorageConfig::create(
    array(
      'field_name' => 'pp_title_sira',
      'entity_type' => 'paragraph',
      'bundle' => 'physics',
      'type' => 'text_long',
      'settings' => [
        'max_length' => '255',
      ],
      'cardinality' => 1,
    )
  )->save();

  FieldConfig::create([
    'field_name' => 'pp_title_sira',
    //'field_storage' => $pp_field_storage,
    'entity_type' => 'paragraph',
    'status' => TRUE,
    'bundle' => 'physics',
    'label' => 'title',
    'field_type' => 'text_long',
    'widget' => []
  ])->save();
}
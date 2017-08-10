<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\process;

use Drupal\field\Entity\FieldConfig;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Node body field creation
 *
 * @MigrateProcessPlugin(
 *   id = "node_body_field_create"
 * )
 *
 */
class NodeBodyField extends ProcessPluginBase{
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property){
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
    return $value;
  }
}
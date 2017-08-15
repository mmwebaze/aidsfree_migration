<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\process;

use Drupal\aidsfree_migration\Exception\MissingNodeTypeException;
use Drupal\aidsfree_migration\Util\MigrationUtil;
use Drupal\field\Entity\FieldConfig;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Node body field creation plugin
 *
 * @MigrateProcessPlugin(
 *   id = "node_body_field_create"
 * )
 *
 */
class NodeBodyField extends ProcessPluginBase{
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property){

    if (!MigrationUtil::checkNodeTypeExists($value)){
      throw new MissingNodeTypeException($value);
    }
    $field = FieldConfig::loadByName('node', $value, 'body');
    if (empty($field)) {
      FieldConfig::create([
        'field_name' => 'body',
        'entity_type' => 'node',
        'status' => TRUE,
        'bundle' => $value,
        'label' => 'body',
        'field_type' => 'text_long',
        'widget' => []
      ])->save();
    }
    return $value;
  }
}
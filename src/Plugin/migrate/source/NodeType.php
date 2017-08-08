<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Aidsfree taxomony from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_node_types_sql"
 * )
 *
 */
class NodeType extends SqlBase{
  public function fields(){
    $fields = [
      'type' => $this->t('The machine-readable name of this type.'),
      'name' => $this->t('The hum-readable name of this type.'),
      'base' => $this->t('The base string used to construct callbacks corresponding to this type.'),
      'module' => $this->t('The module defining this node type.'),
      'description' => $this->t('A brief description of this type.'),
      'help' => $this->t('Help information shown to the user when creating a node of this type.'),
      'has_title' => $this->t('Boolean indicating whether this type uses the node.title.field.'),
      'title_label' => $this->t('The label displayed for the title field on the edit form.'),
      'custom' => $this->t('A boolean value see table description'),
      'modified' => $this->t('A boolean value see table description'),
      'locked' => $this->t('A boolean value see table description'),
      'disabled' => $this->t('A boolean indicating whether the administrator can change the machine name of this type.'),
      'orig_type' => $this->t('The original machine name of this type.'),
    ];

    return $fields;
  }
  public function getIds(){
    return [
      'type' => [
        'type' => 'string'
      ]
    ];
  }
  public function query(){
    $query =  $this->select('node_type', 'nt')
      ->fields('nt', array_keys($this->fields()));
    return $query;
  }
}
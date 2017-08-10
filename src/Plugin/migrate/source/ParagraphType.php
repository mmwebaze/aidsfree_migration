<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Aidsfree paragraph type from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_paragraph_types_sql"
 * )
 *
 */
class ParagraphType extends SqlBase{

  public function fields(){
    $fields = [
      'bundle' => $this->t('The machine-readable name of this bundle.'),
      'name' => $this->t('The human-readable name of this bundle.'),
      'locked' => $this->t('A boolean value see table description'),
    ];

    return $fields;
  }
  public function getIds(){
    return [
      'bundle' => [
        'type' => 'string'
      ]
    ];
  }
  public function query(){
    echo 'hmmmm';
    $query =  $this->select('paragraphs_bundle', 'pb')
      ->fields('pb', array_keys($this->fields()));
    return $query;
  }
}
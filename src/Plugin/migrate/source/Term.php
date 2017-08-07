<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\source;


use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Aidsfree terms from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_term_sql"
 * )
 *
 */
class Term extends SqlBase {
  public function getIds() {
    return [
      'tid' => [
        'type' => 'integer'
      ]
    ];
  }

  public function fields() {
    $fields = [
      'tid' => $this->t('Unique term ID'),
      'vid' => $this->t('The vocabulary to which the term is assigned'),
      'name' => $this->t('The term name'),
      'description' => $this->t('The description of the term'),
      'format' => $this->t('The filter_format.format of the description.'),
      'weight' => $this->t('The weight of this term in relation to other terms'),
    ];

    return $fields;
  }

  public function query() {
    $query = $this->select('taxonomy_term_data', 'ttd')
      ->fields('ttd', array_keys($this->fields()))
      ->distinct();
    return $query;
  }
  public function prepareRow(Row $row) {
    $parents = $this->select('taxonomy_term_hierarchy', 'tth')
      ->fields('tth', array('tid', 'parent'))
      ->condition('tid', $row->getSourceProperty('tid'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('parent', $parents);
    return parent::prepareRow($row);
  }
}
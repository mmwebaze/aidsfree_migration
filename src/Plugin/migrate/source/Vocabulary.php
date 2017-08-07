<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Aidsfree taxomony from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_vocabulary_sql"
 * )
 *
 */
class Vocabulary extends SqlBase{
  public function fields() {
    $fields = [
      'vid' => $this->t('Unique vocabulary ID'),
      'name' => $this->t('Name of vocabulary'),
      'machine_name' => $this->t('The vocabulary machine name'),
      'description' => $this->t('Description of the vocabulary'),
      'hierarchy' => $this->t('The type of hierarchy allowed within the vocabulary'),
      'module' => $this->t('The module which created the vocabulary'),
      'weight' => $this->t('The weight of this vocabulary in relation to other vocabularies'),
    ];

    return $fields;
  }

  public function getIds() {
    return [
      'vid' => [
        'type' => 'integer'
      ]
    ];
  }

  public function query() {
    $query =  $this->select('taxonomy_vocabulary', 'tv')
      ->fields('tv', array_keys($this->fields()));
    return $query;
  }
}
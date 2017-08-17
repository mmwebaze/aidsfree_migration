<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Provides a 'ParagraphFieldClass' migrate source.
 *
 * @MigrateSource(
 *  id = "paragraph_field_class"
 * )
 */
class ParagraphFieldClass extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query =  $this->select('paragraphs_item', 'p')
      ->fields('p', array_keys($this->fields()));

    return $query;
  }
  /*public function query() {
    $query =  $this->select('paragraphs_item', 'p');
    $query->innerJoin('field_data_field_class ', 'c', 'c.entity_id = p.item_id');
    $query->fields('p', ['item_id'])->fields('c', array_keys($this->fields()));
    return $query;
  }*/

  /**
   * {@inheritdoc}
   */
  public function fields(){
    $paragraph_items_fields = [
      'item_id' => 'Unique paragraph item ID',
      'bundle' => $this->t('The field instance bundle to which this row belongs, used when deleting a field instance'),
    ];

    return $paragraph_items_fields;
  }
  public function fieldClassFields(){
    $field_class_value = [
      //'entity_type' => $this->t('The entity type this data is attached to'),
      //'bundle' => $this->t('The field instance bundle to which this row belongs, used when deleting a field instance'),
      'entity_id' => $this->t('The entity type this data is attached to'),
      'field_class_value' => $this->t('Content associated with field_class_value field'),
    ];

    return $field_class_value;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds(){
    return [
      'item_id' => [
        'type' => 'integer'
      ]
    ];
  }
  public function prepareRow(Row $row) {
      $q = $this->select('field_data_field_class', 'c')
        ->fields('c', array_keys($this->fieldClassFields()))
        ->condition('entity_id', $row->getSourceProperty('item_id'))
        ->execute()->fetchCol(1);
      //var_dump(json_encode($q).' ** '.$r);

      $row->setSourceProperty('field_class', $q);
      return parent::prepareRow($row);
    }
}

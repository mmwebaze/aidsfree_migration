<?php
namespace Drupal\aidsfree_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
/**
 * Aidsfree node from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_paragraphs_pack_content_sql"
 * )
 *
 */
class ParagraphsPackContent extends SqlBase{
  public function ppBodyfields(){
    $pp_body_fields = [
      'entity_type' => $this->t('The entity type this data is attached to'),
      'bundle' => $this->t('The field instance bundle to which this row belongs, used when deleting a field instance'),
      'entity_id' => $this->t('The entity type this data is attached to'),
      'pp_body_value' => $this->t('Content associated with the pp_body field'),
      'pp_body_format' => $this->t('Format associated with the pp_body field'),
    ];

    return $pp_body_fields;
  }
  public function fields(){
    $paragraph_items_fields = [
      'item_id' => 'Unique paragraph item ID',
    ];

    return $paragraph_items_fields;
  }
  /*public function fieldClassFields(){
    $field_class_value = [
      'entity_id' => $this->t('The entity type this data is attached to'),
      'field_class_value' => $this->t('Content associated with field_class_value field'),
    ];

    return $field_class_value;
  }*/
  public function getIds(){
    return [
      'item_id' => [
        'type' => 'integer'
      ]
    ];
  }
  public function query(){
    $query =  $this->select('paragraphs_item', 'p');
    $query->innerJoin('field_data_pp_body ', 'b', 'b.entity_id = p.item_id');
    $query->fields('p', array_keys($this->fields()))
      ->fields('b', array_keys($this->ppBodyfields()));

    return $query;
  }
  /*public function prepareRow(Row $row) {
    $q = $this->select('field_data_field_class', 'c')
      ->fields('c', array('entity_id', 'field_class_value'))
      ->condition('entity_id', $row->getSourceProperty('item_id'))
      ->execute()->fetchCol(1);
    //var_dump(json_encode($q).' ** '.$r);

    $row->setSourceProperty('field_class', $q);
    return parent::prepareRow($row);
  }*/
}
<?php
namespace Drupal\aidsfree_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
/**
 * Aidsfree node from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_paragraphs_pack_content_sql"
 * )
 *
 */
class ParagraphsPackContent extends SqlBase{
  public function fields(){
    $pp_body_fields = [
      'entity_type' => $this->t('The entity type this data is attached to'),
      'bundle' => $this->t('The field instance bundle to which this row belongs, used when deleting a field instance'),
      'entity_id' => $this->t('The entity type this data is attached to'),
      'pp_body_value' => $this->t('Content associated with the pp_body field'),
      'pp_body_format' => $this->t('Format associated with the pp_body field'),
    ];

    return $pp_body_fields;
  }
  public function fieldClassFields(){
    $field_class_value = [
      'entity_id' => $this->t('The entity type this data is attached to'),
      'field_class_value' => $this->t('Content associated with field_class_value field'),
    ];

    return $field_class_value;
  }
  public function getIds(){
    return [
      'entity_id' => [
        'type' => 'integer'
      ]
    ];
  }
  public function query(){
    $query =  $this->select('field_data_pp_body ', 'b');
    $query->innerJoin('field_data_field_class ', 'c', 'b.entity_id = c.entity_id');
    $query->fields('b', array_keys($this->fields()))
      ->fields('c', array_keys($this->fieldClassFields()));

    return $query;
  }
}
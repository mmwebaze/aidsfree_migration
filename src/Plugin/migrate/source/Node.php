<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\source;


use Drupal\migrate\Plugin\migrate\source\SqlBase;
/**
 * Aidsfree node from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_nodes_sql"
 * )
 *
 */
class Node extends SqlBase {
  /**
   * defines the fields in the node table
   *
   * @return array of fields for node table
   */
  public function fields(){
    $fields = [
      'nid' => $this->t('The primary identifier for a node.'),
      'vid' => $this->t('The current node revision version identifier.'),
      'type' => $this->t('The node_type type of this node.'),
      'title' => $this->t('The language of this node.'),
      'uid' => $this->t('The users uid that owns this node.'),
      'status' => $this->t('A boolean value see node table description.'),
      'created' => $this->t('Timestamp when the node was created.'),
      'changed' => $this->t('Timestamp when the node was most recently changed.'),
      'comment' => $this->t('A boolean value see node table description'),
      'promote' => $this->t('A boolean value see node table description'),
      'sticky' => $this->t('A boolean value see node table description.'),
      'tnid' => $this->t('The translation set id for this node.'),
      'translate' => $this->t('A boolean value see node table description.'),
    ];

    return $fields;
  }
  /**
   * defines the fields in the field_data_body table
   *
   * @return array of fields for field_data_body table
   */
  public function dataFields(){
    $fields = [
      'entity_type' => $this->t('The entity type this data is attached to'),
      'bundle' => $this->t('The field instance bundle to which this row belongs, used when deleting a field instance'),
      'deleted' => $this->t('A boolean indicating whether this data item has been deleted'),
      'entity_id' => $this->t('The entity id this data is attached to'),
      'revision_id' => $this->t('The entity revision id this data is attached to, or NULL if the entity type is not versioned'),
      'language' => $this->t('The language for this data item'),
      'delta' => $this->t('The sequence number for this data item, used for multi-value fields'),
      'body_value' => $this->t('The entity type this data is attached to'),
      'body_summary' => $this->t('The entity type this data is attached to'),
      'body_format' => $this->t('The entity type this data is attached to'),
    ];

    return $fields;
  }

  /**
   * @return array of node ids as defined in the node table.
   */
  public function getIds(){
    return [
      'nid' => [
        'type' => 'integer'
      ]
    ];
  }

  /**
   *
   *
   * @return results of inner join node and field_data_body tables
   */
  public function query(){
    $query =  $this->select('node', 'n');
    $query->innerJoin('field_data_body', 'd', 'n.nid = d.entity_id');
    $query->fields('n', array_keys($this->fields()))
      ->fields('d', array_keys($this->dataFields()));
    #$query->condition('n.type', 'about');

    return $query;
  }
}
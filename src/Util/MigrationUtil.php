<?php

namespace Drupal\aidsfree_migration\Util;

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\Entity\NodeType;
use  Drupal\paragraphs\Entity\ParagraphsType;

/**
 * Aidsfree migration utility class
 *
 * @package Drupal\aidsfree_migration\Util
 */
class MigrationUtil {

  /**
   * utility to check if a node type exists
   *
   * @param $name node type machine name
   * @return bool true if node type exists else false
   */
  public static function  checkNodeTypeExists($name){
    $types = [];
    $nodeTypes =  NodeType::loadMultiple();
    foreach ($nodeTypes as $nodeType){
      array_push($types, $nodeType->id());
    }

    if (in_array($name, $types)){
      return TRUE;
    }
    return FALSE;
  }
  public static function checkParagraphTypeExists($name){
    $paragraphs = [];
    $paragraphTypes = ParagraphsType::loadMultiple();
    foreach ($paragraphTypes as $paragraph){
      array_push($paragraphs, $paragraph->id());
    }
    if (in_array($name, $paragraphs)){
      return TRUE;
    }
    return FALSE;
  }
  public static function createFields($enityType, $bundle, array $fields){
    foreach ($fields as $field => $label){
      $field_storage = FieldStorageConfig::create(
        array(
          'field_name' => $field,
          'entity_type' => $enityType,
          'bundle' => $bundle,
          'type' => 'text_long',
          'settings' => [
            'max_length' => '255',
          ],
          'cardinality' => 1,
        )
      )->save();

      FieldConfig::create([
        'field_name' => $field,
        //'field_storage' => $field_storage,
        'entity_type' => $enityType,
        'status' => TRUE,
        'bundle' => $bundle,
        'label' => $label,
        'field_type' => 'text_long',
        'widget' => []
      ])->save();
    }
  }
}
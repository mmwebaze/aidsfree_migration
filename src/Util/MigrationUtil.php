<?php

namespace Drupal\aidsfree_migration\Util;

use Drupal\node\Entity\NodeType;

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
}
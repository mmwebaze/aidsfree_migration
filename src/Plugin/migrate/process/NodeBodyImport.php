<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Node body manipulation from the d7 database
 *
 * @MigrateProcessPlugin(
 *   id = "node_body"
 * )
 *
 */
class NodeBodyImport extends ProcessPluginBase {
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property){

    return $value;
  }
}
<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\process;
use Drupal\field\Entity\FieldConfig;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\aidsfree_migration\Util\MigrationUtil;

/**
 * Node body field creation plugin
 *
 * @MigrateProcessPlugin(
 *   id = "paragraph_field_create"
 * )
 *
 */
class ParagraphField extends ProcessPluginBase{
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property){
    switch ($value){
      case 'paragraphs_pack_content':

        $fields = ['pp_body' => 'Content', 'field_class' => 'Class'];
        foreach ($fields as $field => $label){
          $field = FieldConfig::loadByName('paragraph', 'paragraphs_pack_content', $field);
          if (empty($field)){
            MigrationUtil::createFields('paragraph', 'paragraphs_pack_content', $fields);
          }
        }
        break;
      case 'paragraphs_pack_node_list':

        break;
      case 'photo_left':

        break;
      case 'photo_right':

        break;
      case 'regimen':

        break;
      case 'resources':

        break;
      case 'single_column':

        break;
      case 'three_column':
        break;
      case 'two_column_conten':
        break;
      case 'video':
        break;
      case 'week':
        break;
    }
    return $value;
  }
}
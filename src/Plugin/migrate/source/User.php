<?php

namespace Drupal\aidsfree_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Aidsfree user from the d7 database
 *
 * @MigrateSource(
 *   id = "aidsfree_user_sql"
 * )
 *
 */
class User extends SqlBase {

  public function fields() {
    $fields = [
      'uid' => $this->t('User ID'),
      'name' => $this->t('Unique username'),
      'pass' => $this->t('User password hashed'),
      'mail' => $this->t('User email address'),
      'created' => $this->t('Timestamp for when user was created'),
      'access' => $this->t('Timestamp for previous time user accessed the site'),
      'login' => $this->t('Timestamp for user last login'),
      'status' => $this->t('Whether the user is active(1) or blocked(0)'),
      'timezone' => $this->t('User timezone'),
      'init' => $this->t('E-mail address used for initial account creation.'),
    ];

    return $fields;
  }

  public function getIds() {
    return [
      'uid' => [
        'type' => 'integer'
      ]
    ];
  }

  public function query() {
    $query =  $this->select('users', 'u')
      ->fields('u', array_keys($this->fields()))
      ->condition('uid', 1, '>');

    return $query;
  }
}
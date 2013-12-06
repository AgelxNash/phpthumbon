<?php
$xpdo_meta_map['ThumbImages']= array (
  'package' => 'phpthumbon',
  'version' => '1.1.0',
  'table' => 'thumb_images',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'image' => NULL,
    'cache_image' => NULL,
    'config' => NULL,
    'isend' => 0,
  ),
  'fieldMeta' => 
  array (
    'image' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'index' => 'index',
    ),
    'cache_image' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
    ),
    'config' => 
    array (
      'dbtype' => 'mediumtext',
      'phptype' => 'json',
      'null' => true,
    ),
    'isend' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'image' => 
    array (
      'alias' => 'image',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'image' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => true,
        ),
      ),
    ),
  ),
);

<?php
/**
* phpThumbOn
* Создание превьюх картинок
*
* Copyright 2013 by Agel_Nash <Agel_Nash@xaker.ru>
*
* @category images
* @license GNU General Public License (GPL), http://www.gnu.org/copyleft/gpl.html
* @author Agel_Nash <Agel_Nash@xaker.ru>
*
*/
/**
 * @package phpThumbOn
 * @subpackage build
 */

$snippet= $modx->newObject('modSnippet');
$snippet->fromArray(array(
    'id' => 0,
    'name' => PKG_NAME_LOWER,
    'description' => 'Создание превьюх картинок',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.phpthumbon.php'),
));
$snippet->setProperties(array(
    array(
        'name' => 'input',
        'value' => '',
        'type' => 'textfield',
        'desc' => 'phpthumbon.input',
        'lexicon' => 'phpthumbon:properties'
    ),array(
        'name' => 'options',
        'value' => '',
        'type' => 'textfield',
        'desc' => 'phpthumbon.folder',
        'lexicon' => 'phpthumbon:properties'
    ))
);
return $snippet;
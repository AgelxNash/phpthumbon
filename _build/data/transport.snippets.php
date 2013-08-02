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
* @date 02.08.2013
* @version 1.0.0
*
*/
/**
 * @package phpThumbOn
 * @subpackage build
 */
$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => PKG_NAME_LOWER,
    'description' => 'Создание превьюх картинок',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.phpthumbon.php'),
));
$snippets[0]->setProperties(array(
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
return $snippets;
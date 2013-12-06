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
 * @date 25.08.2013
 * @version 1.0.1
 */
/**
 * Russian Lexicon for phpThumbOn
 *
 * @package phpThumbOn
 *
 * @subpackage lexicon
 * @language ru
 */

$_lang['setting_phpthumbon.cache_dir'] = 'Имя папки кеша';
$_lang['setting_phpthumbon.cache_dir_desc'] = 'Имя папки с кешем относительно папки assets.';

$_lang['setting_phpthumbon.images_dir'] = 'Имя папки с картинками';
$_lang['setting_phpthumbon.images_dir_desc'] = 'Имя папки относительно директории assets, имя которой будет удаляться из пути в кеш-директории';

$_lang['setting_phpthumbon.quality'] = 'Качество картинки по умолчанию';
$_lang['setting_phpthumbon.quality_desc'] = 'Если не задано качество картинки в параметрах при вызове сниппета, то будет использоваться это значение';

$_lang['setting_phpthumbon.ext'] = 'Тип картинки по умолчанию';
$_lang['setting_phpthumbon.ext_desc'] = 'Если на сжатие приходит картинка в неизвестном формате, то будет использоваться этот тип';

$_lang['setting_phpthumbon.noimage'] = 'Путь к картинки с изображением "картинка не существует"';
$_lang['setting_phpthumbon.noimage_desc'] = 'Если картинка указанная в input окажется не доступной или вообще этот параметр пуст, то на обработку поступит картинка указанная в этом параметре';

$_lang['setting_phpthumbon.core_path'] = 'Путь к ядру компонента phpThumbOn';
$_lang['setting_phpthumbon.core_path_desc'] = 'По умолчанию это /core/components/phpthumbon/';

$_lang['setting_phpthumbon.queue'] = 'Очередь';
$_lang['setting_phpthumbon.queue_desc'] = 'По умолчанию возможны 3 варианта: 0 - не использовать, 1 - используем очередь и не сжимаем noimage, 2 - используем очередь и сжимаем noimage под нужный размер';

$_lang['setting_phpthumbon.queue_classpath'] = 'Класс QueueThumb';
$_lang['setting_phpthumbon.queue_classpath_desc'] = 'Путь к файлу с классом QueueThumb';

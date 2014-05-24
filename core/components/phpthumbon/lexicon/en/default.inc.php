<?php
/**
 * phpThumbOn
 * Creates thumbnail images
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
 * English Lexicon for phpThumbOn
 *
 * @package phpThumbOn
 *
 * @subpackage lexicon
 * @language en
 */

$_lang['setting_phpthumbon.cache_dir'] = 'Cache directory';
$_lang['setting_phpthumbon.cache_dir_desc'] = 'Path to the cache directory (relative to the "assets" directory)';

$_lang['setting_phpthumbon.images_dir'] = 'Images directory';
$_lang['setting_phpthumbon.images_dir_desc'] = 'Name of the directory that contains the original images (relative to the "assets" directory); it will be removed from the path to the cache directory.';

$_lang['setting_phpthumbon.quality'] = 'Default image quality';
$_lang['setting_phpthumbon.quality_desc'] = 'If you don\'t use the image quality parameters when calling the snippet, the values in this field will be used';

$_lang['setting_phpthumbon.ext'] = 'Default image type (file extension)';
$_lang['setting_phpthumbon.ext_desc'] = 'This image format will be used when the image format is unknown or not explicitly specified.';

$_lang['setting_phpthumbon.noimage'] = 'Path to the "no image available" image';
$_lang['setting_phpthumbon.noimage_desc'] = 'When an image is missing and the noimage parameter is empty, the image specified here will be displayed.';

$_lang['setting_phpthumbon.core_path'] = 'Path to the phpThumbOn component';
$_lang['setting_phpthumbon.core_path_desc'] = 'The default path is /core/components/phpthumbon/';

$_lang['setting_phpthumbon.queue'] = 'Queue';
$_lang['setting_phpthumbon.queue_desc'] = 'There are 3 options: 0 - Don\'t use queue (default); 1 - Use queue, don\'t process "noimage" image; 2 - Use queue and force "noimage" image dimensions to the desired size';

$_lang['setting_phpthumbon.queue_classpath'] = 'QueueThumb class';
$_lang['setting_phpthumbon.queue_classpath_desc'] = 'Path to the file in which the class "QueueThumb" is defined';

$_lang['setting_phpthumbon.error_mode'] = 'How to handle error images';
$_lang['setting_phpthumbon.error_mode_desc'] = '1 - noimage compression with specified parameters (default); 2 - displays the original image without treatment';

$_lang['setting_phpthumbon.noimage_cache'] = 'Directory for the cached noimage images';
$_lang['setting_phpthumbon.noimage_cache_desc'] = 'Path to the directory in which the cached noimage images are stored in the desired size';

$_lang['setting_phpthumbon.total_queue'] = 'Number of simultaneously processed jobs from the queue';
$_lang['setting_phpthumbon.total_queue_desc'] = 'Not more than 10. If this field is left empty, the default is 1.';

$_lang['setting_phpthumbon.make_cachename'] = 'Snippet that generates the names for the cached images';
$_lang['setting_phpthumbon.make_cachename_desc'] = 'Snippet that can replace the default rules for generating the file names of the cached images';

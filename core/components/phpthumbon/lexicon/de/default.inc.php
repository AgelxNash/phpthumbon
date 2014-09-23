<?php
/**
 * phpThumbOn
 * Erstellt Vorschaubilder
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
 * German Lexicon for phpThumbOn
 *
 * @package phpThumbOn
 *
 * @subpackage lexicon
 * @language de
 */

$_lang['setting_phpthumbon.cache_dir'] = 'Cache-Verzeichnis';
$_lang['setting_phpthumbon.cache_dir_desc'] = 'Pfad zum Cache-Verzeichnis (relativ zum Verzeichnis "assets")';

$_lang['setting_phpthumbon.images_dir'] = 'Bilder-Verzeichnis';
$_lang['setting_phpthumbon.images_dir_desc'] = 'Name des Originalbilder-Verzeichnisses (relativ zum Verzeichnis "assets"); er wird aus dem Pfad zum Cache-Verzeichnis entfernt.';

$_lang['setting_phpthumbon.quality'] = 'Standard-Bildqualität';
$_lang['setting_phpthumbon.quality_desc'] = 'Wenn Sie die Parameter zum Festlegen der Bildqualität beim Aufruf des Snippets nicht verwenden, werden die hier eingegebenen Werte verwendet.';

$_lang['setting_phpthumbon.ext'] = 'Standard-Bildtyp (Dateinamen-Endung)';
$_lang['setting_phpthumbon.ext_desc'] = 'Dieses Bildformat wird verwendet, wenn das Bildformat unbekannt ist oder nicht explizit angegeben wird.';

$_lang['setting_phpthumbon.noimage'] = 'Pfad zu dem "Kein Bild vorhanden"-Bild (noimage)';
$_lang['setting_phpthumbon.noimage_desc'] = 'Wenn ein Bild nicht vorhanden ist und der noimage-Parameter leer ist, so wird das hier angegebene Bild angezeigt.';

$_lang['setting_phpthumbon.core_path'] = 'Pfad zur phpThumbOn-Komponente';
$_lang['setting_phpthumbon.core_path_desc'] = 'Der Standardwert ist /core/components/phpthumbon/';

$_lang['setting_phpthumbon.queue'] = 'Warteschlange';
$_lang['setting_phpthumbon.queue_desc'] = 'Es gibt 3 Optionen: 0 - Warteschlange nicht verwenden (Standard); 1 - Warteschlange verwenden, noimage-Bild nicht bearbeiten; 2 - Warteschlange verwenden und noimage-Bild auf die gewünschte Größe bringen.';

$_lang['setting_phpthumbon.queue_classpath'] = 'QueueThumb-Klasse';
$_lang['setting_phpthumbon.queue_classpath_desc'] = 'Pfad zur Datei, in der die Klasse "QueueThumb" definiert wird';

$_lang['setting_phpthumbon.error_mode'] = 'Anzeige des noimage-Bildes im Fehlerfall';
$_lang['setting_phpthumbon.error_mode_desc'] = '1 - Das noimage-Bild wird gemäß den vorgegebenen Parametern bearbeitet (Standard); 2 - Das unbearbeitete Originalbild wird angezeigt.';

$_lang['setting_phpthumbon.noimage_cache'] = 'Verzeichnis für die gecachten noimage-Dateien';
$_lang['setting_phpthumbon.noimage_cache_desc'] = 'Pfad zu dem Verzeichnis, in dem die gecachten noimage-Bilder in der gewünschten Größe gespeichert sind';

$_lang['setting_phpthumbon.total_queue'] = 'Anzahl der gleichzeitig bearbeiteten Aufträge aus der Warteschlange';
$_lang['setting_phpthumbon.total_queue_desc'] = 'Dieser Wert darf nicht größer sein als 10. Wenn hier kein Wert angegeben wird, wird der Standardwert 1 verwendet.';

$_lang['setting_phpthumbon.make_cachename'] = 'Snippet, das die Namen für die gecachten Bilder generiert';
$_lang['setting_phpthumbon.make_cachename_desc'] = 'Snippet, das die Standard-Regeln für die Generierung der Dateinamen für die gecachten Bilder ersetzen kann';

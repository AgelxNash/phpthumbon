<?php

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            /** @var xpdo $modx */
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('phpthumbon.core_path',array(),$modx->getOption('core_path').'components/phpthumbon/')."model/";
            $modx->addPackage('phpthumbon',$modelPath);

            $manager = $modx->getManager();
            $manager->createObjectContainer('ThumbImages');
            break;
    }
}

return true;
<?php
/**
 * Oggetto parallels extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Parallels module to newer versions in the future.
 * If you wish to customize the Oggetto Parallels module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @copyright  Copyright (C) 2011 Oggetto Web (http://oggettoweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Processes config
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Model
 * @author     Dan Kocherga <dan@oggettoweb.com>
 */
class Oggetto_Parallels_Model_Config
{
    /**
     *  Processes path in xml configs
     */
    const XML_PATH_PROCESSES = 'global/parallels/process';

    /**
     * Register process in the registry
     * 
     * @param string $processCode 
     * @param Oggetto_Parallels_Model_Registry $registry 
     * @return Oggetto_Parallels_Model_Config
     */
    public function registerProcess($processCode, Oggetto_Parallels_Model_Registry $registry)
    {
        $config = Mage::getConfig()->getNode(self::XML_PATH_PROCESSES);
        $method = (string) $config->$processCode->method;
        $model = Mage::getModel((string) $config->$processCode->model);
        
        $registry->add($processCode, $model, $method);
        return $this;
    }
}

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
 * Parallel process runner
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Model
 * @author     Dan Kocherga <dan@oggettoweb.com>
 */
class Oggetto_Parallels_Model_Runner
{
    /**
     * Run the process
     *
     * @param string $process   Process
     * @param array  $arguments Arguments
     * @return void
     */
    public function run($process, $arguments = [])
    {
        $arguments = $this->_serializeObjects($arguments);

        Mage::getModel('parallels/driver')->factory(
            Mage::helper('parallels')->getDriverCode()
        )
            ->run($process, $arguments);
    }

    /**
     * Serialize objects in arguments
     *
     * @param array $arguments Arguments
     * @return array
     */
    private function _serializeObjects(array $arguments)
    {
        return array_map(function ($arg) {
            return is_object($arg) ? base64_encode(serialize($arg)) : $arg;
        }, $arguments);
    }
}

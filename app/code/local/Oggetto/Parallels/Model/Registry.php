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
 * Events registry model
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Model
 * @author     Dan Kocherga <dan@oggettoweb.com>
 */
class Oggetto_Parallels_Model_Registry
{
    /**
     * Registered processes
     * 
     * @var array
     */
    protected $_processes = [];

    /**
     * Add process to the registry
     * 
     * @param string                                    $processCode Process code
     * @param Oggetto_Parallels_Model_Process_Interface $process     Process model
     * @param string                                    $method      Method
     * @return Oggetto_Parallels_Model_Registry
     */
    public function add($processCode, $process, $method)
    {
        $this->_processes[$processCode]['model']  = $process;
        $this->_processes[$processCode]['method'] = $method;
        return $this;
    }

    /**
     * Call registered process by code
     * 
     * @param string $processCode Process code
     * @param array  $params      Parameters
     * @return Oggetto_Parallels_Model_Registry
     */
    public function call($processCode, $params = [])
    {
        $params = $this->_unserializeParams($params);

        call_user_func_array(
            [
                $this->_processes[$processCode]['model'], 
                $this->_processes[$processCode]['method']
            ], $params
        );
        return $this;
    }

    /**
     * Unserialize params
     *
     * @param array $params Parameters
     * @return array
     */
    private function _unserializeParams(array $params)
    {
        return array_map(function ($param) {
            if ($encoded = base64_decode($param, true)) {
                return unserialize($encoded);
            }
            return $param;
        }, $params);
    }
}

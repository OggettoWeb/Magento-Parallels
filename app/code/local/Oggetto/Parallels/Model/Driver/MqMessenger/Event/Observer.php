<?php
/**
 * Oggetto Web Parallels extension for Magento
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
 * @copyright  Copyright (C) 2014
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Parallels MQ messenger driver event observer
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Model
 * @author     Eduard Paliy <epaliy@oggettoweb.com>
 */
class Oggetto_Parallels_Model_Driver_MqMessenger_Event_Observer
    implements
    Oggetto_Messenger_Model_Event_Observer_Interface,
    Oggetto_Messenger_Model_Log_Loggable
{
    private $_logger;

    /**
     * Check if event could be observed by this class
     *
     * @param Oggetto_Messenger_Model_Event $event Event
     * @return boolean
     */
    public function match(Oggetto_Messenger_Model_Event $event)
    {
        return $event->getName() == 'parallels_task_executed';
    }

    /**
     * Observe event
     *
     * @param Oggetto_Messenger_Model_Event $event Event
     * @return void
     */
    public function observe(Oggetto_Messenger_Model_Event $event)
    {
        $this->_logger->info('A parallel task received.');

        $process = $event->getData()['process'];
        $arguments = $event->getData()['arguments'];

        $registry = Mage::getModel('parallels/registry');
        Mage::getModel('parallels/config')->registerProcess($process, $registry);
        $registry->call($process, $arguments);
    }

    /**
     * Set logger
     *
     * @param Zend_Log $logger Logger
     * @return mixed
     */
    public function setLogger(Zend_Log $logger)
    {
        $this->_logger = $logger;
    }
}

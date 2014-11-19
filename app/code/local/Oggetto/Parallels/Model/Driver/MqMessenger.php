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
 * MQ messenger parallels driver
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Model
 * @author     Eduard Paliy <epaliy@oggettoweb.com>
 */
class Oggetto_Parallels_Model_Driver_MqMessenger
    implements Oggetto_Parallels_Model_Driver_Interface
{
    /**
     * Run the process
     *
     * @param string $process   The process name
     * @param array  $arguments Arguments
     * @return void
     */
    public function run($process, array $arguments = [])
    {
        $event = Mage::getModel('messenger/event')
            ->setName('parallels_task_executed')
            ->setData([
                'process'   => $process,
                'arguments' => $arguments
            ]);

        $this->_dispatch($event);
    }

    /**
     * Dispatch event
     *
     * @param Oggetto_Messenger_Model_Event $event Event
     * @return void
     */
    private function _dispatch(Oggetto_Messenger_Model_Event $event)
    {
        $this->_di()->newInstance('messenger/event_dispatcher')
            ->dispatch($event);
    }

    /**
     * Get DI instance
     *
     * @return Oggetto_Messenger_Model_Di
     */
    private function _di()
    {
        return Mage::getSingleton('messenger/di');
    }
}

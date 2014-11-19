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
 * MQ messenger driver test
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Test
 * @author     Eduard Paliy <epaliy@oggettoweb.com>
 */
class Oggetto_Parallels_Test_Model_Driver_MqMessenger extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test implements driver interface
     *
     * @return void
     */
    public function testImplementsDriverInterface()
    {
        $this->assertInstanceOf(
            'Oggetto_Parallels_Model_Driver_Interface',
            Mage::getModel('parallels/driver_mqMessenger')
        );
    }

    /**
     * Test parallel process calling from the application
     *
     * @return void
     */
    public function testParallelProcessRunning()
    {
        $name = 'parallels_task_executed';
        $data = [
            'process'   => 'foo',
            'arguments' => [
                1, 2, 42
            ]
        ];

        $event = $this->_getMessengerEventMock($name, $data);

        $this->replaceByMock('model', 'messenger/event', $event);

        $dispatcher = $this->getModelMock('messenger/event_dispatcher', ['dispatch']);

        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo($event));

        $this->replaceByMock('model', 'messenger/event_dispatcher', $dispatcher);

        $di = $this->getModelMock('messenger/di', ['newInstance']);

        $di->expects($this->once())
            ->method('newInstance')
            ->with($this->equalTo('messenger/event_dispatcher'))
            ->will($this->returnValue($dispatcher));

        $this->replaceByMock('singleton', 'messenger/di', $di);

        Mage::getModel('parallels/driver_mqMessenger')->run('foo', [1, 2, 42]);
    }

    /**
     * Get messenger event mock
     *
     * @param string $name Name
     * @param array  $data Data
     * @return EcomDev_PHPUnit_Mock_Proxy
     */
    protected function _getMessengerEventMock($name, $data)
    {
        $event = $this->getModelMock('messenger/event', ['setName', 'setData']);

        $event->expects($this->once())
            ->method('setName')
            ->with($this->equalTo($name))
            ->will($this->returnSelf());

        $event->expects($this->once())
            ->method('setData')
            ->with($this->equalTo($data))
            ->will($this->returnSelf());

        return $event;
    }
}

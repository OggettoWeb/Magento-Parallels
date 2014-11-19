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
 * MQ messenger event observer test
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Test
 * @author     Eduard Paliy <epaliy@oggettoweb.com>
 */
class Oggetto_Parallels_Test_Model_Driver_MqMessenger_Event_Observer
    extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test matches event
     *
     * @param string $name Event name
     * @dataProvider dataProvider
     * @loadExpectation
     * @return void
     */
    public function testMatchesEvent($name)
    {
        $event = Mage::getModel('messenger/event');
        $event->setName($name);

        $this->assertEquals(
            $this->expected($name)->getMatch(),
            Mage::getModel('parallels/driver_mqMessenger_event_observer')->match($event)
        );
    }

    /**
     * Test observes event
     *
     * @return void
     */
    public function testObservesEvent()
    {
        $name = 'foo';
        $data = [
            'process'   => 'bar',
            'arguments' => [1, 2, 42]
        ];

        $event = Mage::getModel('messenger/event');
        $event->setName($name);
        $event->setData($data);

        $registry = $this->getModelMock('parallels/registry', ['call']);

        $registry->expects($this->once())
            ->method('call')
            ->with(
                $this->equalTo('bar'),
                $this->equalTo([1, 2, 42])
            );

        $this->replaceByMock('model', 'parallels/registry', $registry);

        $config = $this->getModelMock('parallels/config', ['registerProcess']);

        $config->expects($this->once())
            ->method('registerProcess')
            ->with(
                $this->equalTo('bar'),
                $this->equalTo($registry)
            );

        $this->replaceByMock('model', 'parallels/config', $config);

        $observer = Mage::getModel('parallels/driver_mqMessenger_event_observer');
        $observer->setLogger(new Zend_Log(new Zend_Log_Writer_Mock()));
        $observer->observe($event);
    }

}

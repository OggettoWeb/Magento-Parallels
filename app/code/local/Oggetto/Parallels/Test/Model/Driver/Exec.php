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
 * Exec driver test
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Test
 * @author     Eduard Paliy <epaliy@oggettoweb.com>
 */
class Oggetto_Parallels_Test_Model_Driver_Exec extends EcomDev_PHPUnit_Test_Case
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
            Mage::getModel('parallels/driver_exec')
        );
    }

    /**
     * Test parallel process calling from the application
     *
     * @return void
     */
    public function testParallelProcessRunning()
    {
        $driver = $this->getModelMock('parallels/driver_exec', ['exec']);
        $driver->expects($this->once())
            ->method('exec')
            ->with($this->stringEndsWith(".parallels/run.sh test_process 'arg one' 'arg two' 'thr'\''ee'"));
        $driver->run('test_process', ['arg one', 'arg two', "thr'ee"]);
    }

    /**
     * Test command is executed in the background without PHP waiting for it to finish
     *
     * @return void
     */
    public function testRunsWithoutWaitingForFinish()
    {
        $startTime = time();

        Mage::getModel('parallels/driver_exec')->exec('sleep 10');

        $resultTime = time() - $startTime;
        $this->assertLessThan(2, $resultTime);
    }
}

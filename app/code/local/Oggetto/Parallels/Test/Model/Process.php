<?php
/**
 * Oggetto parallels extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Parallels module to newer versions in the future.
 * If you wish to customize the Oggetto Parallels module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @copyright  Copyright (C) 2011 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Parallels process test case
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @copyright  Copyright (C) 2011
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Oggetto_Parallels_Test_Model_Process extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test parallel process calling from the application
     *
     * @test
     */
    public function testParallelProcessRunniung()
    {
        $runner = $this->getModelMock('parallels/runner', array('exec'));
        $runner->expects($this->once())
            ->method('exec')
            ->with($this->stringEndsWith(".parallels/run.sh test_process 'arg one' 'arg two' 'thr'\''ee'"));
        $runner->run('test_process', array('arg one', 'arg two', "thr'ee"));
    }

    /**
     * Test process execution from registry
     *
     * @test
     */
    public function testExecutionFromRegistry()
    {
        $process = $this->getMock('Oggetto_Parallels_Model_Process_Interface', array('execute'));
        $process->expects($this->once())
                ->method('execute')
                ->with(
                    $this->equalTo('First Arg'),
                    $this->equalTo('Second Arg')
                );

        $registry = Mage::getModel('parallels/registry');
        $registry->add('test_process', $process, 'execute');
        $registry->call('test_process', array('First Arg', 'Second Arg'));
    }

    /**
     * Test process finding from config
     *
     * @test
     * @loadFixture
     */
    public function testFinding()
    {
        $process = $this->getMock('Oggetto_Parallels_Model_Process_Interface', array('execute'));
        $this->replaceByMock('model', 'parallels/process', $process);

        $config = Mage::getModel('parallels/config');
        $registry = $this->getModelMock('parallels/registry');
        $registry->expects($this->once())
                 ->method('add')
                 ->with(
                     $this->equalTo('test_process'),
                     $this->equalTo($process),
                     $this->equalTo('execute')
                 );

        $config->registerProcess('test_process', $registry);
    }
}

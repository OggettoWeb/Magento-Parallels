<?php
/**
 * eCommeleon Ltd ecommerce software
 *
 * NOTICE OF LICENSE
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Proprietary and confidential.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @copyright  Copyright (c) 2014 eCommeleon Ltd (http://ecommeleon.com/)
 */

/**
 * Runner test
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @author     Valentin Sushkov <me@vsushkov.com>
 */
class Oggetto_Parallels_Test_Model_Runner extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Test runs specified driver
     *
     * @param string $process    Process name
     * @param array  $args       Arguments
     * @param string $driverCode Driver code
     * @dataProvider dataProvider
     * @return void
     */
    public function testRunsSpecifiedDriver($process, $args, $driverCode)
    {
        $helper = $this->getHelperMock('parallels/data', ['getDriverCode']);

        $helper->expects($this->once())
            ->method('getDriverCode')
            ->will($this->returnValue($driverCode));

        $this->replaceByMock('helper', 'parallels', $helper);


        $driver = $this->getMock('Oggetto_Parallels_Model_Driver_Interface', ['run']);

        $driver->expects($this->once())
            ->method('run')
            ->with(
                $this->equalTo($process),
                $this->equalTo($args)
            );

        $factory = $this->getModelMock('parallels/driver', ['factory']);

        $factory->expects($this->once())
            ->method('factory')
            ->with($this->equalTo($driverCode))
            ->will($this->returnValue($driver));

        $this->replaceBymock('model', 'parallels/driver', $factory);

        Mage::getModel('parallels/runner')->run($process, $args);
    }
}

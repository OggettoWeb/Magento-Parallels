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
     * Test command is executed in the background without PHP waiting for it to finish
     *
     * @return void
     */
    public function testRunsWithoutWaitingForFinish()
    {
        $startTime = time();

        Mage::getModel('parallels/runner')->exec('sleep 10');

        $resultTime = time() - $startTime;
        $this->assertLessThan(2, $resultTime);
    }
}

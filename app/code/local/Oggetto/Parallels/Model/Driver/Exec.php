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
 * Exec parallels driver
 *
 * @category   Oggetto
 * @package    Oggetto_Parallels
 * @subpackage Model
 * @author     Eduard Paliy <epaliy@oggettoweb.com>
 */
class Oggetto_Parallels_Model_Driver_Exec
    implements Oggetto_Parallels_Model_Driver_Interface
{
    /**
     * Execution files dir
     */
    const EXEC_DIR_PATH = '.parallels';

    /**
     * Execution file name
     */
    const SH_FILENAME = 'run.sh';

    /**
     * Run the process
     *
     * @param string $process   The process name
     * @param array  $arguments Arguments
     * @return void
     */
    public function run($process, array $arguments = [])
    {
        $arguments = array_map('escapeshellarg', $arguments);
        $arguments = implode(' ', $arguments);
        $execFile = Mage::getBaseDir() . DS . self::EXEC_DIR_PATH . DS . self::SH_FILENAME;
        $this->exec("{$execFile} {$process} {$arguments}");
    }

    /**
     * Execute the command
     *
     * @param string $command Command
     * @return void
     */
    public function exec($command)
    {
        if (strpos(strtolower(php_uname()), 'windows') !== false) {
            pclose(popen("start /B ". $command, "r"));
        } else {
            exec($command . " > /dev/null &");
        }
    }
}

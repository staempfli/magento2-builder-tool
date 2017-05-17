<?php

/**
 * setAvailableServers.php
 *
 * @category  development-tool
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

require_once "phing/Task.php";
require_once dirname(dirname(__FILE__)) . '/lib/SpycLib.php';

class setAvailableServers extends Task
{
    /**
     * Get Config from Yaml and set config for corresponding environment
     */
    public function main()
    {
        $configFilename = $this->getProject()->getProperty('servers.config.filename');

        if (file_exists($configFilename)) {
            $serversConfig = SpycLib::YAMLLoad($configFilename);
            if (count($serversConfig) > 0) {
                $availableServers = implode(',', array_keys($serversConfig));
                $this->getProject()->setProperty('servers.available', strtolower($availableServers));
            }
        }
    }
}
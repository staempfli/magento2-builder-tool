<?php

/**
 * SetServerProperties.php
 *
 * @category  development-tool
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

require_once "phing/Task.php";
require_once dirname(dirname(__FILE__)) . '/lib/SpycLib.php';

class SetServerProperties extends Task
{
    /**
     * Get Config from Yaml and set config for corresponding environment
     */
    public function main()
    {
        $configFilename = $this->getProject()->getProperty('servers.config.filename');
        $remoteEnvironment = strtoupper($this->getProject()->getProperty('remote.environment'));

        if (!$remoteEnvironment) {
            throw new BuildException("Remote Environment is not defined");
        }

        $serversConfig = SpycLib::YAMLLoad($configFilename);
        if (!isset($serversConfig[$remoteEnvironment])) {
            throw new BuildException(sprintf('Not ssh configuration defined for server: %s', $remoteEnvironment));
        }

        $config = $serversConfig[$remoteEnvironment];
        foreach ($config as $param => $value) {
            $this->getProject()->setNewProperty('server.ssh.' . $param, $value);
        }
    }
}
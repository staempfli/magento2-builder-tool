<?php

/**
 * EnsureConfiguration.php
 *
 * @category  development-tool
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

require_once "phing/Task.php";
require_once dirname(dirname(__FILE__)) . '/lib/SpycLib.php';

class EnsureConfiguration extends Task
{
    /**
     * Get Config from Yaml and set config for corresponding environment
     */
    public function main()
    {
        $configFilename = $this->getProject()->getProperty('magento.config.filename');
        $environment = strtoupper($this->getProject()->getProperty('project.environment'));

        if (!$environment) {
            throw new BuildException("Environment is not defined");
        }

        $allConfig = SpycLib::YAMLLoad($configFilename);
        if (!isset($allConfig[$environment])) {
            throw new BuildException(sprintf('No core config data defined for environment: %s', $environment));
        }

        $config = $allConfig[$environment];
        $this->_setConfigValues($config);
    }

    /**
     * Set Core Config Values
     * - Format array: array(path => array(scope => array(scope_id => value)))
     *
     * @param array $config
     * @throws BuildException
     */
    private function _setConfigValues(array $config)
    {
        $magerunBin = $this->getProject()->getProperty('bin.n98-magerun2');
        foreach ($config as $path => $pathData) {
            foreach ($pathData as $scope => $scopeData) {
                foreach ($scopeData as $scopeId => $value) {
                    $value = $this->getProject()->replaceProperties($value);
                    $command = sprintf('%s config:set --scope="%s" --scope-id="%s" %s %s',
                        $magerunBin, $scope, $scopeId, $path, $value);
                    exec($command, $output, $return);
                    if ($return) {
                        $message = sprintf('Error executing command: %s', $command);
                        $this->log($message, Project::MSG_ERR);
                        throw new BuildException("Error executing command: %s", $command);
                    }
                    $message = sprintf('Setting magento config scope="%s" scope-id=%s path=%s value=%s',
                        $scope, $scopeId, $path, $value);
                    $this->log($message, Project::MSG_INFO);
                }
            }
        }
    }
    
}
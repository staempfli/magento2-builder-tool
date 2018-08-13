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
    private $magentoConfigSetCommandAvailable;

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
        $this->setConfigValues($config);
    }

    /**
     * Set Core Config Values
     * - Format array: array(path => array(scope => array(scope_id => value)))
     *
     * @param array $config
     * @throws BuildException
     */
    private function setConfigValues(array $config)
    {
        foreach ($config as $path => $pathData) {
            foreach ($pathData as $scope => $scopeData) {
                if ('default' == $scope) {
                    $this->executeConfigSetCommand($path, $scopeData);
                    continue;
                }
                foreach ($scopeData as $scopeCode => $value) {
                    $this->executeConfigSetCommand($path, $value, $scope, $scopeCode);
                }
            }
        }
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    private function executeConfigSetCommand($path, $value, $scope = false, $scopeCode = false)
    {
        $value = $this->getProject()->replaceProperties($value);
        $command = $this->getConfigSetCommand($path, $value);
        if ($scope && $scopeCode) {
            $command = $command . " " . $this->getConfigSetScopeParams($scope, $scopeCode);
        }
        $this->log($command, Project::MSG_INFO);
        exec($command, $output, $return);
        if ($return) {
            $message = sprintf('Error executing command: %s', $command);
            $this->log($message, Project::MSG_ERR);
            throw new BuildException($message);
        }
    }

    private function getConfigSetCommand($path, $value)
    {
        if ($this->isMagentoConfigSetAvailable()) {
            $magentoBin = $this->getProject()->getProperty('bin.magento');
            return "{$magentoBin} config:set --lock {$path} {$value}";
        }
        $magerunBin = $this->getProject()->getProperty('bin.n98-magerun2');
        return "{$magerunBin} config:set {$path} {$value}";
    }

    private function getConfigSetScopeParams($scope, $scopeCode)
    {
        if ($this->isMagentoConfigSetAvailable()) {
            return "--scope={$scope} --scope-code={$scopeCode}";
        }
        return "--scope={$scope} --scope-id={$scopeCode}";
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    private function isMagentoConfigSetAvailable(): bool
    {
        if (null === $this->magentoConfigSetCommandAvailable) {
            $magentoBin = $this->getProject()->getProperty('bin.magento');
            exec("{$magentoBin} config:set --help 2> /dev/null", $output, $return);
            $this->magentoConfigSetCommandAvailable = ($return) ? false : true;
        }
        return $this->magentoConfigSetCommandAvailable;
    }
}

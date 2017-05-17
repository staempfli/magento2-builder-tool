<?php

require_once "phing/Task.php";

class CustomHookTask extends Task
{
    /**
     * name of the current target where custom tasks can hook into
     *
     * @var string
     */
    protected $_hook = null;

    /**
     * @param string $hook
     */
    public function setHook($hook)
    {
        $this->_hook = $hook;
    }

    /**
     * Main
     */
    public function main()
    {
        $callbacks = explode(',', $this->getProject()->getProperty($this->_hook));

        foreach ($callbacks as $callback) {
            if ($callback) {
                try {
                    $message = sprintf('Executing target %s from %s', $callback, $this->_hook);
                    $this->log($message);
                    $this->getProject()->executeTarget($callback);
                } catch (BuildException $ex) {
                    $message = sprintf(
                        'Failed to execute target %s as called in %s. Reason: %s', $callback, $this->_hook,
                        $ex->getMessage()
                    );
                    $this->log($message, Project::MSG_ERR);
                }
            }
        }
    }
} 
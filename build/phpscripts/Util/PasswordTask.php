<?php

/**
 * PasswordTask.php
 *
 * @category  development-tool
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

require_once "phing/Task.php";

class PasswordTask extends Task
{
    protected $_outputPropertyName = null;

    protected $_passwordLength = null;

    /**
     * @param int $passwordLength
     */
    public function setPasswordLength($passwordLength)
    {
        $this->_passwordLength = $passwordLength;
    }

    /**
     * @param string $outputPropertyName
     */
    public function setOutputPropertyName($outputPropertyName)
    {
        $this->_outputPropertyName = $outputPropertyName;
    }

    public function init()
    {
        if (!$this->_passwordLength) {
            $this->_passwordLength = 12;
        }
    }

    public function main()
    {
        $this->getProject()->setProperty(
            $this->_outputPropertyName,
            $this->_generateRandomPassword($this->_passwordLength));
    }

    /**
     * generates a random password to be used as database password etc.
     *
     * @param int desired length of password (default 16)
     *
     * @return string
     */
    protected function _generateRandomPassword($length = 0)
    {
        $validChars     = '0123456789abcdefghijklmnopqrstuvwABCDEFGHIJKLMNOPQRSTUVW';
        $i              = 0;
        $password       = '';

        while ($i < $length) {
            $num = mt_rand() % strlen($validChars);
            $password .= substr($validChars, $num, 1);
            $i++;
        }

        return $password;
    }
}
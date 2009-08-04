<?php
/**
* sfExtraValidatorCaptcha check if the value of the captcha is correct
*
* @author   David Zeller <zellerda01@gmail.com>
*/
class sfExtraValidatorCaptcha extends sfValidatorBase
{
    protected function configure($options = array(), $messages = array())
    {
        $this->addMessage('captcha', 'Wrong code');
        $this->setOption('empty_value', '');
    }
    
    protected function doClean($value)
    {
        $clean = trim($value);

        if (sfContext::getInstance()->getUser()->getAttribute('captcha') != $value)
        {
            sfContext::getInstance()->getUser()->setAttribute('captcha', '');
            throw new sfValidatorError($this, 'captcha', array());
        }

        return $clean;
    }
}

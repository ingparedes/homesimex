<?php

namespace PHPMaker2021\simexamerica;

/**
 * reCAPTCHA class
 */
class ReCaptcha extends CaptchaBase
{
    // Input
    public $Response = "";
    public $ResponseField = "g-recaptcha-response";

    // Private key
    public $PrivateKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
    public $Size = "normal";

    // Validate
    public function validate()
    {
        global $Page;
        $sessionName = $this->getSessionName();
        if ($this->Response == @$_SESSION[$sessionName]) {
            return true;
        } else {
            $recaptcha = new \ReCaptcha\ReCaptcha($this->PrivateKey, new \ReCaptcha\RequestMethod\Post());
            $resp = $recaptcha->verify($this->Response, @$_SERVER["REMOTE_ADDR"]);
            if ($resp) {
                if ($resp->isSuccess()) {
                    $_SESSION[$sessionName] = $this->Response;
                    return true;
                } else {
                    $errors = $resp->getErrorCodes();
                    if (count($errors)) {
                        $Page->setFailureMessage($errors[0]);
                    }
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    // HTML tag
    public function getHtml()
    {
        global $Language, $Page;
        $classAttr = ($Page->OffsetColumnClass) ? ' class="' . $Page->OffsetColumnClass . '"' : "";
        return <<<EOT
<div class="form-group row ew-captcha-{$this->Size}">
    <div{$classAttr}>
        <div id="{$this->getElementId()}" class="g-recaptcha"></div>
        <input type="hidden" name="{$this->getElementId()}" class="form-control ew-recaptcha" disabled>
        <div class="invalid-feedback"></div>
    </div>
</div>
EOT;
    }

    // HTML tag for confirm page
    public function getConfirmHtml()
    {
        return '<input type="hidden" id="' . $this->getElementId() . '" name="' . $this->getElementId() . '" value="' . HtmlEncode($this->Response) . '">';
    }

    // Client side validation script
    public function getScript($formName)
    {
        return $formName . '.addField("' . $this->getElementId() . '", ew.Validators.recaptcha, false);';
    }
}

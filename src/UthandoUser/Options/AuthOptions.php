<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class AuthOptions
 *
 * @package UthandoUser\Options
 */
class AuthOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $authenticateMethod;

    /**
     * @var string
     */
    protected $credentialTreatment;

    /**
     * @var bool
     */
    protected $useFallbackTreatment;

    /**
     * @var string
     */
    protected $fallbackCredentialTreatment;

    /**
     * @return string
     */
    public function getAuthenticateMethod()
    {
        return $this->authenticateMethod;
    }

    /**
     * @param string $authenticateMethod
     * @return $this
     */
    public function setAuthenticateMethod($authenticateMethod)
    {
        $this->authenticateMethod = $authenticateMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getCredentialTreatment()
    {
        return $this->credentialTreatment;
    }

    /**
     * @param string $credentialTreatment
     * @return $this
     */
    public function setCredentialTreatment($credentialTreatment)
    {
        $this->credentialTreatment = $credentialTreatment;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isUseFallbackTreatment()
    {
        return $this->useFallbackTreatment;
    }

    /**
     * @param boolean $useFallbackTreatment
     * @return $this
     */
    public function setUseFallbackTreatment($useFallbackTreatment)
    {
        $this->useFallbackTreatment = $useFallbackTreatment;
        return $this;
    }

    /**
     * @return string
     */
    public function getFallbackCredentialTreatment()
    {
        return $this->fallbackCredentialTreatment;
    }

    /**
     * @param string $fallbackCredentialTreatment
     * @return $this
     */
    public function setFallbackCredentialTreatment($fallbackCredentialTreatment)
    {
        $this->fallbackCredentialTreatment = $fallbackCredentialTreatment;
        return $this;
    }
}

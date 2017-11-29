<?php declare(strict_types=1);
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

    public function getAuthenticateMethod(): ?string
    {
        return $this->authenticateMethod;
    }

    public function setAuthenticateMethod(string $authenticateMethod): AuthOptions
    {
        $this->authenticateMethod = $authenticateMethod;
        return $this;
    }

    public function getCredentialTreatment(): ?string
    {
        return $this->credentialTreatment;
    }

    public function setCredentialTreatment(string $credentialTreatment): AuthOptions
    {
        $this->credentialTreatment = $credentialTreatment;
        return $this;
    }

    public function isUseFallbackTreatment(): ?bool
    {
        return $this->useFallbackTreatment;
    }

    public function setUseFallbackTreatment(bool $useFallbackTreatment): AuthOptions
    {
        $this->useFallbackTreatment = $useFallbackTreatment;
        return $this;
    }

    public function getFallbackCredentialTreatment(): ?string
    {
        return $this->fallbackCredentialTreatment;
    }

    public function setFallbackCredentialTreatment(string $fallbackCredentialTreatment): AuthOptions
    {
        $this->fallbackCredentialTreatment = $fallbackCredentialTreatment;
        return $this;
    }


}

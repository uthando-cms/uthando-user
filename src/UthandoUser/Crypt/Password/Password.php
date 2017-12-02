<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Crypt\Password
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Crypt\Password;

use Zend\Crypt\Exception\InvalidArgumentException;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Password
 *
 * @package UthandoUser\Crypt\Password
 */
class Password implements PasswordInterface
{
    const MIN_SALT_SIZE = 16;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var string
     */
    protected $cost;

    /**
     * @var int
     */
    protected $aglo = PASSWORD_DEFAULT;

    /**
     * @var bool
     */
    protected $rehashIfNeeded = true;

    /**
     * Constructor
     *
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct($options = [])
    {
        if (!empty($options)) {
            if ($options instanceof \Traversable) {
                $options = ArrayUtils::iteratorToArray($options);
            } elseif (!is_array($options)) {
                throw new InvalidArgumentException(
                    'The options parameter must be an array or a Traversable'
                );
            }

            if (isset($options['salt'])) {
                $this->setSalt($options['salt']);
            }

            if (isset($options['cost'])) {
                $this->setCost($options['cost']);
            }

            if (isset($options['aglo'])) {
                $this->setAglo($options['aglo']);
            }

            if (isset($options['rehash_if_needed'])) {
                $this->setAglo($options['rehash_if_needed']);
            }
        }
    }

    /**
     * Verify if a password is correct against a hash value.
     *
     * @param string $password
     * @param string $hash
     * @return bool|array
     */
    public function verify($password, $hash)
    {
        $verify = password_verify($password, $hash);

        if (true === $verify && $this->isRehashIfNeeded() && $this->needsRehash($hash)) {
            $newHash = $this->create($password);
            $verify = [
                'verify' => true,
                'hash' => $newHash,
            ];
        }

        return $verify;
    }

    public function isRehashIfNeeded(): bool
    {
        return $this->rehashIfNeeded;
    }

    public function setRehashIfNeeded(bool $rehashIfNeeded): Password
    {
        $this->rehashIfNeeded = $rehashIfNeeded;
        return $this;
    }

    public function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, $this->getAglo(), $this->getOptions());
    }


    public function getAglo(): int
    {
        return $this->aglo;
    }

    public function setAglo(int $aglo): Password
    {
        if (!is_int($aglo)) {
            throw new InvalidArgumentException(
                'The aglo must be algorithm constant denoting the algorithm to use when hashing the password
                see http://php.net/manual/en/password.constants.php'
            );
        }

        $this->aglo = $aglo;
        return $this;
    }

    public function getOptions(): array
    {
        return [
            'salt' => $this->getSalt(),
            'cost' => $this->getCost(),
        ];
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): Password
    {
        if (strlen($salt) < self::MIN_SALT_SIZE) {
            throw new InvalidArgumentException(
                'The length of the salt must be at least ' . self::MIN_SALT_SIZE . ' bytes'
            );
        }

        $this->salt = $salt;
        return $this;
    }

    public function getCost(): string
    {
        return $this->cost;
    }

    public function setCost(string $cost): Password
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @param string $password
     * @return bool|string
     */
    public function create($password)
    {
        return password_hash($password, $this->getAglo(), $this->getOptions());
    }

    public function getInfo(string $hash): array
    {
        return password_get_info($hash);
    }
}
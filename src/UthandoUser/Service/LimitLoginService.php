<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 04/12/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoUser\Service;

use UthandoCommon\Service\AbstractMapperService;
use UthandoUser\Hydrator\LimitLoginHydrator;
use UthandoUser\Mapper\LimitLoginMapper;
use UthandoUser\Model\LimitLoginModel;
use UthandoUser\Option\LoginOptions;
use Zend\Http\PhpEnvironment\RemoteAddress;

class LimitLoginService extends AbstractMapperService
{
    protected $hydrator = LimitLoginHydrator::class;
    protected $mapper   = LimitLoginMapper::class;
    protected $model    = LimitLoginModel::class;

    public function getByIp(): LimitLoginModel
    {
        $ip         = $this->getIpAddress();
        /** @var LimitLoginMapper $mapper */
        $mapper     = $this->getMapper();
        $model      = $mapper->getLoginByIp($ip);
        $options    = $this->getOptions();

        if (!$model->getId()) {

            $model->setIp($ip)
                ->setAttempts(0)
                ->setAttemptTime(strtotime('now'))
                ->setLockedTime($options->getBanTime());
        } else {
            $diff = $this->getTimeDiff($model);

            if ($diff > 0) {
                $this->delete($model->getId());
                $model->setId(null)
                    ->setAttempts(0)
                    ->setAttemptTime(strtotime('now'));
            }
        }

        return $model;
    }

    public function checkBanIp(LimitLoginModel $model): bool
    {
        $options = $this->getOptions();

        if ($model->getAttempts() >= $options->getMaxLoginAttempts()) {
            return true;
        }

        return false;
    }

    public function getTimeDiff(LimitLoginModel $model): int
    {
        $now        = strtotime('now');
        $lockedTime = $model->getAttemptTime() + $model->getLockedTime();
        $diff       = $now - $lockedTime;

        return $diff;
    }

    public function normalizeTime(int $time): string
    {
        $time = abs($time);

        if($time < 60) {
            $timeString = sprintf('%d seconds', $time);
        } elseif ($time < 60*60) {
            $timeString = sprintf('%d mintues', ceil($time / 60));
        } elseif ($time < 60*60*24) {
            $timeString = sprintf('%d hours', ceil($time / 60*60));
        } else {
            $timeString = sprintf('%d days', ceil($time / 60*60*24));
        }

        return $timeString;
    }

    public function getOptions(): LoginOptions
    {
        /** @var LoginOptions $options */
        $options = $this->getService(LoginOptions::class);
        return $options;
    }

    public function getIpAddress(): string
    {
        $remoteAddress = new RemoteAddress();
        $remoteAddress->setUseProxy(true);
        return $remoteAddress->getIpAddress();
    }
}

<?php

/*
 * This file is part of the Dubas Dark Theme for EspoCRM.
 *
 * (c) DUBAS S.C.
 * Website: https://dubas.pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class AfterUninstall
{
    protected $container;

    public function run($container)
    {
        $this->container = $container;
    }

    protected function clearCache()
    {
        try {
            $this->container->get('dataManager')->clearCache();
        } catch (\Exception $e) {
        }
    }
}

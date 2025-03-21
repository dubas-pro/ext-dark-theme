<?php

use Espo\Core\Container;
use Espo\Core\DataManager;
use Exception;

class BeforeInstall
{
    private Container $container;

    public function run(Container $container): void
    {
        $this->container = $container;
    }

    protected function clearCache(): void
    {
        try {
            $this->container->getByClass(DataManager::class)->clearCache();
        } catch (Exception $e) {
        }
    }
}

<?php

namespace Feierstoff\CommandBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Routing\Loader\PhpFileLoader;

class CommandExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container) {
        $loader = new \Symfony\Component\DependencyInjection\Loader\PhpFileLoader($container, new FileLocator(__DIR__."/../Resources/config"));

    }

}
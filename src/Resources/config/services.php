<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Feierstoff\CommandBundle\Util\Cmd;

return function(ContainerConfigurator $container) {
    $container->services()
        ->set(Cmd::class)
            ->arg("\$projectDir", "%kernel.project_dir%")
            ->arg("\$env", "%kernel.environment%")
            ->arg("\$em", service("doctrine.orm.default_entity_manager"))
    ;
};
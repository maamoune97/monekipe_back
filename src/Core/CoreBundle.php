<?php

namespace App\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CoreBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        //dd($container);
        parent::build($container);
    }

}
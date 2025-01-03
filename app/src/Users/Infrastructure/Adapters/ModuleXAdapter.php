<?php

namespace App\Users\Infrastructure\Adapters;

use App\ModuleX\Infrastructure\API\Api;

class ModuleXAdapter
{
    public function __construct(private readonly Api $moduleXApi)
    {
    }

    public function getSomeData(): array{
        $this->moduleXApi->getSomeData();
        //mapping

        return [];
    }
}
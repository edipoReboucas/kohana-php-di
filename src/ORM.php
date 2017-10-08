<?php

namespace EdipoReboucas\KohanaPhpDi;

class ORM extends \ORM
{
    public static function factory($model, $id = NULL)
    {
        $container = ContainerSimpleFactory::getInstance();

        $model = parent::factory($model, $id);

        $container->injectOn($model);

        return $container;
    }
}
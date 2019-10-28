<?php
declare(strict_types=1);

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(include "settings.php");
$builder->addDefinitions(include "services.php");
$builder->addDefinitions(include "controllers.php");

return $builder->build();
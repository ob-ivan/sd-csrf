<?php
namespace tests;

use SD\Csrf\DependencyInjection\CsrfAwareTrait;
use SD\DependencyInjection\AutoDeclarerInterface;
use SD\DependencyInjection\AutoDeclarerTrait;

class ParentConsumer implements AutoDeclarerInterface {
    use AutoDeclarerTrait;
    use CsrfAwareTrait;
}

<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use SD\Csrf\DependencyInjection\CsrfProvider;
use SD\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class AwareTraitTest extends TestCase {
    public function testInheritAutoDeclare() {
        $container = new Container();
        $provider = new CsrfProvider();
        $provider->setSession(new Session(new MockArraySessionStorage()));
        $container->connect($provider);
        $expectedService = $container->get($provider->getServiceName());
        $subclassConsumer = $container->produce(SubclassConsumer::class);
        $actualService = $subclassConsumer->getService();
        $this->assertSame($expectedService, $actualService, 'Subclass must inherit auto declare trait');
    }
}

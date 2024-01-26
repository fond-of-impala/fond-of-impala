<?php

namespace FondOfImpala\Glue\CartValidation;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\Kernel\Container;

class CartValidationDependencyProviderTest extends Unit
{
    protected CartValidationDependencyProvider $cartValidationDependencyProvider;

    protected MockObject|Container $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartValidationDependencyProvider = new CartValidationDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->cartValidationDependencyProvider->provideDependencies($this->containerMock),
        );
    }
}

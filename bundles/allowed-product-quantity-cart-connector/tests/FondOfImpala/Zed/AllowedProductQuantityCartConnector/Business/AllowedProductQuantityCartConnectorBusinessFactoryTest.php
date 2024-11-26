<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorConfig;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorDependencyProvider;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\Validator\QuoteValidator;
use FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface;
use Spryker\Zed\Kernel\Container;

class AllowedProductQuantityCartConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\AllowedProductQuantityCartConnector\Business\AllowedProductQuantityCartConnectorBusinessFactory
     */
    protected $allowedProductQuantityCartConnectorBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\AllowedProductQuantityCartConnectorConfig
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\AllowedProductQuantityCartConnector\Dependency\Facade\AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface
     */
    protected $allowedProductQuantityFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(AllowedProductQuantityCartConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityFacadeMock = $this->getMockBuilder(AllowedProductQuantityCartConnectorToAllowedProductQuantityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->allowedProductQuantityCartConnectorBusinessFactory = new AllowedProductQuantityCartConnectorBusinessFactory();
        $this->allowedProductQuantityCartConnectorBusinessFactory->setContainer($this->containerMock);
        $this->allowedProductQuantityCartConnectorBusinessFactory->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCreateQuoteValidator(): void
    {
        $self = $this;

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $callCount = $this->atLeastOnce();
        $this->containerMock->expects($callCount)
            ->method('get')
            ->willReturnCallback(static function (string $key) use ($self, $callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame(AllowedProductQuantityCartConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY, $key);

                        return $self->allowedProductQuantityFacadeMock;
                    case 2:
                        $self->assertSame(AllowedProductQuantityCartConnectorDependencyProvider::FACADE_ALLOWED_PRODUCT_QUANTITY, $key);

                        return $self->allowedProductQuantityFacadeMock;
                }

                throw new Exception('Unexpected call count');
            });

        static::assertInstanceOf(
            QuoteValidator::class,
            $this->allowedProductQuantityCartConnectorBusinessFactory->createQuoteValidator(),
        );
    }
}

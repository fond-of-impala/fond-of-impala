<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Model\ErpOrderCancellationApiInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\Validator\ErpOrderCancellationApiValidatorInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\ErpOrderCancellationApiDependencyProvider;
use FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationApiBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepository
     */
    protected MockObject|ErpOrderCancellationApiRepository $repositoryMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiBusinessFactory
     */
    protected ErpOrderCancellationApiBusinessFactory $businessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface
     */
    protected MockObject|ErpOrderCancellationApiToApiFacadeInterface $erpOrderCancellationApiToApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToErpOrderCancellationFacadeInterface
     */
    protected MockObject|ErpOrderCancellationApiToErpOrderCancellationFacadeInterface $erpOrderCancellationApiToErpOrderCancellationFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ErpOrderCancellationApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationApiToApiFacadeMock = $this->getMockBuilder(ErpOrderCancellationApiToApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock = $this->getMockBuilder(ErpOrderCancellationApiToErpOrderCancellationFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->businessFactory = new ErpOrderCancellationApiBusinessFactory();
        $this->businessFactory->setRepository($this->repositoryMock);
        $this->businessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellationApi(): void
    {
        $self = $this;
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $callCount = static::atLeastOnce();
        $this->containerMock->expects($callCount)
            ->method('get')
            ->willReturnCallback(
                static function (string $key) use ($self, $callCount) {
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
                            $self->assertEquals(ErpOrderCancellationApiDependencyProvider::FACADE_API, $key);

                            return $self->erpOrderCancellationApiToApiFacadeMock;
                        case 2:
                            $self->assertEquals(ErpOrderCancellationApiDependencyProvider::FACADE_ERP_ORDER_CANCELLATION, $key);

                            return $self->erpOrderCancellationApiToErpOrderCancellationFacadeMock;
                    }
                },
            );

        static::assertInstanceOf(
            ErpOrderCancellationApiInterface::class,
            $this->businessFactory->createErpOrderCancellationApi(),
        );
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellationApiValidator(): void
    {
        static::assertInstanceOf(
            ErpOrderCancellationApiValidatorInterface::class,
            $this->businessFactory->createErpOrderCancellationApiValidator(),
        );
    }
}

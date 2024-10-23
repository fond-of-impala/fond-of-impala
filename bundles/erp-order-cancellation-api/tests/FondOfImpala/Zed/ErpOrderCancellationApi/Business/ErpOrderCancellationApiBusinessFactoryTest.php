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
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ErpOrderCancellationApiDependencyProvider::FACADE_API],
                [ErpOrderCancellationApiDependencyProvider::FACADE_ERP_ORDER_CANCELLATION],
            )->willReturnOnConsecutiveCalls(
                $this->erpOrderCancellationApiToApiFacadeMock,
                $this->erpOrderCancellationApiToErpOrderCancellationFacadeMock,
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

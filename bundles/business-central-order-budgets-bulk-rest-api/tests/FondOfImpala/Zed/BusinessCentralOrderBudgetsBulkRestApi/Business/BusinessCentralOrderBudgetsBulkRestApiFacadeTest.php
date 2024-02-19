<?php

namespace FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralOrderBudgetsBulkRestApiFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\BusinessCentralOrderBudgetsBulkRestApiFacadeInterface
     */
    protected BusinessCentralOrderBudgetsBulkRestApiFacadeInterface $facade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\BusinessCentralOrderBudgetsBulkRestApiBusinessFactory
     */
    protected MockObject|BusinessCentralOrderBudgetsBulkRestApiBusinessFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\Business\Expander\RestOrderBudgetsBulkRequestExpanderInterface
     */
    protected MockObject|RestOrderBudgetsBulkRequestExpanderInterface $restOrderBudgetsBulkRequestExpanderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    protected MockObject|RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(BusinessCentralOrderBudgetsBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestExpanderMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new BusinessCentralOrderBudgetsBulkRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandRestOrderBudgetsBulkRequest(): void
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createRestOrderBudgetsBulkRequestExpander')
            ->willReturn($this->restOrderBudgetsBulkRequestExpanderMock);

        $this->restOrderBudgetsBulkRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restOrderBudgetsBulkRequestTransferMock)
            ->willReturn($this->restOrderBudgetsBulkRequestTransferMock);

        $restOrderBudgetsBulkRequestTransfer = $this->facade
            ->expandRestOrderBudgetsBulkRequest($this->restOrderBudgetsBulkRequestTransferMock);

        static::assertEquals(
            $this->restOrderBudgetsBulkRequestTransferMock,
            $restOrderBudgetsBulkRequestTransfer,
        );
    }
}

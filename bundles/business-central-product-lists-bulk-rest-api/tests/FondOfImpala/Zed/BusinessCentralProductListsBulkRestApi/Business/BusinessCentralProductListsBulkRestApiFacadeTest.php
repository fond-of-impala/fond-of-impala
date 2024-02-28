<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralProductListsBulkRestApiFacadeTest extends Unit
{
    protected BusinessCentralProductListsBulkRestApiBusinessFactory|MockObject $factoryMock;

    protected MockObject|RestProductListsBulkRequestExpanderInterface $restProductListsBulkRequestExpanderMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected BusinessCentralProductListsBulkRestApiFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(BusinessCentralProductListsBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestExpanderMock = $this->getMockBuilder(RestProductListsBulkRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new BusinessCentralProductListsBulkRestApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandRestProductListsBulkRequest(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createRestProductListsBulkRequestExpander')
            ->willReturn($this->restProductListsBulkRequestExpanderMock);

        $this->restProductListsBulkRequestExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $this->facade->expandRestProductListsBulkRequest($this->restProductListsBulkRequestTransferMock),
        );
    }
}

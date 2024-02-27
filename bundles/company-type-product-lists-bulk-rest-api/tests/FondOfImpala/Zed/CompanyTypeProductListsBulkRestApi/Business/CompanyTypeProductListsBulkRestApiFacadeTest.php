<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyTypeProductListsBulkRestApiFacadeTest extends Unit
{
    protected RestProductListsBulkRequestExpanderInterface|MockObject $restProductListsBulkRequestExpanderMock;

    protected CompanyTypeProductListsBulkRestApiBusinessFactory|MockObject $factoryMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected CompanyTypeProductListsBulkRestApiFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restProductListsBulkRequestExpanderMock = $this->getMockBuilder(RestProductListsBulkRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CompanyTypeProductListsBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyTypeProductListsBulkRestApiFacade();
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

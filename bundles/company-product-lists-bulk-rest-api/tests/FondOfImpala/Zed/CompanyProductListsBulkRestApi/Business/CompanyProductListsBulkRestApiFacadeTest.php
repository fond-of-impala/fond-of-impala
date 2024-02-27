<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyProductListsBulkRestApiFacadeTest extends Unit
{
    protected CompanyProductListsBulkRestApiBusinessFactory|MockObject $factoryMock;

    protected MockObject|RestProductListsBulkRequestExpanderInterface $restProductListsBulkRequestExpanderMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected CompanyProductListsBulkRestApiFacade $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyProductListsBulkRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestExpanderMock = $this->getMockBuilder(RestProductListsBulkRequestExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyProductListsBulkRestApiFacade();
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
            $this->facade->expandRestProductListsBulkRequest($this->restProductListsBulkRequestTransferMock)
        );
    }
}

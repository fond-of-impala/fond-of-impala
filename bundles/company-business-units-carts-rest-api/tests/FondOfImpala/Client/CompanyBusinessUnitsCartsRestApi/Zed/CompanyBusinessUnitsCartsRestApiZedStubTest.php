<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

class CompanyBusinessUnitsCartsRestApiZedStubTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer
     */
    protected $restCompanyBusinessUnitCartListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @var \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Zed\CompanyBusinessUnitsCartsRestApiZedStub
     */
    protected $companyBusinessUnitsOrdersRestApiZedStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiZedStub = new CompanyBusinessUnitsCartsRestApiZedStub(
            $this->zedRequestClientMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuotes(): void
    {
        $this->zedRequestClientMock->expects(self::atLeastOnce())
            ->method('call')
            ->with(
                '/company-business-units-carts-rest-api/gateway/find-quotes',
                $this->restCompanyBusinessUnitCartListTransferMock,
            )->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        $companyBusinessUnitQuoteListTransfer = $this->companyBusinessUnitsOrdersRestApiZedStub->findQuotes(
            $this->restCompanyBusinessUnitCartListTransferMock,
        );

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $companyBusinessUnitQuoteListTransfer,
        );
    }
}

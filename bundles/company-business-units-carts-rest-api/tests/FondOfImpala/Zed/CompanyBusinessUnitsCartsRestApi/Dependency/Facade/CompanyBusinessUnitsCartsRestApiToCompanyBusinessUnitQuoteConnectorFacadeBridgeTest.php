<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;

class CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorFacadeInterface
     */
    protected $companyBusinessUnitQuoteConnectorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer
     */
    protected $companyBusinessUnitQuoteListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge
     */
    protected $companyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitQuoteConnectorFacadeMock = $this->getMockBuilder(CompanyBusinessUnitQuoteConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge = new CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge(
            $this->companyBusinessUnitQuoteConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuotes(): void
    {
        $this->companyBusinessUnitQuoteConnectorFacadeMock->expects(self::atLeastOnce())
            ->method('findQuotes')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        $companyBusinessUnitQuoteListTransfer = $this->companyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeBridge
            ->findQuotes($this->companyBusinessUnitQuoteListRequestTransferMock);

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $companyBusinessUnitQuoteListTransfer,
        );
    }
}

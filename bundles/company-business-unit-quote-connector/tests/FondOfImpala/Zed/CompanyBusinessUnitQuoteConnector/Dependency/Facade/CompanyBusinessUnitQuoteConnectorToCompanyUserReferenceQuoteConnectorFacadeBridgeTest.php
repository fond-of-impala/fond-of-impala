<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorFacadeInterface;
use Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;

class CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\CompanyUserReferenceQuoteConnectorFacadeInterface
     */
    protected $companyUserReferenceQuoteConnectorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserReferenceCollectionTransfer
     */
    protected $companyUserReferenceCollectionTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Dependency\Facade\CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridge
     */
    protected $companyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReferenceQuoteConnectorFacadeMock = $this->getMockBuilder(CompanyUserReferenceQuoteConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReferenceCollectionTransferMock = $this->getMockBuilder(CompanyUserReferenceCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridge = new CompanyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridge(
            $this->companyUserReferenceQuoteConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuotesByCompanyUserReferences(): void
    {
        $this->companyUserReferenceQuoteConnectorFacadeMock->expects(self::atLeastOnce())
            ->method('findQuotesByCompanyUserReferences')
            ->with($this->companyUserReferenceCollectionTransferMock)
            ->willReturn($this->quoteCollectionTransferMock);

        $quoteCollectionTransfer = $this->companyBusinessUnitQuoteConnectorToCompanyUserReferenceQuoteConnectorFacadeBridge
            ->findQuotesByCompanyUserReferences($this->companyUserReferenceCollectionTransferMock);

        self::assertEquals(
            $this->quoteCollectionTransferMock,
            $quoteCollectionTransfer,
        );
    }
}

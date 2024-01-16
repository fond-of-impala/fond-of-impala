<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\QuoteReaderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;

class CompanyBusinessUnitQuoteConnectorFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorFacade
     */
    protected $companyBusinessUnitQuoteConnectorFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\CompanyBusinessUnitQuoteConnectorBusinessFactory
     */
    protected $companyBusinessUnitQuoteConnectorBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Business\Model\QuoteReaderInterface
     */
    protected $quoteReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer
     */
    protected $companyBusinessUnitQuoteListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitQuoteConnectorBusinessFactoryMock = $this->getMockBuilder(
            CompanyBusinessUnitQuoteConnectorBusinessFactory::class,
        )->disableOriginalConstructor()->getMock();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListRequestTransferMock = $this->getMockBuilder(
            CompanyBusinessUnitQuoteListRequestTransfer::class,
        )->disableOriginalConstructor()->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(
            CompanyBusinessUnitQuoteListTransfer::class,
        )->disableOriginalConstructor()->getMock();

        $this->companyBusinessUnitQuoteConnectorFacade = new CompanyBusinessUnitQuoteConnectorFacade();

        $this->companyBusinessUnitQuoteConnectorFacade->setFactory(
            $this->companyBusinessUnitQuoteConnectorBusinessFactoryMock,
        );
    }

    /**
     * @return void
     */
    public function testFindQuotes(): void
    {
        $this->companyBusinessUnitQuoteConnectorBusinessFactoryMock->expects(self::atLeastOnce())
            ->method('createQuoteReader')
            ->willReturn($this->quoteReaderMock);

        $this->quoteReaderMock->expects(self::atLeastOnce())
            ->method('findByCompanyBusinessUnitQuoteListRequest')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $this->companyBusinessUnitQuoteConnectorFacade->findQuotes(
                $this->companyBusinessUnitQuoteListRequestTransferMock,
            ),
        );
    }
}

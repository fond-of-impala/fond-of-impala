<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\QuoteReaderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

class CompanyBusinessUnitsCartsRestApiFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\CompanyBusinessUnitsCartsRestApiBusinessFactory
     */
    protected $companyBusinessUnitsCartsRestApiBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\QuoteReaderInterface
     */
    protected $quoteReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer
     */
    protected $restCompanyBusinessUnitCartListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\CompanyBusinessUnitsCartsRestApiFacade
     */
    protected $companyBusinessUnitsCartsRestApiFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitsCartsRestApiBusinessFactoryMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteReaderMock = $this->getMockBuilder(QuoteReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsRestApiFacade = new CompanyBusinessUnitsCartsRestApiFacade();
        $this->companyBusinessUnitsCartsRestApiFacade->setFactory($this->companyBusinessUnitsCartsRestApiBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindQuotes(): void
    {
        $this->companyBusinessUnitsCartsRestApiBusinessFactoryMock->expects(self::atLeastOnce())
            ->method('createQuoteReader')
            ->willReturn($this->quoteReaderMock);

        $this->quoteReaderMock->expects(self::atLeastOnce())
            ->method('find')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        $companyBusinessUnitQuoteListTransfer = $this->companyBusinessUnitsCartsRestApiFacade
            ->findQuotes($this->restCompanyBusinessUnitCartListTransferMock);

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $companyBusinessUnitQuoteListTransfer,
        );
    }
}

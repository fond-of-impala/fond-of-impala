<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface;
use FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence\CompanyBusinessUnitsCartsRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;

class QuoteReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\CompanyBusinessUnitReaderInterface
     */
    protected $companyBusinessUnitReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\RestCompanyBusinessUnitCartListMapperInterface
     */
    protected $restCompanyBusinessUnitCartListMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Persistence\CompanyBusinessUnitsCartsRestApiRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Dependency\Facade\CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface
     */
    protected $companyBusinessUnitQuoteConnectorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer
     */
    protected $restCompanyBusinessUnitCartListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer
     */
    protected $companyBusinessUnitQuoteListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitsCartsRestApi\Business\Model\QuoteReader
     */
    protected $quoteReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitReaderMock = $this->getMockBuilder(CompanyBusinessUnitReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListMapperMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteConnectorFacadeMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiToCompanyBusinessUnitQuoteConnectorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteReader = new QuoteReader(
            $this->companyBusinessUnitReaderMock,
            $this->restCompanyBusinessUnitCartListMapperMock,
            $this->repositoryMock,
            $this->companyBusinessUnitQuoteConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindForSpecifiedQuote(): void
    {
        $idCompanyBusinessUnit = 1;
        $cartUuid = '97722578-1efd-4e78-8d2a-5370f462cfc3';
        $idQuote = 1;

        $this->restCompanyBusinessUnitCartListMapperMock->expects(self::atLeastOnce())
            ->method('mapToCompanyBusinessUnitQuoteListRequestTransfer')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->companyBusinessUnitReaderMock->expects(self::atLeastOnce())
            ->method('getByRestCompanyBusinessUnitCartList')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($idCompanyBusinessUnit);

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('setIdCompanyBusinessUnit')
            ->with($idCompanyBusinessUnit)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCartUuid')
            ->willReturn($cartUuid);

        $this->repositoryMock->expects(self::atLeastOnce())
            ->method('getIdQuoteByQuoteUuid')
            ->with($cartUuid)
            ->willReturn($idQuote);

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('setIdQuote')
            ->with($idQuote)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->companyBusinessUnitQuoteConnectorFacadeMock->expects(self::atLeastOnce())
            ->method('findQuotes')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $this->quoteReader->find($this->restCompanyBusinessUnitCartListTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindWithoutIdCompanyBusinessUnit(): void
    {
        $this->restCompanyBusinessUnitCartListMapperMock->expects(self::atLeastOnce())
            ->method('mapToCompanyBusinessUnitQuoteListRequestTransfer')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->companyBusinessUnitReaderMock->expects(self::atLeastOnce())
            ->method('getByRestCompanyBusinessUnitCartList')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn(null);

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::never())
            ->method('setIdCompanyBusinessUnit');

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCartUuid')
            ->willReturn(null);

        $this->repositoryMock->expects(self::never())
            ->method('getIdQuoteByQuoteUuid');

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('setIdQuote')
            ->with(null)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->companyBusinessUnitQuoteConnectorFacadeMock->expects(self::atLeastOnce())
            ->method('findQuotes')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $this->quoteReader->find($this->restCompanyBusinessUnitCartListTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $idCompanyBusinessUnit = 1;

        $this->restCompanyBusinessUnitCartListMapperMock->expects(self::atLeastOnce())
            ->method('mapToCompanyBusinessUnitQuoteListRequestTransfer')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->companyBusinessUnitReaderMock->expects(self::atLeastOnce())
            ->method('getByRestCompanyBusinessUnitCartList')
            ->with($this->restCompanyBusinessUnitCartListTransferMock)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->companyBusinessUnitTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn($idCompanyBusinessUnit);

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('setIdCompanyBusinessUnit')
            ->with($idCompanyBusinessUnit)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCartUuid')
            ->willReturn(null);

        $this->repositoryMock->expects(self::never())
            ->method('getIdQuoteByQuoteUuid');

        $this->companyBusinessUnitQuoteListRequestTransferMock->expects(self::atLeastOnce())
            ->method('setIdQuote')
            ->with(null)
            ->willReturn($this->companyBusinessUnitQuoteListRequestTransferMock);

        $this->companyBusinessUnitQuoteConnectorFacadeMock->expects(self::atLeastOnce())
            ->method('findQuotes')
            ->with($this->companyBusinessUnitQuoteListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        self::assertEquals(
            $this->companyBusinessUnitQuoteListTransferMock,
            $this->quoteReader->find($this->restCompanyBusinessUnitCartListTransferMock),
        );
    }
}

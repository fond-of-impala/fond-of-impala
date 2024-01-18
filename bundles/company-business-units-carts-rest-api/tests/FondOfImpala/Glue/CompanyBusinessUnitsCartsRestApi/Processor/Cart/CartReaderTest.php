<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiClientInterface;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiConfig;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartRestResponseBuilderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CartReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiClientInterface
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartRestResponseBuilderInterface
     */
    protected $cartRestResponseBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var string
     */
    protected $companyBusinessUnitUuid;

    /**
     * @var int
     */
    protected $idCustomer;

    /**
     * @var string
     */
    protected $cartUuid;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $restUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Cart\CartReaderInterface
     */
    protected $cartReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->clientMock = $this->getMockBuilder(CompanyBusinessUnitsCartsRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartRestResponseBuilderMock = $this->getMockBuilder(CartRestResponseBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUserTransferMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitUuid = '0fc338f9-9ffa-4276-93da-37d21ffcecb7';
        $this->idCustomer = 1;
        $this->cartUuid = '0fc338f9-9ffa-4276-93da-37d21ffcecb5';

        $this->cartReader = new CartReader(
            $this->clientMock,
            $this->cartRestResponseBuilderMock,
        );
    }

    /**
     * @return void
     */
    public function testFindCarts(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($this->companyBusinessUnitUuid);

        $this->cartRestResponseBuilderMock->expects(static::never())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse');

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->idCustomer);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('findQuotes')
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        $this->cartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createCartListRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals($this->restResponseMock, $this->cartReader->findCarts($this->restRequestMock));
    }

    /**
     * @return void
     */
    public function testFindCartsWithoutParentResource(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn(null);

        $this->restResourceMock->expects(static::never())
            ->method('getId');

        $this->cartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::never())
            ->method('getRestUser');

        $this->clientMock->expects(static::never())
            ->method('findQuotes');

        $this->cartRestResponseBuilderMock->expects(static::never())
            ->method('createCartListRestResponse');

        static::assertEquals($this->restResponseMock, $this->cartReader->findCarts($this->restRequestMock));
    }

    /**
     * @return void
     */
    public function testGetCartWithoutParentResource(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn(null);

        $this->restResourceMock->expects(static::never())
            ->method('getId');

        $this->cartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse')
            ->willReturn($this->restResponseMock);

        $this->restRequestMock->expects(static::never())
            ->method('getRestUser');

        $this->clientMock->expects(static::never())
            ->method('findQuotes');

        $this->cartRestResponseBuilderMock->expects(static::never())
            ->method('createCartRestResponse');

        static::assertEquals($this->restResponseMock, $this->cartReader->getCart(
            $this->cartUuid,
            $this->restRequestMock,
        ));
    }

    /**
     * @return void
     */
    public function testGetCart(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($this->companyBusinessUnitUuid);

        $this->cartRestResponseBuilderMock->expects(static::never())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse');

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->idCustomer);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('findQuotes')
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        $this->companyBusinessUnitQuoteListTransferMock->expects(static::atLeastOnce())
            ->method('getQuotes')
            ->willReturn(new ArrayObject([$this->quoteTransferMock]));

        $this->cartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createCartRestResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals($this->restResponseMock, $this->cartReader->getCart(
            $this->cartUuid,
            $this->restRequestMock,
        ));
    }

    /**
     * @return void
     */
    public function testGetCartWithInvalidCartUuid(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('findParentResourceByType')
            ->with(CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS)
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($this->companyBusinessUnitUuid);

        $this->cartRestResponseBuilderMock->expects(static::never())
            ->method('createCompanyBusinessUnitIdentifierMissingErrorResponse');

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects(static::atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->idCustomer);

        $this->clientMock->expects(static::atLeastOnce())
            ->method('findQuotes')
            ->willReturn($this->companyBusinessUnitQuoteListTransferMock);

        $this->companyBusinessUnitQuoteListTransferMock->expects(static::atLeastOnce())
            ->method('getQuotes')
            ->willReturn(new ArrayObject());

        $this->cartRestResponseBuilderMock->expects(static::atLeastOnce())
            ->method('createCartNotFoundErrorResponse')
            ->willReturn($this->restResponseMock);

        static::assertEquals($this->restResponseMock, $this->cartReader->getCart(
            $this->cartUuid,
            $this->restRequestMock,
        ));
    }
}

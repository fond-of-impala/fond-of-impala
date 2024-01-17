<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiConfig;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapperInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CartRestResponseBuilderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer
     */
    protected $restCompanyBusinessUnitCartListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer
     */
    protected $companyBusinessUnitQuoteListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapperInterface
     */
    protected $cartMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCartsAttributesTransfer
     */
    protected $restCartsAttributesTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartRestResponseBuilder
     */
    protected $cartRestResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartMapperMock = $this->getMockBuilder(CartMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyBusinessUnitCartListTransferMock = $this->getMockBuilder(RestCompanyBusinessUnitCartListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitQuoteListTransferMock = $this->getMockBuilder(CompanyBusinessUnitQuoteListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsAttributesTransferMock = $this->getMockBuilder(RestCartsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartRestResponseBuilder = new CartRestResponseBuilder(
            $this->restResourceBuilderMock,
            $this->cartMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateCartRestResource(): void
    {
        $quoteUuid = '8f460b7a-8de4-4fe4-8b22-ba8ffb53f8a7';
        $companyBusinessUnitUuid = '1f43b324-ca87-41a4-810a-249f112edd4a';

        $this->cartMapperMock->expects(self::atLeastOnce())
            ->method('mapQuoteTransferToRestCartsAttributesTransfer')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restCartsAttributesTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getUuid')
            ->willReturn($quoteUuid);

        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResource')
            ->with(
                CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
                $quoteUuid,
                $this->restCartsAttributesTransferMock,
            )->willReturn($this->restResourceMock);

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('getId')
            ->willReturn($quoteUuid);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                    $companyBusinessUnitUuid,
                    CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
                    $quoteUuid,
                ),
            )->willReturn($this->restResourceMock);

        self::assertEquals(
            $this->restResourceMock,
            $this->cartRestResponseBuilder->createCartRestResource(
                $this->restCompanyBusinessUnitCartListTransferMock,
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartRestResponse(): void
    {
        $quoteUuid = '8f460b7a-8de4-4fe4-8b22-ba8ffb53f8a7';
        $companyBusinessUnitUuid = '1f43b324-ca87-41a4-810a-249f112edd4a';

        $this->cartMapperMock->expects(self::atLeastOnce())
            ->method('mapQuoteTransferToRestCartsAttributesTransfer')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restCartsAttributesTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getUuid')
            ->willReturn($quoteUuid);

        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResource')
            ->with(
                CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
                $quoteUuid,
                $this->restCartsAttributesTransferMock,
            )->willReturn($this->restResourceMock);

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('getId')
            ->willReturn($quoteUuid);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                    $companyBusinessUnitUuid,
                    CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
                    $quoteUuid,
                ),
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('setPayload')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restResourceMock);

        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(self::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        self::assertEquals(
            $this->restResponseMock,
            $this->cartRestResponseBuilder->createCartRestResponse(
                $this->restCompanyBusinessUnitCartListTransferMock,
                $this->quoteTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartListRestResponse(): void
    {
        $quoteUuid = '8f460b7a-8de4-4fe4-8b22-ba8ffb53f8a7';
        $companyBusinessUnitUuid = '1f43b324-ca87-41a4-810a-249f112edd4a';

        $this->companyBusinessUnitQuoteListTransferMock->expects(self::atLeastOnce())
            ->method('getQuotes')
            ->willReturn(new ArrayObject([$this->quoteTransferMock]));

        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->cartMapperMock->expects(self::atLeastOnce())
            ->method('mapQuoteTransferToRestCartsAttributesTransfer')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restCartsAttributesTransferMock);

        $this->quoteTransferMock->expects(self::atLeastOnce())
            ->method('getUuid')
            ->willReturn($quoteUuid);

        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResource')
            ->with(
                CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
                $quoteUuid,
                $this->restCartsAttributesTransferMock,
            )->willReturn($this->restResourceMock);

        $this->restCompanyBusinessUnitCartListTransferMock->expects(self::atLeastOnce())
            ->method('getCompanyBusinessUnitUuid')
            ->willReturn($companyBusinessUnitUuid);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('getId')
            ->willReturn($quoteUuid);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                    $companyBusinessUnitUuid,
                    CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
                    $quoteUuid,
                ),
            )->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(self::atLeastOnce())
            ->method('setPayload')
            ->with($this->quoteTransferMock)
            ->willReturn($this->restResourceMock);

        $this->restResponseMock->expects(self::atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceMock)
            ->willReturn($this->restResponseMock);

        self::assertEquals(
            $this->restResponseMock,
            $this->cartRestResponseBuilder->createCartListRestResponse(
                $this->restCompanyBusinessUnitCartListTransferMock,
                $this->companyBusinessUnitQuoteListTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreateCompanyBusinessUnitIdentifierMissingErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(self::atLeastOnce())
            ->method('addError')
            ->with(
                self::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getStatus() === Response::HTTP_BAD_REQUEST
                            && $restErrorMessageTransfer->getCode() === CompanyBusinessUnitsCartsRestApiConfig::RESPONSE_CODE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING
                            && $restErrorMessageTransfer->getDetail() === CompanyBusinessUnitsCartsRestApiConfig::EXCEPTION_MESSAGE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING;
                    },
                ),
            )->willReturn($this->restResponseMock);

        self::assertEquals(
            $this->restResponseMock,
            $this->cartRestResponseBuilder->createCompanyBusinessUnitIdentifierMissingErrorResponse(),
        );
    }

    /**
     * @return void
     */
    public function testCreateCartNotFoundErrorResponse(): void
    {
        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(self::atLeastOnce())
            ->method('addError')
            ->with(
                self::callback(
                    static function (RestErrorMessageTransfer $restErrorMessageTransfer) {
                        return $restErrorMessageTransfer->getStatus() === Response::HTTP_NOT_FOUND
                            && $restErrorMessageTransfer->getCode() === CompanyBusinessUnitsCartsRestApiConfig::RESPONSE_CODE_CANT_FIND_CART
                            && $restErrorMessageTransfer->getDetail() === CompanyBusinessUnitsCartsRestApiConfig::EXCEPTION_MESSAGE_CANT_FIND_CART;
                    },
                ),
            )->willReturn($this->restResponseMock);

        self::assertEquals(
            $this->restResponseMock,
            $this->cartRestResponseBuilder->createCartNotFoundErrorResponse(),
        );
    }
}

<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder;

use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiConfig;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapperInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CartRestResponseBuilder implements CartRestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapperInterface
     */
    protected $cartResourceMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartMapperInterface $cartResourceMapper
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CartMapperInterface $cartResourceMapper
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->cartResourceMapper = $cartResourceMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function createCartRestResource(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer,
        QuoteTransfer $quoteTransfer
    ): RestResourceInterface {
        $restCartsAttributesTransfer = $this->cartResourceMapper
            ->mapQuoteTransferToRestCartsAttributesTransfer($quoteTransfer);

        $cartRestResource = $this->restResourceBuilder->createRestResource(
            CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
            $quoteTransfer->getUuid(),
            $restCartsAttributesTransfer,
        );

        return $this->addSelfLinkToCartRestResource($cartRestResource, $restCompanyBusinessUnitCartListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartRestResponse(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer,
        QuoteTransfer $quoteTransfer
    ): RestResponseInterface {
        $cartRestResource = $this->createCartRestResource($restCompanyBusinessUnitCartListTransfer, $quoteTransfer);

        $cartRestResource->setPayload($quoteTransfer);

        return $this->restResourceBuilder->createRestResponse()
            ->addResource($cartRestResource);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer $companyBusinessUnitQuoteListTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartListRestResponse(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer,
        CompanyBusinessUnitQuoteListTransfer $companyBusinessUnitQuoteListTransfer
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        foreach ($companyBusinessUnitQuoteListTransfer->getQuotes() as $quoteTransfer) {
            $cartRestResource = $this->createCartRestResource(
                $restCompanyBusinessUnitCartListTransfer,
                $quoteTransfer,
            );

            $cartRestResource->setPayload($quoteTransfer);

            $restResponse = $restResponse->addResource($cartRestResource);
        }

        return $restResponse;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCompanyBusinessUnitIdentifierMissingErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setCode(CompanyBusinessUnitsCartsRestApiConfig::RESPONSE_CODE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING)
            ->setDetail(CompanyBusinessUnitsCartsRestApiConfig::EXCEPTION_MESSAGE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING);

        return $this->restResourceBuilder
            ->createRestResponse()
            ->addError($restErrorMessageTransfer);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartNotFoundErrorResponse(): RestResponseInterface
    {
        $restErrorTransfer = (new RestErrorMessageTransfer())
            ->setCode(CompanyBusinessUnitsCartsRestApiConfig::RESPONSE_CODE_CANT_FIND_CART)
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setDetail(CompanyBusinessUnitsCartsRestApiConfig::EXCEPTION_MESSAGE_CANT_FIND_CART);

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface $cartRestResource
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected function addSelfLinkToCartRestResource(
        RestResourceInterface $cartRestResource,
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
    ): RestResourceInterface {
        return $cartRestResource->addLink(
            RestLinkInterface::LINK_SELF,
            sprintf(
                '%s/%s/%s/%s',
                CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
                $restCompanyBusinessUnitCartListTransfer->getCompanyBusinessUnitUuid(),
                CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
                $cartRestResource->getId(),
            ),
        );
    }
}

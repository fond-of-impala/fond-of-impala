<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface CartRestResponseBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    public function createCartRestResource(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer,
        QuoteTransfer $quoteTransfer
    ): RestResourceInterface;

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartRestResponse(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer,
        QuoteTransfer $quoteTransfer
    ): RestResponseInterface;

    /**
     * @param \Generated\Shared\Transfer\RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListTransfer $companyBusinessUnitQuoteListTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartListRestResponse(
        RestCompanyBusinessUnitCartListTransfer $restCompanyBusinessUnitCartListTransfer,
        CompanyBusinessUnitQuoteListTransfer $companyBusinessUnitQuoteListTransfer
    ): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCompanyBusinessUnitIdentifierMissingErrorResponse(): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCartNotFoundErrorResponse(): RestResponseInterface;
}

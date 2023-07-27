<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Controller;

use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiFactory getFactory()
 */
class CompanyUsersBulkResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer $restCompanyUsersBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestCompanyUsersBulkRequestAttributesTransfer $restCompanyUsersBulkRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createCompanyUsersBulkProcessor()
            ->process($restRequest, $restCompanyUsersBulkRequestAttributesTransfer);
    }
}

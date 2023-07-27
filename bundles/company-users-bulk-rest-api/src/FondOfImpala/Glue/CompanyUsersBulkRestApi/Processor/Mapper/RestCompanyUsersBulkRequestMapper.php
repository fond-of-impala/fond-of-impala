<?php

namespace FondOfImpala\Glue\CompanyUsersBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class RestCompanyUsersBulkRequestMapper implements RestCompanyUsersBulkRequestMapperInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer|null $restCompanyUsersBulkRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkRequestTransfer
     */
    public function createRequest(
        RestRequestInterface $restRequest,
        ?RestCompanyUsersBulkRequestAttributesTransfer $restCompanyUsersBulkRequestAttributesTransfer = null
    ): RestCompanyUsersBulkRequestTransfer {
        if ($restCompanyUsersBulkRequestAttributesTransfer === null) {
            $restCompanyUsersBulkRequestAttributesTransfer = $this->createAttributesFromRequest($restRequest);
        }

        return (new RestCompanyUsersBulkRequestTransfer())
            ->setAttributes($restCompanyUsersBulkRequestAttributesTransfer)
            ->setOriginatorReference($this->getOriginatorReference($restRequest));
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return string
     */
    protected function getOriginatorReference(RestRequestInterface $restRequest): string
    {
        return $restRequest->getRestUser()->getNaturalIdentifier();
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersBulkRequestAttributesTransfer
     */
    protected function createAttributesFromRequest(
        RestRequestInterface $restRequest
    ): RestCompanyUsersBulkRequestAttributesTransfer {
        $data = $restRequest->getAttributesDataFromRequest();
        if ($data === null) {
            $data = [];
        }

        return (new RestCompanyUsersBulkRequestAttributesTransfer())
            ->fromArray($data, true);
    }
}

<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Controller;

use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\ProductListsBulkRestApi\ProductListsBulkRestApiFactory getFactory()
 */
class ProductListsBulkResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestProductListsBulkRequestAttributesTransfer $restProductListsBulkRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createProductListsBulkProcessor()
            ->process($restRequest, $restProductListsBulkRequestAttributesTransfer);
    }
}

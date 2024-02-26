<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Controller;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiFactory getFactory()
 */
class OrderBudgetsBulkResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createOrderBudgetsBulkProcessor()
            ->process($restRequest, $restOrderBudgetsBulkRequestAttributesTransfer);
    }
}

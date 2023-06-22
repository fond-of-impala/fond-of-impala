<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Controller;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory getFactory()
 */
class ConditionalAvailabilityPageSearchResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "getCollection": {
     *          "summary": [
     *              "Retrieves list of conditional availability periods."
     *          ],
     *          "parameters": [{
     *              "name": "q",
     *              "in": "query",
     *              "description": "Search query string.",
     *              "required": true
     *          }],
     *         "isIdNullable": true
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        return $this->getFactory()->createConditionalAvailabilityPageSearchReader()->get($restRequest);
    }
}

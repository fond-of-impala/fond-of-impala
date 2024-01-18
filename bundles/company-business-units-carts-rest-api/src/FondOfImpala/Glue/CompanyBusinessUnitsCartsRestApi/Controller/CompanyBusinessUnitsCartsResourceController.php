<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Controller;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiFactory getFactory()
 */
class CompanyBusinessUnitsCartsResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "getResourceById": {
     *          "path": "/company-business-units/{companyBusinessUnitId}/company-business-unit-carts/{companyBusinessUnitCartId}",
     *          "summary": [
     *              "Retrieves cart by identifier."
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responseAttributesClassName": "Generated\\Shared\\Transfer\\RestOrderDetailsAttributesTransfer",
     *          "responses": {
     *              "403": "Unauthorized request.",
     *              "404": "Cart not found."
     *          }
     *     },
     *     "getCollection": {
     *          "path": "/company-business-units/{companyBusinessUnitId}/company-business-unit-carts/
     *          "summary": [
     *              "Retrieves list of carts."
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responses": {
     *              "400": "Company business unit identifier is missing."
     *              "403": "Unauthorized request."
     *          }
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        $orderReference = $restRequest->getResource()->getId();

        if ($orderReference === null) {
            return $this->getFactory()->createCartReader()
                ->findCarts($restRequest);
        }

        return $this->getFactory()->createCartReader()
            ->getCart($orderReference, $restRequest);
    }
}

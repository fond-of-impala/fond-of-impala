<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Plugin\PriceListsRestApiExtension;

use ArrayObject;
use FondOfImpala\Shared\PriceListsRestApi\PriceListsRestApiConstants;
use FondOfOryx\Glue\PriceListsRestApiExtension\Dependency\Plugin\FilterFieldsExpanderPluginInterface;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class PriceListFilterFieldsExpanderPlugin extends AbstractPlugin implements FilterFieldsExpanderPluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \ArrayObject<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\FilterFieldTransfer>
     */
    public function expand(RestRequestInterface $restRequest, ArrayObject $filterFieldTransfers): ArrayObject
    {
        if ($restRequest->getResource()->getId() === null) {
            return $filterFieldTransfers;
        }

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType(PriceListsRestApiConstants::FILTER_FIELD_TYPE_PRICE_LIST_UUID)
            ->setValue((string)$restRequest->getResource()->getId());

        $filterFieldTransfers->append($filterFieldTransfer);

        return $filterFieldTransfers;
    }
}

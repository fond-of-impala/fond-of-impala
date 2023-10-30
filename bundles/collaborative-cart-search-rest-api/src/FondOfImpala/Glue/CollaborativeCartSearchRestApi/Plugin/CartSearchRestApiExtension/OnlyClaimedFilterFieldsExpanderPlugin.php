<?php

namespace FondOfImpala\Glue\CollaborativeCartSearchRestApi\Plugin\CartSearchRestApiExtension;

use ArrayObject;
use FondOfImpala\Shared\CollaborativeCartSearchRestApi\CollaborativeCartSearchRestApiConstants;
use FondOfOryx\Glue\CartSearchRestApiExtension\Dependency\Plugin\FilterFieldsExpanderPluginInterface;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class OnlyClaimedFilterFieldsExpanderPlugin extends AbstractPlugin implements FilterFieldsExpanderPluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \ArrayObject<\Generated\Shared\Transfer\FilterFieldTransfer> $filterFieldTransfers
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\FilterFieldTransfer>
     */
    public function expand(RestRequestInterface $restRequest, ArrayObject $filterFieldTransfers): ArrayObject
    {
        if ($restRequest->getResource()->getId() !== null) {
            return $filterFieldTransfers;
        }

        $onlyClaimed = $restRequest->getHttpRequest()->query->get(
            CollaborativeCartSearchRestApiConstants::PARAMETER_NAME_ONLY_CLAIMED,
        );

        if ($onlyClaimed === null) {
            return $filterFieldTransfers;
        }

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType(CollaborativeCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_CLAIMED)
            ->setValue((string)$onlyClaimed);

        $filterFieldTransfers->append($filterFieldTransfer);

        return $filterFieldTransfers;
    }
}

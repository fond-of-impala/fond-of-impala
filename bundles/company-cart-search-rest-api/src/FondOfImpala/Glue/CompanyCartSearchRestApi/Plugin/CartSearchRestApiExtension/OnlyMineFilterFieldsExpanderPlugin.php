<?php

namespace FondOfImpala\Glue\CompanyCartSearchRestApi\Plugin\CartSearchRestApiExtension;

use ArrayObject;
use FondOfImpala\Shared\CompanyCartSearchRestApi\CompanyCartSearchRestApiConstants;
use FondOfOryx\Glue\CartSearchRestApiExtension\Dependency\Plugin\FilterFieldsExpanderPluginInterface;
use Generated\Shared\Transfer\FilterFieldTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class OnlyMineFilterFieldsExpanderPlugin extends AbstractPlugin implements FilterFieldsExpanderPluginInterface
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

        $onlyMine = $restRequest->getHttpRequest()->query->get(
            CompanyCartSearchRestApiConstants::PARAMETER_NAME_ONLY_MINE,
        );

        if ($onlyMine === null) {
            return $filterFieldTransfers;
        }

        $filterFieldTransfer = (new FilterFieldTransfer())
            ->setType(CompanyCartSearchRestApiConstants::FILTER_FIELD_TYPE_ONLY_MINE)
            ->setValue((string)$onlyMine);

        $filterFieldTransfers->append($filterFieldTransfer);

        return $filterFieldTransfers;
    }
}

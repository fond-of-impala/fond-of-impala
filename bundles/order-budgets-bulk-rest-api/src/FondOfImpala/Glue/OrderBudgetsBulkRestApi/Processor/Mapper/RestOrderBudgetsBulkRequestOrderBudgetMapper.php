<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer;

class RestOrderBudgetsBulkRequestOrderBudgetMapper implements RestOrderBudgetsBulkRequestOrderBudgetMapperInterface
{
    /**
     * @var array<\FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface>
     */
    protected array $restOrderBudgetsBulkRequestOrderBudgetMapperPlugins;

    /**
     * @param array<\FondOfImpala\Glue\OrderBudgetsBulkRestApiExtension\Dependency\Plugin\RestOrderBudgetsBulkRequestOrderBudgetMapperPluginInterface> $restOrderBudgetsBulkRequestOrderBudgetMapperPlugins
     */
    public function __construct(
        array $restOrderBudgetsBulkRequestOrderBudgetMapperPlugins = []
    ) {
        $this->restOrderBudgetsBulkRequestOrderBudgetMapperPlugins = $restOrderBudgetsBulkRequestOrderBudgetMapperPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer
     */
    public function fromRestOrderBudgetsBulkOrderBudget(
        RestOrderBudgetsBulkOrderBudgetTransfer $restOrderBudgetsBulkOrderBudgetTransfer
    ): RestOrderBudgetsBulkRequestOrderBudgetTransfer {
        $restOrderBudgetsBulkRequestOrderBudgetTransfer = (new RestOrderBudgetsBulkRequestOrderBudgetTransfer())
            ->setUuid($restOrderBudgetsBulkOrderBudgetTransfer->getId())
            ->setNextInitialBudget($restOrderBudgetsBulkOrderBudgetTransfer->getNextInitialBudget());

        foreach ($this->restOrderBudgetsBulkRequestOrderBudgetMapperPlugins as $plugin) {
            $restOrderBudgetsBulkRequestOrderBudgetTransfer = $plugin->mapRestOrderBudgetsBulkOrderBudgetToRestOrderBudgetsBulkRequestOrderBudget(
                $restOrderBudgetsBulkOrderBudgetTransfer,
                $restOrderBudgetsBulkRequestOrderBudgetTransfer,
            );
        }

        return $restOrderBudgetsBulkRequestOrderBudgetTransfer;
    }
}

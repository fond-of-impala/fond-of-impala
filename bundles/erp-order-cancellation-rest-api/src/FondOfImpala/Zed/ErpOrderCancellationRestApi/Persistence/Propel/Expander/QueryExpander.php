<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Expander;

use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;

class QueryExpander implements QueryExpanderInterface
{
    /**
     * @var array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface>
     */
    protected array $erpOrderCancellationQueryExpanderPlugins;

    /**
     * @param array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface> $erpOrderCancellationQueryExpanderPlugins
     */
    public function __construct(array $erpOrderCancellationQueryExpanderPlugins)
    {
        $this->erpOrderCancellationQueryExpanderPlugins = $erpOrderCancellationQueryExpanderPlugins;
    }

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery $query
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function expandErpOrderCancellationQuery(
        FoiErpOrderCancellationQuery $query,
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): FoiErpOrderCancellationQuery {
        foreach ($this->erpOrderCancellationQueryExpanderPlugins as $plugin) {
            $query = $plugin->expandErpOrderCancellationQuery($query, $filterTransfer);
        }

        return $query;
    }
}

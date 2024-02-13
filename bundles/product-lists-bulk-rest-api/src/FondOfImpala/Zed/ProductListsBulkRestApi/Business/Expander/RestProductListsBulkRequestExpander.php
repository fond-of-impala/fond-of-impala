<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;

class RestProductListsBulkRequestExpander implements RestProductListsBulkRequestExpanderInterface
{
    protected GroupedIdentifierFilterInterface $groupedIdentifierFilter;

    protected ProductListReaderInterface $productListReader;

    /**
     * @var array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\ProductListIdsReducerPluginInterface>
     */
    protected array $productListIdsReducerPlugins;

    /**
     * @param \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface $groupedIdentifierFilter
     * @param \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader\ProductListReaderInterface $productListReader
     * @param array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\ProductListIdsReducerPluginInterface> $productListIdsReducerPlugins
     */
    public function __construct(
        GroupedIdentifierFilterInterface $groupedIdentifierFilter,
        ProductListReaderInterface $productListReader,
        array $productListIdsReducerPlugins = []
    ) {
        $this->groupedIdentifierFilter = $groupedIdentifierFilter;
        $this->productListReader = $productListReader;
        $this->productListIdsReducerPlugins = $productListIdsReducerPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    public function expand(
        RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransfer
    ): RestProductListsBulkRequestTransfer {
        $groupedIdentifier = $this->groupedIdentifierFilter->filterFromRestProductListsBulkRequest(
            $restProductListsBulkRequestTransfer,
        );

        $productListIds = $this->productListReader->getIdsByGroupedIdentifier($groupedIdentifier);

        foreach ($this->productListIdsReducerPlugins as $plugin) {
            $productListIds = $plugin->reduce($productListIds, $restProductListsBulkRequestTransfer);
        }

        $restProductListsBulkRequestAssignmentTransfers = $this->expandRestProductListsBulkRequestAssignments(
            $restProductListsBulkRequestTransfer->getAssignments(),
            $productListIds,
        );

        return $restProductListsBulkRequestTransfer->setAssignments($restProductListsBulkRequestAssignmentTransfers);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer> $restProductListsBulkRequestAssignmentTransfers
     * @param array<string, int> $productListIds
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer>
     */
    protected function expandRestProductListsBulkRequestAssignments(
        ArrayObject $restProductListsBulkRequestAssignmentTransfers,
        array $productListIds
    ): ArrayObject {
        foreach ($restProductListsBulkRequestAssignmentTransfers as $restProductListsBulkRequestAssignmentTransfer) {
            $restProductListsBulkRequestAssignmentProductListTransfer = $this->expandRestProductListsBulkRequestAssignmentProductLists(
                $restProductListsBulkRequestAssignmentTransfer->getProductListsToAssign(),
                $productListIds,
            );

            $restProductListsBulkRequestAssignmentTransfer->setProductListsToAssign(
                $restProductListsBulkRequestAssignmentProductListTransfer,
            );

            $restProductListsBulkRequestAssignmentProductListTransfer = $this->expandRestProductListsBulkRequestAssignmentProductLists(
                $restProductListsBulkRequestAssignmentTransfer->getProductListsToUnassign(),
                $productListIds,
            );

            $restProductListsBulkRequestAssignmentTransfer->setProductListsToUnassign(
                $restProductListsBulkRequestAssignmentProductListTransfer,
            );
        }

        return $restProductListsBulkRequestAssignmentTransfers;
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer> $restProductListsBulkRequestAssignmentProductListTransfers
     * @param array<string, int> $productListIds
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentProductListTransfer>
     */
    protected function expandRestProductListsBulkRequestAssignmentProductLists(
        ArrayObject $restProductListsBulkRequestAssignmentProductListTransfers,
        array $productListIds
    ): ArrayObject {
        foreach ($restProductListsBulkRequestAssignmentProductListTransfers as $restProductListsBulkRequestAssignmentProductListTransfer) {
            $uuid = $restProductListsBulkRequestAssignmentProductListTransfer->getUuid();

            if ($uuid !== null && isset($productListIds[$uuid])) {
                $restProductListsBulkRequestAssignmentProductListTransfer->setId($productListIds[$uuid]);

                continue;
            }

            $key = $restProductListsBulkRequestAssignmentProductListTransfer->getKey();
            if ($key === null) {
                continue;
            }

            if (!isset($productListIds[$key])) {
                continue;
            }

            $restProductListsBulkRequestAssignmentProductListTransfer->setId($productListIds[$key]);
        }

        return $restProductListsBulkRequestAssignmentProductListTransfers;
    }
}

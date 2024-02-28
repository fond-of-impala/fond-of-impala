<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\ProductListIdsFilterInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use Generated\Shared\Transfer\CustomerProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

class CustomerProductListRelationMapper implements CustomerProductListRelationMapperInterface
{
    protected ProductListIdsFilterInterface $productListIdsFilter;

    protected ProductListReaderInterface $productListReader;

    /**
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\ProductListIdsFilterInterface $productListIdsFilter
     * @param \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\ProductListReaderInterface $productListReader
     */
    public function __construct(
        ProductListIdsFilterInterface $productListIdsFilter,
        ProductListReaderInterface $productListReader
    ) {
        $this->productListIdsFilter = $productListIdsFilter;
        $this->productListReader = $productListReader;
    }

    /**
     * @param \Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerProductListRelationTransfer|null
     */
    public function fromRestProductListsBulkRequestAssignmentTransfer(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): ?CustomerProductListRelationTransfer {
        $restProductListsBulkRequestAssignmentCustomerTransfer = $restProductListsBulkRequestAssignmentTransfer->getCustomer();

        if ($restProductListsBulkRequestAssignmentCustomerTransfer === null) {
            return null;
        }

        $idCustomer = $restProductListsBulkRequestAssignmentCustomerTransfer->getId();

        $productListIdsToAssign = $this->productListIdsFilter->filterFromRestProductListsBulkRequestAssignmentProductLists(
            $restProductListsBulkRequestAssignmentTransfer->getProductListsToAssign(),
        );

        $productListIdsToUnassign = $this->productListIdsFilter->filterFromRestProductListsBulkRequestAssignmentProductLists(
            $restProductListsBulkRequestAssignmentTransfer->getProductListsToUnassign(),
        );

        if ($idCustomer === null || (count($productListIdsToAssign) === 0 && count($productListIdsToUnassign) === 0)) {
            return null;
        }

        $currentProductListIds = $this->productListReader->getIdsByIdCustomer($idCustomer);

        $productListIds = array_unique(array_merge($productListIdsToAssign, $currentProductListIds));
        $productListIds = array_diff($productListIds, $productListIdsToUnassign);
        $productListIds = array_values($productListIds);

        sort($productListIds);

        return (new CustomerProductListRelationTransfer())->setProductListIds($productListIds)
            ->setIdCustomer($idCustomer);
    }
}

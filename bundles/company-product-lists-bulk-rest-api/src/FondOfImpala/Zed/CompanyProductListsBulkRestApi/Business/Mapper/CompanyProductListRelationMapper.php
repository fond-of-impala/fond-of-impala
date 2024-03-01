<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\ProductListIdsFilterInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use Generated\Shared\Transfer\CompanyProductListRelationTransfer;
use Generated\Shared\Transfer\RestProductListsBulkRequestAssignmentTransfer;

class CompanyProductListRelationMapper implements CompanyProductListRelationMapperInterface
{
    protected ProductListIdsFilterInterface $productListIdsFilter;

    protected ProductListReaderInterface $productListReader;

    /**
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\ProductListIdsFilterInterface $productListIdsFilter
     * @param \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\ProductListReaderInterface $productListReader
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
     * @return \Generated\Shared\Transfer\CompanyProductListRelationTransfer|null
     */
    public function fromRestProductListsBulkRequestAssignmentTransfer(
        RestProductListsBulkRequestAssignmentTransfer $restProductListsBulkRequestAssignmentTransfer
    ): ?CompanyProductListRelationTransfer {
        $restProductListsBulkRequestAssignmentCompanyTransfer = $restProductListsBulkRequestAssignmentTransfer->getCompany();

        if ($restProductListsBulkRequestAssignmentCompanyTransfer === null) {
            return null;
        }

        $idCompany = $restProductListsBulkRequestAssignmentCompanyTransfer->getId();

        $productListIdsToAssign = $this->productListIdsFilter->filterFromRestProductListsBulkRequestAssignmentProductLists(
            $restProductListsBulkRequestAssignmentTransfer->getProductListsToAssign(),
        );

        $productListIdsToUnassign = $this->productListIdsFilter->filterFromRestProductListsBulkRequestAssignmentProductLists(
            $restProductListsBulkRequestAssignmentTransfer->getProductListsToUnassign(),
        );

        if ($idCompany === null || (count($productListIdsToAssign) === 0 && count($productListIdsToUnassign) === 0)) {
            return null;
        }

        $currentProductListIds = $this->productListReader->getIdsByIdCompany($idCompany);

        $productListIds = array_unique(array_merge($productListIdsToAssign, $currentProductListIds));
        $productListIds = array_diff($productListIds, $productListIdsToUnassign);
        $productListIds = array_values($productListIds);

        sort($productListIds);

        return (new CompanyProductListRelationTransfer())->setProductListIds($productListIds)
            ->setIdCompany($idCompany);
    }
}

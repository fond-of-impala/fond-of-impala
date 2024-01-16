<?php

namespace FondOfImpala\Zed\CollaborativeCart\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;

interface CollaborativeCartRepositoryInterface
{
    /**
     * Specification:
     * - Returns a Collection of Company Users filterd by the CompanyUserCriterriaFilterTransfer
     *
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function getCompanyUserCollectionByCompanyUserCriteriaFilterTransfer(
        CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer
    ): CompanyUserCollectionTransfer;
}

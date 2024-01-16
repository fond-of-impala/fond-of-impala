<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\CompanyBusinessUnitQuoteConnector\Persistence\CompanyBusinessUnitQuoteConnectorPersistenceFactory getFactory()
 */
class CompanyBusinessUnitQuoteConnectorRepository extends AbstractRepository implements CompanyBusinessUnitQuoteConnectorRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequest
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getActiveCompanyUserByCompanyBusinessUnitQuoteListRequest(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequest
    ): ?CompanyUserTransfer {
        $companyBusinessUnitQuoteListRequest->requireIdCustomer()
            ->requireIdCompanyBusinessUnit();

        $spyCompanyUserQuery = $this->getFactory()->getCompanyUserQuery()
            ->filterByFkCompanyBusinessUnit($companyBusinessUnitQuoteListRequest->getIdCompanyBusinessUnit())
            ->filterByFkCustomer($companyBusinessUnitQuoteListRequest->getIdCustomer())
            ->filterByIsActive(true)
            ->findOne();

        if ($spyCompanyUserQuery === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapCompanyUserEntityToCompanyUserTransfer($spyCompanyUserQuery);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequest
     *
     * @return array
     */
    public function getActiveCompanyUserReferencesByCompanyBusinessUnitQuoteListRequest(
        CompanyBusinessUnitQuoteListRequestTransfer $companyBusinessUnitQuoteListRequest
    ): array {
        $companyBusinessUnitQuoteListRequest->requireIdCompanyBusinessUnit();

        /** @var \Propel\Runtime\Collection\ArrayCollection $collection */
        $collection = $this->getFactory()
            ->getCompanyUserQuery()
            ->clear()
            ->filterByFkCompanyBusinessUnit($companyBusinessUnitQuoteListRequest->getIdCompanyBusinessUnit())
            ->filterByIsActive(true)
            ->select([SpyCompanyUserTableMap::COL_COMPANY_USER_REFERENCE])
            ->find();

        return $collection->toArray();
    }
}

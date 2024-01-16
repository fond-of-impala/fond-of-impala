<?php

namespace FondOfImpala\Zed\CollaborativeCart\Persistence;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartPersistenceFactory getFactory()
 */
class CollaborativeCartRepository extends AbstractRepository implements CollaborativeCartRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function getCompanyUserCollectionByCompanyUserCriteriaFilterTransfer(
        CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer
    ): CompanyUserCollectionTransfer {
        $queryCompanyUser = $this->getFactory()
            ->getCompanyUserQuery()
            ->joinWithCustomer()
            ->useCustomerQuery()
                ->filterByAnonymizedAt(null, Criteria::ISNULL)
            ->endUse();

        $this->applyFilters($queryCompanyUser, $criteriaFilterTransfer);

        $collection = $this->buildQueryFromCriteria($queryCompanyUser, $criteriaFilterTransfer->getFilter());
        /** @var array<\Generated\Shared\Transfer\SpyCompanyUserEntityTransfer> $companyUserCollection */
        $companyUserCollection = $this->getPaginatedCollection($collection, $criteriaFilterTransfer->getPagination());

        $collectionTransfer = $this->getFactory()
            ->createCompanyUserMapper()
            ->mapCompanyUserCollection($companyUserCollection);

        $collectionTransfer->setPagination($criteriaFilterTransfer->getPagination());

        return $collectionTransfer;
    }

    /**
     * @param \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $queryCompanyUser
     * @param \Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer
     *
     * @return void
     */
    protected function applyFilters(SpyCompanyUserQuery $queryCompanyUser, CompanyUserCriteriaFilterTransfer $criteriaFilterTransfer): void
    {
        if ($criteriaFilterTransfer->getIdCompany() !== null) {
            $queryCompanyUser->filterByFkCompany($criteriaFilterTransfer->getIdCompany());
        }

        if ($criteriaFilterTransfer->getIdCustomer() !== null) {
            $queryCompanyUser->filterByFkCustomer($criteriaFilterTransfer->getIdCustomer());
        }

        if ($criteriaFilterTransfer->getCompanyUserIds()) {
            $queryCompanyUser->filterByIdCompanyUser_In($criteriaFilterTransfer->getCompanyUserIds());
        }

        if ($criteriaFilterTransfer->getIsActive() !== null) {
            $queryCompanyUser->filterByIsActive($criteriaFilterTransfer->getIsActive());
        }
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\PaginationTransfer|null $paginationTransfer
     *
     * @return \Propel\Runtime\Collection\Collection|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function getPaginatedCollection(ModelCriteria $query, ?PaginationTransfer $paginationTransfer = null)
    {
        if ($paginationTransfer !== null) {
            $page = $paginationTransfer
                ->requirePage()
                ->getPage();

            $maxPerPage = $paginationTransfer
                ->requireMaxPerPage()
                ->getMaxPerPage();

            $paginationModel = $query->paginate($page, $maxPerPage);

            $paginationTransfer->setNbResults($paginationModel->getNbResults())
                ->setFirstIndex($paginationModel->getFirstIndex())
                ->setLastIndex($paginationModel->getLastIndex())
                ->setFirstPage($paginationModel->getFirstPage())
                ->setLastPage($paginationModel->getLastPage())
                ->setNextPage($paginationModel->getNextPage())
                ->setPreviousPage($paginationModel->getPreviousPage());

            return $paginationModel->getResults();
        }

        return $query->find();
    }
}

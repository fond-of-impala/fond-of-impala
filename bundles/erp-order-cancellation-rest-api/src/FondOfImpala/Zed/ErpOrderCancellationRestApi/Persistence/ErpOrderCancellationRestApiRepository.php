<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence;

use Exception;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Expander\QueryExpanderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiPersistenceFactory getFactory()
 */
class ErpOrderCancellationRestApiRepository extends AbstractRepository implements ErpOrderCancellationRestApiRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @throws \Exception
     *
     * @return int
     */
    public function getIdCustomerByReference(string $customerReference): int
    {
        $customer = $this->getFactory()->getCustomerQuery()->filterByCustomerReference($customerReference)->findOne();
        if ($customer === null) {
            throw new Exception(sprintf('Could not find customer by reference %s', $customerReference));
        }

        return $customer->getIdCustomer();
    }

    /**
     * @param string $mail
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getCustomerReferenceByMail(string $mail): string
    {
        $customer = $this->getFactory()->getCustomerQuery()->filterByEmail($mail)->findOne();
        if ($customer === null) {
            throw new Exception(sprintf('Could not find customer by mail %s', $mail));
        }

        return $customer->getCustomerReference();
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function findErpOrderCancellation(ErpOrderCancellationFilterTransfer $filterTransfer): ErpOrderCancellationCollectionTransfer
    {
        $query = $this->getErpOrderCancellationQuery();

        if (count($filterTransfer->getIds()) > 0) {
            $query->filterByUuid_In($filterTransfer->getIds());
        }

        $query = $this->getQueryExpander()->expandErpOrderCancellationQuery($query, $filterTransfer);

        if ($filterTransfer->getLimit()) {
            $query->limit($filterTransfer->getLimit());
        }

        if ($filterTransfer->getOffset()) {
            $query->offset($filterTransfer->getOffset());
        }

        if ($filterTransfer->getSorting() !== null) {
            foreach ($filterTransfer->getSorting() as $sort) {
                $query->orderBy($sort->getField(), $sort->getDirection());
            }
        }

        $result = $query->find();

        return $this->getFactory()->createEntityToTransferMapper()->mapEntityCollectionToTransferCollection($result);
    }

    /**
     * @param string $uuid
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByUuid(string $uuid): ?ErpOrderCancellationTransfer
    {
        $query = $this->getErpOrderCancellationQuery();
        $query->filterByUuid($uuid);

        $result = $query->findOne();

        if ($result === null) {
            return null;
        }

        return $this->getFactory()->createEntityToTransferMapper()->mapEntityToTransfer($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer
     */
    public function getErpOrderCancellationPagination(
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): ErpOrderCancellationPaginationTransfer {
        $query = $this->getErpOrderCancellationQuery();

        if (count($filterTransfer->getIds()) > 0) {
            $query->filterByUuid_In($filterTransfer->getIds());
        }

        $query = $this->getQueryExpander()->expandErpOrderCancellationQuery($query, $filterTransfer);

        $query->setOffset(0)
            ->setLimit(-1);

        $total = $query->count();
        $page = $filterTransfer->getLimit() ? ($filterTransfer->getOffset() / $filterTransfer->getLimit() + 1) : 1;
        $pageTotal = ($total && $filterTransfer->getLimit()) ? (int)ceil($total / $filterTransfer->getLimit()) : 1;
        if ($page > $pageTotal) {
            throw new NotFoundHttpException('Out of bounds.', null, 404);
        }

        return (new ErpOrderCancellationPaginationTransfer())
            ->setCurrentItemsPerPage($filterTransfer->getLimit())
            ->setCurrentPage($page)
            ->setNumFound($total)
            ->setMaxPage($pageTotal);
    }

    /**
     * @param int $idCustomer
     * @param string $debtorNumber
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function getCompanyUserByIdCustomerAndDebtorNumber(int $idCustomer, string $debtorNumber): CompanyUserTransfer
    {
        /** @var \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $query */
        $query = $this->getFactory()
            ->getCompanyUserQuery()
            ->clear()
            ->filterByFkCustomer($idCustomer)
            ->useCompanyQuery()
            ->filterByDebtorNumber($debtorNumber)
            ->endUse();

        $companyUserEntity = $query
            ->findOne();

        if ($companyUserEntity === null) {
            throw new Exception(sprintf('Could not find company user by idCustomer %s and debtorNumber %s', $idCustomer, $debtorNumber));
        }

        $companyUserTransfer = (new CompanyUserTransfer())->fromArray($companyUserEntity->toArray(), true);
        $customerTransfer = (new CustomerTransfer())->fromArray($companyUserEntity->getCustomer()->toArray(), true);
        $companyTransfer = (new CompanyTransfer())->fromArray($companyUserEntity->getCompany()->toArray(), true);
        $companyBusinessUnitTransfer = (new CompanyBusinessUnitTransfer())->fromArray($companyUserEntity->getCompanyBusinessUnit()->toArray(), true);

        return $companyUserTransfer
            ->setFkCustomer($customerTransfer->getIdCustomer())
            ->setCustomer($customerTransfer)
            ->setFkCompany($companyTransfer->getIdCompany())
            ->setCompany($companyTransfer)
            ->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit())
            ->setCompanyBusinessUnit($companyBusinessUnitTransfer);
    }

    /**
     * @param int $idCustomer
     * @param array<int> $internalCompanyIds
     * @return bool
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function isInternalCustomer(int $idCustomer, array $internalCompanyIds): bool
    {
        /** @var \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery $query */
        $query = $this->getFactory()
            ->getCompanyUserQuery()
            ->clear()
            ->filterByfkCustomer($idCustomer)
            ->useCompanyQuery()
                ->filterByFkCompanyType_In($internalCompanyIds)
            ->endUse();

        $companyUserEntity = $query
            ->findOne();

        return $companyUserEntity !== null;
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    protected function getErpOrderCancellationQuery(): FoiErpOrderCancellationQuery
    {
        return $this->getFactory()->getErpOrderCancellationQuery()->clear();
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Expander\QueryExpanderInterface
     */
    protected function getQueryExpander(): QueryExpanderInterface
    {
        return $this->getFactory()->createQueryExpander();
    }
}

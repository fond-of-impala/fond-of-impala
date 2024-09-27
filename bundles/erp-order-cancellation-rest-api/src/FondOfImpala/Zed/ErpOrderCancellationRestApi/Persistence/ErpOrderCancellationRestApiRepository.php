<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence;

use Exception;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Expander\QueryExpanderInterface;
use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Api\ApiConfig;
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
     * @return int
     * @throws \Exception
     *
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
     * @return string
     * @throws \Exception
     *
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
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function findErpOrderCancellation(ErpOrderCancellationFilterTransfer $filterTransfer): ErpOrderCancellationCollectionTransfer
    {
        $query = $this->getErpOrderCancellationQuery();

        if (count($filterTransfer->getIds()) > 0){
            $query->filterByUuid_In($filterTransfer->getIds());
        }

        $query = $this->getQueryExpander()->expandErpOrderCancellationQuery($query, $filterTransfer);

        if ($filterTransfer->getLimit()){
            $query->limit($filterTransfer->getLimit());
        }

        if ($filterTransfer->getOffset()){
            $query->offset($filterTransfer->getOffset());
        }

        if ($filterTransfer->getSorting() !== null){
            foreach ($filterTransfer->getSorting() as $sort){
                $query->orderBy($sort->getField(), $sort->getDirection());
            }
        }

        $result = $query->find();

        return $this->getFactory()->createEntityToTransferMapper()->mapEntityCollectionToTransferCollection($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $filterTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationPaginationTransfer
     */
    public function getErpOrderCancellationPagination(
        ErpOrderCancellationFilterTransfer $filterTransfer
    ): ErpOrderCancellationPaginationTransfer {
        $query = $this->getErpOrderCancellationQuery();

        if (count($filterTransfer->getIds()) > 0){
            $query->filterByUuid_In($filterTransfer->getIds());
        }

        $query = $this->getQueryExpander()->expandErpOrderCancellationQuery($query, $filterTransfer);

        $query->setOffset(0)
            ->setLimit(-1);

        $total = $query->count();
        $page = $filterTransfer->getLimit() ? ($filterTransfer->getOffset() / $filterTransfer->getLimit() + 1) : 1;
        $pageTotal = ($total && $filterTransfer->getLimit()) ? (int)ceil($total / $filterTransfer->getLimit()) : 1;
        if ($page > $pageTotal) {
            throw new NotFoundHttpException('Out of bounds.', null, ApiConfig::HTTP_CODE_NOT_FOUND);
        }
        return (new ErpOrderCancellationPaginationTransfer())
            ->setCurrentItemsPerPage($filterTransfer->getLimit())
            ->setCurrentPage($page)
            ->setNumFound($total)
            ->setMaxPage($pageTotal);
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





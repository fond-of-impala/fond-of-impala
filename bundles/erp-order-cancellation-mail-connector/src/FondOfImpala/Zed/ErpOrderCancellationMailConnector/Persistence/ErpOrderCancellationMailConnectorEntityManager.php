<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationNotifyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorPersistenceFactory getFactory()
 */
class ErpOrderCancellationMailConnectorEntityManager extends AbstractEntityManager implements ErpOrderCancellationMailConnectorEntityManagerInterface
{
    /**
     * @param int $idErpOrderCancellation
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function removeNotificationRecipientsForErpOrderCancellation(int $idErpOrderCancellation): void
    {
        $this->getFoiErpOrderCancellationNotifyQuery()
            ->filterByFkErpOrderCancellation($idErpOrderCancellation)
            ->delete();
    }

    /**
     * @param int $idErpOrderCancellation
     * @param int $idCustomer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function createNotificationChainEntry(int $idErpOrderCancellation, int $idCustomer): ErpOrderCancellationNotifyTransfer
    {
        $entity = $this->getFoiErpOrderCancellationNotifyQuery()
            ->filterByFkErpOrderCancellation($idErpOrderCancellation)
            ->filterByFkCustomer($idCustomer)
            ->findOneOrCreate();

        $entity->save();

        return $this->getFactory()->createEntityToTransferMapper()->mapErpOrderCancellationNotifyEntityToTransfer($entity);
    }

    /**
     * @param int $idErpOrderCancellation
     * @param int $idCustomer
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function deleteNotificationChainEntry(int $idErpOrderCancellation, int $idCustomer): void
    {
        $this->getFoiErpOrderCancellationNotifyQuery()
            ->filterByFkErpOrderCancellation($idErpOrderCancellation)
            ->filterByFkCustomer($idCustomer)
            ->delete();
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationNotifyQuery
     */
    protected function getFoiErpOrderCancellationNotifyQuery(): FoiErpOrderCancellationNotifyQuery
    {
        return $this->getFactory()->createFoiErpOrderCancellationNotifyQuery()->clear();
    }
}

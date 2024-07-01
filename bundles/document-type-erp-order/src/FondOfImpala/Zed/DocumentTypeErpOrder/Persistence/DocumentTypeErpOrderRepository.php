<?php

namespace FondOfImpala\Zed\DocumentTypeErpOrder\Persistence;

use FondOfOryx\Zed\ErpOrderPermission\Communication\Plugin\Permission\SeeErpOrdersPermissionPlugin;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpOrder\Persistence\DocumentTypeErpOrderPersistenceFactory getFactory()
 */
class DocumentTypeErpOrderRepository extends AbstractRepository implements DocumentTypeErpOrderRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function getErpOrder(DocumentRequestTransfer $documentRequestTransfer): ?ErpOrderTransfer
    {
        $query = $this->getFactory()->getErpOrderQuery()->clear();

        $order = $query
            ->filterByExternalReference($documentRequestTransfer->getId())
            ->useCompanyBusinessUnitQuery()
                ->useCompanyUserQuery()
                    ->useCustomerQuery()
                        ->filterByCustomerReference($documentRequestTransfer->getCustomerReference())
                    ->endUse()
                ->endUse()
            ->endUse()
            ->findOne();

        if ($order === null) {
            return null;
        }

        return (new ErpOrderTransfer())->fromArray($order->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderTransfer|null
     */
    public function getErpOrderWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpOrderTransfer
    {
        $query = $this->getFactory()->getErpOrderQuery()->clear();

        $order = $query
            ->filterByExternalReference($documentRequestTransfer->getId())
            ->useCompanyBusinessUnitQuery()
                ->useCompanyQuery()
                    ->useCompanyRoleQuery()
                        ->useSpyCompanyRoleToPermissionQuery()
                            ->usePermissionQuery()->filterByKey(SeeErpOrdersPermissionPlugin::KEY)
                            ->endUse()
                        ->endUse()
                    ->endUse()
                ->endUse()
                ->useCompanyUserQuery()
                    ->useCustomerQuery()
                        ->filterByCustomerReference($documentRequestTransfer->getCustomerReference())
                    ->endUse()
                ->endUse()
            ->endUse()
            ->findOne();

        if ($order === null) {
            return null;
        }

        return (new ErpOrderTransfer())->fromArray($order->toArray(), true);
    }
}

<?php

namespace FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence;


use FondOfOryx\Zed\ErpDeliveryNotePermission\Communication\Plugin\Permission\SeeErpDeliveryNotesPermissionPlugin;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\ErpDeliveryNoteTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpDeliveryNote\Persistence\DocumentTypeErpDeliveryNotePersistenceFactory getFactory()
 */
class DocumentTypeErpDeliveryNoteRepository extends AbstractRepository implements DocumentTypeErpDeliveryNoteRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     * @return \Generated\Shared\Transfer\ErpDeliveryNoteTransfer|null
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getErpDeliveryNoteWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpDeliveryNoteTransfer
    {
        $query = $this->getFactory()->getErpDeliveryNoteQuery()->clear();

        $deliveryNote = $query
            ->filterByDeliveryNoteNumber($documentRequestTransfer->getId())
            ->useSpyCompanyBusinessUnitQuery()
                ->useCompanyQuery()
                    ->useCompanyRoleQuery()
                        ->useSpyCompanyRoleToPermissionQuery()
                            ->usePermissionQuery()->filterByKey(SeeErpDeliveryNotesPermissionPlugin::KEY)
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

        if ($deliveryNote === null){
            return null;
        }

        return (new ErpDeliveryNoteTransfer())->fromArray($deliveryNote->toArray(), true);
    }
}

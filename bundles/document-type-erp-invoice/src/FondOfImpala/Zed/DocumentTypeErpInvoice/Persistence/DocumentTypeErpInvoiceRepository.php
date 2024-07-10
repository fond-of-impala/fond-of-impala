<?php

namespace FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence;

use FondOfOryx\Zed\ErpInvoicePermission\Communication\Plugin\Permission\SeeErpInvoicesPermissionPlugin;
use Generated\Shared\Transfer\DocumentRequestTransfer;
use Generated\Shared\Transfer\ErpInvoiceTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\DocumentTypeErpInvoice\Persistence\DocumentTypeErpInvoicePersistenceFactory getFactory()
 */
class DocumentTypeErpInvoiceRepository extends AbstractRepository implements DocumentTypeErpInvoiceRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\DocumentRequestTransfer $documentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ErpInvoiceTransfer|null
     */
    public function getErpInvoiceWithPermissionCheck(DocumentRequestTransfer $documentRequestTransfer): ?ErpInvoiceTransfer
    {
        $query = $this->getFactory()->getErpInvoiceQuery()->clear();

        $invoice = $query
            ->filterByDocumentNumber($documentRequestTransfer->getId())
            ->useSpyCompanyBusinessUnitQuery()
                ->useCompanyQuery()
                    ->useCompanyRoleQuery()
                        ->useSpyCompanyRoleToPermissionQuery()
                            ->usePermissionQuery()->filterByKey(SeeErpInvoicesPermissionPlugin::KEY)
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

        if ($invoice === null) {
            return null;
        }

        return (new ErpInvoiceTransfer())->fromArray($invoice->toArray(), true);
    }
}

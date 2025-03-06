<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\RestFilterExpander;

use FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface;
use FondOfImpala\Zed\PermissionErpOrderCancellationRestApi\Communication\Plugin\PermissionExtension\SeeAllErpOrderCancellationPermissionPlugin;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiCommunicationFactory getFactory()
 */
class CustomerReferenceRestFilterToFilterMapperExpanderPlugin extends AbstractPlugin implements ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer
     * @param \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationFilterTransfer
     */
    public function expand(
        RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer,
        ErpOrderCancellationFilterTransfer $erpOrderCancellationFilterTransfer
    ): ErpOrderCancellationFilterTransfer {
        if ($this->canSeeAllErpOrderCancellation($restErpOrderCancellationFilterTransfer)) {
             return $erpOrderCancellationFilterTransfer;
        }

        if ($restErpOrderCancellationFilterTransfer->getCustomerReference() === null) {
            return $erpOrderCancellationFilterTransfer;
        }

        $customerTransfer = $this->getFactory()
            ->getCustomerFacade()
            ->findByReference($restErpOrderCancellationFilterTransfer->getCustomerReference());

        if (!$customerTransfer) {
            return $erpOrderCancellationFilterTransfer;
        }

        return $erpOrderCancellationFilterTransfer->setFkCustomer($customerTransfer->getIdCustomer());
    }

    /**
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer
     *
     * @return bool
     */
    private function canSeeAllErpOrderCancellation(
        RestErpOrderCancellationFilterTransfer $restErpOrderCancellationFilterTransfer
    ): bool {
        if ($restErpOrderCancellationFilterTransfer->getCompanyUserReference() === null) {
            return false;
        }

        $companyUserResponseTransfer = $this->getFactory()
            ->getCompanyUserReferenceFacade()
            ->findCompanyUserByCompanyUserReference(
                (new CompanyUserTransfer())
                    ->setCompanyUserReference($restErpOrderCancellationFilterTransfer->getCompanyUserReference()),
            );

        if (
            $companyUserResponseTransfer->getIsSuccessful() === true
            && $this->getFactory()->getPermissionFacade()
                ->can(SeeAllErpOrderCancellationPermissionPlugin::KEY, $companyUserResponseTransfer->getCompanyUser()->getIdCompanyUser())
        ) {
            return true;
        }

        return false;
    }
}

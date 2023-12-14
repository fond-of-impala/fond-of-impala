<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Communication\Plugin\JellyfishB2BExtension;

use FondOfImpala\Zed\JellyfishB2BExtension\Dependency\Plugin\EventEntityTransferExportValidatorPluginInterface;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig getConfig()
 */
class CompanyTypeRoleEventEntityTransferExportValidatorPluginInterface extends AbstractPlugin implements EventEntityTransferExportValidatorPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer $transfer
     *
     * @return bool
     */
    public function validate(EventEntityTransfer $transfer): bool
    {
        return $this->getFacade()->validateCompanyTypeRoleForExport($transfer);
    }
}

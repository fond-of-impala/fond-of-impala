<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\WebUiSettingsCustomerConnectorRepositoryInterface getRepository()
 */
class WebUiSettingsCustomerTransferExpanderPlugin extends AbstractPlugin implements CustomerTransferExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function expandTransfer(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        if ($customerTransfer->getFkWebUiSettings() !== null && $customerTransfer->getWebUiSettings() === null) {
            $customerTransfer->setWebUiSettings($this->getRepository()->findWebUiSettingsByIdCustomer($customerTransfer->getIdCustomer()));
        }

        return $customerTransfer;
    }
}

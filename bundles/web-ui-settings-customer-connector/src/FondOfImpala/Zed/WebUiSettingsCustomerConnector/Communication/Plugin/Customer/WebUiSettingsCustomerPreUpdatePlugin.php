<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\CustomerExtension\Dependency\Plugin\CustomerPreUpdatePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\WebUiSettingsCustomerConnectorFacadeInterface getFacade()
 */
class WebUiSettingsCustomerPreUpdatePlugin extends AbstractPlugin implements CustomerPreUpdatePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function execute(CustomerTransfer $customerTransfer): void
    {
        $this->getFacade()->handleWebUiSettings($customerTransfer);
    }
}

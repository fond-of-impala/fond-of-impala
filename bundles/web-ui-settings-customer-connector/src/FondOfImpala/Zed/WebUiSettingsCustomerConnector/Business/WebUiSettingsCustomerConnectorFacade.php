<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\WebUiSettingsCustomerConnectorBusinessFactory getFactory()
 */
class WebUiSettingsCustomerConnectorFacade extends AbstractFacade implements WebUiSettingsCustomerConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function handleWebUiSettings(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->getFactory()->createWebUiSettingsManager()->handleCustomerWebUiSettings($customerTransfer);
    }
}

<?php

namespace FondOfImpala\Zed\CustomerAppRestApi\Communication\Plugin\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use JsonException;
use Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CustomerAppRestApi\Communication\CustomerAppRestApiCommunicationFactory getFactory()
 */
class CustomerAppSettingsCustomerTransferExpanderPlugin extends AbstractPlugin implements CustomerTransferExpanderPluginInterface
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
        $appSettings = $customerTransfer->getAppSettings();

        if ($appSettings !== null){
            try {
                $customerTransfer->setAppSettingsData(json_decode($appSettings, true, 512, JSON_THROW_ON_ERROR));
            } catch (JsonException $e) {
                $this->getFactory()->getLogger()->error(sprintf('Could not decode app settings: %s', $e->getMessage()), $e->getTrace());
            }
        }

        return $customerTransfer;
    }
}

<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\Manager;

use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade\WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\WebUiSettingsCustomerConnectorRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;

class WebUiSettingsManager implements WebUiSettingsManagerInterface
{
    protected WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface $webUiSettingsFacade;

    protected WebUiSettingsCustomerConnectorRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade\WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface $webUiSettingsFacade
     * @param \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\WebUiSettingsCustomerConnectorRepositoryInterface $repository
     */
    public function __construct(
        WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface $webUiSettingsFacade,
        WebUiSettingsCustomerConnectorRepositoryInterface $repository
    ) {
        $this->webUiSettingsFacade = $webUiSettingsFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer|null $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function handleCustomerWebUiSettings(
        CustomerTransfer $customerTransfer,
        ?WebUiSettingsTransfer $webUiSettingsTransfer = null
    ): CustomerTransfer {
        if ($webUiSettingsTransfer === null && $customerTransfer->getWebUiSettings() === null) {
            return $customerTransfer;
        }

        if ($webUiSettingsTransfer === null) {
            $webUiSettingsTransfer = $customerTransfer->getWebUiSettings();
        }

        $settingsTransfer = $this->repository->findWebUiSettingsByIdCustomer($customerTransfer->getIdCustomer());

        if ($settingsTransfer === null) {
            $settingsTransfer = $this->webUiSettingsFacade->handleWebUiSettings($webUiSettingsTransfer);

            return $customerTransfer
                ->setWebUiSettings($settingsTransfer)
                ->setFkWebUiSettings($settingsTransfer->getIdWebUiSettings());
        }

        $id = $settingsTransfer->getIdWebUiSettings();
        $settingsTransfer->fromArray($webUiSettingsTransfer->modifiedToArray(), true)->setIdWebUiSettings($id);

        return $customerTransfer
            ->setFkWebUiSettings($id)
            ->setWebUiSettings($this->webUiSettingsFacade->handleWebUiSettings($settingsTransfer));
    }
}

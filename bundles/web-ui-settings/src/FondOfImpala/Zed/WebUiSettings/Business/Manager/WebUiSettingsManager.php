<?php

namespace FondOfImpala\Zed\WebUiSettings\Business\Manager;

use FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsEntityManagerInterface;
use FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;

class WebUiSettingsManager implements WebUiSettingsManagerInterface
{
    protected WebUiSettingsEntityManagerInterface $entityManager;

    protected WebUiSettingsRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsEntityManagerInterface $entityManager
     * @param \FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsRepositoryInterface $repository
     */
    public function __construct(WebUiSettingsEntityManagerInterface $entityManager, WebUiSettingsRepositoryInterface $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer|null $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function handleCustomerWebUiSettings(CustomerTransfer $customerTransfer, ?WebUiSettingsTransfer $webUiSettingsTransfer = null): CustomerTransfer
    {
        if ($webUiSettingsTransfer === null && $customerTransfer->getWebUiSettings() === null) {
            return $customerTransfer;
        }

        if ($webUiSettingsTransfer === null) {
            $webUiSettingsTransfer = $customerTransfer->getWebUiSettings();
        }

        $settingsTransfer = $this->repository->findWebUiSettingsByIdCustomer($customerTransfer->getIdCustomer());

        if ($settingsTransfer === null) {
            $settingsTransfer = $this->entityManager->createWebUiSettings($webUiSettingsTransfer);

            return $customerTransfer
                ->setWebUiSettings($settingsTransfer)
                ->setFkWebUiSettings($settingsTransfer->getIdWebUiSettings());
        }

        $id = $settingsTransfer->getIdWebUiSettings();
        $settingsTransfer->fromArray($webUiSettingsTransfer->modifiedToArray(), true)->setIdWebUiSettings($id);

        return $customerTransfer
            ->setFkWebUiSettings($id)
            ->setWebUiSettings($this->entityManager->updateWebUiSettingsById($settingsTransfer));
    }
}

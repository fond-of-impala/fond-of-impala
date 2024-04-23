<?php

namespace FondOfImpala\Zed\WebUiSettings\Business\Manager;

use FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsEntityManagerInterface;
use Generated\Shared\Transfer\WebUiSettingsTransfer;

class WebUiSettingsManager implements WebUiSettingsManagerInterface
{
    protected WebUiSettingsEntityManagerInterface $entityManager;

    /**
     * @param \FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsEntityManagerInterface $entityManager
     */
    public function __construct(WebUiSettingsEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function handle(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer
    {
        if ($webUiSettingsTransfer->getIdWebUiSettings() === null) {
            return $this->entityManager->createWebUiSettings($webUiSettingsTransfer);
        }

        return $this->entityManager->updateWebUiSettingsById($webUiSettingsTransfer);
    }
}

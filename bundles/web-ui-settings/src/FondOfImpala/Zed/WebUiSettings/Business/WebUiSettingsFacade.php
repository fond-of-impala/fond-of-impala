<?php

namespace FondOfImpala\Zed\WebUiSettings\Business;

use Generated\Shared\Transfer\WebUiSettingsTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\WebUiSettings\Business\WebUiSettingsBusinessFactory getFactory()
 */
class WebUiSettingsFacade extends AbstractFacade implements WebUiSettingsFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function handleWebUiSettings(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer
    {
        return $this->getFactory()->createWebUiSettingsManager()->handle($webUiSettingsTransfer);
    }
}

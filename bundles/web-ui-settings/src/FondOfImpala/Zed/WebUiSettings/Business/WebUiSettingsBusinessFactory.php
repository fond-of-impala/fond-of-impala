<?php

namespace FondOfImpala\Zed\WebUiSettings\Business;

use FondOfImpala\Zed\WebUiSettings\Business\Manager\WebUiSettingsManager;
use FondOfImpala\Zed\WebUiSettings\Business\Manager\WebUiSettingsManagerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\WebUiSettings\Persistence\WebUiSettingsEntityManagerInterface getEntityManager()
 */
class WebUiSettingsBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\WebUiSettings\Business\Manager\WebUiSettingsManagerInterface
     */
    public function createWebUiSettingsManager(): WebUiSettingsManagerInterface
    {
        return new WebUiSettingsManager(
            $this->getEntityManager(),
        );
    }
}

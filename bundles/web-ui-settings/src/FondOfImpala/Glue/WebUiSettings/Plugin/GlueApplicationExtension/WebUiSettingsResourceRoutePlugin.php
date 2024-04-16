<?php

namespace FondOfImpala\Glue\WebUiSettings\Plugin\GlueApplicationExtension;

use FondOfImpala\Glue\WebUiSettings\WebUiSettingsConfig;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class WebUiSettingsResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(
        ResourceRouteCollectionInterface $resourceRouteCollection
    ): ResourceRouteCollectionInterface {
        return $resourceRouteCollection
            ->addPatch(WebUiSettingsConfig::ACTION_WEB_UI_SETTINGS_PATCH, true);
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return WebUiSettingsConfig::RESOURCE_WEB_UI_SETTINGS;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return WebUiSettingsConfig::CONTROLLER_WEB_UI_SETTINGS;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestWebUiSettingsRequestAttributesTransfer::class;
    }
}

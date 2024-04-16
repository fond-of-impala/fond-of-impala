<?php

namespace FondOfImpala\Glue\WebUiSettings\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\WebUiSettings\WebUiSettingsConfig;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class WebUiSettingsResourceRoutePluginTest extends Unit
{
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionMock;

    protected MockObject|RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransferMock;

    protected WebUiSettingsResourceRoutePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restWebUiSettingsRequestAttributesTransferMock = $this->getMockBuilder(RestWebUiSettingsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new WebUiSettingsResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects(static::atLeastOnce())
            ->method('addPatch')
            ->willReturnSelf();

        $this->plugin->configure($this->resourceRouteCollectionMock);
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        static::assertEquals(WebUiSettingsConfig::RESOURCE_WEB_UI_SETTINGS, $this->plugin->getResourceType());
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(WebUiSettingsConfig::CONTROLLER_WEB_UI_SETTINGS, $this->plugin->getController());
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(RestWebUiSettingsRequestAttributesTransfer::class, $this->plugin->getResourceAttributesClassName());
    }
}

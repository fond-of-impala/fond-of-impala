<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiConfig;
use Generated\Shared\Transfer\RestPriceListAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class PriceListResourceRoutePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionMock;

    /**
     * @var \FondOfImpala\Glue\PriceListsRestApi\Plugin\GlueApplicationExtension\PriceListResourceRoutePlugin
     */
    protected PriceListResourceRoutePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new PriceListResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects(static::atLeastOnce())
            ->method('addGet')
            ->with(
                PriceListsRestApiConfig::ACTION_PRICE_LISTS_GET,
                true,
            )->willReturn($this->resourceRouteCollectionMock);

        static::assertEquals(
            $this->resourceRouteCollectionMock,
            $this->plugin->configure(
                $this->resourceRouteCollectionMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        static::assertEquals(
            PriceListsRestApiConfig::RESOURCE_PRICE_LISTS,
            $this->plugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(
            PriceListsRestApiConfig::CONTROLLER_PRICE_LISTS,
            $this->plugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(
            RestPriceListAttributesTransfer::class,
            $this->plugin->getResourceAttributesClassName(),
        );
    }
}

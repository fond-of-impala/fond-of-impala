<?php

namespace FondOfImpala\Glue\ProductListsBulkRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ProductListsBulkRestApi\ProductListsBulkRestApiConfig;
use Generated\Shared\Transfer\RestProductListsBulkRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class ProductListsBulkResourceRoutePluginTest extends Unit
{
    protected ResourceRouteCollectionInterface|MockObject $resourceRouteCollectionMock;

    protected ProductListsBulkResourceRoutePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductListsBulkResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects(static::atLeastOnce())
            ->method('addPost')
            ->with('post', true)
            ->willReturnSelf();

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
            ProductListsBulkRestApiConfig::RESOURCE_PRODUCT_LISTS_BULK,
            $this->plugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(
            ProductListsBulkRestApiConfig::CONTROLLER_PRODUCT_LISTS_BULK,
            $this->plugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(
            RestProductListsBulkRequestAttributesTransfer::class,
            $this->plugin->getResourceAttributesClassName(),
        );
    }
}

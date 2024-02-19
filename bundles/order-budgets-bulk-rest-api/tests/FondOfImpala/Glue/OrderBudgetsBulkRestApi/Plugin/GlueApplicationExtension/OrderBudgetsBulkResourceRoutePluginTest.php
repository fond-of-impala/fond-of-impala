<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiConfig;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class OrderBudgetsBulkResourceRoutePluginTest extends Unit
{
    protected ResourceRouteCollectionInterface|MockObject $resourceRouteCollectionMock;

    protected OrderBudgetsBulkResourceRoutePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new OrderBudgetsBulkResourceRoutePlugin();
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
            OrderBudgetsBulkRestApiConfig::RESOURCE_ORDER_BUDGETS_BULK,
            $this->plugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(
            OrderBudgetsBulkRestApiConfig::CONTROLLER_ORDER_BUDGETS_BULK,
            $this->plugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(
            RestOrderBudgetsBulkRequestAttributesTransfer::class,
            $this->plugin->getResourceAttributesClassName(),
        );
    }
}

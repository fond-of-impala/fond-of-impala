<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiConfig;
use Generated\Shared\Transfer\RestConditionalAvailabilityPageSearchRequestTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class ConditionalAvailabilityPageSearchResourcePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Plugin\GlueApplicationExtension\ConditionalAvailabilityPageSearchResourcePlugin
     */
    protected $conditionalAvailabilityPageSearchResourcePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionInterfaceMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchResourcePlugin = new ConditionalAvailabilityPageSearchResourcePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addGet')
            ->with('get')
            ->willReturnSelf();

        $this->assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->conditionalAvailabilityPageSearchResourcePlugin->configure(
                $this->resourceRouteCollectionInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertSame(
            ConditionalAvailabilityPageSearchRestApiConfig::RESOURCE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH,
            $this->conditionalAvailabilityPageSearchResourcePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(
            ConditionalAvailabilityPageSearchRestApiConfig::CONTROLLER_RESOURCE_CONDITIONAL_AVAILABILITY_PAGE_SEARCH,
            $this->conditionalAvailabilityPageSearchResourcePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(
            RestConditionalAvailabilityPageSearchRequestTransfer::class,
            $this->conditionalAvailabilityPageSearchResourcePlugin->getResourceAttributesClassName(),
        );
    }
}

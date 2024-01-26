<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Plugin;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiConfig;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Plugin\GlueApplication\CollaborativeCartsResourceRoutePlugin;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CollaborativeCartsResourceRoutePluginTest extends Unit
{
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionMock;

    protected CollaborativeCartsResourceRoutePlugin $collaborativeCartsResourceRoutePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsResourceRoutePlugin = new CollaborativeCartsResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        static::assertEquals(
            CollaborativeCartsRestApiConfig::RESOURCE_COLLABORATIVE_CARTS,
            $this->collaborativeCartsResourceRoutePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects(static::atLeastOnce())
            ->method('addPost')
            ->with('post')
            ->willReturn($this->resourceRouteCollectionMock);

        static::assertEquals(
            $this->resourceRouteCollectionMock,
            $this->collaborativeCartsResourceRoutePlugin->configure($this->resourceRouteCollectionMock),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(
            CollaborativeCartsRestApiConfig::CONTROLLER_COLLABORATIVE_CARTS,
            $this->collaborativeCartsResourceRoutePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(
            RestCollaborativeCartsRequestAttributesTransfer::class,
            $this->collaborativeCartsResourceRoutePlugin->getResourceAttributesClassName(),
        );
    }
}

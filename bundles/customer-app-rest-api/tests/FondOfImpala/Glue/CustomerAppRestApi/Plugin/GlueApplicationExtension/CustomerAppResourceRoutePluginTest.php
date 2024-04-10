<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CustomerAppRestApi\CustomerAppRestApiConfig;
use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CustomerAppResourceRoutePluginTest extends Unit
{
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionMock;

    protected MockObject|RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransferMock;

    protected CustomerAppResourceRoutePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerAppRequestAttributesTransferMock = $this->getMockBuilder(RestCustomerAppRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CustomerAppResourceRoutePlugin();
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
        static::assertEquals(CustomerAppRestApiConfig::RESOURCE_CUSTOMER_APP, $this->plugin->getResourceType());
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(CustomerAppRestApiConfig::CONTROLLER_CUSTOMER_APP, $this->plugin->getController());
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(RestCustomerAppRequestAttributesTransfer::class, $this->plugin->getResourceAttributesClassName());
    }
}

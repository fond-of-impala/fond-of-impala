<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi\Plugin\ResourceRoute;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use Generated\Shared\Transfer\RestCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CompanyUserCartsResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUserCartsRestApi\Plugin\ResourceRoute\CompanyUserCartsResourceRoutePlugin
     */
    protected $companyUserCartsResourceRoutePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resourceRouteCollectionInterfaceMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCartsResourceRoutePlugin = new CompanyUserCartsResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addGet')
            ->with('get')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addPost')
            ->with('post')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addPatch')
            ->with('patch')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addDelete')
            ->with('delete')
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->assertInstanceOf(ResourceRouteCollectionInterface::class, $this->companyUserCartsResourceRoutePlugin->configure($this->resourceRouteCollectionInterfaceMock));
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertSame(CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USER_CARTS, $this->companyUserCartsResourceRoutePlugin->getResourceType());
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(CompanyUserCartsRestApiConfig::CONTROLLER_CARTS, $this->companyUserCartsResourceRoutePlugin->getController());
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(RestCartsRequestAttributesTransfer::class, $this->companyUserCartsResourceRoutePlugin->getResourceAttributesClassName());
    }

    /**
     * @return void
     */
    public function testGetParentResourceType(): void
    {
        $this->assertSame(CompanyUserCartsRestApiConfig::RESOURCE_COMPANY_USERS, $this->companyUserCartsResourceRoutePlugin->getParentResourceType());
    }
}

<?php

namespace FondOfImpala\Glue\CompanyUsersRestApi\Plugin;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CompanyUsersResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CompanyUsersRestApi\Plugin\CompanyUsersResourceRoutePlugin
     */
    protected $companyUsersResourceRoutePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsersResourceRoutePlugin = new CompanyUsersResourceRoutePlugin();
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

        $this->resourceRouteCollectionMock->expects(static::atLeastOnce())
            ->method('addPatch')
            ->with('patch')
            ->willReturn($this->resourceRouteCollectionMock);

        $this->resourceRouteCollectionMock->expects(static::atLeastOnce())
            ->method('addGet')
            ->with('get')
            ->willReturn($this->resourceRouteCollectionMock);

        $this->resourceRouteCollectionMock->expects(static::atLeastOnce())
            ->method('addDelete')
            ->with('delete')
            ->willReturn($this->resourceRouteCollectionMock);

        static::assertEquals(
            $this->resourceRouteCollectionMock,
            $this->companyUsersResourceRoutePlugin->configure(
                $this->resourceRouteCollectionMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertSame(
            CompanyUsersRestApiConfig::RESOURCE_COMPANY_USERS,
            $this->companyUsersResourceRoutePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(
            CompanyUsersRestApiConfig::CONTROLLER_COMPANY_USERS,
            $this->companyUsersResourceRoutePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(
            RestCompanyUsersRequestAttributesTransfer::class,
            $this->companyUsersResourceRoutePlugin->getResourceAttributesClassName(),
        );
    }
}

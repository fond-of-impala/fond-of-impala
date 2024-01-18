<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiConfig;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CompanyBusinessUnitsCartsResourceRoutePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Plugin\GlueApplicationExtension\CompanyBusinessUnitsCartsResourceRoutePlugin
     */
    protected $companyBusinessUnitsCartsResourceRoutePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resourceRouteCollectionMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsCartsResourceRoutePlugin = new CompanyBusinessUnitsCartsResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        self::assertEquals(
            CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_COMPANY_BUSINESS_UNIT_CARTS,
            $this->companyBusinessUnitsCartsResourceRoutePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects(self::atLeastOnce())
            ->method('addGet')
            ->with('get');

        self::assertEquals(
            $this->resourceRouteCollectionMock,
            $this->companyBusinessUnitsCartsResourceRoutePlugin->configure($this->resourceRouteCollectionMock),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        self::assertEquals(
            CompanyBusinessUnitsCartsRestApiConfig::CONTROLLER_COMPANY_BUSINESS_UNITS_CARTS,
            $this->companyBusinessUnitsCartsResourceRoutePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        self::assertEquals(
            RestCartsAttributesTransfer::class,
            $this->companyBusinessUnitsCartsResourceRoutePlugin->getResourceAttributesClassName(),
        );
    }

    /**
     * @return void
     */
    public function testGetParentResourceType(): void
    {
        self::assertEquals(
            CompanyBusinessUnitsCartsRestApiConfig::PARENT_RESOURCE_COMPANY_BUSINESS_UNITS,
            $this->companyBusinessUnitsCartsResourceRoutePlugin->getParentResourceType(),
        );
    }
}

<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiConfig;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class PriceProductAbstractPriceListSearchResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Plugin\GlueApplicationExtension\PriceProductAbstractPriceListSearchResourceRoutePlugin
     */
    protected PriceProductAbstractPriceListSearchResourceRoutePlugin $priceProductAbstractPriceListSearchResourceRoutePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionInterfaceMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductAbstractPriceListSearchResourceRoutePlugin = new PriceProductAbstractPriceListSearchResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionInterfaceMock->expects(static::atLeastOnce())
            ->method('addGet')
            ->with('get', true)
            ->willReturnSelf();

        static::assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->priceProductAbstractPriceListSearchResourceRoutePlugin->configure(
                $this->resourceRouteCollectionInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        static::assertSame(
            PriceProductPriceListSearchRestApiConfig::RESOURCE_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH,
            $this->priceProductAbstractPriceListSearchResourceRoutePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertSame(
            PriceProductPriceListSearchRestApiConfig::CONTROLLER_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH,
            $this->priceProductAbstractPriceListSearchResourceRoutePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertSame(
            RestPriceProductPriceListSearchAttributesTransfer::class,
            $this->priceProductAbstractPriceListSearchResourceRoutePlugin->getResourceAttributesClassName(),
        );
    }
}

<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Plugin\GlueApplicationExtension;

use Codeception\Test\Unit;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiConfig;
use Generated\Shared\Transfer\RestPriceProductPriceListSearchAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class PriceProductConcretePriceListSearchResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Plugin\GlueApplicationExtension\PriceProductConcretePriceListSearchResourceRoutePlugin
     */
    protected PriceProductConcretePriceListSearchResourceRoutePlugin $priceProductConcretePriceListSearchResourceRoutePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionTransferMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductConcretePriceListSearchResourceRoutePlugin = new PriceProductConcretePriceListSearchResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionTransferMock->expects(static::atLeastOnce())
            ->method('addGet')
            ->with('get', true)
            ->willReturnSelf();

        static::assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->priceProductConcretePriceListSearchResourceRoutePlugin->configure(
                $this->resourceRouteCollectionTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        static::assertSame(
            PriceProductPriceListSearchRestApiConfig::RESOURCE_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH,
            $this->priceProductConcretePriceListSearchResourceRoutePlugin->getResourceType(),
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertSame(
            PriceProductPriceListSearchRestApiConfig::CONTROLLER_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH,
            $this->priceProductConcretePriceListSearchResourceRoutePlugin->getController(),
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertSame(
            RestPriceProductPriceListSearchAttributesTransfer::class,
            $this->priceProductConcretePriceListSearchResourceRoutePlugin->getResourceAttributesClassName(),
        );
    }
}

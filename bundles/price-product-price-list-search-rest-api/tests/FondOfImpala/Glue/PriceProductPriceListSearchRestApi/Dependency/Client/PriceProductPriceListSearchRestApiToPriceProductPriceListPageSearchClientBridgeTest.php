<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchClientInterface;

class PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge
     */
    protected $priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchClientInterface
     */
    protected $priceProductPriceListPageSearchClientInterfaceMock;

    /**
     * @var string
     */
    protected $searchString;

    /**
     * @var array
     */
    protected $requestParameters;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceProductPriceListPageSearchClientInterfaceMock = $this->getMockBuilder(PriceProductPriceListPageSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchString = 'search-string';

        $this->requestParameters = [];

        $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge
            = new PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge(
                $this->priceProductPriceListPageSearchClientInterfaceMock,
            );
    }

    /**
     * @return void
     */
    public function testSearchAbstract(): void
    {
        $this->priceProductPriceListPageSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('searchAbstract')
            ->with($this->searchString, $this->requestParameters)
            ->willReturn([]);

        $this->assertIsArray(
            $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge->searchAbstract(
                $this->searchString,
                $this->requestParameters,
            ),
        );
    }

    /**
     * @return void
     */
    public function testSearchConcrete(): void
    {
        $this->priceProductPriceListPageSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('searchConcrete')
            ->with($this->searchString, $this->requestParameters)
            ->willReturn([]);

        $this->assertIsArray(
            $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge->searchConcrete(
                $this->searchString,
                $this->requestParameters,
            ),
        );
    }
}

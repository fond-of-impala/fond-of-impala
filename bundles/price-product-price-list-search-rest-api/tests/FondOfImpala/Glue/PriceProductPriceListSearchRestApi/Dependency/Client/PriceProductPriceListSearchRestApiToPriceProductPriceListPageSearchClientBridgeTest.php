<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchClientInterface;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge
     */
    protected PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge $priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchClientInterface
     */
    protected MockObject|PriceProductPriceListPageSearchClientInterface $priceProductPriceListPageSearchClientInterfaceMock;

    /**
     * @var string
     */
    protected string $searchString;

    /**
     * @var array
     */
    protected array $requestParameters;

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
        $this->priceProductPriceListPageSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('searchAbstract')
            ->with($this->searchString, $this->requestParameters)
            ->willReturn([]);

        static::assertIsArray(
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
        $this->priceProductPriceListPageSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('searchConcrete')
            ->with($this->searchString, $this->requestParameters)
            ->willReturn([]);

        static::assertIsArray(
            $this->priceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge->searchConcrete(
                $this->searchString,
                $this->requestParameters,
            ),
        );
    }
}

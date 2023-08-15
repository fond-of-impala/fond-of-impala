<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service;

use PHPUnit\Framework\MockObject\MockObject;
use Codeception\Test\Unit;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;

class PriceProductPriceListPageSearchToUtilEncodingServiceBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Service\PriceProductPriceListPageSearchToUtilEncodingServiceBridge
     */
    protected $priceProductPriceListPageSearchToUtilEncodingServiceBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\UtilEncoding\UtilEncodingServiceInterface
     */
    private MockObject|UtilEncodingServiceInterface $utilEncodingServiceInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->utilEncodingServiceInterfaceMock = $this->getMockBuilder(UtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchToUtilEncodingServiceBridge = new PriceProductPriceListPageSearchToUtilEncodingServiceBridge($this->utilEncodingServiceInterfaceMock);
    }

    /**
     * @return void
     */
    public function testEncodeJson(): void
    {
        $this->utilEncodingServiceInterfaceMock->expects($this->atLeastOnce())
            ->method('encodeJson')
            ->willReturn('{id: hi}');

        $this->assertSame('{id: hi}', $this->priceProductPriceListPageSearchToUtilEncodingServiceBridge->encodeJson('{id: hi}'));
    }

    /**
     * @return void
     */
    public function testDecodeJson(): void
    {
        $this->utilEncodingServiceInterfaceMock->expects($this->atLeastOnce())
            ->method('decodeJson')
            ->willReturn([]);

        $this->assertIsArray($this->priceProductPriceListPageSearchToUtilEncodingServiceBridge->decodeJson('{id: hi}'));
    }
}

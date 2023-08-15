<?php

namespace FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade;
use FondOfImpala\Zed\PriceListApi\PriceListApiConfig;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListApiValidatorPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api\PriceListApiValidatorPlugin
     */
    protected PriceListApiValidatorPlugin $priceListApiValidatorPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade
     */
    protected MockObject|PriceListApiFacade $priceListApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceListApiFacadeMock = $this->getMockBuilder(PriceListApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListApiValidatorPlugin = new PriceListApiValidatorPlugin();

        $this->priceListApiValidatorPlugin->setFacade($this->priceListApiFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetResourceName(): void
    {
        static::assertSame(PriceListApiConfig::RESOURCE_PRICE_LISTS, $this->priceListApiValidatorPlugin->getResourceName());
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        static::assertIsArray($this->priceListApiValidatorPlugin->validate($this->apiRequestTransferMock));
    }
}

<?php

namespace FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade;
use FondOfImpala\Zed\PriceListApi\PriceListApiConfig;
use Generated\Shared\Transfer\ApiRequestTransfer;

class PriceListApiValidatorPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\PriceListApi\Communication\Plugin\Api\PriceListApiValidatorPlugin
     */
    protected $priceListApiValidatorPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceListApi\Business\PriceListApiFacade
     */
    protected $priceListApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

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
        $this->assertSame(PriceListApiConfig::RESOURCE_PRICE_LISTS, $this->priceListApiValidatorPlugin->getResourceName());
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->assertIsArray($this->priceListApiValidatorPlugin->validate($this->apiRequestTransferMock));
    }
}

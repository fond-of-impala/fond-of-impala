<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiFacade;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationApiValidatorPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationApi\Business\ErpOrderCancellationApiFacade
     */
    protected MockObject|ErpOrderCancellationApiFacade $facadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected MockObject|ApiRequestTransfer $apiRequestTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationApi\Communication\Plugin\Api\ErpOrderCancellationApiValidatorPlugin
     */
    protected ErpOrderCancellationApiValidatorPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiRequestTransferMock = $this
            ->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this
            ->getMockBuilder(ErpOrderCancellationApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ErpOrderCancellationApiValidatorPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGetResourceName(): void
    {
        static::assertIsString($this->plugin->getResourceName());
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('validateErpOrderCancellation')
            ->with($this->apiRequestTransferMock)
            ->willReturn([]);

        static::assertIsArray($this->plugin->validate($this->apiRequestTransferMock));
    }
}

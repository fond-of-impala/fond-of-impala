<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Business\BusinessCentralProductListsBulkRestApiFacade;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class BusinessCentralRestProductListsBulkRequestExpanderPluginTest extends Unit
{
    protected BusinessCentralProductListsBulkRestApiFacade|MockObject $facadeMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected BusinessCentralRestProductListsBulkRequestExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(BusinessCentralProductListsBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new BusinessCentralRestProductListsBulkRequestExpanderPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('expandRestProductListsBulkRequest')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkRequestTransferMock);

        static::assertEquals(
            $this->restProductListsBulkRequestTransferMock,
            $this->plugin->expand($this->restProductListsBulkRequestTransferMock),
        );
    }
}

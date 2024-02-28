<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Communication\Plugin\ProductListsBulkRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\CustomerProductListsBulkRestApiFacade;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerRestProductListsBulkRequestExpanderPluginTest extends Unit
{
    protected CustomerProductListsBulkRestApiFacade|MockObject $facadeMock;

    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    protected CustomerRestProductListsBulkRequestExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CustomerProductListsBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CustomerRestProductListsBulkRequestExpanderPlugin();
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

<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Communication\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\ProductListsBulkRestApiFacade;
use Generated\Shared\Transfer\RestProductListsBulkRequestTransfer;
use Generated\Shared\Transfer\RestProductListsBulkResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class GatewayControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ProductListsBulkRestApi\Business\ProductListsBulkRestApiFacade
     */
    protected MockObject|ProductListsBulkRestApiFacade $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ProductListsBulkRestApi\Communication\Controller\GatewayController
     */
    protected GatewayController $gatewayController;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestProductListsBulkRequestTransfer
     */
    protected MockObject|RestProductListsBulkRequestTransfer $restProductListsBulkRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestProductListsBulkResponseTransfer
     */
    protected MockObject|RestProductListsBulkResponseTransfer $restProductListsBulkResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ProductListsBulkRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkRequestTransferMock = $this
            ->getMockBuilder(RestProductListsBulkRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductListsBulkResponseTransferMock = $this
            ->getMockBuilder(RestProductListsBulkResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->facadeMock) extends GatewayController {
            /**
             * @var \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected AbstractFacade $productListsBulkRestApiFacade;

            /**
             * @param \Spryker\Zed\Kernel\Business\AbstractFacade $facade
             */
            public function __construct(AbstractFacade $facade)
            {
                $this->productListsBulkRestApiFacade = $facade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->productListsBulkRestApiFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testBulkProcessAction(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('bulkProcess')
            ->with($this->restProductListsBulkRequestTransferMock)
            ->willReturn($this->restProductListsBulkResponseTransferMock);

        static::assertEquals(
            $this->restProductListsBulkResponseTransferMock,
            $this->gatewayController->bulkProcessAction($this->restProductListsBulkRequestTransferMock),
        );
    }
}

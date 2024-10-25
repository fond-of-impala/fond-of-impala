<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiFacade;
use Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class GatewayControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiFacade
     */
    protected MockObject|ErpOrderCancellationRestApiFacade $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Controller\GatewayController
     */
    protected GatewayController $gatewayController;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer
     */
    protected MockObject|RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationResponseTransfer
     */
    protected MockObject|RestErpOrderCancellationResponseTransfer $restErpOrderCancellationResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErpOrderCancellationCollectionResponseTransfer
     */
    protected MockObject|RestErpOrderCancellationCollectionResponseTransfer $restErpOrderCancellationCollectionResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(ErpOrderCancellationRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationRequestTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationResponseTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restErpOrderCancellationCollectionResponseTransferMock = $this
            ->getMockBuilder(RestErpOrderCancellationCollectionResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->facadeMock) extends GatewayController {
            protected AbstractFacade $erpOrderCancellationRestApiFacade;

            /**
             * @param \Spryker\Zed\Kernel\Business\AbstractFacade $facade
             */
            public function __construct(AbstractFacade $facade)
            {
                $this->erpOrderCancellationRestApiFacade = $facade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->erpOrderCancellationRestApiFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testAddErpOrderCancellationAction(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('addErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationResponseTransferMock,
            $this->gatewayController->addErpOrderCancellationAction($this->restErpOrderCancellationRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetErpOrderCancellationAction(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationCollectionResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationCollectionResponseTransferMock,
            $this->gatewayController->getErpOrderCancellationAction($this->restErpOrderCancellationRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPatchErpOrderCancellationAction(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationResponseTransferMock,
            $this->gatewayController->patchErpOrderCancellationAction($this->restErpOrderCancellationRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellationAction(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellation')
            ->with($this->restErpOrderCancellationRequestTransferMock)
            ->willReturn($this->restErpOrderCancellationResponseTransferMock);

        static::assertEquals(
            $this->restErpOrderCancellationResponseTransferMock,
            $this->gatewayController->deleteErpOrderCancellationAction($this->restErpOrderCancellationRequestTransferMock),
        );
    }
}

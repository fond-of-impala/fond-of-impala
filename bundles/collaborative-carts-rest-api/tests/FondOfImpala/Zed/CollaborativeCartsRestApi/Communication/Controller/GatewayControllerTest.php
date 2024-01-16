<?php

namespace FondOfImpala\Zed\CollaborativeCartsRestApi\Communication\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CollaborativeCartsRestApi\Business\CollaborativeCartsRestApiFacade;
use Generated\Shared\Transfer\RestClaimCartRequestTransfer;
use Generated\Shared\Transfer\RestClaimCartResponseTransfer;
use Generated\Shared\Transfer\RestReleaseCartRequestTransfer;
use Generated\Shared\Transfer\RestReleaseCartResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class GatewayControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CollaborativeCartsRestApi\Business\CollaborativeCartsRestApiFacade
     */
    protected $collaborativeCartsRestApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestClaimCartRequestTransfer
     */
    protected $restClaimCartRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ClaimCartResponseTransfer
     */
    protected $restClaimCartResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestReleaseCartResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restReleaseCartResponseTransferMock;

    /**
     * @var \FondOfImpala\Zed\CollaborativeCartsRestApi\Communication\Controller\GatewayController
     */
    protected $gatewayController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->collaborativeCartsRestApiFacadeMock = $this->getMockBuilder(CollaborativeCartsRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartRequestTransferMock = $this->getMockBuilder(RestClaimCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restClaimCartResponseTransferMock = $this->getMockBuilder(RestClaimCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartRequestTransferMock = $this->getMockBuilder(RestReleaseCartRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restReleaseCartResponseTransferMock = $this->getMockBuilder(RestReleaseCartResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->gatewayController = new class ($this->collaborativeCartsRestApiFacadeMock) extends GatewayController {
            /**
             * @var \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected $collaborativeCartsRestApiFacade;

            /**
             *  constructor.
             *
             * @param \Spryker\Zed\Kernel\Business\AbstractFacade $facade
             */
            public function __construct(AbstractFacade $facade)
            {
                $this->collaborativeCartsRestApiFacade = $facade;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->collaborativeCartsRestApiFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testClaimCartAction(): void
    {
        $this->collaborativeCartsRestApiFacadeMock->expects(static::atLeastOnce())
            ->method('claimCart')
            ->with($this->restClaimCartRequestTransferMock)
            ->willReturn($this->restClaimCartResponseTransferMock);

        static::assertEquals(
            $this->restClaimCartResponseTransferMock,
            $this->gatewayController->claimCartAction($this->restClaimCartRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testReleaseCartAction(): void
    {
        $this->collaborativeCartsRestApiFacadeMock->expects(static::atLeastOnce())
            ->method('releaseCart')
            ->with($this->restReleaseCartRequestTransferMock)
            ->willReturn($this->restReleaseCartResponseTransferMock);

        static::assertEquals(
            $this->restReleaseCartResponseTransferMock,
            $this->gatewayController->releaseCartAction($this->restReleaseCartRequestTransferMock),
        );
    }
}

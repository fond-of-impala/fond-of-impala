<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessorInterface;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CollaborativeCartsResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCollaborativeCartsRequestAttributesTransferMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collaborativeCartProcessorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\CollaborativeCartsRestApi\Controller\CollaborativeCartsResourceController
     */
    protected $collaborativeCartsResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCollaborativeCartsRequestAttributesTransferMock = $this->getMockBuilder(RestCollaborativeCartsRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CollaborativeCartsRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartProcessorMock = $this->getMockBuilder(CollaborativeCartProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collaborativeCartsResourceController = new class ($this->factoryMock) extends CollaborativeCartsResourceController {
            /**
             * @var \Spryker\Glue\Kernel\AbstractFactory
             */
            protected $collaborativeCartsRestApiFactory;

            /**
             * @param \FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory $abstractFactory
             */
            public function __construct(CollaborativeCartsRestApiFactory $abstractFactory)
            {
                $this->collaborativeCartsRestApiFactory = $abstractFactory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            protected function getFactory(): AbstractFactory
            {
                return $this->collaborativeCartsRestApiFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testPostAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCollaborativeCartProcessor')
            ->willReturn($this->collaborativeCartProcessorMock);

        $this->collaborativeCartProcessorMock->expects(static::atLeastOnce())
            ->method('process')
            ->with($this->restRequestMock, $this->restCollaborativeCartsRequestAttributesTransferMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->collaborativeCartsResourceController->postAction(
                $this->restRequestMock,
                $this->restCollaborativeCartsRequestAttributesTransferMock,
            ),
        );
    }
}

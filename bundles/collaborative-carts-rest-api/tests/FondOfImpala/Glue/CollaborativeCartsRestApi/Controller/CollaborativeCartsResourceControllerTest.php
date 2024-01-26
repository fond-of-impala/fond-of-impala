<?php

namespace FondOfImpala\Glue\CollaborativeCartsRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CollaborativeCartsRestApi\CollaborativeCartsRestApiFactory;
use FondOfImpala\Glue\CollaborativeCartsRestApi\Processor\CollaborativeCart\CollaborativeCartProcessorInterface;
use Generated\Shared\Transfer\RestCollaborativeCartsRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CollaborativeCartsResourceControllerTest extends Unit
{
    protected MockObject|RestRequestInterface $restRequestMock;

    protected MockObject|RestCollaborativeCartsRequestAttributesTransfer $restCollaborativeCartsRequestAttributesTransferMock;

    protected MockObject|CollaborativeCartsRestApiFactory $factoryMock;

    protected MockObject|CollaborativeCartProcessorInterface $collaborativeCartProcessorMock;

    protected MockObject|RestResponseInterface $restResponseMock;

    protected CollaborativeCartsResourceController $collaborativeCartsResourceController;

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
            protected CollaborativeCartsRestApiFactory $collaborativeCartsRestApiFactory;

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

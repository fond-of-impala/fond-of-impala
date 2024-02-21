<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiFactory;
use FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk\OrderBudgetsBulkProcessorInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class OrderBudgetsBulkResourceControllerTest extends Unit
{
    protected OrderBudgetsBulkRestApiFactory|MockObject $factoryMock;

    protected OrderBudgetsBulkProcessorInterface|MockObject $orderBudgetsBulkProcessorMock;

    protected RestRequestInterface|MockObject $restRequestMock;

    protected RestOrderBudgetsBulkRequestAttributesTransfer|MockObject $restOrderBudgetsBulkRequestAttributesTransferMock;

    protected RestResponseInterface|MockObject $restResponseMock;

    protected OrderBudgetsBulkResourceController $controller;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(OrderBudgetsBulkRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderBudgetsBulkProcessorMock = $this->getMockBuilder(OrderBudgetsBulkProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restOrderBudgetsBulkRequestAttributesTransferMock = $this->getMockBuilder(RestOrderBudgetsBulkRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new class ($this->factoryMock) extends OrderBudgetsBulkResourceController {
            protected AbstractFactory $abstractFactory;

            /**
             * @param \Spryker\Glue\Kernel\AbstractFactory $abstractFactory
             */
            public function __construct(AbstractFactory $abstractFactory)
            {
                $this->abstractFactory = $abstractFactory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            protected function getFactory(): AbstractFactory
            {
                return $this->abstractFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testPostAction(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createOrderBudgetsBulkProcessor')
            ->willReturn($this->orderBudgetsBulkProcessorMock);

        $this->orderBudgetsBulkProcessorMock->expects(static::atLeastOnce())
            ->method('process')
            ->with(
                $this->restRequestMock,
                $this->restOrderBudgetsBulkRequestAttributesTransferMock,
            )->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->controller->postAction(
                $this->restRequestMock,
                $this->restOrderBudgetsBulkRequestAttributesTransferMock,
            ),
        );
    }
}

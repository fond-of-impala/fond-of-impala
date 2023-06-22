<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory;
use FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Reader\ConditionalAvailabilityPageSearchReaderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class ConditionalAvailabilityPageSearchResourceControllerTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\ConditionalAvailabilityPageSearchRestApiFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityPageSearchRestApiFactoryMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Processor\ConditionalAvailabilityPageSearch\Reader\ConditionalAvailabilityPageSearchReaderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $conditionalAvailabilityPageSearchReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Controller\ConditionalAvailabilityPageSearchResourceController
     */
    protected $conditionalAvailabilityPageSearchResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->conditionalAvailabilityPageSearchRestApiFactoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchReaderMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchResourceController = new class ($this->conditionalAvailabilityPageSearchRestApiFactoryMock) extends ConditionalAvailabilityPageSearchResourceController {
            /**
             * @var \Spryker\Glue\Kernel\AbstractFactory
             */
            protected $factory;

            /**
             *  constructor.
             *
             * @param \Spryker\Glue\Kernel\AbstractFactory $factory
             */
            public function __construct(AbstractFactory $factory)
            {
                $this->factory = $factory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            public function getFactory(): AbstractFactory
            {
                return $this->factory;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetAction(): void
    {
        $this->conditionalAvailabilityPageSearchRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createConditionalAvailabilityPageSearchReader')
            ->willReturn($this->conditionalAvailabilityPageSearchReaderMock);

        $this->conditionalAvailabilityPageSearchReaderMock->expects(static::atLeastOnce())
            ->method('get')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->conditionalAvailabilityPageSearchResourceController->getAction($this->restRequestMock);

        static::assertEquals($this->restResponseMock, $restResponse);
    }
}

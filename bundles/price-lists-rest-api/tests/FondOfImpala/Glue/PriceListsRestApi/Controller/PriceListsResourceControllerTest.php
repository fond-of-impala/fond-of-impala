<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiFactory;
use FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListReaderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PriceListsResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiFactory
     */
    protected MockObject|PriceListsRestApiFactory $priceListsRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceListsRestApi\Processor\PriceList\PriceListReaderInterface
     */
    protected MockObject|PriceListReaderInterface $priceListReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected MockObject|RestResponseInterface $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected MockObject|RestResourceInterface $restResourceMock;

    /**
     * @var \FondOfImpala\Glue\PriceListsRestApi\Controller\PriceListsResourceController
     */
    protected PriceListsResourceController $priceListsResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceListsRestApiFactoryMock = $this->getMockBuilder(PriceListsRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListReaderMock = $this->getMockBuilder(PriceListReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListsResourceController = new class (
            $this->priceListsRestApiFactoryMock
        ) extends PriceListsResourceController {
            protected PriceListsRestApiFactory $priceListsRestApiFactory;

            /**
             * @param \FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiFactory $priceListsRestApiFactory
             */
            public function __construct(PriceListsRestApiFactory $priceListsRestApiFactory)
            {
                $this->priceListsRestApiFactory = $priceListsRestApiFactory;
            }

            /**
             * @return \FondOfImpala\Glue\PriceListsRestApi\PriceListsRestApiFactory
             */
            public function getFactory(): PriceListsRestApiFactory
            {
                return $this->priceListsRestApiFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetActionWithResourceId(): void
    {
        $resourceId = '8bb8ea24-51f1-47b6-9291-95d37611108e';

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($resourceId);

        $this->priceListsRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListReader')
            ->willReturn($this->priceListReaderMock);

        $this->priceListReaderMock->expects(static::atLeastOnce())
            ->method('getPriceListByUuid')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->priceListsResourceController->getAction(
                $this->restRequestMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetAction(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->priceListsRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceListReader')
            ->willReturn($this->priceListReaderMock);

        $this->priceListReaderMock->expects(static::atLeastOnce())
            ->method('getAllPriceLists')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        static::assertEquals(
            $this->restResponseMock,
            $this->priceListsResourceController->getAction(
                $this->restRequestMock,
            ),
        );
    }
}

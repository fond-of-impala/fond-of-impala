<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Controller;

use Codeception\Test\Unit;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiFactory;
use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductPriceListSearchReaderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PriceProductConcretePriceListSearchResourceControllerTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Controller\PriceProductConcretePriceListSearchResourceController
     */
    protected PriceProductConcretePriceListSearchResourceController $priceProductConcretePriceListSearchResourceController;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiFactory
     */
    protected MockObject|PriceProductPriceListSearchRestApiFactory $priceProductPriceListSearchRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Processor\PriceProductPriceListSearch\PriceProductPriceListSearchReaderInterface
     */
    protected MockObject|PriceProductPriceListSearchReaderInterface $priceProductPriceListSearchReaderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected MockObject|RestResponseInterface $restResponseInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceProductPriceListSearchRestApiFactoryMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListSearchReaderInterfaceMock = $this->getMockBuilder(PriceProductPriceListSearchReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseInterfaceMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductConcretePriceListSearchResourceController = new class (
            $this->priceProductPriceListSearchRestApiFactoryMock
        ) extends PriceProductConcretePriceListSearchResourceController {
            protected PriceProductPriceListSearchRestApiFactory $priceProductPriceListSearchRestApiFactory;

            /**
             * @param \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiFactory $priceProductPriceListSearchRestApiFactory
             */
            public function __construct(PriceProductPriceListSearchRestApiFactory $priceProductPriceListSearchRestApiFactory)
            {
                $this->priceProductPriceListSearchRestApiFactory = $priceProductPriceListSearchRestApiFactory;
            }

            /**
             * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApi\PriceProductPriceListSearchRestApiFactory
             */
            public function getFactory(): PriceProductPriceListSearchRestApiFactory
            {
                return $this->priceProductPriceListSearchRestApiFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetAction(): void
    {
        $this->priceProductPriceListSearchRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createPriceProductConcretePriceListSearchReader')
            ->willReturn($this->priceProductPriceListSearchReaderInterfaceMock);

        $this->priceProductPriceListSearchReaderInterfaceMock->expects(static::atLeastOnce())
            ->method('search')
            ->with($this->restRequestInterfaceMock)
            ->willReturn($this->restResponseInterfaceMock);

        static::assertInstanceOf(
            RestResponseInterface::class,
            $this->priceProductConcretePriceListSearchResourceController->getAction(
                $this->restRequestInterfaceMock,
            ),
        );
    }
}

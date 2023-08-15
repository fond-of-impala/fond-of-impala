<?php

namespace FondOfImpala\Glue\PriceListsRestApi\Plugin\PriceListsRestApiExtension;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Shared\PriceListsRestApi\PriceListsRestApiConstants;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PriceListFilterFieldsExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected MockObject|RestResourceInterface $restResourceMock;

    /**
     * @var \FondOfImpala\Glue\PriceListsRestApi\Plugin\PriceListsRestApiExtension\PriceListFilterFieldsExpanderPlugin
     */
    protected PriceListFilterFieldsExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new PriceListFilterFieldsExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $uuid = '011c4a22-49de-4ed6-b4cc-5a24c5b031b8';
        $filterFieldTransfers = new ArrayObject();

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn($uuid);

        $filterFieldTransfers = $this->plugin->expand($this->restRequestMock, $filterFieldTransfers);

        static::assertCount(1, $filterFieldTransfers);
        static::assertEquals(
            PriceListsRestApiConstants::FILTER_FIELD_TYPE_PRICE_LIST_UUID,
            $filterFieldTransfers->offsetGet(0)->getType(),
        );
        static::assertEquals(
            $uuid,
            $filterFieldTransfers->offsetGet(0)->getValue(),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithoutResourceId(): void
    {
        $filterFieldTransfers = new ArrayObject();

        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $filterFieldTransfers = $this->plugin->expand($this->restRequestMock, $filterFieldTransfers);

        static::assertCount(0, $filterFieldTransfers);
    }
}

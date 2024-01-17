<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder;

use Codeception\Test\Unit;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\CompanyBusinessUnitsCartsRestApiConfig;
use FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapperInterface;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestLinkInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;

class CartItemRestResponseBuilderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\Mapper\CartItemMapperInterface
     */
    protected $cartItemMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $firstRestResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $secondRestResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi\Processor\RestResponseBuilder\CartItemRestResponseBuilder
     */
    protected $cartItemRestResponseBuilder;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartItemMapperMock = $this->getMockBuilder(CartItemMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->firstRestResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->secondRestResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartItemRestResponseBuilder = new CartItemRestResponseBuilder(
            $this->restResourceBuilderMock,
            $this->cartItemMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateCartItemResource(): void
    {
        $groupKey = 'GROUP_KEY';
        $localeName = 'de_DE';
        $cartUuid = 'e609040d-2bad-4757-bcdc-552a080a0fc2';

        $this->itemTransferMock->expects(self::atLeastOnce())
            ->method('getGroupKey')
            ->willReturn($groupKey);

        $this->cartItemMapperMock->expects(self::atLeastOnce())
            ->method('mapItemTransferToRestItemsAttributesTransfer')
            ->with(
                $this->itemTransferMock,
                self::isInstanceOf(RestItemsAttributesTransfer::class),
                $localeName,
            );

        $this->restResourceBuilderMock->expects(self::atLeastOnce())
            ->method('createRestResource')
            ->with(
                CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_CART_ITEMS,
                $groupKey,
                self::isInstanceOf(RestItemsAttributesTransfer::class),
            )->willReturn($this->secondRestResourceMock);

        $this->firstRestResourceMock->expects(self::atLeastOnce())
            ->method('getId')
            ->willReturn($cartUuid);

        $this->secondRestResourceMock->expects(self::atLeastOnce())
            ->method('addLink')
            ->with(
                RestLinkInterface::LINK_SELF,
                sprintf(
                    '%s/%s/%s/%s',
                    CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_CARTS,
                    $cartUuid,
                    CompanyBusinessUnitsCartsRestApiConfig::RESOURCE_CART_ITEMS,
                    $groupKey,
                ),
            )->willReturn($this->secondRestResourceMock);

        self::assertEquals(
            $this->secondRestResourceMock,
            $this->cartItemRestResponseBuilder->createCartItemResource(
                $this->firstRestResourceMock,
                $this->itemTransferMock,
                $localeName,
            ),
        );
    }
}

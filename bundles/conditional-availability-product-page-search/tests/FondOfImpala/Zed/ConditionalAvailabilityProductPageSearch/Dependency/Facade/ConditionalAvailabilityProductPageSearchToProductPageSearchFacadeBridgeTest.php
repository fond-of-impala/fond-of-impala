<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface;

class ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface
     */
    protected MockObject|ProductPageSearchFacadeInterface $productPageSearchFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface
     */
    protected ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productPageSearchFacadeMock = $this->getMockBuilder(ProductPageSearchFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityProductPageSearchToProductPageSearchFacadeBridge(
            $this->productPageSearchFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetPublish(): void
    {
        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publish')
            ->with([1]);

        $this->bridge->publish([1]);
    }

    /**
     * @return void
     */
    public function testPublishProductConcretes(): void
    {
        $this->productPageSearchFacadeMock->expects(static::atLeastOnce())
            ->method('publishProductConcretes')
            ->with([1]);

        $this->bridge->publishProductConcretes([1]);
    }
}

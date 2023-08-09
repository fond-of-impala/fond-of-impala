<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Dependency\Facade;

class ConditionalAvailabilitySearchToProductPageSearchFacadeBridge implements ConditionalAvailabilitySearchToProductPageSearchFacadeInterface
{
    /**
     * @var \Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface
     */
    protected $productPageSearchFacade;

    /**
     * @param \Spryker\Zed\ProductPageSearch\Business\ProductPageSearchFacadeInterface $productPageSearchFacade
     */
    public function __construct($productPageSearchFacade)
    {
        $this->productPageSearchFacade = $productPageSearchFacade;
    }

    /**
     * @param array<int> $productAbstractIds
     *
     * @return void
     */
    public function publish(array $productAbstractIds): void
    {
        $this->productPageSearchFacade->publish($productAbstractIds);
    }

    /**
     * @param array<int> $productConcreteIds
     *
     * @return void
     */
    public function publishProductConcretes(array $productConcreteIds): void
    {
        $this->productPageSearchFacade->publishProductConcretes($productConcreteIds);
    }
}

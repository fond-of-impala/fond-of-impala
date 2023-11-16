<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander;

use Generated\Shared\Transfer\ProductConcretePageSearchTransfer;

interface ProductConcretePageSearchExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcretePageSearchTransfer
     */
    public function expand(
        ProductConcretePageSearchTransfer $productConcretePageSearchTransfer
    ): ProductConcretePageSearchTransfer;
}

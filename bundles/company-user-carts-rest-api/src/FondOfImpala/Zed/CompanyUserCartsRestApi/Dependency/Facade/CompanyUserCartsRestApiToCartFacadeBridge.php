<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Zed\Cart\Business\CartFacadeInterface;

class CompanyUserCartsRestApiToCartFacadeBridge implements CompanyUserCartsRestApiToCartFacadeInterface
{
    /**
     * @var \Spryker\Zed\Cart\Business\CartFacadeInterface
     */
    protected $cartFacade;

    /**
     * @param \Spryker\Zed\Cart\Business\CartFacadeInterface $cartFacade
     */
    public function __construct(CartFacadeInterface $cartFacade)
    {
        $this->cartFacade = $cartFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function addToCart(CartChangeTransfer $cartChangeTransfer): QuoteResponseTransfer
    {
        return $this->cartFacade->addToCart($cartChangeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteResponseTransfer
     */
    public function removeFromCart(CartChangeTransfer $cartChangeTransfer): QuoteResponseTransfer
    {
        return $this->cartFacade->removeFromCart($cartChangeTransfer);
    }
}

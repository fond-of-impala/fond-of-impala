<?php

namespace FondOfImpala\Zed\NavisionCompany\Communication\Plugin\CheckoutExtension;

use FondOfImpala\Shared\NavisionCompany\NavisionCompanyConstants;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreConditionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\NavisionCompany\NavisionCompanyConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompany\Business\NavisionCompanyFacade getFacade()
 */
class NavisionCompanyCheckoutPreConditionPlugin extends AbstractPlugin implements CheckoutPreConditionPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return bool
     */
    public function checkCondition(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $companyUserTransfer = $quoteTransfer->getCompanyUser();

        if ($companyUserTransfer === null) {
            return true;
        }

        $companyTransfer = $companyUserTransfer->getCompany();

        if ($companyTransfer === null || !$companyTransfer->getIsBlocked()) {
            return true;
        }

        $checkoutErrorTransfer = (new CheckoutErrorTransfer())
            ->setMessage(NavisionCompanyConstants::MESSAGE_COMPANY_IS_BLOCKED);

        $checkoutResponseTransfer
            ->setIsSuccess(false)
            ->addError($checkoutErrorTransfer);

        return false;
    }
}

<?php

namespace FondOfImpala\Zed\NavisionCompany\Communication\Plugin\QuoteExtension;

use FondOfImpala\Shared\NavisionCompany\NavisionCompanyConstants;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteExpanderPluginInterface;

/**
 * @method \FondOfImpala\Zed\NavisionCompany\NavisionCompanyConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompany\Business\NavisionCompanyFacade getFacade()
 */
class NavisionCompanyQuoteExpanderPlugin extends AbstractPlugin implements QuoteExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $companyUserTransfer = $quoteTransfer->getCompanyUser();

        if ($companyUserTransfer === null) {
            return $quoteTransfer;
        }

        $companyTransfer = $companyUserTransfer->getCompany();

        if ($companyTransfer === null || !$companyTransfer->getIsBlocked()) {
            return $quoteTransfer;
        }

        $messageTransfer = (new MessageTransfer())->setType(NavisionCompanyConstants::MESSAGE_TYPE_ERROR)
            ->setValue(NavisionCompanyConstants::MESSAGE_COMPANY_IS_BLOCKED);

        return $quoteTransfer->addValidationMessage($messageTransfer);
    }
}

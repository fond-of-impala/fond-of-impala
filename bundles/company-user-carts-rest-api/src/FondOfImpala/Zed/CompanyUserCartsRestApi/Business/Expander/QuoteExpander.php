<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander;

use FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig
     */
    protected $config;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig $config
     */
    public function __construct(CompanyUserCartsRestApiConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(
        QuoteTransfer $quoteTransfer,
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): QuoteTransfer {
        $quoteTransfer = $this->expandWithConfigurableFields($quoteTransfer, $restCompanyUserCartsRequestTransfer);
        $quoteTransfer = $this->expandWithCustomer($quoteTransfer, $restCompanyUserCartsRequestTransfer);

        return $this->expandWithCompanyUser($quoteTransfer, $restCompanyUserCartsRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function expandWithCustomer(
        QuoteTransfer $quoteTransfer,
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): QuoteTransfer {
        if ($quoteTransfer->getCustomerReference() === null) {
            $quoteTransfer->setCustomerReference($restCompanyUserCartsRequestTransfer->getCustomerReference());
        }

        $customerTransfer = $quoteTransfer->getCustomer();

        if ($customerTransfer === null) {
            $customerTransfer = new CustomerTransfer();
        }

        return $quoteTransfer->setCustomer(
            $customerTransfer->setCustomerReference($quoteTransfer->getCustomerReference()),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function expandWithCompanyUser(
        QuoteTransfer $quoteTransfer,
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): QuoteTransfer {
        if ($quoteTransfer->getCompanyUserReference() === null) {
            $quoteTransfer->setCompanyUserReference($restCompanyUserCartsRequestTransfer->getCompanyUserReference());
        }

        $companyUserTransfer = $quoteTransfer->getCompanyUser();

        if ($companyUserTransfer === null) {
            $companyUserTransfer = new CompanyUserTransfer();
        }

        return $quoteTransfer->setCompanyUser(
            $companyUserTransfer->setCompanyUserReference($quoteTransfer->getCompanyUserReference()),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function expandWithConfigurableFields(
        QuoteTransfer $quoteTransfer,
        RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
    ): QuoteTransfer {
        $restCartsRequestAttributesTransfer = $restCompanyUserCartsRequestTransfer->getCart();

        if ($restCartsRequestAttributesTransfer === null) {
            return $quoteTransfer;
        }

        $allowedFieldsToPatchInQuote = $this->config->getAllowedFieldsToPatchInQuote();

        foreach ($restCartsRequestAttributesTransfer->modifiedToArray() as $key => $value) {
            $method = sprintf('set%s', ucfirst(str_replace('_', '', ucwords($key, '_'))));

            if (!in_array($key, $allowedFieldsToPatchInQuote, true) || !method_exists($quoteTransfer, $method)) {
                continue;
            }

            $quoteTransfer->$method($value);
        }

        return $quoteTransfer;
    }
}

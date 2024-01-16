<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\CompanyUserQuote;

use FondOfImpala\Client\CompanyUserQuote\Zed\CompanyUserQuoteStub;
use FondOfImpala\Client\CompanyUserQuote\Zed\CompanyUserQuoteStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CompanyUserQuoteFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyUserQuote\Zed\CompanyUserQuoteStubInterface
     */
    public function createZedCompanyUserQuoteStub(): CompanyUserQuoteStubInterface
    {
        return new CompanyUserQuoteStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyUserQuoteDependencyProvider::CLIENT_ZED_REQUEST);
    }
}

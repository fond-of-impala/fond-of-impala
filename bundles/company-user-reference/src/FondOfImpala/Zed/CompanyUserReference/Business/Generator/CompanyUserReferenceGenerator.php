<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Generator;

use FondOfImpala\Shared\CompanyUserReference\CompanyUserReferenceConstants;
use FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;

class CompanyUserReferenceGenerator implements CompanyUserReferenceGeneratorInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface
     */
    protected $sequenceNumberFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig
     */
    protected $config;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToSequenceNumberFacadeInterface $sequenceNumberFacade
     * @param \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToStoreFacadeInterface $storeFacade
     * @param \FondOfImpala\Zed\CompanyUserReference\CompanyUserReferenceConfig $config
     */
    public function __construct(
        CompanyUserReferenceToSequenceNumberFacadeInterface $sequenceNumberFacade,
        CompanyUserReferenceToStoreFacadeInterface $storeFacade,
        CompanyUserReferenceConfig $config
    ) {
        $this->sequenceNumberFacade = $sequenceNumberFacade;
        $this->storeFacade = $storeFacade;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $sequenceNumberSettingsTransfer = (new SequenceNumberSettingsTransfer())
            ->setName(CompanyUserReferenceConstants::NAME_COMPANY_USER_REFERENCE)
            ->setPrefix($this->getPrefix());

        return $this->sequenceNumberFacade->generate($sequenceNumberSettingsTransfer);
    }

    /**
     * @return string
     */
    protected function getPrefix(): string
    {
        $sequenceNumberPrefixParts = [
            $this->storeFacade->getCurrentStore()->getName(),
            $this->config->getEnvironmentPrefix(),
            CompanyUserReferenceConstants::PREFIX_COMPANY_USER_REFERENCE,
        ];

        return implode($this->getUniqueIdentifierSeparator(), $sequenceNumberPrefixParts)
            . $this->getUniqueIdentifierSeparator();
    }

    /**
     * @return string
     */
    protected function getUniqueIdentifierSeparator(): string
    {
        return '-';
    }
}

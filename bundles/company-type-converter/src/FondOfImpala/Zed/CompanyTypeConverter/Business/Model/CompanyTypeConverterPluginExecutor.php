<?php

namespace FondOfImpala\Zed\CompanyTypeConverter\Business\Model;

use Generated\Shared\Transfer\CompanyTransfer;

class CompanyTypeConverterPluginExecutor implements CompanyTypeConverterPluginExecutorInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPreSavePluginInterface[]
     */
    protected $companyTypeConverterPreSavePlugins;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPostSavePluginInterface[]
     */
    protected $companyTypeConverterPostSavePlugins;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPreSavePluginInterface[] $companyTypeConverterPreSavePlugins
     * @param \FondOfImpala\Zed\CompanyTypeConverterExtension\Dependency\Plugin\CompanyTypeConverterPostSavePluginInterface[] $companyTypeConverterPostSavePlugins
     */
    public function __construct(
        array $companyTypeConverterPreSavePlugins = [],
        array $companyTypeConverterPostSavePlugins = []
    ) {
        $this->companyTypeConverterPreSavePlugins = $companyTypeConverterPreSavePlugins;
        $this->companyTypeConverterPostSavePlugins = $companyTypeConverterPostSavePlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function executeCompanyTypeConverterPreSavePlugins(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        foreach ($this->companyTypeConverterPreSavePlugins as $companyTypeConverterPreSavePlugin) {
            $companyTransfer = $companyTypeConverterPreSavePlugin->preSave($companyTransfer);
        }

        return $companyTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function executeCompanyTypeConverterPostSavePlugins(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        foreach ($this->companyTypeConverterPostSavePlugins as $companyTypeConverterPostSavePlugin) {
            $companyTransfer = $companyTypeConverterPostSavePlugin->postSave($companyTransfer);
        }

        return $companyTransfer;
    }
}

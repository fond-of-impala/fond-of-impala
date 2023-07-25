<?php

namespace FondOfImpala\Zed\CompanyType\Business;

use FondOfImpala\Zed\CompanyType\Business\CompanyTypeExportValidator\CompanyTypeExportValidator;
use FondOfImpala\Zed\CompanyType\Business\CompanyTypeExportValidator\CompanyTypeExportValidatorInterface;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeAssigner;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeAssignerInterface;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReader;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeWriter;
use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeWriterInterface;
use FondOfImpala\Zed\CompanyType\CompanyTypeDependencyProvider;
use FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyType\CompanyTypeConfig getConfig()
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface getRepository()
 */
class CompanyTypeBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface
     */
    public function createCompanyTypeReader(): CompanyTypeReaderInterface
    {
        return new CompanyTypeReader(
            $this->getRepository(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeWriterInterface
     */
    public function createCompanyTypeWriter(): CompanyTypeWriterInterface
    {
        return new CompanyTypeWriter(
            $this->getEntityManager(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeAssignerInterface
     */
    public function createCompanyTypeAssigner(): CompanyTypeAssignerInterface
    {
        return new CompanyTypeAssigner(
            $this->getConfig(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyType\Business\CompanyTypeExportValidator\CompanyTypeExportValidatorInterface
     */
    public function createCompanyTypeExportValidator(): CompanyTypeExportValidatorInterface
    {
        return new CompanyTypeExportValidator(
            $this->createCompanyTypeReader(),
            $this->getCompanyBusinessUnitFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeInterface
     */
    public function getCompanyBusinessUnitFacade(): CompanyTypeToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyTypeDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }
}

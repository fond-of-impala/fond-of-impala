<?php

namespace FondOfImpala\Zed\CompanyType\Business\CompanyTypeExportValidator;

use FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface;
use FondOfImpala\Zed\CompanyType\CompanyTypeConfig;
use FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;

/**
 * Class CompanyTypeExportValidator
 *
 * @package FondOfImpala\Zed\CompanyType\Business\CompanyTypeExportValidator
 */
class CompanyTypeExportValidator implements CompanyTypeExportValidatorInterface
{
    /**
     * @var string
     */
    protected const EVENT_ENTITY_TYPE_COMPANY_BUSINESS_UNIT = 'spy_company_business_unit';

    /**
     * @var string
     */
    protected const EVENT_ENTITY_TYPE_COMPANY = 'spy_company';

    /**
     * @var \FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyType\CompanyTypeConfig
     */
    protected $companyTypeConfig;

    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface
     */
    protected $companyTypeReader;

    /**
     * @param \FondOfImpala\Zed\CompanyType\Business\Model\CompanyTypeReaderInterface $companyTypeReader
     * @param \FondOfImpala\Zed\CompanyType\Dependency\Facade\CompanyTypeToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \FondOfImpala\Zed\CompanyType\CompanyTypeConfig $companyTypeConfig
     */
    public function __construct(
        CompanyTypeReaderInterface $companyTypeReader,
        CompanyTypeToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyTypeConfig $companyTypeConfig
    ) {
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyTypeConfig = $companyTypeConfig;
        $this->companyTypeReader = $companyTypeReader;
    }

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return bool
     */
    public function validate(EventEntityTransfer $eventEntityTransfer): bool
    {
        $idCompany = $this->getCompanyIdByForeignKey($eventEntityTransfer);

        if ($idCompany === null) {
            $idCompany = $this->getCompanyIdByEventEntityType($eventEntityTransfer);
        }

        if ($idCompany === null) {
            return false;
        }

        $companyTransfer = (new CompanyTransfer())->setIdCompany($idCompany);
        $companyTypeTransfer = $this->companyTypeReader->findCompanyTypeByIdCompany($companyTransfer);

        if ($companyTypeTransfer === null) {
            return false;
        }

        return in_array(
            $companyTypeTransfer->getName(),
            $this->companyTypeConfig->getValidCompanyTypesForExport(),
            true,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return int|null
     */
    protected function getCompanyIdByForeignKey(EventEntityTransfer $eventEntityTransfer): ?int
    {
        $foreignKey = sprintf('%s.fk_company', $eventEntityTransfer->getName());
        $foreignKeys = $eventEntityTransfer->getForeignKeys();

        if (array_key_exists($foreignKey, $foreignKeys) === false) {
            return null;
        }

        return $foreignKeys[$foreignKey];
    }

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return int|null
     */
    protected function getCompanyIdByEventEntityType(EventEntityTransfer $eventEntityTransfer): ?int
    {
        if ($eventEntityTransfer->getName() === self::EVENT_ENTITY_TYPE_COMPANY) {
            return $eventEntityTransfer->getId();
        }

        if ($eventEntityTransfer->getName() === self::EVENT_ENTITY_TYPE_COMPANY_BUSINESS_UNIT) {
            return $this->getCompanyIdByCompanyBusinessUnitId($eventEntityTransfer);
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $eventEntityTransfer
     *
     * @return int|null
     */
    protected function getCompanyIdByCompanyBusinessUnitId(EventEntityTransfer $eventEntityTransfer): ?int
    {
        $companyBusinessUnitTransfer = (new CompanyBusinessUnitTransfer())
            ->setIdCompanyBusinessUnit($eventEntityTransfer->getId());
        $companyBusinessUnitTransfer = $this->companyBusinessUnitFacade
            ->getCompanyBusinessUnitById($companyBusinessUnitTransfer);

        return $companyBusinessUnitTransfer->getFkCompany();
    }
}

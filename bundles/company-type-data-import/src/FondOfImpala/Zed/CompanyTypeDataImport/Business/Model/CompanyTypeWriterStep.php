<?php

namespace FondOfImpala\Zed\CompanyTypeDataImport\Business\Model;

use Orm\Zed\CompanyType\Persistence\FoiCompanyTypeQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CompanyTypeWriterStep implements DataImportStepInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $foiCompanyType = FoiCompanyTypeQuery::create()
            ->filterByKey($dataSet[CompanyTypeDataSetInterface::COLUMN_KEY])
            ->findOneOrCreate();

        $foiCompanyType->fromArray($dataSet->getArrayCopy());

        if ($foiCompanyType->isNew() || $foiCompanyType->isModified()) {
            $foiCompanyType->save();
        }
    }
}

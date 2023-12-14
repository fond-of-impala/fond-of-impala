# Company Type Module
[![CI](https://github.com/fond-of-impala/company-type/actions/workflows/main.yml/badge.svg)](https://github.com/fond-of-impala/company-type/actions/workflows/main.yml)
[![license](https://img.shields.io/github/license/fond-of-impala/company-type.svg)](https://packagist.org/packages/fond-of-impala/company-type)

Module was migrated from `fond-of-spryker/company-type`. Please read below for migration instruction!

## Installation

```
composer require fond-of-impala/company-type
```

## Migration

To prevent losing data, please rename db data like

```
do
$$
begin
ALTER TABLE spy_company RENAME CONSTRAINT "spy_company-fos_company_type" TO "spy_company-foi_company_type";
ALTER TABLE fos_company_type RENAME CONSTRAINT "fos_company_type-name" TO "foi_company_type-name";
ALTER TABLE fos_company_type RENAME TO foi_company_type;
ALTER SEQUENCE fos_company_type_pk_seq RENAME TO foi_company_type_pk_seq;
end
$$;
```

You can use also the `fond-of-oryx/propel-pre-migration` package for migration. Just use the package and create migration file with the above content!

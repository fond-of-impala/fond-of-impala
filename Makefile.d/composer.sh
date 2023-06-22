#!/bin/bash
function generate_replace_section {
    REPLACE=()
    for i in $(ls bundles/)
    do
        REPLACE+=("\"fond-of-impala/$i\": \"*\"")
    done

    REPLACE_AS_STRING=$(IFS=, ; echo "{${REPLACE[*]}}")
    mv composer.json composer.json.old
    cat composer.json.old | Makefile.d/jq -r --argjson replace "$REPLACE_AS_STRING" '.replace |= $replace' > composer.json
    rm composer.json.old
}

function generate_autoload_section {
    AUTOLOAD=()
    for i in $(ls bundles/)
    do
        for j in $(ls bundles/$i/src/FondOfImpala/)
        do
            for k in $(ls bundles/$i/src/FondOfImpala/$j)
            do
                AUTOLOAD+=("\"FondOfImpala\\\\$j\\\\$k\\\\\": \"bundles/$i/src/FondOfImpala/$j/$k\"")
            done
        done
    done

    AUTOLOAD_AS_STRING=$(IFS=, ; echo "{${AUTOLOAD[*]}}")
    mv composer.json composer.json.old
    cat composer.json.old | Makefile.d/jq -r --argjson autoload "$AUTOLOAD_AS_STRING" '.autoload."psr-4" |= $autoload' > composer.json
    rm composer.json.old
}

function generate_autoload_dev_section {
    AUTOLOAD_DEV=()
    for i in $(ls bundles/)
    do
        for j in $(ls bundles/$i/src/FondOfImpala/)
        do
            for k in $(ls bundles/$i/src/FondOfImpala/$j)
            do
                AUTOLOAD_DEV+=("\"FondOfImpala\\\\$j\\\\$k\\\\\": \"bundles/$i/tests/FondOfImpala/$j/$k\"")
            done
        done
    done

    AUTOLOAD_DEV+=("\"Generated\\\\\": \"src/Generated/\"")
    AUTOLOAD_DEV+=("\"Orm\\\\Zed\\\\\": \"src/Orm/Zed/\"")

    AUTOLOAD_DEV_AS_STRING=$(IFS=, ; echo "{${AUTOLOAD_DEV[*]}}")
    mv composer.json composer.json.old
    cat composer.json.old | Makefile.d/jq -r --argjson autoloadDev "$AUTOLOAD_DEV_AS_STRING" '."autoload-dev"."psr-4" |= $autoloadDev' > composer.json
    rm composer.json.old
}

function generate_sections {
    generate_replace_section
    generate_autoload_section
    generate_autoload_dev_section
}

case "$1" in
    generate_replace_section)
        generate_replace_section
        ;;
    generate_autoload_section)
        generate_autoload_section
        ;;
    generate_autoload_dev_section)
        generate_autoload_dev_section
        ;;
    generate_sections)
        generate_sections
        ;;
    *)
        echo $"Usage: $0 generate_replace_section|generate_autoload_section|generate_autoload_dev_section|generate_sections"
        exit 255
esac

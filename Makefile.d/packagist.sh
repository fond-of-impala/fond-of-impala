#!/bin/bash
function add_all {
    if [ -z "${PACKAGIST_USERNAME}" ]; then echo "Environment variable \"PACKAGIST_USERNAME\" must be set."; exit 255; fi
    if [ -z "${PACKAGIST_TOKEN}" ]; then echo "Environment variable \"PACKAGIST_TOKEN\" must be set."; exit 255; fi

    for i in $(ls bundles)
    do
        status_code=$(curl --write-out %{http_code} --silent --output /dev/null https://repo.packagist.org/p2/fond-of-impala/${i}.json)
        if [[ "${status_code}" -eq 404 ]]
        then
            curl -X POST "https://packagist.org/api/create-package?username=${PACKAGIST_USERNAME}&apiToken=${PACKAGIST_TOKEN}" -d "{\"repository\":{\"url\":\"https://github.com/fond-of-impala/${i}\"}}"
            echo ""
        fi
    done
}

case "$1" in
    add_all)
        add_all
        ;;
    *)
        echo $"Usage: $0 add_all"
        exit 255
esac

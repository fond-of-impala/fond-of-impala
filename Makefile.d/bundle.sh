#!/bin/bash

function test {
    BUNDLE="${1}"
    CURRENT_WORKING_PATH=$(pwd)
    RELATIVE_BUNDLE_PATH="./bundles/${BUNDLE}"
    PATH_TO_ERROR_LOG="${CURRENT_WORKING_PATH}/${BUNDLE}.err.log"

    if [ ! -d "${RELATIVE_BUNDLE_PATH}" ]; then
      # Take action if $DIR exists. #
      echo "Bundle \"${BUNDLE}\" does not exists..."
      return
    fi

    cd ${RELATIVE_BUNDLE_PATH}
    make install ci &> ${PATH_TO_ERROR_LOG}
    STATUS=${?}
    make clean &>/dev/null
    [ "${STATUS}" -eq 0 ] && echo "${BUNDLE} :: [SUCCESS]" || echo "${BUNDLE} :: [ERROR] :: Look at ${PATH_TO_ERROR_LOG}"
    cd ${CURRENT_WORKING_PATH}
}


function test_all {
    for BUNDLE in $(ls -d ./bundles/*/ | xargs -n1 -I{} basename "{}"); do
        test ${BUNDLE}
    done;
}

function usage {
    echo $"Usage: ${0} test_all|test bundle_name"
}

if [ "${#}" -gt 2 ] || [ "${#}" -lt 1 ]; then
    usage ${0}
fi

case "${1}" in
    test_all)
        [ "${#}" -eq 1 ] || usage
        test_all
        ;;
    test)
        [ "${#}" -eq 2 ] || usage
        test ${2}
        ;;
    *)
        echo usage ${1}
        exit 255
esac



#!/bin/bash
function print_replace_content {
    REPLACE_CONTENT=$(for i in $(ls bundles/); do echo -n "\"fond-of-impala/${i}\": \"*\","; done | sed 's/,$//' )
    echo $REPLACE_CONTENT | sed 's/,/,\n/g'
}

case "$1" in
    print_replace_content)
        print_replace_content
        ;;
    *)
        echo $"Usage: $0 print_replace_content"
        exit 255
esac

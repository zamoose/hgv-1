#!/bin/bash
PROV_ROOT="/vagrant/provisioning"

shopt -s nullglob
for file in $PROV_ROOT/conf.d/default-sites.yml $PROV_ROOT/customsites/*.yml
do
    echo "### Provisioning $file ###"
    $ANS_BIN $PROV_ROOT/wordpress.yml -i'127.0.0.1,' --extra-vars="@$file"
done

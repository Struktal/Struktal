#!/bin/sh

for langDir in project/translations/*; do
    lang=$(basename $langDir)
    msgfmt -o project/translations/$lang/LC_MESSAGES/messages.mo project/translations/$lang/LC_MESSAGES/messages.po
done

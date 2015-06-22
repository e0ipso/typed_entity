#!/bin/bash
# @file
# Simple script to run the tests.

set -e

# Goto current directory.
DIR=$(dirname $0)
cd $DIR

drush test-run "Typed Entity" "$@"

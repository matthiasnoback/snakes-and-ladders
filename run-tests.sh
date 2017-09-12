#!/usr/bin/env bash

set -eux

vendor/bin/phpunit
vendor/bin/behat

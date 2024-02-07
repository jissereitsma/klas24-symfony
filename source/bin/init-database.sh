#!/bin/bash
bin/console doctrine:migrations:migrate --no-interaction
bin/console category:sync
bin/console product:sync
bin/console product:generate

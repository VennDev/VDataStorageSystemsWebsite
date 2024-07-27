#!/bin/bash

echo -ne "\033]0;VDataStorageSystemsWebsite\007"

php -S localhost:8080 -t src/venndev router.php

read -p "Press [Enter] to exit..."
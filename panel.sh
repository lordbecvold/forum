#!/bin/bash

# clear console in script start
clear

# print panel menu
echo "\033[33m\033[1m############################################################################\033[0m"
echo "\033[33m\033[1m##\033[0m                                \033[32mWEB PANEL\033[0m                               \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m############################################################################\033[0m"
echo "\033[33m\033[1m##\033[0m                                                                        \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m   \033[33m1    -   Start dev server\033[0m        \033[33m2   -   Build production\033[0m            \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m   \033[33m3    -   Run tests\033[0m               \033[33m4   -   Run config manager\033[0m          \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m                                                                        \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m   \033[33m5    -   Run installer\033[0m                                               \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m                                                                        \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m############################################################################\033[0m"
echo "\033[33m\033[1m##\033[0m   \033[33m0    -   Exit panel\033[0m                                                  \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m############################################################################\033[0m"

# stuck menu for select action
read selector

# clear console with select
clear

# selector action
case $selector in

	1*)
		sh scripts/start.sh
	;;
	2*)
		sh scripts/build_prod.sh
	;;
	3*)
		php tests/ResponseTest.php
		php tests/CryptTest.php
		php tests/HashTest.php
	;;
	4*)
		sh scripts/config_manager.sh
	;;
	5*)
		sh scripts/install.sh
	;;
	0*)
		exit
	;;
	*)
		echo "\033[33mYour vote not found!\033[0m"
	;;
esac

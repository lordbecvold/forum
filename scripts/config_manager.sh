#!/bin/bash

# clear console in script start
clear

red_echo () { echo "$(tput setaf 9)$1"; }

# print panel menu
echo "\033[33m\033[1m############################################################################\033[0m"
echo "\033[33m\033[1m##\033[0m                                \033[32mWEB PANEL\033[0m                               \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m############################################################################\033[0m"
echo "\033[33m\033[1m##\033[0m                                                                        \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m   \033[33m1    -   Start maintenance\033[0m       \033[33m2   -   Stop maintenance\033[0m            \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m                                                                        \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m                                                                        \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m##\033[0m                                                                        \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m############################################################################\033[0m"
echo "\033[33m\033[1m##\033[0m   \033[33m0    -   Back panel\033[0m                                                  \033[33m\033[1m##\033[0m"
echo "\033[33m\033[1m############################################################################\033[0m"

# ttuck menu for select action
read selector

# clear console with select
clear

# selector methodes
case $selector in

	1*)
		sed -i 's/"disabled"/"enabled"/' config.php
		red_echo "Config: maintenance mode is enabled!"
	;;
	2*)
		sed -i 's/"enabled"/"disabled"/' config.php
		red_echo "Config: maintenance mode is disabled!"
	;;
	0*)
		sh panel.sh
	;;
	*)
		echo "\033[33mYour vote not found!\033[0m"
	;;
esac

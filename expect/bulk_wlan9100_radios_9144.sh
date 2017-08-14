#!/bin/bash
while IFS=$'\n' read line
do  
    if [[ "$line" =~ \#.* ]];then
        echo "comment line: Ignoring $line"
    else
       ./wlan9100_radios_9144.exp "$line" "admin" "admin";
       # echo "normal line:$line"
    fi
done <  lhs.txt

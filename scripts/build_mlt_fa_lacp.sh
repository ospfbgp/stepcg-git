#!/bin/bash
echo "# remove mlt"
for i in {101..112}
do
echo "no mlt $i"
done
echo "# create mlt"
for i in {101..112}
do
p=$((i-100))
echo "mlt $i"
echo "mlt $i name lacp-$i"
echo "interface mlt $i"
echo "lacp key $i"
echo "lacp ena"
echo "fa enable"
echo "no fa message-authentication"
echo "smlt"
echo "exit"
echo ""

echo "interface gigabit 1/$p"
echo "name lacp-$i"
echo "lacp key $i"
echo "lacp aggregation ena"
echo "lacp mode active"
echo "lacp ena"
echo "no spanning-tree mstp"
echo "y"
echo "no shut"
echo "exit"
echo ""
done

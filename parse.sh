#!/bin/bash
#tshark -Y http.host==mikolaj.ovh -T fields -e http.cookie -e http.request.uri > tshark_cookies.txt

echo $(cat tshark_cookies.txt | awk -F '\t' '{print $1}' | awk 'NF' > cookies.txt)
echo $(awk '!seen[$0]++' cookies.txt > cookies_dup.txt)

echo $(python3 test.py cookies_dup.txt)

#!/bin/bash

#start product_id=55181
#end   product_id=104013

for pid in `seq 55181 104013`
do
echo "insert into merchantproduct (merchant_id,product_id) values(282, $pid);"
done

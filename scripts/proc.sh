#!/bin/bash

declare -A CAT
export CAT
# CAT,category_id,subcat_level=1,subcat_id
CAT["01-FOOD 1"]="5,87"
CAT["02-FOOD 2"]="5,87"
CAT["03-CONFECTIONERY"]="5,837"
CAT["04-SUNDRY"]="5,838"
CAT["05-FRESH MART"]="5,84"
CAT["06-FROZEN"]="5,95"
CAT["07-MEDICINE"]="4,835"
CAT["08-TOBACCO/CIGARETTE"]="6,452"
CAT["09-LIQUOR"]="5,839"
CAT["10-COSMETIC"]="3,582"
CAT["11-TOILETRIES"]="4,676"
CAT["12-ELECTRICAL APPLIANCES"]="1,3"
CAT["13-TOYS"]="7,125"
CAT["14-COTTON"]="6,57"
CAT["15-EMBROIDERIES"]="6,437"
CAT["16-STATIONERY"]="16,206"
CAT["17-HARDWARE"]="6,451"
CAT["18-GLASSWARE"]="6,841"
CAT["19-COSTUME JEWELLERY"]="846"
CAT["20-COMPUTER"]="1,1"
CAT["22-GENTS SHIRT"]="2,653"
CAT["23-GENTS PANTS"]="2,653"
CAT["24-GENTS BASIC"]="2,653"
CAT["25-GENTS ACCS"]="2,669"
CAT["26-SPORT WEAR"]="2,843"
CAT["27-SHOES/HANDBAGS"]="2,847"
CAT["28-LADIES FASHION"]="2,39"
CAT["29-LADIES BASIC WEAR"]="2,844"
CAT["30-LADIES ACCESSORIES"]="2,668"
CAT["31-CHILDREN DRESS"]="2,654"
CAT["32-CHILDREN TOP"]="2,654"
CAT["33-CHILDREN BOTTOM"]="2,654"
CAT["34-CHILDREN BASIC WEAR"]="2,654"
CAT["35-SCHOOL UNIFORM"]="2,658"
CAT["36-BABY WEAR"]="23,826"
CAT["37-BABY TOILETRIES"]="23,816"
CAT["38-BABY ACCS"]="23,812"
CAT["50-BRIGHTWAY"]="26,848"
CAT["51-YOUNG COSTUME JEWELLER"]="26,849"
CAT["52-LEE TRADING-CONSIGN"]="26,850"
CAT["53-INDO IMPERIAL-CONSIGN"]="26,851"
CAT["54-STATIONERY-CONSIGN"]="26,853"
CAT["55-IBRA FASHION"]="26,854"
CAT["56-ALBERT-CONSIGN"]="26,855"
CAT["57-CHIAN YIH-CONSIGN"]="26,856"
CAT["58-FRESH BAKERY"]="5,89"
CAT["60-KITCHEN WARE"]="6,432"

#echo '***** Internal ******'
#echo ${CAT["34-CHILDREN BASIC WEAR"]} 


i=0
while read -r line; do
	line=`echo $line | tr -d '"'`
	sc1=`echo $line|cut -d';' -f1` #"PRODUCT CATEGORY",subcat_level_1   
	sc2=`echo $line|cut -d';' -f2` #"PRODUCT GROUP",subcat_level_2      
	sku=`echo $line|cut -d';' -f3` #"STOCK CODE",product.sku            
	bc=` echo $line|cut -d';' -f4` #"BARCODE",bc_management.barcode     
	nam=`echo $line|cut -d';' -f5` #"DESCRIPTION 1",product.description 
	pd1=`echo $line|cut -d';' -f6` #"DESCRIPTION 2",product.description 
	pd2=`echo $line|cut -d';' -f7` #"DESCRIPTION 3",product.description 
	pd3=`echo $line|cut -d';' -f8` #"UNIT DESC",product.description     
	prp=`echo $line|tr -d ' '|cut -d';' -f9` #"PRICE 1",product.retail_price
	dprp=`echo "scale=0;$prp * 100"|bc`
	desc="$pd1 $pd2 $pd3"

	if [ "$sc1" = "" ]||[ "$sc2" = "" ]; then
		continue
	fi

	category_id=`echo ${CAT[$sc1]} | cut -d',' -f1`
	subcat_id=`  echo ${CAT[$sc1]} | cut -d',' -f2`

	if [ "$nam" = "PROMOSI ITEM" ]; then
		nam="PROMOSI ITEM MYR${prp}"
	fi

	#if [ "$i" = "4859" ]; then
    #	echo ">>$dprp<<"
	#	echo    "'b2c',$category_id,1,$subcat_id,\"$sku\",\"$nam\",\"$desc\",${dprp},'active');"
	#fi

	echo -n "insert into product (segment,category_id,subcat_level,subcat_id,"
	echo -n "sku,name,description,retail_price,status) values("
	echo    "'b2c',$category_id,1,$subcat_id,\"$sku\",\"$nam\",\"$desc\",${dprp},'active');"

	let i=i+1
done

#echo -n 'Successfully completed generating import script! '
#echo    "$i records generated!"


<script type="text/javascript">
function arraySum(anArray) {
	var ret=0;
	for (var i = anArray.length - 1; i >= 0; i--) {
		ret+=anArray[i];
	}
	return ret;
}
// This function is a port of the Php function but is not giving the desired results. This is more efficient and should be used.
	function sumCombos(numberArray,desiredSum,errorMargin,partialArray=[]) {
		var sum = partialArray.reduce((a,b)=>a+b,0);
		
		// console.log(partialArray);
		console.log(sum);
		// var error=(errorMargin*desiredSum)/100;
		// var minErrorSum= desiredSum-error;
		// var maxErrorSum=desiredSum+error;
		// if (sum>= minErrorSum && sum<= maxErrorSum) {
		// 	comboArray.push(partialArray);
		// }

		if (sum==desiredSum) {
			comboArray.push(partialArray);
		}
		if (sum>=desiredSum) {
			return 0;
		}
		i=0;
		while(i<numberArray.length) {
			 var n = numberArray[i];
			 var remaining=numberArray.slice(); //Copy of NumberArray
			 remaining.shift();
			 var temp= partialArray.slice();
			 if (partialArray.includes(n)==false) {
			 	temp.push(n);
			 	sumCombos(remaining,desiredSum,errorMargin,temp);
			 }
			 i++;
		}
	}
</script>
<script type="text/javascript">
	
		// Global Variable
		var comboArray=[];
		var anArray=[3,7,9,8,4,5,10];
		sumCombos(anArray,19,2);
		// console.log(comboArray);
		for (var i = comboArray.length - 1; i >= 0; i--) {
			console.log(comboArray[i]);
		}
	
</script>
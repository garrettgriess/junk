<?
/*
	Garrett's FizzBuzz Script - Version 0.04

	History Log:
	0.04 - Changed $i to start at 1. Changed += to .= -Thinking of JS. Fixed spelling mistake in comments. Dang it!
	0.03 - Added parentheses to "if !$num" line. Dang it!
	0.02 - Removed semi colon from for loop. Got Carried away with the semi colons. Dang it!

	Future Plans:
	Give up on programming forever and apply at nearest fast food restaurant. :)
*/

for ($i=1;$i<=100;$i++) {
	$num="";
	if ($i%3==0) {
		$num.="Fizz";
	}
	if ($i%5==0) {
		$num.="Buzz";
	}
	if (!$num) {
		$num=$i;
	}
	echo $num."<br>\r\n";
}
?>
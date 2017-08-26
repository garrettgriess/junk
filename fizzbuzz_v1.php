<?
/*
	Garrett's First FizzBuzz Script Attempt - Version 1.0

	History Log:
		Version 1.0
		 - Tested and ready for market. Created list of Future Plans. Dang it!
		 
		Version 0.04
		 - Changed $i to start at 1, Changed += to .= (was thinking of JS,) and fixed spelling mistake in comments. Dang it!
		 
		Version 0.03
		 - Added parentheses to "if !$num" line. Dang it!
		
		Version 0.02
		 - Removed semicolon from for loop. Got carried away with the semicolons. Dang it!

	Future Plans:
		- Give up on programming forever and apply at nearest fast food restaurant.
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
<?php

class BinaryHelper {
	public static function addCheckBytes($buffer){
		$sum = 0;
		$arr = str_split ( $buffer );

		foreach ( $arr as $v ) {
		 	$sum = $sum + ord ( $v );
		}


		$sumLast = substr(dechex($sum), -2, 2);
        $value = hexdec($sumLast);

       	$result = $buffer . pack('C', $value);

       	return $result;
	}
}

?>


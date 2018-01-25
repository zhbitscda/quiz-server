<?php

		$numbers = array(hexdec(0xFE), 1, 0, 0, 100, 101, 0);

		       	$buffer = pack('CnCCCCn', 0xFE, 1, 0, 0, 100, 101, 0);

		       	$arr = str_split ( $buffer );
	foreach ( $arr as $v ) {
		echo ord ( $v ), "\n";
	}

?>



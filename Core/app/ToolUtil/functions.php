<?php

	/**
	 * 获取当前Unix时间戳和微秒数
	 */
    function getMicrotime()
	{
   		list($usec, $sec) = explode(" ", microtime());
   		return ((float)$usec + (float)$sec);
	}

	/**
	 * 打印数组
	 */
	function p($var, $echo=true, $label='<pre>', $strict=false) {
	    $label = ($label === null) ? '' : rtrim($label) . ' ';
	    if (!$strict) {
	        if (ini_get('html_errors')) {
	            $output = print_r($var, true);
	            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
	        } else {
	            $output = $label . print_r($var, true);
	        }
	    } else {
	        ob_start();
	        var_dump($var);
	        $output = ob_get_clean();
	        if (!extension_loaded('xdebug')) {
	            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
	            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
	        }
	    }
	    if ($echo) {
	        echo($output);
	        return null;
	    }else
	        return $output;
	}

	/**
	 * 产生1-Z随机数
	 */
	function randomkeys($length) {
        $returnStr='';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for($i = 0; $i < $length; $i ++) {
            $returnStr .= $pattern {mt_rand ( 0, 61 )}; //生成php随机数
        }
        return $returnStr;
  }

  /**
   * 数字转英文
   */
   function numberToEnglish($number){
     $enws=array(
       0=>"A",1=>"B",2=>"C",3=>"D",4=>"E",
       5=>"F",6=>"G",7=>"H",8=>"I",9=>"J",
     );
     return $enws[$number];
   }

   /**
    * 英文转数字
    */
    function englishtToNumber($english){
      $enws=array(
        "A"=>0 ,"B"=>1, "C"=>2, "D"=>3 ,"E"=>4,
        "F"=>5 ,"G"=>6, "H"=>7, "I"=>8 ,"J"=>9,
      );
      return $enws[$english];
    }

    //组合多维数组
    function unlimitedForLayer($cate, $pid = 0){
        $arr = array();
        foreach ($cate as $v) {
          if($v['parentId'] == $pid){
            $v['children'] = unlimitedForLayer($cate,$v['id']);
            unset($v['pivot']);
            if($v['description'] == null){
              $v['description'] = "";
            }
            $arr[] = $v;
          }
        }
        return $arr;
    }

		//获取文件后缀
		function get_extension($file)
		{
			return substr(strrchr($file, '.'), 1);
		}

		// 多线程处理
		function curl_post_muti_handle($url, $data, $mh=null) {
			  if(!$mh){
					$mh = curl_multi_init ();
				}

		    $ch = curl_init ();
		    $timeout = 30;

				curl_setopt($ch, CURLOPT_URL, $url);
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	      // post数据
	      curl_setopt($ch, CURLOPT_POST, 1);
	      // post的变量
	      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);

		    curl_multi_add_handle($mh, $ch);

				$active = null;

				executeHandles($mh);

				// do{
				//     curl_multi_exec($mh,$running);
				// }while($running > 0);
		}

		function executeHandles($mh) {
    if (! empty ( $mh )) {
        $active = null;
        // execute the handles
        do {
            $mrc = curl_multi_exec ( $mh, $active );
        } while ( $mrc == CURLM_CALL_MULTI_PERFORM );
        while ( $active && $mrc == CURLM_OK ) {
            if (curl_multi_select ( $mh ) == - 1) {
                usleep ( 100 );
            }
            do {
                $mrc = curl_multi_exec ( $mh, $active );
            } while ( $mrc == CURLM_CALL_MULTI_PERFORM );
        }
    }

		function tranferCn($str=""){
			if($str=="") return;
			$cnArray = array(
				'0' => '零',
				'1' => '一',
				'2' => '二',
				'3' => '三',
				'4' => '四',
				'5' => '五',
				'6' => '六',
				'7' => '七',
				'8' => '八',
				'9' => '九'
			);
			$ret = array();
			for($i=0;$i<strlen($str);$i++)
			{
			  $middle = substr($str,$i,1); //将单个字符存到数组当中
				$ret .= $cnArray[$middle];
			}
			return $ret;
		}

}

?>

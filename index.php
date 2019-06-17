<?php



	//可以发送get和post的请求方式
	function curl_request($url,$method='get',$data=null,$https=false){
		
	    //1.初识化curl
	    $ch = curl_init($url);
	    //2.根据实际请求需求进行参数封装
	    //返回数据不直接输出
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    //如果是https请求
	    if($https === true){
	        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	    }
	    //如果是post请求
	    if($method === 'post'){
	        //开启发送post请求选项
	        curl_setopt($ch,CURLOPT_POST,true);
	        //发送post的数据
	        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	    }
	    //3.发送请求
	    $result = curl_exec($ch);
	    //4.返回返回值，关闭连接
	    curl_close($ch);
	    return $result;
	}



	/*
	*	重复截取你想要的字符串
	*	$str 截取的字符串	
	*	$start 开始的字符	
	*	$start 双层精度 可开可不开	
	*	$end 结束的字符
	*	$start_substr_lenght 为了获取更为准确的字符串，自定义改变 截取前的长度
	*	$end_substr_lenght 为了获取更为准确的字符串，自定义改变结尾前 截取后的长度
	*	$reyurn_type 想要返回的数据类型	1|2|3  数组|字符串|两种都要
	*/
	function strrt_end_substr($str,$starts= '',$start = '',$end = '',$start_substr_lenght = 0,$end_substr_lenght = 7,$reyurn_type = 1)
	{

		$soso1 = $str;		// 赋值
		$zhuaqu_str_array = []; 	//抓取需要获取的str
		$zhuaqu_str_str = ''; 	//抓取需要获取的str
		$start_substr_lenght = $start_substr_lenght ?  $start_substr_lenght : mb_strlen($start);		//截取前的长度

		for ($i=1; $i > 0 ; $i++) {	  //循环 直到找不到匹配的字符串 才会结束

			if ($starts) {	//双精度
				$soso1 = mb_strstr($soso1,$starts);		// 再次检查一下是否存在想要截取的字符串
				$soso1 ? $soso1 = mb_strstr($soso1,$start) : '';

			}else{
				$soso1 = mb_strstr($soso1,$start);		// 先检查一下是否存在想要截取的字符串
			}


			if ($soso1) {	//判断是否存在这个字符串
				
				$end_substr_lenght = mb_strpos($soso1,$end) - $end_substr_lenght;	//结尾索引


				$zhuaqu_str_array[$i] = mb_substr($soso1,$start_substr_lenght,$end_substr_lenght);	//存入数组

				$zhuaqu_str_str =  $zhuaqu_str_array[$i] . ',';		//存入字符串

				$soso1 = mb_strstr($soso1,$end);	// 处理截取后的字符串，生成新的字符串，再次处理

			}else{

				// 处理生成的数组和字符串
				if (count($zhuaqu_str_array) !== 0) {
					$zhuaqu_str_str = substr($zhuaqu_str_str,0,-1);
					$i = -100;
				}

				// 返回数据
				if (count($zhuaqu_str_array) == 0) {
					return array('没有匹配到',[0=>'没有匹配到']);
				}else{

					switch ($reyurn_type) {
						case '1':
							return array($zhuaqu_str_array);
							break;
						case '2':
							return $zhuaqu_str_str;
							break;
						case '3':
							return array($zhuaqu_str_str,$zhuaqu_str_array);
							break;
					}
					
				}

			}
			
		}

	}


	$url_data = [
		
		"http://www.findingschool.net/Phillips-Exeter-Academy",
		"http://www.findingschool.net/The-Lawrenceville-School",
		"http://www.findingschool.net/Marianapolis-Preparatory-School",
		"http://www.findingschool.net/Phillips-Academy-Andover",
		"http://www.findingschool.net/The-Hotchkiss-School",
		"http://www.findingschool.net/Middlesex-School",
		"http://www.findingschool.net/Groton-School",
		"http://www.findingschool.net/St-Pauls-School",
		"http://www.findingschool.net/Milton-Academy",
		"http://www.findingschool.net/Deerfield-Academy",
		
		
	];




	// 获取院校 官网
	foreach ($url_data as $key => $value) {

		$curl_str = curl_request($value); //获取网页


		$soso = mb_strstr($curl_str,'建校年份');// 先检查一下是否有图片
		if (!$soso) {
			print_r( "没找到1");
		}else{

			$res = strrt_end_substr($soso,'建校年份','<td>','</td>',4,5,2);
			
			// 打印
			echo "<pre>";
			print_r($res);

		}

	}


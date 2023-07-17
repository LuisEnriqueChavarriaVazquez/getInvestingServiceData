<?php

	function my_curl($url, $timeout=500, $error_report=TRUE)
	{
		$curl = curl_init();

		$header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: close";
		$header[] = "User-Agent: m";
		$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: en-us,en;q=0.5";
		$header[] = "Pragma: "; // browsers keep this blank.

		// SET THE CURL OPTIONS - SEE http://php.net/manual/en/function.curl-setopt.php
		curl_setopt($curl, CURLOPT_URL,            $url);
		curl_setopt($curl, CURLOPT_USERAGENT,      'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
		curl_setopt($curl, CURLOPT_HTTPHEADER,     $header);
		curl_setopt($curl, CURLOPT_REFERER,        'http://www.google.com');
		curl_setopt($curl, CURLOPT_ENCODING,       'gzip,deflate');
		curl_setopt($curl, CURLOPT_AUTOREFERER,    TRUE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl, CURLOPT_TIMEOUT,        $timeout);

		// RUN THE CURL REQUEST AND GET THE RESULTS
		$htm = curl_exec($curl);
		$err = curl_errno($curl);
		$inf = curl_getinfo($curl);
		curl_close($curl);

		// ON FAILURE
		if (!$htm)
		{
			// PROCESS ERRORS HERE
			if ($error_report)
			{
				error_log("CURL FAIL: $url TIMEOUT=$timeout, CURL_ERRNO=$err");
				error_log(var_dump($inf));
			}
			return FALSE;
		}

		// ON SUCCESS
		return $htm;
	}

	$prueba = my_curl("http://www.google.com");
	echo $prueba;

?>

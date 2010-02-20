<?php
function send_request( $call, $args = false)
{
	$options = array(
	    CURLOPT_RETURNTRANSFER => true,     // return web page
	    CURLOPT_HEADER         => false,    // don't return headers
	    CURLOPT_FOLLOWLOCATION => true,     // follow redirects
	    CURLOPT_ENCODING       => "",       // handle all encodings
	    CURLOPT_USERAGENT      => "spider", // who am i
	    CURLOPT_AUTOREFERER    => true,     // set referer on redirect
	    CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
	    CURLOPT_TIMEOUT        => 120,      // timeout on response
	    CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);

	$url = "http://localhost/naturalmoney/server/main.php?call=$call";
	$ch      = curl_init( $url );

	if ($args) {
		curl_setopt($ch, CURLOPT_POST, true);

		// this should be done more cleanly
		foreach ($args AS $key=>$value)
		{
			if (is_array($value)) {
				foreach ($value AS $ke=>$val)
				{
					if (is_array($val)) {
						foreach ($val AS $k=>$v)
							$post_url .= $key.'['.$ke.']['.$k.']='.$v.'&';
					}
					else
						$post_url .= $key.'['.$ke.']='.$val.'&';
				}
			}
			else
				$post_url .= $key.'='.$value.'&';
		}
		$post_url = rtrim($post_url, '&');
		//echo $post_url."<br>".urldecode(http_build_query($args))."<br>";
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_url);
	}
	curl_setopt_array( $ch, $options );
	$info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$content = curl_exec( $ch );
	curl_close( $ch );
	return $content;
}
?>
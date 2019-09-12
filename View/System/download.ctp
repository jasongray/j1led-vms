<?php
ob_flush();
flush();
set_time_limit(0);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_PROGRESSFUNCTION, 'progressBar');   
curl_setopt($curl, CURLOPT_NOPROGRESS, false); // needed to make progress function work
$html = curl_exec($curl);
curl_close($curl);			
function progressBar($download_size, $downloaded, $upload_size, $uploaded) {
	static $previousProgress = 0;
	if ($download_size == 0) {
		$progress = 0;
	} else {
		$progress = round( $downloaded * 100 / $download_size );
	}
	if ($progress > $previousProgress) {
		$previousProgress = $progress;
		echo '<script>parent.updateProgress(' . $progress . ');</script>';
		//echo $progress;
		//echo "<script type=\"text/javascript\">$('.bar').prop('style', 'width:$progress%');</script>";
		ob_flush();
		flush();
    	sleep(1);
	}
}
ob_flush();
flush();
?>
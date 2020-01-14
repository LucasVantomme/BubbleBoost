<?php
for($i=1; $i<=20; $i++) {
	$in = 'http://funquizzes.fun//uploads/manga/Gamaran/0005/'.sprintf("%03d", $i).'.jpg';
	$out = '1/5/'.$i.'.jpg';
	file_put_contents($out, file_get_contents($in));
//	sleep(1);
}
?>
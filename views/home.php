<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>
		Interview Test 1 - Activist Network
	</title>
	<link rel="stylesheet" href="<?= CSS_PATH ?>/style.css" type="text/css">
</head>
<body>
	<br />
	<div id="section">
		<button data-val="koyan" class="btn activist-btn">koyan</button>
		<button data-val="remy" class="btn activist-btn">remy</button>
		<button data-val="bill" class="btn activist-btn">bill</button>
		<button data-val="maria" class="btn activist-btn">maria</button>
		<button data-val="helen" class="btn activist-btn">helen</button>
		<button data-val="jim" class="btn activist-btn">jim</button>

		<div id="headline">
			<?php
				if(isset($_GET['activist-name']) && $_GET['activist-name'])
					echo $_GET['activist-name'] . '\'s network';
			?>
		</div>
		<form id="form" method="get" action="../index.php">
			<input type="hidden" id="activist-name" name="activist-name" value="<?=$_GET['activist-name'] ?? ''?>" />
		</form>
	</div>
</body>
</html>

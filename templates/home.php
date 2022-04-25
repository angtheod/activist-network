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
	<link rel="stylesheet" href="<?= CSS_PATH ?>style.css" type="text/css">
</head>
<body>
<br />
<div id="section">
	<button data-val="Kyle" class="btn activist-btn">Kyle</button>
	<button data-val="Remy" class="btn activist-btn">Remy</button>
	<button data-val="Bill" class="btn activist-btn">Bill</button>
	<button data-val="Maria" class="btn activist-btn">Maria</button>
	<button data-val="Helen" class="btn activist-btn">Helen</button>
	<button data-val="Jim" class="btn activist-btn">Jim</button>

	<div id="headline">
		<?php
			if(isset($_GET['activist-name']) && $_GET['activist-name'])
				echo $_GET['activist-name'] . '\'s network';
		?>
	</div>
	<small>(hover name to see signed actions)</small>

	<form id="form" method="get" action="index.php">
		<input type="hidden" id="activist-name" name="activist-name" value="<?= $_GET['activist-name'] ?? '' ?>" />
	</form>
	<br /><a href=".">Clear</a>
</div>
</body>
</html>
<script type="text/javascript" src="<?= JS_PATH ?>main.js"></script>

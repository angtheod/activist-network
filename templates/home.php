<?php

/**
 * @var array $data
 */

$activistName = $data['activistName'];
$activists    = $data['activists'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        Interview Test 1 - Activist Network
    </title>
    <link rel="stylesheet" href="<?= CSS_FILE ?>?v=<?= filemtime(CSS_FILE)?>" type="text/css">
</head>
<body>
<br />
<div id="section">
    <?php foreach ($activists as $activist) { ?>
        <button data-val="<?= $activist['name'] ?>" class="btn activist-btn"><?= $activist['name'] ?></button>
    <?php } ?>
    <a href=".">Clear</a><br />

    <?php if ($activistName) { ?>
        <div id="headline">
            <?= $activistName . '\'s network' ?>
        </div>
        <small>(hover name to see signed actions)</small>
        <br /><br />
    <?php } ?>

    <form id="form" method="get" action="index.php">
        <input type="hidden" id="activist-name" name="activist-name" value="<?= $activistName ?? '' ?>" />
    </form>
</div>
</body>
</html>
<script type="text/javascript" src="<?= JS_FILE ?>?v=<?= filemtime(JS_FILE)?>"></script>

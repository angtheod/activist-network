<?php

/**
 * @var array $data
 * @var Activist $activist
 * @var int $depth
 */

use models\Activist;

$activist = $data['activist'];
$depth    = $data['depth'];
?>
<ul>
    <li id="depth<?= $depth ?>" class="hoverable">
        <span class="hoverable__main"><?= $activist->getName() ?></span> (<?= $depth ?>)
        <span class="hoverable__tooltip"><?= implode('<br />', $activist->getSignedActionsNames()) ?></span>
    </li>

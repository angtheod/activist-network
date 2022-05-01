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
    <li class="hoverable">
        <div id="depth<?= $depth ?>" class="hoverable__main sticky"><?= htmlspecialchars($activist->getName()) ?> (<?= $depth ?>)</div>
        <div class="hoverable__tooltip"><?= implode(', ', array_map('htmlspecialchars', $activist->getSignedActionsNames())) ?></div>
    </li>

<?php

/**
 * @var Activist $activist
 * @var int $depth
 */

use models\Activist;
?>
<ul>
    <li id="depth<?= $depth ?>" class="hoverable">
        <span class="hoverable__main"><?= $activist->getName() ?></span> (<?= $depth ?>)
        <span class="hoverable__tooltip"><?= implode('<br />', $activist->getSignedActionsNames()) ?></span>
    </li>

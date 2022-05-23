<?php

namespace tests\unit;

use models\Action;
use PHPUnit\Framework\TestCase;

/**
 * Class ActionTest
 * @package tests/unit
 */
class ActionTest extends TestCase
{
    /**
     * @covers Action::__construct
     * @covers Action::signedBy
     */
    public function testSignedBy()
    {
    }

    /**
     * @covers Action::getSigningActivists
     */
    public function testGetSigningActivists()
    {
    }

    /**
     * @param int $id
     * @param string $name
     * @return Action
     */
    private function createSUT(int $id, string $name): Action
    {
        return new Action($id, $name);
    }
}

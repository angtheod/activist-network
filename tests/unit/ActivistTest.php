<?php

declare(strict_types=1);

namespace tests\unit;

use models\Action;
use models\Activist;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivistTest
 * @package tests/unit
 */
class ActivistTest extends TestCase
{
    /**
     * @covers Activist::__construct
     * @covers Activist::sign
     */
    public function testSign()
    {
        $activist = $this->createSUT(100, 'TestUser');
        $activist->sign(new Action(100, 'TestAction'));
    }

    /**
     * @covers Activist::getSignedActions
     * @covers Activist::getSignedActionsNames
     */
    public function testGetSignedActions()
    {
        $activist = $this->createSUT(100, 'TestUser');
        $this->assertCount(
            3,
            $activist->getSignedActions()
        );
        $this->assertEquals(
            [
                'Whales',
                'Climate',
                'Toxics'
            ],
            $activist->getSignedActionsNames()
        );
    }

    /**
     * @covers Activist::setParent
     * @covers Activist::getParent
     */
    public function testHasCorrectParent()
    {
        $activist = $this->createSUT(100, 'TestUser');
        $activist->setParent($this->createSUT(99, 'TestParentUser'));
    }

    /**
     * @covers Activist::setChild
     * @covers Activist::getChildren
     */
    public function testHasCorrectChildren()
    {
        $activist = $this->createSUT(100, 'TestUser');
        $activist->setChild($this->createSUT(101, 'TestChildUser1'));
        $activist->setChild($this->createSUT(102, 'TestChildUser2'));
    }

    /**
     * Creates instance of SUT (System Under Test)
     *
     * @param int $id
     * @param string $name
     * @return Activist
     */
    private function createSUT(int $id, string $name): Activist
    {
        return new Activist($id, $name);
    }
}

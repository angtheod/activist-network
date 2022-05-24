<?php

declare(strict_types=1);

namespace tests\unit;

use models\Action;
use models\Activist;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivistTest
 * @package tests/unit
 */
class ActivistTest extends TestCase
{
    /**
     * @covers Activist::__construct
     * @covers Activist::setParent
     * @covers Activist::getParent
     */
    public function testHasCorrectParent()
    {
        $activist = $this->createSUT(100, 'TestUser');
        $activistParent = $this->createSUT(99, 'TestParentUser');
        $activist->setParent($activistParent);

        $this->assertSame(
            $activistParent,
            $activist->getParent()
        );
    }

    /**
     * @covers Activist::setChild
     * @covers Activist::getChildren
     */
    public function testHasCorrectChildren()
    {
        $activist       = $this->createSUT(100, 'TestUser');
        $activistChild1 = $this->createSUT(101, 'TestChildUser1');
        $activistChild2 = $this->createSUT(102, 'TestChildUser2');
        $activist->setChild($activistChild1);
        $activist->setChild($activistChild2);

        $this->assertTrue(
            isset($activist->getChildren()[$activistChild1->getId()])
        );
        $this->assertTrue(
            isset($activist->getChildren()[$activistChild2->getId()])
        );
    }

    /**
     * @covers Activist::getSignedActions
     * @covers Activist::getSignedActionsNames
     */
    public function testGetSignedActions()
    {
        $activist = $this->createSUT(100, 'TestUser');

        //Create stub(s) of dependency class
        $stubAction1 = $this->createDependency(Action::class, 1, 'Whales', $activist);
        $this->assertEquals(1, $stubAction1->getId());            //Test stub
        $this->assertEquals('Whales', $stubAction1->getName());

        $stubAction2 = $this->createDependency(Action::class, 2, 'Toxics', $activist);
        $this->assertEquals(2, $stubAction2->getId());            //Test stub
        $this->assertEquals('Toxics', $stubAction2->getName());

        $stubAction3 = $this->createDependency(Action::class, 4, 'Climate', $activist);
        $this->assertEquals(4, $stubAction3->getId());            //Test stub
        $this->assertEquals('Climate', $stubAction3->getName());

        //Assertions
        $activist->sign($stubAction1);
        $activist->sign($stubAction2);
        $activist->sign($stubAction3);
        $this->assertCount(
            3,
            $activist->getSignedActions()
        );
        $this->assertEquals(
            [
                'Whales',
                'Toxics',
                'Climate'
            ],
            $activist->getSignedActionsNames()
        );
    }

    /**
     * Create a stub of the dependency class
     *
     * @param string        $originalClassName
     * @param int           $id
     * @param string        $name
     * @param Activist|null $sut
     *
     * @return Action|Stub
     */
    protected function createDependency(string $originalClassName, int $id, string $name, Activist $sut = null): Action|Stub
    {
        $stub = $this->createStub($originalClassName);               //Create stub
        $stub->method('getId')->willReturn($id);           //Configure stub
        $stub->method('getName')->willReturn($name);
        $stub->method('signedBy')->with($sut);

        return $stub;
    }

    /**
     * Creates instance of SUT (System Under Test)
     *
     * @param int $id
     * @param string $name
     * @return Activist
     */
    protected function createSUT(int $id, string $name): Activist
    {
        return new Activist($id, $name);
    }
}

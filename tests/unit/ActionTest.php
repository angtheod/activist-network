<?php

namespace tests\unit;

use models\Action;
use models\Activist;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * Class ActionTest
 * @package tests/unit
 */
class ActionTest extends TestCase
{
    public const SUT = Action::class;    //System Under Test

    /**
     * @covers Action::__construct
     * @covers Action::signBy
     * @covers Action::isSignedBy
     * @covers Action::getSigningActivists
     */
    public function testSignBy()
    {
        $action = $this->createSUT(100, 'Energy');

        //Create stub(s) of dependency class
        $stubActivist1 = $this->createDependency(Activist::class, 101, 'TestUser1', $action);
        $this->assertEquals(101, $stubActivist1->getId());            //Test stub
        $this->assertEquals('TestUser1', $stubActivist1->getName());

        $stubActivist2 = $this->createDependency(Activist::class, 102, 'TestUser2', $action);
        $this->assertEquals(102, $stubActivist2->getId());            //Test stub
        $this->assertEquals('TestUser2', $stubActivist2->getName());

        $stubActivist3 = $this->createDependency(Activist::class, 103, 'TestUser3', $action);
        $this->assertEquals(103, $stubActivist3->getId());            //Test stub
        $this->assertEquals('TestUser3', $stubActivist3->getName());

        //Assertions
        $action->signBy($stubActivist1);
        //$action->signBy($stubActivist2);
        $action->signBy($stubActivist3);
        $this->assertContains(
            $stubActivist1,
            $action->getSigningActivists()
        );
        $this->assertNotContains(
            $stubActivist2,
            $action->getSigningActivists()
        );
        $this->assertContains(
            $stubActivist3,
            $action->getSigningActivists()
        );
        $this->assertTrue(
            $action->isSignedBy($stubActivist1)
        );
        $this->assertFalse(
            $action->isSignedBy($stubActivist2)
        );
    }

    /**
     * Create a stub of the dependency class
     *
     * @param string      $originalClassName
     * @param int         $id
     * @param string      $name
     * @param Action|null $sut
     *
     * @return Activist|Stub
     */
    protected function createDependency(string $originalClassName, int $id, string $name, Action $sut = null): Activist|Stub
    {
        $stub = $this->createStub($originalClassName);               //Create stub
        $stub->method('getId')->willReturn($id);           //Configure stub
        $stub->method('getName')->willReturn($name);

        return $stub;
    }

    /**
     * Creates instance of SUT (System Under Test)
     *
     * @param int $id
     * @param string $name
     *
     * @return Action
     */
    private function createSUT(int $id, string $name): Action
    {
        return new (self::SUT)($id, $name);
    }
}

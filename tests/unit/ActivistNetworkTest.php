<?php

declare(strict_types=1);

namespace tests\unit;

use models\Activist;
use models\ActivistNetwork;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivistNetworkTest
 * @package tests/unit
 */
class ActivistNetworkTest extends TestCase
{
    public const SUT = ActivistNetwork::class;  //System Under Test

    /**
     * @covers ActivistNetwork::__construct
     */
    public function testCanBeFilledForExistingUser(): void
    {
        $this->assertFalse(    //For UX purposes we catch all exceptions, so this is the way to test it was filled
            $this->createSUT('TestUser')->isEmpty()
        );
    }

    /**
     * @covers ActivistNetwork::readData
     * @covers ActivistNetwork::createActions
     * @covers ActivistNetwork::createActivists
     * @covers ActivistNetwork::signActions
     */
    public function testReadData(): void
    {
        $activistNetwork = $this->createSUT('TestUser');
        $this->assertCount(
            4,
            $activistNetwork->getActions()
        );
        $this->assertCount(
            6,
            $activistNetwork->getActivists()
        );
        $this->assertEquals(
            10,
            $activistNetwork->getSignedActions()
        );
        $this->assertTrue(    //Test invalid data
            $this->createSUT('TestUser', 'tests/samples/invalidtestdata.json')->isEmpty()
        );
    }

    /**
     * @covers ActivistNetwork::isEmpty
     */
    public function testCanNotBeFilledForNonExistingUser(): void
    {
        $this->assertTrue(    //For UX purposes we catch all exceptions, so this is the way to test it was not filled
            $this->createSUT('NonExistingUser')->isEmpty()
        );
        $this->assertTrue(
            $this->createSUT('')->isEmpty()
        );
    }

    /**
     * @covers ActivistNetwork::fill
     * @covers ActivistNetwork::getNetworkSize
     * @covers ActivistNetwork::getNetworkDepth
     */
    public function testFillNetwork()
    {
        $activistNetwork = $this->createSUT('TestUser');
        $this->assertEquals(
            9,
            $activistNetwork->getNetworkSize()
        );
        $this->assertEquals(
            3,
            $activistNetwork->getNetworkDepth()
        );
    }

    /**
     * @covers ActivistNetwork::addNode
     * @covers ActivistNetwork::getRoot
     */
    public function testAddNode(): void
    {
        $activistNetwork = $this->createSUT('TestUser');

        //Create stub(s) of dependency class
        $stubActivist = $this->createDependency(Activist::class, 100, 'TestChildUser', $activistNetwork);
        $this->assertEquals(100, $stubActivist->getId());                     //Test stub
        $this->assertEquals('TestChildUser', $stubActivist->getName());

        //Assertions
        $activistNetwork->addNode($stubActivist);        //Add stub node to network
        $this->assertSame(                               //Assert root node is parent of newly added stub node
            $activistNetwork->getRoot(),
            $stubActivist->getParent()
        );
        $this->assertEquals(                             //Assert root node is parent of newly added stub node
            6,
            $stubActivist->getParent()->getId()
        );
        $this->assertTrue(                               //Assert newly added stub node is a child of root node
            isset($activistNetwork->getRoot()->getChildren()[$stubActivist->getId()])
        );
//        $this->assertTrue(                               //Assert network contains newly added stub node
//            $activistNetwork->contains($stubActivist)    // TODO - Fix
//        );
    }

    /**
     * Create a stub of the dependency class
     *
     * @param string               $originalClassName
     * @param int                  $id
     * @param string               $name
     * @param ActivistNetwork|null $sut
     *
     * @return Activist|Stub
     */
    protected function createDependency(string $originalClassName, int $id, string $name, ActivistNetwork $sut = null): Activist|Stub
    {
        //Create stub(s) of dependency class
        $stub = $this->createStub($originalClassName);                   //Create stub
        $stub->method('getId')->willReturn($id);               //Configure stub
        $stub->method('getName')->willReturn($name);
        $stub->method('setParent')->with($sut->getRoot());
        $stub->method('getParent')->willReturn($sut->getRoot());

        return $stub;
    }

    /**
     * Creates instance of SUT (System Under Test)
     *
     * @param string $activistName
     * @param string|null $fileName
     *
     * @return ActivistNetwork
     */
    protected function createSUT(string $activistName, string $fileName = null): ActivistNetwork
    {
        return new (self::SUT)($activistName, $this->getTestDataFile($fileName));
    }

    /**
     * @param string|null $fileName
     *
     * @return string
     */
    protected function getTestDataFile(string $fileName = null): string
    {
        return $fileName ?? TEST_DATA_FILE;
    }
}

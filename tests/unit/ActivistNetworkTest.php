<?php

declare(strict_types=1);

namespace tests\unit;

use models\Activist;
use models\ActivistNetwork;
use PHPUnit\Framework\TestCase;

/**
 * Class ActivistNetworkTest
 * @package tests/unit
 */
class ActivistNetworkTest extends TestCase
{
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

        //Create a stub node to add as child and test it
        $stubActivist = $this->createMock(Activist::class);            //Create stub
        $stubActivist->method('getId')->willReturn(100);               //Configure stub
        $stubActivist->method('getName')->willReturn('TestChildUser');
        $stubActivist->method('setParent')->with($activistNetwork->getRoot());
        $stubActivist->method('getParent')->willReturn($activistNetwork->getRoot());

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
     * Creates instance of SUT (System Under Test)
     *
     * @param string $activistName
     * @param string|null $fileName
     * @return ActivistNetwork
     */
    private function createSUT(string $activistName, string $fileName = null): ActivistNetwork
    {
        return new ActivistNetwork($activistName, $this->getTestDataFile($fileName));
    }

    /**
     * @param string|null $fileName
     * @return string
     */
    private function getTestDataFile(string $fileName = null): string
    {
        return $fileName ?? TEST_DATA_FILE;
    }
}

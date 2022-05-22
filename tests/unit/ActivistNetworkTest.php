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
    public function testCanBeCreatedForExistingUser(): void
    {
        $this->assertFalse(
            $this->createInstance('TestUser')->isEmpty()
        );
    }

    /**
     * @covers ActivistNetwork::createActions
     * @covers ActivistNetwork::createActivists
     * @covers ActivistNetwork::signActions
     */
    public function testCanBeFilledForExistingUser(): void
    {
        $instance = $this->createInstance('TestUser');
        $this->assertCount(
            4,
            $instance->getActions()
        );
        $this->assertCount(
            6,
            $instance->getActivists()
        );
        $this->assertEquals(
            10,
            $instance->getSignedActions()
        );
    }

    /**
     * @covers ActivistNetwork::isEmpty
     */
    public function testCanNotBeFilledForNonExistingUser(): void
    {
        $this->assertTrue(
            $this->createInstance('NonExistingUser')->isEmpty()
        );
        $this->assertTrue(
            $this->createInstance('')->isEmpty()
        );
    }

    /**
     * @covers ActivistNetwork::fill
     * @covers ActivistNetwork::getNetworkSize
     * @covers ActivistNetwork::getNetworkDepth
     */
    public function testFillNetwork()
    {
        $instance = $this->createInstance('TestUser');
        $this->assertEquals(
            9,
            $instance->getNetworkSize()
        );
        $this->assertEquals(
            3,
            $instance->getNetworkDepth()
        );
    }

    /**
     * @covers ActivistNetwork::addChild
     * @covers Activist::getParent
     * @covers Activist::getChildren
     */
    public function testAddChild(): void
    {
        $instance = $this->createInstance('TestUser');
        $activist = new Activist(100, 'TestChildUser');
        $instance->addChild($activist);    //Add child to root node

        $this->assertEquals(               //Assert that root node is the parent of the newly added node
            $instance->getRoot()->getId(),
            $activist->getParent()->getId()
        );
        $this->assertTrue(                 //Assert newly added node is a child of root node
            isset($instance->getRoot()->getChildren()[$activist->getId()])
        );
    }

    /**
     * @param $activistName
     *
     * @return ActivistNetwork
     */
    private function createInstance($activistName): ActivistNetwork
    {
        return new ActivistNetwork($activistName, $this->getTestDataFile());
    }

    /**
     * Gets test data file
     * @return string path to test data
     */
    private function getTestDataFile(): string
    {
        return TEST_DATA_FILE;
    }
}

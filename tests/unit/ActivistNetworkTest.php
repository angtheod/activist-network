<?php

declare(strict_types=1);

namespace tests\unit;

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
        $this->assertInstanceOf(
            ActivistNetwork::class,
            $this->createInstance('TestUser')
        );
    }

    /**
     * @covers ActivistNetwork::__construct
     * @covers ActivistNetwork::isEmpty
     */
    public function testCanNotBeCreatedForNotExistingUser(): void
    {
        $this->assertTrue(
            $this->createInstance('NonExistingUser')->isEmpty()
        );
        $this->assertTrue(
            $this->createInstance('')->isEmpty()
        );
    }

    /**
     * @covers ActivistNetwork::createActions
     */
    public function testCreateActions()
    {
        // TODO: implement me
    }

    /**
     * @covers ActivistNetwork::createActivists
     */
    public function testCreateActivists()
    {
        // TODO: implement me
    }

    /**
     * @covers ActivistNetwork::signActions
     */
    public function testSignActions()
    {
        // TODO: implement me
    }

    /**
     * @covers ActivistNetwork::fill
     */
    public function testFill()
    {
        // TODO: implement me
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

<?php

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
     * @covers ActivistNetwork::createActions
     */
    public function testCreateActions()
    {
        /** @var ActivistNetwork $an */
        $an = $this->createActivistNetwork();
    }

    /**
     * @covers ActivistNetwork::createActivists
     */
    public function testCreateActivists()
    {
        /** @var ActivistNetwork $an */
        $an = $this->createActivistNetwork();
    }

    /**
     * @covers ActivistNetwork::signActions
     */
    public function testSignActions()
    {
        /** @var ActivistNetwork $an */
        $an = $this->createActivistNetwork();
    }

    /**
     * @covers ActivistNetwork::fill
     */
    public function testFill()
    {
        /** @var ActivistNetwork $an */
        $an = $this->createActivistNetwork();
    }

    /**
     *
     */
    private function createActivistNetwork()
    {
        // TODO: implement me
    }

    /**
     * Gets test data
     * @return string path to test data
     */
    private function getTestData(): string
    {
        return TEST_DATA_JSON;
    }
}
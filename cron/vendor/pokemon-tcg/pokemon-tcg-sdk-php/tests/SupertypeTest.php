<?php

use GuzzleHttp\Psr7\Response;
use Pokemon\Pokemon;

/**
 * Class SubtypeTest
 */
class SupertypeTest extends TestCase
{

    /**
     * @return string
     */
    protected function fixtureDirectory(): string
    {
        return 'supertypes';
    }

    /**
     * Run before tests
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpClientResponses([
            new Response(200, [], $this->getFixture('all.json')),
        ]);
    }

    /**
     * Get all supertypes
     */
    public function testAllReturnsAllSupertypes(): void
    {
        Pokemon::Options($this->clientOptions);
        $supertypes = Pokemon::Supertype()->all();

        $this->assertEquals(3, count($supertypes));
        $this->assertEquals(['Energy', 'Pokémon', 'Trainer'], $supertypes);
    }
}
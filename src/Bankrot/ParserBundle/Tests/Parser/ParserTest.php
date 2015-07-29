<?php

namespace Bankrot\ParserBundle\Tests\Parser;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ParserTest extends KernelTestCase
{
    private $parser;

    public function setUp()
    {
        self::bootKernel();
        $this->parser = static::$kernel->getContainer()
            ->get('bankrot_parser.parser');
    }

    public function testSync()
    {
        $this->parser->sync();
    }
}

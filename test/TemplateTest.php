<?php

namespace Pendenga\TemplatePHP\Test;

use Pendenga\TemplatePHP\Template;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    protected static $sample;

    static function setUpBeforeClass()
    {
        self::$sample = file_get_contents(__DIR__ . '/fixture/sample.csv');
    }

    /**
     * @covers \Pendenga\TemplatePHP\Template::getIt
     */
    public function testGetIt()
    {
        $template = new Template();
        $this->assertEquals('it', $template->getIt());
    }

    public function testSample()
    {
        $this->assertEquals("1,2,3\n", self::$sample);
    }
}

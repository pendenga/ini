<?php

namespace Pendenga\Ini\Test;

use DomainException;
use Pendenga\Ini\Ini;
use PHPUnit\Framework\TestCase;

class IniTest extends TestCase
{
    public function testLoadFailure()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('ini file not found');

        $ini = new Ini('not_there.ini');
        $ini->get('config_key');
    }

    public function testFindFile_override()
    {
        $ini = new Ini('unittest.ini');
        $this->assertEquals('unittest.ini', $ini->setIniDir(__DIR__ . '/fixture')->get('config_name'));
    }

    public function testGet()
    {
        $ini = new Ini('config.ini');
        $this->assertEquals('config_value', $ini->get('config_key'));
        $this->assertEquals('/tmp/unittest/', $ini->get('tmp_directory'));
    }

    public function testGet_array()
    {
        $ini = new Ini('config.ini');
        $this->assertEquals(['red', 'green', 'blue'], $ini->get('colors'));
    }

    public function testGet_notFound()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('undefined ini value: aint it');

        $ini = new Ini('config.ini');
        $ini->get('aint it');
    }

    public function testSection()
    {
        $ini = new Ini('config.ini');
        $this->assertEquals(
            [
                'config_key'    => 'config_value',
                'tmp_directory' => '/tmp/unittest/',
            ],
            $ini->section('unit test')
        );
    }

    public function testSection_alt()
    {
        $ini = new Ini('config.ini');
        $this->assertEquals(
            [
                'tmp_directory' => '/tmp/',
            ],
            $ini->section('app')
        );
    }

    public function testSection_notFound()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('undefined ini section: aint it');

        $ini = new Ini('config.ini');
        $ini->section('aint it');
    }
}

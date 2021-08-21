<?php

namespace Pendenga\Ini;

use DomainException;
use Pendenga\File\FileNotFoundException;

class Ini
{
    const MAX_RECURSION = 10;

    /**
     * @var string
     */
    protected $ini_name;

    /**
     * @var string
     */
    protected $ini_dir;

    /**
     * @var array
     */
    protected $ini;

    /**
     * @var array
     */
    protected $ini_sections;

    public function __construct(string $ini_name)
    {
        $this->ini_name = $ini_name;
    }

    /**
     * @param string $ini_dir
     * @return self
     */
    public function setIniDir(string $ini_dir): self
    {
        $this->ini_dir = $ini_dir;

        return $this;
    }

    /**
     * @param string $key
     * @return array|string
     * @throws DomainException
     */
    public function get(string $key)
    {
        $this->load();
        if (!isset($this->ini[$key])) {
            throw new DomainException('undefined ini value: ' . $key);
        }
        return $this->ini[$key];
    }

    /**
     * @param string $key
     * @return array|string
     * @throws DomainException
     */
    public function section($key)
    {
        $this->load();
        if (!isset($this->ini_sections[$key])) {
            throw new DomainException('undefined ini section: ' . $key);
        }
        return $this->ini_sections[$key];
    }

    /**
     * @param string $file_dir
     * @param int    $i
     * @return string
     * @throws DomainException
     */
    protected function getBaseDir(string $file_dir, $i = 0): string
    {
        if ($i > self::MAX_RECURSION) {
            throw new DomainException('base dir not found');
        }

        if (!is_dir($file_dir . '/vendor')) {
            $file_dir = $this->getBaseDir($file_dir . '/..', $i + 1);
        }

        return realpath($file_dir);
    }

    /**
     * @return string
     */
    protected function getIniDir(): string
    {
        if (!isset($this->ini_dir)) {
            $this->ini_dir = $this->getBaseDir(__DIR__);
        }
        return $this->ini_dir;
    }

    /**
     * Make sure we find the ini file next to the vendor directory
     * @return string
     * @throws DomainException if the ini file is not found
     */
    protected function getIniPath(): string
    {
        $ini_path = $this->getIniDir() . '/' . $this->ini_name;
        if (!file_exists($ini_path)) {
            throw new DomainException('ini file not found');
        }

        return $ini_path;
    }

    /**
     * @return self
     */
    protected function load(): self
    {
        if (!isset($this->ini)) {
            $this->ini = parse_ini_file(self::getIniPath());
        }
        if (!isset($this->ini_sections)) {
            $this->ini_sections = parse_ini_file(self::getIniPath(), true);
        }

        return $this;
    }

}

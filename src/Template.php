<?php

namespace Pendenga\TemplatePHP;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Template
{
    use LoggerAwareTrait;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->setLogger($logger ?? new NullLogger());
    }

    public function getIt() {
        return 'it';
    }
}

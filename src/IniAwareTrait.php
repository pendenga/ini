<?php

namespace Pendenga\Ini;

trait IniAwareTrait
{
    protected $ini;

    /**
     * @param Ini $ini
     * @return self
     */
    public function setIni(Ini $ini): self
    {
        $this->ini = $ini;

        return $this;
    }

    /**
     * @return Ini
     */
    protected function getIni(): Ini
    {
        return $this->ini;
    }
}

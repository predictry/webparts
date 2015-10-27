<?php

namespace App;

class Item extends \NeoEloquent
{

    protected $label = 'Item:{tenant}';

    public function setTenant($tenant)
    {
        $this->label = str_replace('{tenant}', $tenant, $this->label);
    }

}

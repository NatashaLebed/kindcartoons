<?php

namespace Lebed\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LebedUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

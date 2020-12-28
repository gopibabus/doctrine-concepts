<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $manager->flush();
    }
}

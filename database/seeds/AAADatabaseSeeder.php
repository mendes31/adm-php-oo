<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AAADatabaseSeeder extends AbstractSeed
{
   /**
     * Define as dependências para essa seed.
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'AddDepartments',
            'AddAdmsPositions',
            'AddAdmsUsers',                                  
            'AddAccessLevels',
            'AddAdmsUsersAccessLevels',
            'AddAdmsUsersDepartments',
            'AddAdmsPackagesPages',
            'AddAdmsGroupsPages',
            'AddAdmsPages',
            
        ];
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsFiller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:rp-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all the required roles and permissions that are required';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Role::findOrCreate('super_admin'); // has all perms by default
        $admin = Role::findOrCreate('admin');
        $committee = Role::findOrCreate('committee');


        $adminP = Permission::findOrCreate('admin');

        $adminSeason = Permission::findOrCreate('admin.seasons'); // Allows access to seasons area
        $adminSeasonManage = Permission::findOrCreate('admin.seasons.manage'); // Allows creation/editing/deletion of seasons
        $adminSeasonManageDelete = Permission::findOrCreate('admin.seasons.delete');

        $adminCompetitions = Permission::findOrCreate('admin.competitions');
        $adminCompetitionsManage = Permission::findOrCreate('admin.competitions.manage');
        $adminCompetitionsManageDelete = Permission::findOrCreate('admin.competitions.delete');

        $adminUniversity = Permission::findOrCreate('admin.universities');
        $adminUniversityManage = Permission::findOrCreate('admin.universities.manage');

        $adminUsers = Permission::findOrCreate('admin.users');
        $adminUsersManage = Permission::findOrCreate('admin.users.manage');

        $adminResources = Permission::findOrCreate('admin.resources');
        $adminResourcesManage = Permission::findOrCreate('admin.resources.manage');

        $article = Permission::findOrCreate('article');

        // Give admin all perms for now
        $baseAdminPerms = [$adminP, $adminSeason, $adminCompetitions, $adminUniversity, $adminUsers, $adminResources, $article, $adminSeasonManage, $adminCompetitionsManage, $adminUniversityManage, $adminUsersManage, $adminResourcesManage, $adminSeasonManageDelete, $adminCompetitionsManageDelete];
        $admin->syncPermissions($baseAdminPerms);

        // Committee can view seasons, comps, unis and users and do article stuff
        $committee->syncPermissions([$article, $adminSeason, $adminP, $adminCompetitions, $adminUniversity, $adminResources]);


        $this->info('All permissions and roles created!');



        return 0;
    }
}

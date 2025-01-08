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

        $articles = Role::findOrCreate('articles');
        $competitions = Role::findOrCreate('competitions');
        $resources = Role::findOrCreate('resources');
        $sercs = Role::findOrCreate('sercs');
        $usersAndUnis = Role::findOrCreate('users-unis');



        $adminP = Permission::findOrCreate('admin');

        $adminSeason = Permission::findOrCreate('admin.seasons'); // Allows access to seasons area
        $adminSeasonManage = Permission::findOrCreate('admin.seasons.manage'); // Allows creation/editing/deletion of seasons
        $adminSeasonManageDelete = Permission::findOrCreate('admin.seasons.delete');

        $adminCompetitions = Permission::findOrCreate('admin.competitions');
        $adminCompetitionsManage = Permission::findOrCreate('admin.competitions.manage');
        $adminCompetitionsManageDelete = Permission::findOrCreate('admin.competitions.delete');

        $adminUniversity = Permission::findOrCreate('admin.universities');
        $adminUniversityManage = Permission::findOrCreate('admin.universities.manage');
        $adminUniversityManageDelete = Permission::findOrCreate('admin.universities.delete');

        $adminUsers = Permission::findOrCreate('admin.users');
        $adminUsersManage = Permission::findOrCreate('admin.users.manage');

        $adminResources = Permission::findOrCreate('admin.resources');
        $adminResourcesManage = Permission::findOrCreate('admin.resources.manage');

        $adminSercs = Permission::findOrCreate('admin.sercs');
        $adminSercsManage = Permission::findOrCreate('admin.sercs.manage');
        $adminSercsManageDelete = Permission::findOrCreate('admin.sercs.delete');

        $articleP = Permission::findOrCreate('article');

        // Give admin all perms for now
        $baseAdminPerms = [$adminP, $adminSeason, $adminCompetitions, $adminUniversity, $adminUsers, $adminResources, $articleP, $adminSeasonManage, $adminCompetitionsManage, $adminUniversityManage, $adminUsersManage, $adminResourcesManage, $adminSeasonManageDelete, $adminCompetitionsManageDelete, $adminUniversityManageDelete, $adminSercs, $adminSercsManage, $adminSercsManageDelete];
        $admin->syncPermissions($baseAdminPerms);

     
        $articles->syncPermissions([$articleP]);
        $competitions->syncPermissions([$adminP, $adminSeason, $adminSeasonManage, $adminSeasonManageDelete, $adminCompetitions, $adminCompetitionsManage, $adminCompetitionsManageDelete]);
        $resources->syncPermissions([$adminP, $adminResources, $adminResourcesManage]);
        $sercs->syncPermissions([$adminP, $adminSercs, $adminSercsManage, $adminSercsManageDelete]);
        $usersAndUnis->syncPermissions([$adminP, $adminUsers, $adminUsersManage, $adminUniversity, $adminUniversityManage, $adminUniversityManageDelete]);


        $this->info('All permissions and roles created!');

        // Delete any old roles that aren't the following
        $currentRoles = ['super_admin', 'admin', 'sercs', 'articles', 'competitions', 'resources', 'sercs', 'users-unis'];

        Role::whereNotIn('name', $currentRoles)->delete();



        return 0;
    }
}

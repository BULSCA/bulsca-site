<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate universities to organisations
        $universities = DB::table('unis')->get();
        
        foreach ($universities as $uni) {
            $orgId = DB::table('organisations')->insertGetId([
                'name' => $uni->name,
                'short_name' => $uni->short_name ?? null,
                'type' => 'club',
                'description' => null,
                'website' => null,
                'email' => null,
                'created_at' => $uni->created_at,
                'updated_at' => $uni->updated_at,
            ]);
            
            // Store mapping for later use
            DB::table('uni_org_mapping')->insert([
                'uni_id' => $uni->id,
                'organisation_id' => $orgId,
            ]);
        }
        
        // Migrate university admins to organisation managers
        $uniAdmins = DB::table('user_universities')->where('admin', 1)->get();
        
        foreach ($uniAdmins as $admin) {
            $mapping = DB::table('uni_org_mapping')->where('uni_id', $admin->uni)->first();
            
            if ($mapping) {
                DB::table('organisation_managers')->insert([
                    'organisation_id' => $mapping->organisation_id,
                    'user_id' => $admin->user,
                    'role' => 'owner',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Migrate regular university members to organisation members
        $uniMembers = DB::table('user_universities')->where('admin', 0)->get();
        
        foreach ($uniMembers as $member) {
            $mapping = DB::table('uni_org_mapping')->where('uni_id', $member->uni)->first();
            
            if ($mapping) {
                DB::table('organisation_members')->insert([
                    'organisation_id' => $mapping->organisation_id,
                    'user_id' => $member->user,
                    'status' => 'active',
                    'joined_at' => $member->created_at ?? now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Update competition references
        $competitions = DB::table('competitions')->whereNotNull('uni')->get();
        
        foreach ($competitions as $competition) {
            $mapping = DB::table('uni_org_mapping')->where('uni_id', $competition->uni)->first();
            
            if ($mapping) {
                DB::table('competitions')->where('id', $competition->id)->update([
                    'organisation_id' => $mapping->organisation_id,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Optionally restore data (this is complex, consider if you need it)
        DB::table('organisation_members')->truncate();
        DB::table('organisation_managers')->truncate();
        DB::table('organisations')->truncate();
        DB::table('uni_org_mapping')->truncate();
        
        DB::table('competitions')->update(['organisation_id' => null]);
    }
};
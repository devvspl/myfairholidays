<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserProfileImagePaths extends Migration
{
    public function up()
    {
        // Update existing profile image paths from writable/uploads/profiles/ to uploads/profiles/
        $this->db->query("UPDATE users SET profile_image = REPLACE(profile_image, 'writable/uploads/profiles/', 'uploads/profiles/') WHERE profile_image LIKE 'writable/uploads/profiles/%'");
    }

    public function down()
    {
        // Revert back to old paths
        $this->db->query("UPDATE users SET profile_image = REPLACE(profile_image, 'uploads/profiles/', 'writable/uploads/profiles/') WHERE profile_image LIKE 'uploads/profiles/%'");
    }
}
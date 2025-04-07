<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:update-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the admin user password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = User::where('email', 'admin@admin.com')->first();

        if (!$admin) {
            $this->error('Admin user not found!');
            return 1;
        }

        $admin->password = Hash::make('admin123');
        $admin->is_admin = true;
        $admin->save();

        $this->info('Admin password updated successfully!');
        return 0;
    }
}

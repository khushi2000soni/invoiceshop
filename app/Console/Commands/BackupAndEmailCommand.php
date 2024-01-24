<?php

namespace App\Console\Commands;

use App\Mail\ShareBackupFileMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class BackupAndEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:email';
    protected $description = 'Backup, email, and truncate on December 31st.';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Executing backup, email, and truncate tasks...');
        // Run the createbackup command
        Artisan::call('backup:database');
        $backupFilePath = app(DatabaseBackUp::class)->getBackupFilePath();
         // Send email with the backup file
         $this->sendBackupEmail($backupFilePath);
        // Truncate orders and order_product tables
        //$this->truncateTables();
        $this->info('Tasks completed successfully.');
    }

    protected function sendBackupEmail($backupFilePath)
    {
        $to = config('app.email');
        $subject = 'Backup File ' . now()->format('d_M_Y_H_i_s');
        // Use the ShareBackupFileMail mail class
        Mail::to($to)->send(new ShareBackupFileMail($backupFilePath, $subject));
        $this->info('Email sent with the backup file.');
    }

    protected function truncateTables()
    {
        // Perform truncation logic here
        // You can use Eloquent or DB facade to truncate tables
        // Example: DB::table('orders')->truncate();
        //          DB::table('order_product')->truncate();
        // Remember to handle foreign key constraints if any
        $this->info('Tables truncated.');
    }
}

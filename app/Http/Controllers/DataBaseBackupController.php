<?php

namespace App\Http\Controllers;

use App\DataTables\DatabaseBackupDataTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Helpers\Format;
use Spatie\Backup\Tasks\Backup\BackupJob;
use Spatie\Backup\BackupDestination\Backup;
use Illuminate\Support\Facades\File;


class DataBaseBackupController extends Controller
{
    //
    // public function index()
    // {
    //     $backupPath = 'Invoice';

    //     // Get the list of backup files
    //     $backupFiles = Storage::files($backupPath);

    //     // Transform the file list into an array of backup information
    //     $backups = collect($backupFiles)->map(function ($backupFile) {
    //         return [
    //             'file' => pathinfo($backupFile, PATHINFO_BASENAME),
    //             'size' => Storage::size($backupFile),
    //             'date' => Carbon::createFromTimestamp(Storage::lastModified($backupFile))->diffForHumans(),
    //         ];
    //     });

    //     // Now $backups contains the list of backups
    //     //dd($backups);
    //     return view('admin.backup.index', compact('backups'));
    // }

    public function index(DatabaseBackupDataTable $dataTable)
    {
        return $dataTable->render('admin.backup.index');
    }

    public function createBackup(){
        $backupPath = storage_path('app/db_backups/');
        // Create the backup directory if it doesn't exist
        if (!File::exists($backupPath)) {
            // Create the backup directory if it doesn't exist
            File::makeDirectory($backupPath, 0755, true);
        }
        // Use environment variables for credentials
        $fileName = 'backup_' . now()->format('d_m_Y_H_i_s') . '.sql';
        $filePath = $backupPath . $fileName;
        $command = sprintf(
            'mysqldump --user=%s --password=%s %s > %s',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            $filePath
        );

        try {
            // Execute the mysqldump command
            exec($command);
            // Check if the file was created successfully
            if (file_exists($filePath)) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.backup.created'),
                    'alert-type' => trans('quickadmin.alert-type.success'),
                    'file_path' => $filePath,
                ]);
            } else {
                // Handle the case where the file was not created
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.backup.failed'),
                    'alert-type' => trans('quickadmin.alert-type.error'),
                    'error' => 'Backup file not created.',
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the backup process
            return response()->json([
                'success' => false,
                'message' => trans('messages.backup.failed'),
                'alert-type' => trans('quickadmin.alert-type.error'),
                'error' => $e->getMessage(), // Provide additional error details
            ], 500);
        }
    }

    // public function restoreBackup($fileName)
    // {
    //     // Specify the path to the backup file
    //     $backupFilePath = storage_path("app/backup/{$fileName}");

    //     // Run the restore command
    //     Artisan::call('backup:restore', [
    //         '--only' => $fileName,
    //         '--db-username' => config('database.connections.mysql.username'),
    //         '--db-password' => config('database.connections.mysql.password'),
    //         '--db-name' => config('database.connections.mysql.database'),
    //         '--db-host' => config('database.connections.mysql.host'),
    //         '--db-port' => config('database.connections.mysql.port'),
    //         '--force' => true, // Use force to confirm the restore
    //     ]);

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Backup restored successfully!');
    // }

    // public function deleteBackup($fileName)
    // {
    //     // Delete the backup file
    //     BackupJob::getBackupDestination()->deleteBackup($fileName);

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Backup deleted successfully!');
    // }
}

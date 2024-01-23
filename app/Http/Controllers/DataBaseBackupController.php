<?php

namespace App\Http\Controllers;

use App\DataTables\DatabaseBackupDataTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Helpers\Format;
use Spatie\Backup\Tasks\Backup\BackupJob;
use Spatie\Backup\BackupDestination\Backup;
use Illuminate\Support\Facades\File;


class DataBaseBackupController extends Controller
{

    public function index(DatabaseBackupDataTable $dataTable)
    {
        return $dataTable->render('admin.backup.index');
    }

    public function createBackup()
    {
        try {
            // Run the custom Artisan command to create a database backup
            Artisan::call('backup:database');
            // Retrieve the output of the Artisan command
            $output = Artisan::output();
            // Check if the backup file was created successfully
            if (File::exists($filePath = $this->extractBackupFilePath($output))) {
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
            dd($e->getMessage());
           // \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => trans('messages.backup.failed'),
                'alert-type' => trans('quickadmin.alert-type.error'),
                'error' => $e->getMessage(), // Provide additional error details
            ], 500);
        }
    }

    private function extractBackupFilePath($output)
    {
        // Parse the output to find the backup file path
        preg_match('/Backup file created at: (.+)/', $output, $matches);

        return isset($matches[1]) ? trim($matches[1]) : null;
    }

    // public function createBackup(){
    //     $backupPath = storage_path('app/db_backups/');
    //     // Create the backup directory if it doesn't exist
    //     if (!File::exists($backupPath)) {
    //         File::makeDirectory($backupPath, 0755, true);
    //     }

    //     $fileName = 'backup_' . now()->format('d_m_Y_H_i_s') . '.sql';
    //     $filePath = $backupPath . $fileName;
    //     $host = env('DB_HOST', '127.0.0.1');
    //     $port = env('DB_PORT', '3306');
    //     $username = env('DB_USERNAME');
    //     $password = env('DB_PASSWORD');
    //     $database = env('DB_DATABASE');
    //     try {
    //         $command = sprintf(
    //             'mysqldump --user=%s --password=%s --host=%s --port=%s --databases %s > %s',
    //             $username,$password,$host,$port,$database,$filePath
    //         );

    //         $returnVar = null;
    //         $output = null;
    //         //dd($command);
    //         exec($command, $output, $returnVar);
    //         // Check if the command was successful
    //         if ($returnVar !== 0) {
    //             throw new \Exception('mysqldump command failed: ' . implode(PHP_EOL, $output));
    //         }

    //         // Check if the file was created successfully
    //         if (file_exists($filePath)) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => trans('messages.backup.created'),
    //                 'alert-type' => trans('quickadmin.alert-type.success'),
    //                 'file_path' => $filePath,
    //             ]);
    //         } else {
    //             // Handle the case where the file was not created
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => trans('messages.backup.failed'),
    //                 'alert-type' => trans('quickadmin.alert-type.error'),
    //                 'error' => 'Backup file not created.',
    //             ], 500);
    //         }
    //     } catch (\Exception $e) {
    //         // Handle any exceptions that may occur during the backup process
    //         // Log the exception for debugging
    //         //\Log::error($e->getMessage());
    //         dd($e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => trans('messages.backup.failed'),
    //             'alert-type' => trans('quickadmin.alert-type.error'),
    //             'error' => $e->getMessage(), // Provide additional error details
    //         ], 500);
    //     }
    // }

    public function restoreBackup(Request $request)
    {
        try {
            $fileName = $request->fileName;
            $backupPath = storage_path('app/db_backups/');
            $filePath = $backupPath . $fileName;
            // Drop all tables in the current database
            DB::statement('SET foreign_key_checks = 0');
            $tables = DB::select('SHOW TABLES');
            foreach ($tables as $table) {
                $table_array = get_object_vars($table);
                $table_name = $table_array[key($table_array)];
                DB::statement('DROP TABLE IF EXISTS ' . $table_name);
            }
            DB::statement('SET foreign_key_checks = 1');
            // Import tables from the backup file
            putenv('PATH=' . getenv('PATH') . env('DB_MYSLDUMP_PATH'));
            $command = 'mysql --user=' . env('DB_USERNAME') . ' --password=' . env('DB_PASSWORD') . env('DB_DATABASE') . ' > ' . $backupPath . $fileName;
            $returnVar = null;
            $output = null;
            exec($command, $output, $returnVar);
            // Check if the command was successful
            if ($returnVar !== 0) {
                throw new \Exception('mysqldump command failed: ' . implode(PHP_EOL, $output));
            }

            return response()->json([
                'success' => true,
                'message' => trans('messages.backup.restored'),
                'alert-type' => trans('quickadmin.alert-type.success'),
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error restoring database.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function deleteBackup(Request $request)
    {
        $fileName = $request->fileName;
        $backupPath = storage_path('app/db_backups/');
        $filePath = $backupPath . $fileName;
        try {
            if (File::exists($filePath)) {
                File::delete($filePath);
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.backup.deleted'),
                    'alert-type' => trans('quickadmin.alert-type.success'),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.backup.not_found'),
                    'alert-type' => trans('quickadmin.alert-type.error'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.backup.delete_failed'),
                'alert-type' => trans('quickadmin.alert-type.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

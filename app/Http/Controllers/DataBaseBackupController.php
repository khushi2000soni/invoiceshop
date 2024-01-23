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
            // $command = 'mysql --user=' . env('DB_USERNAME') . ' --password=' . env('DB_PASSWORD') . env('DB_DATABASE') . ' > ' . $backupPath . $fileName;
            // exec($command);
            $pdo = DB::connection()->getPdo();
            $pdo->exec(file_get_contents($filePath));
            if ($pdo->errorCode() !== '00000') {
                throw new \Exception('Error importing database: ' . implode(', ', $pdo->errorInfo()));
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

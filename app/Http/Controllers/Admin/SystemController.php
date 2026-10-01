<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    /**
     * Display system information.
     */
    public function info()
    {
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_connection' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
            'environment' => app()->environment(),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'maintenance_mode' => app()->isDownForMaintenance() ? 'Enabled' : 'Disabled',
        ];

        // Get database info
        try {
            $databaseInfo = [
                'database_name' => config('database.connections.' . config('database.default') . '.database'),
                'connection_status' => 'Connected',
            ];
        } catch (\Exception $e) {
            $databaseInfo = [
                'database_name' => 'Unknown',
                'connection_status' => 'Connection failed',
            ];
        }

        // Get disk usage
        $diskInfo = [
            'total_space' => $this->formatBytes(disk_total_space('/')),
            'free_space' => $this->formatBytes(disk_free_space('/')),
            'used_space' => $this->formatBytes(disk_total_space('/') - disk_free_space('/')),
        ];

        return view('admin.system.info', compact('systemInfo', 'databaseInfo', 'diskInfo'));
    }

    /**
     * Display system logs.
     */
    public function logs(Request $request)
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logFile)) {
            $file = fopen($logFile, 'r');
            $lines = [];

            // Read last 100 lines for performance
            $lineCount = 0;
            $bufferSize = 1024;
            $pos = -1;

            while ($lineCount < 100 && $pos >= 0) {
                fseek($file, $pos, SEEK_END);
                $char = fgetc($file);
                if ($char === "\n") {
                    $lineCount++;
                }
                $pos--;
            }

            $lines = array_reverse(explode("\n", fread($file, abs($pos))));
            fclose($file);

            foreach ($lines as $line) {
                if (!empty(trim($line))) {
                    $logs[] = $this->parseLogLine($line);
                }
            }
        }

        return view('admin.system.logs', compact('logs'));
    }

    /**
     * Display cache management interface.
     */
    public function cache()
    {
        $cacheInfo = [
            'driver' => config('cache.default'),
            'status' => Cache::store()->getStore() ? 'Connected' : 'Not Connected',
        ];

        // Get cache statistics if available
        $cacheStats = [];
        try {
            if (config('cache.default') === 'redis') {
                $redis = Cache::store('redis')->getRedis();
                $cacheStats = [
                    'keys_count' => $redis->dbsize(),
                    'memory_used' => $this->formatBytes($redis->info('memory')['used_memory']),
                ];
            } elseif (config('cache.default') === 'file') {
                $cachePath = config('cache.stores.file.path');
                $cacheStats = [
                    'cache_files' => count(glob($cachePath . '/*')),
                ];
            }
        } catch (\Exception $e) {
            $cacheStats = ['error' => 'Unable to retrieve cache statistics'];
        }

        return view('admin.system.cache', compact('cacheInfo', 'cacheStats'));
    }

    /**
     * Clear application cache.
     */
    public function clearCache(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return redirect()->back()->with('success', 'Cache cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * Display backup management interface.
     */
    public function backup()
    {
        $backups = [];

        // Check if backup directory exists
        $backupPath = storage_path('backups');
        if (is_dir($backupPath)) {
            $files = glob($backupPath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $backups[] = [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => $this->formatBytes(filesize($file)),
                        'modified' => date('Y-m-d H:i:s', filemtime($file)),
                    ];
                }
            }
            // Sort by modification time (newest first)
            usort($backups, function($a, $b) {
                return strtotime($b['modified']) - strtotime($a['modified']);
            });
        }

        return view('admin.system.backup', compact('backups'));
    }

    /**
     * Create a new backup.
     */
    public function createBackup(Request $request)
    {
        try {
            // Create backup directory if it doesn't exist
            $backupPath = storage_path('backups');
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $timestamp = date('Y-m-d_H-i-s');
            $filename = 'backup_' . $timestamp . '.sql';
            $filepath = $backupPath . '/' . $filename;

            // Use mysqldump if available, otherwise use Laravel's backup command
            if ($this->commandExists('mysqldump')) {
                $command = sprintf(
                    'mysqldump --user=%s --password=%s --host=%s %s > %s',
                    escapeshellarg(config('database.connections.mysql.username')),
                    escapeshellarg(config('database.connections.mysql.password')),
                    escapeshellarg(config('database.connections.mysql.host')),
                    escapeshellarg(config('database.connections.mysql.database')),
                    escapeshellarg($filepath)
                );

                exec($command, $output, $returnVar);

                if ($returnVar === 0) {
                    return redirect()->back()->with('success', 'Database backup created successfully!');
                } else {
                    return redirect()->back()->with('error', 'Failed to create backup');
                }
            } else {
                // Fallback: Use Laravel's database backup if available
                return redirect()->back()->with('error', 'mysqldump command not available. Please install mysqldump or use a backup package.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file.
     */
    public function downloadBackup($filename)
    {
        $backupPath = storage_path('backups/' . $filename);

        if (file_exists($backupPath)) {
            return response()->download($backupPath);
        }

        return redirect()->back()->with('error', 'Backup file not found');
    }

    /**
     * Delete a backup file.
     */
    public function deleteBackup(Request $request, $filename)
    {
        $backupPath = storage_path('backups/' . $filename);

        if (file_exists($backupPath)) {
            unlink($backupPath);
            return redirect()->back()->with('success', 'Backup deleted successfully!');
        }

        return redirect()->back()->with('error', 'Backup file not found');
    }

    /**
     * Display API settings interface.
     */
    public function api()
    {
        $apiSettings = [
            'api_enabled' => config('app.api_enabled', false),
            'api_key_required' => config('app.api_key_required', false),
            'rate_limiting' => config('app.rate_limiting', false),
            'cors_enabled' => config('cors.enabled', false),
        ];

        return view('admin.system.api', compact('apiSettings'));
    }

    /**
     * Parse a log line into structured data.
     */
    private function parseLogLine($line)
    {
        // Basic log parsing - can be enhanced based on your log format
        $parts = explode(' ', $line, 4);

        return [
            'timestamp' => isset($parts[0]) ? $parts[0] : '',
            'level' => isset($parts[1]) ? $parts[1] : '',
            'message' => isset($parts[3]) ? $parts[3] : $line,
            'raw' => $line,
        ];
    }

    /**
     * Format bytes into human readable format.
     */
    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Check if a command exists on the system.
     */
    private function commandExists($command)
    {
        $whereIsCommand = (PHP_OS_FAMILY === 'Windows') ? 'where' : 'which';
        $output = shell_exec("$whereIsCommand $command");
        return !empty($output);
    }
}
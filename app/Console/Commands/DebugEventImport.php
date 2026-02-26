<?php

namespace App\Console\Commands;

use App\Imports\EventImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class DebugEventImport extends Command
{
    protected $signature = 'debug:event-import {file}';

    protected $description = 'Debug Event Import';

    public function handle()
    {
        $file = $this->argument('file');
        $this->info("Importing file: $file");

        try {
            Excel::import(new EventImport, $file);
            $this->info('Import finished successfully.');
        } catch (\Exception $e) {
            $this->error('Import failed: '.$e->getMessage());
            if ($e instanceof \Maatwebsite\Excel\Validators\ValidationException) {
                foreach ($e->failures() as $failure) {
                    $this->error('Row '.$failure->row().': '.implode(', ', $failure->errors()));
                }
            }
        }
    }
}

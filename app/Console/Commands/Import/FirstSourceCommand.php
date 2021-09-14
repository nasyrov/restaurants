<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use League\Csv\Reader;

class FirstSourceCommand extends Command
{
    protected $signature = 'import:first-source';

    protected $description = 'Import first source';

    public function handle(): int
    {
        $reader = Reader::createFromPath(storage_path('app/csv/restaurants-hours-source-1.csv'))
            ->setHeaderOffset(0);

        foreach ($reader as $record) {
        }

        return 0;
    }
}

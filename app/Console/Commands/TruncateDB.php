<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class TruncateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncatedb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates all existing tables in the current database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
        if (!$this->confirm('CONFIRM TRUNCATE ALL TABLES IN THE CURRENT DATABASE? [Y|N]')) {
            exit('Truncate tables command aborted');
        }
        */
        $tableName = 'Tables_in_' . strtolower(env('DB_DATABASE'));
        $tables = DB::select('SHOW TABLES');

        try {
            
            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            foreach ($tables as $table) {
                
                $name = $table->$tableName;

                if ($name == 'migrations') {
                    continue;
                }
                $truncateList[] = $name;
                DB::statement("TRUNCATE TABLE $name");
            }
            $truncateList = implode(',', $truncateList);
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            DB::commit();

        }catch(\PDOException $e){
            $this->error("Database truncate command didn\'t finish properly: ".$e->getMessage());
            return 2;
        }
    }
}

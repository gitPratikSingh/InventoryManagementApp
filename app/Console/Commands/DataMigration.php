<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use DateTime;

class DataMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migratedb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migarte database!';

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
        try {

            var_dump($this->description);
            // set the PDO error mode to exception
            $connOLD = DB::connection('mysql_old')->getPdo();
            $connNEW = DB::connection()->getPdo();

        } catch (\Exception $e) {
            $this->info("Database connection failed!");
            $this->error($e->getMessage());
            return 2;
        }
    
        /* Backup Old DB first */
        
        $newhost = env('DB_HOST');
        $newdatabase = env('DB_DATABASE');
        $newusername = env('DB_USERNAME');
        $newpassword = env('DB_PASSWORD');
        
        $oldhost = env('DB_HOST');
        $olddatabase = env('DB_DATABASE');
        $oldusername = env('DB_USERNAME');
        $oldpassword = env('DB_PASSWORD');

        // create a back up
        $filename='database_backup_'.date('m_d_y__H_i_s');
        #$lastLine=exec('mysqldump '.$newdatabase.' --password='.$oldpassword.' --user='.$oldusername.' --host='.$oldhost.' --single-transaction >'.$filename.'.sql', $backupData, $status);
        $status = 0;
        // check if command did not run properly
        if ($status !== 0){
            $this->error("Database backup command didn\'t finish properly: ".$status);
            return 2;
        }

        $truncateRet = $this->call('truncatedb');
        if($truncateRet!=0){
            $this->error("Truncate db command didn\'t finish properly: ".$truncateRet);
            return 2;
        }

        // migrate the codes table
        $dataOLD = $connOLD->prepare("SELECT * FROM codes_make");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        $connNEW->prepare("INSERT INTO makes(id, name, deleted_at) VALUES (1,'N/A',NULL)")->execute();

        foreach($results as $r){
            $dataNewEq = $connNEW->prepare("INSERT INTO makes(id, name, deleted_at) VALUES (?,?,?)");
            $dataNewEq->execute(array($r['code'], $r['description'], NULL));
        }
        
        $dataOLD = $connOLD->prepare("select building, room from machines group by building, room");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();

        $locationhashmap = array();
        $idx=1;
        foreach($results as $r){
            $idx=$idx+1;
            $dataNewEq = $connNEW->prepare("INSERT INTO locations(id, building_number, room_number) VALUES (?,?,?)");
            $r['building'] = strtoupper(trim($r['building']));
            $r['room'] = strtoupper(trim($r['room']));

            $dataNewEq->execute(array($idx, $r['building'], $r['room']));
            $locationhashmap[$r['building'].','.$r['room']] = $idx;
        }

        // migrate the codes table
        $dataOLD = $connOLD->prepare("SELECT distinct upper(trim(model)) as model FROM machines");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        $modelhashmap = array();

        $connNEW->prepare("INSERT INTO models(id, name, deleted_at) VALUES (1,'N/A',NULL)")->execute();
        $modelhashmap['N/A'] = 1;
        
        $idx=1;
        foreach($results as $r){
            if ($r['model']!='' 
             && $r['model']!='NA'
             && $r['model']!='?'
             && $r['model']!='-- NONE --'
             && $r['model']!='N/A') {
                $idx=$idx+1;
                $dataNewEq = $connNEW->prepare("INSERT INTO models(id, name, deleted_at) VALUES (?,?,?)");
                $dataNewEq->execute(array($idx, trim($r['model']), null));
                $modelhashmap[$r['model']] = $idx;
            }else{
                $modelhashmap[$r['model']] = 1;
            }
        }

        // devices types
        // migrate the codes table
        $dataOLD = $connOLD->prepare("SELECT code, description, 
                                            IF(code IN (1,3,4,13,27,51), 'Computer', 
                                            IF(code IN (2,43,44), 'Printer',
                                            IF(code IN (41,170,12), 'HandHeld', 'Others'))) 
                                            as category 
                                        FROM codes_type");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        $categoryhashmap = array();

        foreach($results as $r){

            $dataNewEq = $connNEW->prepare("INSERT INTO devices_types(id, name, category, deleted_at) VALUES (?,?,?,?)");
            $dataNewEq->execute(array(trim($r['code']), trim($r['description']), $r['category'], NULL));
            $categoryhashmap[trim($r['code'])] = $r['category'];

        }

        $dataOLD = $connOLD->prepare("SELECT * FROM codes_reseller");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        $vendorhashmap = array();
        $vendorhashmap[0] = 'N/A';

        foreach($results as $r){
            $vendorhashmap[$r['code']] = $r['description'];
        }

        //devices table, machines table
        $dataOLD = $connOLD->prepare("SELECT * FROM machines");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        //var_dump($results);


        function validateDate($date, $format = 'Y-m-d')
        {
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) == $date;
        }

        foreach($results as $r){

            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices(id, category, type_id, make_id, model_id, serial_number, unit_id, owner, location_id,
            user, network_name, surplussed_at, created_at, updated_at, deleted_at) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            
            $r['createDate'] = $r['createDate']=="0000-00-00"?($r['purchased']=="0000-00-00"?($r['date_mod']=="0000-00-00"?NULL:$r['date_mod']):$r['purchased']):$r['createDate'];
            $r['surplusDate'] = $r['surplusDate']=="0000-00-00"?NULL:$r['surplusDate'];
            $r['date_mod'] = $r['date_mod']=="0000-00-00"?NULL:$r['date_mod'];
            $r['retireDate']=="0000-00-00"?NULL:$r['retireDate'];
            $r['purchased'] = $r['purchased']=="0000-00-00"?NULL:$r['purchased'];

            if(validateDate($r['createDate'])==FALSE)
                $r['createDate'] = NULL;
            if(validateDate($r['surplusDate'])==FALSE)
                $r['surplusDate'] = NULL;
            if(validateDate($r['date_mod'])==FALSE)
                $r['date_mod'] = NULL;
            if(validateDate($r['retireDate'])==FALSE)
                $r['retireDate'] = NULL;
            if(validateDate($r['purchased'])==FALSE)
                $r['purchased'] = NULL;
            
            
            $r['model'] = strtoupper(trim($r['model']));
            $r['building'] = strtoupper(trim($r['building']));
            $r['room'] = strtoupper(trim($r['room']));

            #special handling for a case
            if (preg_match('/^USB 3.0 SUPERSPEED/', $r['model']) || preg_match('/DUAL VIDE$/', $r['model'])) {
                $r['model'] = 'USB 3.0 SUPERSPEED DUAL VIDEO';
            }

            $dataNewEq->execute(array($r['id'], 
            $categoryhashmap[$r['type']], $r['type'], $r['make']==0?1:$r['make'],
            $modelhashmap[$r['model']], $r['serialnum'], $r['unit'], $r['owner'], $locationhashmap[$r['building'].','.$r['room']],
            $r['contact'],$r['name'], $r['surplusDate'],$r['createDate'],$r['date_mod'],$r['retireDate']));


            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices_purchases(device_id,vendor,account,quote_number,order_number,price,date_purchased,created_at,updated_at,deleted_at) 
            VALUES (?,?,?,?,?,?,?,?,?,?)");
            $dataNewEq->execute(array($r['id'], $vendorhashmap[$r['reseller']], $r['acct'], $r['quote'], $r['po'], $r['price'], $r['purchased'], $r['createDate'], $r['date_mod'], $r['retireDate']));


            $dataNewEq = $connNEW->prepare("
            INSERT INTO notes(device_id,note) 
            VALUES (?,?)");
            $dataNewEq->execute(array($r['id'], trim(preg_replace('/\s\s+/', ' ', $r['notes']))));

            if($r['config']!=''):
                $dataNewEq = $connNEW->prepare("
                INSERT INTO notes(device_id,note) 
                VALUES (?,?)");
                $dataNewEq->execute(array($r['id'],trim(preg_replace('/\s\s+/', ' ', $r['config']))));
            endif;
            
            /*
            if($r['speed']!=''){
                $dataNewEq = $connNEW->prepare("
                INSERT INTO devices_details(device_id,data,created_at,updated_at,deleted_at) 
                VALUES (?,?,?,?,?,?,?)");
                $dataNewEq->execute(array($r['id'], 'speed'.':'.$r['speed'], $r['createDate'], $r['date_mod'], $r['retireDate']));
            }
            */
        }

        $this->info("Migarte database Success!");
        return 0;
    }
}

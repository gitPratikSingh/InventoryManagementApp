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
    protected $description = 'Migrate database!';

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
        $dataNewEq = $connNEW->prepare("INSERT INTO makes(id, name, deleted_at) VALUES (0,'',NULL)");
        $dataNewEq->execute();

        $dataOLD = $connOLD->prepare("SELECT * FROM codes_make");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        foreach($results as $r){
            $dataNewEq = $connNEW->prepare("INSERT INTO makes(id, name, deleted_at) VALUES (?,?,?)");
            $dataNewEq->execute(array($r['code'], $r['description'], NULL));
        }

        $dataOLD = $connOLD->prepare("SELECT * FROM codes_domain");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        foreach($results as $r){
            $dataNewEq = $connNEW->prepare("INSERT INTO domains(id, name, deleted_at) VALUES (?,?,?)");
            $dataNewEq->execute(array($r['code'], $r['description'], NULL));
        }
        
        $dataOLD = $connOLD->prepare("SELECT * FROM units");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
                
        foreach($results as $r){
            $dataNewEq = $connNEW->prepare("INSERT INTO units(id, name) VALUES (?,?)");
            $dataNewEq->execute(array($r['id'], $r['unit_name']));
        }

        $dataOLD = $connOLD->prepare("SELECT room, building FROM machines group by room, building");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
                
        foreach($results as $r){
            $dataNewEq = $connNEW->prepare("INSERT INTO rooms(building_id, number) VALUES (?,?)");
            $dataNewEq->execute(array($r['building'], $r['room']));
        }

        /*
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
        */

        // migrate the codes table
        $dataOLD = $connOLD->prepare("select m.model, m.make from machines m group by m.model, m.make");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        $modelhashmap = array();
        
        $idx=0;
        foreach($results as $r){
            $idx=$idx+1;
            $r['make'] = $r['make'] == 0? 1: $r['make'];
            $dataNewEq = $connNEW->prepare("INSERT INTO models(id, name, make_id, deleted_at) VALUES (?,?,?,?)");
            $dataNewEq->execute(array($idx, $r['model'], $r['make'], null));
            $modelhashmap[$r['model'].','.$r['make']] = $idx;
            $modelhashmap[ucwords($r['model']).','.$r['make']] = $idx;
            $modelhashmap[strtolower($r['model']).','.$r['make']] = $idx;
            $modelhashmap[strtoupper($r['model']).','.$r['make']] = $idx;
            $modelhashmap[strtoupper(trim($r['model'])).','.$r['make']] = $idx;
        }

        //echo '<pre>';
        //print_r($modelhashmap);
        //echo '</pre>';
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

            $dataNewEq = $connNEW->prepare("INSERT INTO devices_types(id, minor, major, deleted_at) VALUES (?,?,?,?)");
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

        $dataOLD = $connOLD->prepare("SELECT * FROM codes_os");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        $oshashmap = array();
        $oshashmap[0] = '';

        foreach($results as $r){
            $oshashmap[$r['code']] = $r['description'];
        }

        $dataOLD = $connOLD->prepare("SELECT * FROM codes_kernel");
        $dataOLD->execute();
        $results = $dataOLD->fetchAll();
        
        $kernelhashmap = array();
        $kernelhashmap[0] = '';

        foreach($results as $r){
            $kernelhashmap[$r['code']] = $r['description'];
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

        foreach ($results as $r) {
            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices(id, name, serial_number, cams_tag, type_id, make_id,
            model_id, unit_id, owner, user, building_id, location_id, created_at, updated_at, deleted_at) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            
            $r['createDate'] = $r['createDate']=="0000-00-00"?($r['purchased']=="0000-00-00"?($r['date_mod']=="0000-00-00"?null:$r['date_mod']):$r['purchased']):$r['createDate'];
            $r['surplusDate'] = $r['surplusDate']=="0000-00-00"?null:$r['surplusDate'];
            $r['date_mod'] = $r['date_mod']=="0000-00-00"?null:$r['date_mod'];
            $r['retireDate']=="0000-00-00"?null:$r['retireDate'];
            $r['purchased'] = $r['purchased']=="0000-00-00"?null:$r['purchased'];
            $r['make'] = $r['make'] == 0?1:$r['make'];
            $model = array_key_exists($r['model'].','.$r['make'], $modelhashmap)?$modelhashmap[$r['model'].','.$r['make']]:array_key_exists(strtoupper($r['model'].','.$r['make']), $modelhashmap)?$modelhashmap[strtoupper($r['model'].','.$r['make'])]:$modelhashmap[strtoupper(trim($r['model']).','.$r['make'])];

            if (validateDate($r['createDate'])==false) {
                $r['createDate'] = null;
            }
            if (validateDate($r['surplusDate'])==false) {
                $r['surplusDate'] = null;
            }
            if (validateDate($r['date_mod'])==false) {
                $r['date_mod'] = null;
            }
            if (validateDate($r['retireDate'])==false) {
                $r['retireDate'] = null;
            }
            if (validateDate($r['purchased'])==false) {
                $r['purchased'] = null;
            }
            
            #special handling for an unknown character encoding in the machine.model field
            if (preg_match('/^USB 3.0 SUPERSPEED/', $r['model']) || preg_match('/DUAL VIDE$/', $r['model'])) {
                $r['model'] = 'USB 3.0 SUPERSPEED DUAL VIDEO';
            }

            $dataNewEq->execute(array($r['id'], $r['name'], $r['serialnum'], $r['cams'],
            $r['type'], $r['make'], $model, $r['unit'], $r['owner'], $r['contact'], 
            $r['building'], NULL, $r['createDate'],$r['date_mod'],$r['retireDate']));

            // devices notes
            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices_notes(device_id,note) 
            VALUES (?,?)");
            $dataNewEq->execute(array($r['id'], trim(preg_replace('/\s\s+/', ' ', $r['notes']))));

            if ($r['config']!=''):
                $dataNewEq = $connNEW->prepare("
                INSERT INTO devices_notes(device_id,note) 
                VALUES (?,?)");
            $dataNewEq->execute(array($r['id'],trim(preg_replace('/\s\s+/', ' ', $r['config']))));
            endif;

            // devices_purchases
            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices_purchases(device_id,vendor,account,quote_number,order_number,price,ordered_at,created_at,updated_at,deleted_at) 
            VALUES (?,?,?,?,?,?,?,?,?,?)");
            $dataNewEq->execute(array($r['id'], $vendorhashmap[$r['reseller']], $r['acct'], $r['quote'], $r['po'], $r['price'], $r['purchased'], $r['createDate'], $r['date_mod'], $r['retireDate']));
           
            //devices_warranties
            if (intval($r['warranty'])!=0) {
                $dataNewEq = $connNEW->prepare("
                INSERT INTO devices_warranties(device_id,expires_at,created_at,updated_at,deleted_at) 
                VALUES (?,?,?,?,?)");
                $expiration = ($r['purchased']==NULL||intval($r['warranty'])==0)?NULL:date("Y-m-d H:i:s", strtotime("+".intval($r['warranty'])." years", strtotime($r['purchased'])));
                $dataNewEq->execute(array($r['id'], $expiration, $r['createDate'], $r['date_mod'], $r['retireDate']));
            }

            //devices_processors
            if (intval($r['os'])!=0 || intval($r['kernel'])) {
                $dataNewEq = $connNEW->prepare("
                INSERT INTO devices_operating_systems(device_id,caption,kernel,created_at,updated_at,deleted_at) 
                VALUES (?,?,?,?,?,?)");
                $dataNewEq->execute(array($r['id'], $oshashmap[$r['os']], $kernelhashmap[$r['kernel']], $r['createDate'], $r['date_mod'], $r['retireDate']));
            }

            //devices_network_adapters
            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices_network_adapters(device_id,mac_address,ip_address,domain_id,host_name,created_at,updated_at,deleted_at) 
            VALUES (?,?,?,?,?,?,?,?)");
            $dataNewEq->execute(array($r['id'], $r['ethernet'], $r['ip'], $r['domain'], $r['hostid'], $r['createDate'], $r['date_mod'], $r['retireDate']));
            
            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices_memories(device_id,capacity,created_at,updated_at,deleted_at) 
            VALUES (?,?,?,?,?)");
            $dataNewEq->execute(array($r['id'], $r['memory'], $r['createDate'], $r['date_mod'], $r['retireDate']));
            
            $dataNewEq = $connNEW->prepare("
            INSERT INTO devices_disk_drives(device_id,size,created_at,updated_at,deleted_at) 
            VALUES (?,?,?,?,?)");
            $dataNewEq->execute(array($r['id'], $r['hd'], $r['createDate'], $r['date_mod'], $r['retireDate']));
            
        }

        $this->info("Migration completed!");
        return 0;
    }
}

<?php


//$connOLD = new PDO("mysql:host=192.168.10.10;dbname=mdb2", "homestead", "secret");
//$connNEW = new PDO("mysql:host=192.168.10.10;dbname=homestead", "homestead", "secret");

$connOLD = new PDO("mysql:host=mysql-tools.ece.ncsu.edu;dbname=oracle", "compreg-wrt", "");
$connNEW = new PDO("mysql:host=mysql-tools.ece.ncsu.edu;dbname=mdb_new", "compreg-wrt", "");

/* Backup Old DB first */
$filename='database_backup_'.date('m_d_y__H_i_s');
$result=exec('mysqldump mdb_new --password= --user=compreg-wrt --host=mysql-tools.ece.ncsu.edu --single-transaction >backup/'.$filename.'_n.sql', $output1);
$result=exec('mysqldump mdb2    --password= --user=compreg-wrt --host=mysql-tools.ece.ncsu.edu --single-transaction >backup/'.$filename.'_o.sql', $output2);
var_dump($output1);
var_dump($output2);

if(@$_REQUEST['machines']==1){


	/* Remove Old Data */
	$dataNewEq = $connNEW->prepare("
		DELETE FROM mdb_equipment WHERE id>0;
		ALTER TABLE mdb_equipment_purchase AUTO_INCREMENT=0;
		ALTER TABLE mdb_equipment_computer AUTO_INCREMENT=0;
		ALTER TABLE mdb_notes AUTO_INCREMENT=0;"
	);
	$dataNewEq->execute();

	/* Get Machines data and Insert to to new Table */
	$dataOLD = $connOLD->prepare("SELECT * FROM mdb2.machines");
	$dataOLD->execute();
	$results = $dataOLD->fetchAll();

	$count = 0;
	foreach($results as $r){
		//if($r['id']==2380){
			echo "<pre>";
			//print_r($r);
			echo "</pre>";


			/* Insert the Machine/Equipment */
			$dataNewEq = $connNEW->prepare("INSERT INTO mdb_equipment (id,equipment_name,building_id,serial_number,make_id,room,cams,type_id,active,surplused,personal,group_id,warranty,offsite,model,updated_at,created_at,config,owner,primary_user) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$dataNewEq->execute(array($r['id'],$r['name'],$r['building'],$r['serialnum'],$r['make'],$r['room'],$r['cams'],$r['type'],$r['surplused']=="Y"?0:($r['active']=="Y"?1:0),$r['surplused']=="Y"?1:0,$r['personal']=="Y"?1:0,$r['groups'],$r['warranty'],$r['offsite']=="Y"?1:0,$r['model'],$r['date_mod']=='0000-00-00'?date('Y-m-d'):$r['date_mod'],$r['createDate']=='0000-00-00'?'2003-03-11 00:00:00':$r['createDate'],$r['config'],$r['owner'],$r['contact']  ));

			/* Insert the PC details */
			//if($r['os']!=0 and $r['domain']!=0 and $r['ethernet']!='' and $r['ip']!=''){
			$dataNewEq = $connNEW->prepare("INSERT INTO mdb_equipment_computer (equipment_id,os_id,ip,domain_id,ethernet,hostname,processor,memory,harddrive) VALUES (?,?,?,?,?,?,?,?,?)");
			$dataNewEq->execute(array($r['id'],$r['os'],$r['ip'],$r['domain'],$r['ethernet'],$r['hostid'],$r['speed'],$r['memory'],$r['hd']  ));
			//}


			/* Insert the Purchase details */
			$dataNewEq = $connNEW->prepare("INSERT INTO mdb_equipment_purchase (equipment_id,acct_no,po_no,quote_no,price,reseller,warranty,date_purchased) VALUES (?,?,?,?,?,?,?,?)");
			$dataNewEq->execute(array($r['id'],$r['acct'],$r['po'],$r['quote'],$r['price'],$r['reseller'],$r['warranty'],$r['purchased']  ));
			//$connNEW->lastInsertId()."no";

			/* Insert the Notes */
			if($r['notes']!=''):
			$dataNewEq = $connNEW->prepare("INSERT INTO mdb_notes (equipment_id,note) VALUES (?,?)");
			$dataNewEq->execute(array($r['id'],trim(preg_replace('/\s\s+/', ' ', $r['notes']))));
			endif;

			if($r['config']!=''):
			$dataNewEq = $connNEW->prepare("INSERT INTO mdb_notes (equipment_id,note) VALUES (?,?)");
			$dataNewEq->execute(array($r['id'],trim(preg_replace('/\s\s+/', ' ', $r['config']))));
			endif;

			//var_dump($dataNewEq);

		//}

		$count++;
		// if($count==500) break;
	}

	$dataNewEq = $connNEW->prepare("UPDATE mdb_equipment e LEFT JOIN mdb_groups g ON (g.id=e.group_id) SET e.unit_id=g.unit_id");
	$dataNewEq->execute();
}


if(@$_REQUEST['os']==1){
	$dataOLD = $connOLD->prepare("SELECT * FROM mdb2.codes_os");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		var_dump($r);
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_os (id,name,group_id) VALUES (?,?,?)");
		$dataNewEq->execute(array($r['code'],$r['description'],$r['groupID'] ));

	}
}

if(@$_REQUEST['model']==1){
	$dataOLD = $connOLD->prepare("SELECT make , model FROM mdb2.machines GROUP BY model,make");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		var_dump($r);
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_equipment_make_model (name,make_id) VALUES (?,?)");
		$dataNewEq->execute(array($r['model'],$r['make']  ));

	}
}

function getModelId($model){
	global $connNEW;

	$dataNewEq = $connNEW->prepare("SELECT * FROM mdb_equipment_make_model m WHERE m.name=\"$model\" ");
	$dataNewEq->execute();

	$results = $dataNewEq->fetchAll();

	return $results[0]['id'];
}


if(@$_REQUEST['make']==1){
	$dataOLD = $connOLD->prepare("SELECT * FROM mdb2.codes_make");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_equipment_make (id,name,group_id) VALUES (?,?,?)");
		$dataNewEq->execute(array($r['code'],$r['description'],$r['groupID']  ));

		var_dump($dataNewEq);
	}
}

if(@$_REQUEST['building']==1){
	$dataOLD = $connOLD->prepare("SELECT * FROM mdb2.codes_building");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_buildings (id,name) VALUES (?,?)");
		$dataNewEq->execute(array($r['code'],$r['description']));
		var_dump($dataNewEq);
	}


	$dataOLD = $connOLD->prepare("SELECT * FROM oracle.BUILDING");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_buildings (id,name,abbreviation) VALUES (?,?,?)");
		$dataNewEq->execute(array($r['nc_building_num'],$r['nc_building_name'],$r['nc_build_abbr']  ));
		var_dump($dataNewEq);
	}

}

if(@$_REQUEST['domain']==1){
	$dataOLD = $connOLD->prepare("SELECT * FROM mdb2.codes_domain");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_domain (id,name,group_id,active) VALUES (?,?,?,?)");
		$dataNewEq->execute(array($r['code'],$r['description'],$r['groupID'],$r['active']=="Y"?1:0  ));

		var_dump($dataNewEq);
	}
}

if(@$_REQUEST['group']==1){
	$dataOLD = $connOLD->prepare("SELECT * FROM mdb2.groups");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_groups (id,name,parent) VALUES (?,?,?)");
		$dataNewEq->execute(array($r['id'],$r['name'],$r['parent']  ));

		var_dump($dataNewEq);
	}
}


if(@$_REQUEST['type']==1){
	$dataOLD = $connOLD->prepare("SELECT * FROM mdb2.codes_type");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		$dataNewEq = $connNEW->prepare("INSERT INTO mdb_equipment_type (id,name,type,group_id) VALUES (?,?,?,?)");
		$dataNewEq->execute(array($r['code'],$r['description'],$r['type'],$r['groupID']  ));

		var_dump($dataNewEq);
	}
}


if(@$_REQUEST['fixGroups']==1){
	$dataOLD = $connNEW->prepare("SELECT * FROM mdb_new.mdb_groups");
	$dataOLD->execute();

	$results = $dataOLD->fetchAll();
	$count = 0;
	foreach($results as $r){
		//$dataNewEq = $connNEW->prepare("INSERT INTO mdb_equipment_type (id,name,type,group_id) VALUES (?,?,?,?)");
		//$dataNewEq->execute(array($r['code'],$r['description'],$r['type'],$r['groupID']  ));
		if($r['parent']==0):
			echo "-1-->".$r['name'];
			echo "<br>";
			foreach($results as $child):
				if($child['parent']==$r['id']):
					echo "--2--->".$child['name'].' '.$child['id'];
					echo "<br>";
					foreach($results as $grChild):
						if($grChild['parent']==$child['id']):
							echo "---3---->".$grChild['name'].' '.$grChild['id'];
							echo "<br>";
							foreach($results as $grGrChild):
								if($grGrChild['parent']==$grChild['id']):
									echo "----4----->".$grGrChild['name'].' '.$grGrChild['id'];
									echo "<br>";
								endif;
							endforeach;
						endif;
					endforeach;
				endif;
			endforeach;
		endif;
	}
}

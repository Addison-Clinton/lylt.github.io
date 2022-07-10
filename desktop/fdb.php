<?php
namespace fdb;
const db = 'db';
class fset{
	public function __construct(private string $setname='def'){}
	public function getdat($record,string $tarname){
		$datdir=$this->setname.'/'.$record.'/'.$tarname.'/data';
		if(!\is_file($datdir)){
			return false;
		}
		return file_get_contents($datdir);
	}
	public function getrec($record){
		$recdir=opendir($this->setname.'/'.$record);
		$datArray=array();
		if(!\is_dir($recdir)){
			return false;
		}
		while (($file = readdir($recdir)) !== false){
			if ($file == '.' || $file == '..'){continue;}
			$datArray[$file]=$this->getdat($record,$file);
		}
		return $datArray;
	}
	public function get(){
		$recdir=opendir($this->setname);
		$datArray=array();
		while (($file = readdir($recdir)) !== false){
			if ($file == '.' || $file == '..'){continue;}
			$datArray[$file]=$this->getrec($file);
		}
		return $datArray;
	}
	public function addrec($record){
		$recdir=$this->setname.'/'.$record;
		if(!is_dir($recdir)){
			mkdir($recdir);
		}
	}
	public function setdat($record,$tarname,$data){
		$tardir=$this->setname.'/'.$record.'/'.$tarname;
		$this->addrec($record);
		if(!is_dir($tardir)){
			mkdir($tardir);
		}
		if($fp = fopen($tardir.'/data', 'w')){
			$startTime = microtime();
			do{
				$canWrite = flock($fp,LOCK_EX);
				if(!$canWrite) usleep(round(rand(0, 100)*1000));
			} while ((!$canWrite)&&((microtime()-$startTime) < 1000));
			if ($canWrite) {
				fwrite($fp, $data);
			}
			fclose($fp);
		}
	}
}
class fdb{
	public function __construct(private string $dbname='def'){
		$dbdir=db.'/'.$this->dbname;
		if(!is_dir($dbdir)){
			mkdir($dbdir);
		}
	}
	public function addset($setname){
		$setdir=db.'/'.$this->dbname.'/'.$setname;
		if($this->dbname==''){
			return 0;
		}
		if(!is_dir($setdir)){
			mkdir($setdir);
		}
	}
	public function addrec($setname,$record){
		$recdir=db.'/'.$this->dbname.'/'.$setname.'/'.$record;
		$this->addset($setname);
		if(!is_dir($recdir)){
			mkdir($recdir);
		}
	}
	public function setdat($setname,$record,$tarname,$data){
		$tardir=db.'/'.$this->dbname.'/'.$setname.'/'.$record.'/'.$tarname;
		$this->addrec($setname,$record);
		if(!is_dir($tardir)){
			mkdir($tardir);
		}
		if($fp = fopen($tardir.'/data', 'w')){
			$startTime = microtime();
			do{
				$canWrite = flock($fp,LOCK_EX);
				if(!$canWrite) usleep(round(rand(0, 100)*1000));
			} while ((!$canWrite)&&((microtime()-$startTime) < 1000));
			if ($canWrite) {
				fwrite($fp, $data);
			}
			fclose($fp);
		}
	}
	public function setrec($setname,$record,$dataArray){
		foreach($dataArray as $key=>$value){
			$this->setdat($setname,$record,$key,$value);
		}
	}
	public function delrec($setname,$record){}
	public function delset($setname){}
	public function deldat($setname,$record,$tarname){}
	public function getdat($setname,$record,$tarname){
		$datdir=db.'/'.$this->dbname.'/'.$setname.'/'.$record.'/'.$tarname.'/data';
		if(!\is_file($datdir)){
			return false;
		}
		return file_get_contents($datdir);
	}
	public function getrec($setname,$record){
		$_recdir=db.'/'.$this->dbname.'/'.$setname.'/'.$record;
		if(!\is_dir($_recdir)){
			return false;
		}
		$recdir=opendir($_recdir);
		$datArray=array();
		while (($file = readdir($recdir)) !== false){
			if ($file == '.' || $file == '..'){continue;}
			$datArray[$file]=file_get_contents(db.'/'.$this->dbname.'/'.$setname.'/'.$record.'/'.$file.'/data');
		}
		return $datArray;
	}
	public function getset($setname){
		$setdir=db.'/'.$this->dbname.'/'.$setname;
		if(!is_dir($setdir)){
			mkdir($setdir);
		}
		return new fset(db.'/'.$this->dbname.'/'.$setname);
	}
}
?>
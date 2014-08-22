<?
	/*
		Git Deploy Hook for Bitbucket - v0.1
		Mr.Jack - 2014
	*/
	
	$hook_branch = "development";
	
	function valid_data( $text ){
		preg_match("~^[a-z0-9\-]+$~i", $text, $r);
		return !empty($r);
	}
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	set_time_limit(0);
	
	$fp = fopen("data.log", 'a');
	fwrite($fp, date("d/m/y h:i:s -----------------------"). PHP_EOL );
	foreach($_POST as $key=>$post){
		fwrite($fp, $key.":".$post. PHP_EOL );
	}
	fclose($fp);
	
	if(isset($_POST['payload'])){
		$payload = urldecode($_POST['payload']);
		try{
			$pdec = json_decode($payload);
		}catch(Exception $e) {
		}
		$found = false;
		
		if(!empty($pdec) && count($pdec->commits)) foreach($pdec->commits as $commit){
			if($commit->branch == $hook_branch || (!empty($commit->branches) && in_array($hook_branch, $commit->branches))){
				$found = true;
				break;
			}
		}
		
		if($found && valid_data($pdec->repository->owner) && valid_data($pdec->repository->slug)){
			$sxe =  simplexml_load_file("repos.xml");
			$expression = sprintf("//repositories/repository[@owner='%s' and @slug='%s']", $pdec->repository->owner, $pdec->repository->slug);
			$query = $sxe->xpath($expression);
			if(!empty($query[0]->path)){
				$sys = exec("cd ".$query[0]->path."; git pull hook_origin ".$hook_branch." 2>&1", $response);
				echo "OK";
			}else{
				echo "ERROR";
			}
		}else{
			echo "ERROR";
		}
	}else{
		echo "ERROR";
	}
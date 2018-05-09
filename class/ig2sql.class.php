<?php 
class ig2sql{

	function ig2_conn($host,$user,$pass,$database,$charset){
		$conn=mysql_connect($host,$user,$pass) or die(mysql_error("no database"));
		mysql_select_db($database,$conn) or die(mysql_error("no table".$database));
		mysql_query ( "SET character_set_connection=" . $charset . ", 
		                   character_set_results=" . $charset . ", 
		                   character_set_client=binary");
	}
	
	function ig2_select($table,$where){
		if ($where){
			$sql="select * from ".$table." where ".$where;
		}else {
		    $sql="select * from ".$table;
		}
		$q=$this->ig2_query($sql);
		if ($q){
			$r=mysql_fetch_assoc($q);
		    while ($r) {
				$arr [] = $r;
				$r = mysql_fetch_assoc($q);
		    }
		    return $arr;
		}else {
			echo $sql;
			//$this->debug(); 
		}
		
	}
	function ig2_select_query($sql){
		$q=$this->ig2_query($sql);
		if ($q){
			$r=mysql_fetch_assoc($q);
		    while($r){
				$arr[]=$r;
				$r=mysql_fetch_assoc($q);
		    }
		    return $arr;
		}else {
			echo $sql;
		}
		
	}
	
	function ig2_select_distinct($distinct,$table,$where){
		$sql="select distinct ".$distinct." from ".$table." where ".$where;
		$q=$this->ig2_query($sql);
		if ($q){
			$r=mysql_fetch_assoc($q);
		    while ($r) {
				$arr [] = $r;
				$r = mysql_fetch_assoc ( $q );
		    }
		    return $arr;
		}else {
			echo $sql;
		}
	}
	
	function ig2_insert($table,$value){
		$fields=$this->desc($table);
		$result=implode(" ','", $value);
		$sql="insert into ".$table." (`".implode('`,`',$fields)."`) 
		                      values ('".$result."');";
		$q=$this->ig2_query($sql);
		if ($q){
			//echo "写入成功,".mysql_insert_id();
		    return mysql_insert_id();
		}else {
			echo $sql;
			//print_r($fields);
			$this->debug();
		}
	}
	
    function ig2_update($table,$value,$where){
		$fields=$this->desc($table);		
    	$set = array ();
		foreach ( $fields as $result ) {
			if (array_key_exists ( $result, $value ) == true) {
				$set [] = "`".$result."` = '" . $value [$result] . "'";
			}
		}		
		$sql="update ".$table." set ".implode ( ', ', $set ) . ' WHERE ' . $where;
		$q=$this->ig2_query($sql);
		if ($q){
		    /*
			echo "修改成功,等待页面响应...";
			echo "<script>";
            echo  "window.location.href=window.location.href;";
            echo "</script>"; 
			*/
		    return $q;
		}else {
		    echo $sql;
		}
	}
	
	function ig2_delete($table,$where){
	    if(empty($where)){
			$sql = 'delete from '.$table;
		}else{
			$sql = 'delete from '.$table.' where '.$where;
		}
		if($sql){
			return $this->ig2_query($sql);
		}else {
			return $sql;
		}		
	}
	
	//获取字段名称
	function desc($table){
			$sql="DESC ".$table;
			$res=$this->ig2_query($sql);
			$arr = array ();
			$row = mysql_fetch_row ($res);
			while ($row) {
				$arr [] = $row [0];
				$row = mysql_fetch_row ($res);
			}
			return $arr;
	}
	
	//执行SQL语句
	function ig2_query($sql){
		$q = mysql_query ($sql);
		return $q;
	}
	
	//获取一条数据
	function ig2_want($table,$where) {
		$q = $this->ig2_query ( "select * from ".$table." where ".$where );
		if ($q) {
			return mysql_fetch_assoc ( $q );
		} else {
			$this->debug();
			//return $q;
		}
	}
	
	//获取最新的数据ID
	function finalid($table,$id){
		$sql="select ".$id." from ".$table." order by ".$id." desc";
		$q=$this->ig2_query($sql);
		if ($q) {
			$r=mysql_fetch_assoc($q);
		    return $r;
		}else {
			echo $sql."<br>";
			$this->debug(); 
		}
	}
	
	
	
	function debug(){
		//echo "出错的函数：".__FUNCTION__."<br>".mysql_errer()."<br>"."SQL语句是：".$this->$sql;
		return false;
	}
	
	function ig2_msg($msg){
		//return "<script language=javascript>alert('".$msg."');window.history.go(-1)</script>";
		echo $msg;
	}
}


?>
<?php

class baza_sql {
	public function Czy_jest($adres, $user, $pass, $database,$table) {
    	@mysql_connect($adres,$user,$pass) or die("Nie można połączyć z serwerem");
	   	if(@mysql_select_db($database)){
			$query = "SELECT * FROM $table";
			$result=mysql_query($query); 
			$num = mysql_num_rows($result); 
			if($num==0){
				return false;
			}
			else {
					return true;
			}
			mysql_close();
		} else {
			return false;
		}
	}
}
?>
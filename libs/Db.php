<?php

namespace libs;

class Db {
	static function query($sql) {
		$con = mysqli_connect('localhost', 'root', 'root', 'db_board');
		return $con->query($sql);
		
	}
}

?>
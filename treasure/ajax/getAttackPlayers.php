<?php
	session_start();
	header('Content-Type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

	echo '<response>';

		if( @mysql_connect('localhost','root','') && mysql_select_db('war_of_mettles') )
		{
			for($i=1;$i<=50;$i++)
			{
				$query = "select `id`,`room`,`row`,`col` from `attack_player` where `id`=$i";
				if ($query_run = mysql_query($query))
				{
					echo '<team'.$i.'>';
						echo '<id>'.mysql_result($query_run,0,'id').'</id>';
						echo '<room>'.mysql_result($query_run,0,'room').'</room>';
						echo '<row>'.mysql_result($query_run,0,'row').'</row>';
						echo '<col>'.mysql_result($query_run,0,'col').'</col>';
					echo '</team'.$i.'>';
				}
			}
			$defenderRoom = $_POST['room'];
			$query = "select `id`,`room`,`row`,`col` from `defence_player` where `id`=$defenderRoom";
			if ($query_run = mysql_query($query))
			{
				echo '<defender>';
					echo '<id>'.mysql_result($query_run,0,'id').'</id>';
					echo '<room>'.mysql_result($query_run,0,'room').'</room>';
					echo '<row>'.mysql_result($query_run,0,'row').'</row>';
					echo '<col>'.mysql_result($query_run,0,'col').'</col>';
				echo '</defender>';
			}
			$query = "select * from `walls` where `room`=$defenderRoom";
			if ($query_run = mysql_query($query))
			{
				for($i=4;$i<=8;$i++)
				{
					for($j=1;$j<=9;$j++)
					{
						$colName = 'w'.$i.$j;
						$data = mysql_result($query_run,0,$colName);
						echo '<cell'.$i.$j.'>'.$data.'</cell'.$i.$j.'>';
					}
				}
			}
		}

	echo '</response>';
?>
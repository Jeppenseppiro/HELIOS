<?php
	require 'db_connect.php';
	if(isset($_POST["view"])){
		if($_POST["view"] != ''){
			$update_query = "UPDATE tbl_log SET log_status=1 WHERE log_status=0";
			$conn->query($update_query);
		}

		$notification_query = "SELECT * FROM tbl_log INNER JOIN tbl_account ON tbl_log.account_id = tbl_account.account_id ORDER BY log_id DESC LIMIT 5";
		$notification_result = $conn->query($notification_query);

		$output = '';

		if($notification_result->num_rows > 0){
			while ($row = $notification_result->fetch_assoc()){
				if($row["notification_id"] == 1){
					$output .=' 
	                  	<a href="'.$row["url_link"].'">
	                  	  <div class="panel-heading" style="z-index: 90; vertical-align: baseline; width: 300px;">
	                        <table class="tg">
	                          <tr> 
	                          	<th style="vertical-align:bottom;" rowspan="2"><img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"></th>
	                            <th class="tg-s268">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a><small style="text-align: right; float: right;"></th>
	                          </tr>
	                          <tr>
	                            <td class="tg-s268">has inserted a Primary Utility Post</td>
	                          </tr>
	                        </table>                         
	                      </div>
	                  	</a>
					';
				}

				if($row["notification_id"] == 2){
					$output .=' 
	                  	<a href="'.$row["url_link"].'">
	                  	  <div class="panel-heading" style="z-index: 90; vertical-align: baseline; width: 300px;">
	                        <table class="tg">
	                          <tr> 
		                        <th style="vertical-align:bottom;" rowspan="2"><img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"></th>
		                        <th class="tg-s268">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a><small style="text-align: right; float: right;"></th>
	                          </tr>
	                          <tr>
	                            <td class="tg-s268">has inserted a Secondary Utility Post</td>
	                          </tr>
	                        </table>                         
	                      </div>
	                  	</a>
					';
				}

				if($row["notification_id"] == 3){
					$output .=' 
	                  	<a href="'.$row["url_link"].'">
	                  	  <div class="panel-heading" style="z-index: 90; vertical-align: baseline; width: 300px;">
	                        <table class="tg">
	                          <tr> 
	                          	<th style="vertical-align:bottom;" rowspan="2"><img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"></th>
	                            <th class="tg-s268">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a><small style="text-align: right; float: right;"></th>
	                          </tr>
	                          <tr>
	                            <td class="tg-s268">has inserted a Transformer</td>
	                          </tr>
	                        </table>                         
	                      </div>
	                  	</a>
					';
				}

				if($row["notification_id"] == 4){
					$output .=' 
	                  	<a href="'.$row["url_link"].'">
	                  	  <div class="panel-heading" style="z-index: 90; vertical-align: baseline; width: 300px;">
	                        <table class="tg">
	                          <tr> 
	                          	<th style="vertical-align:bottom;" rowspan="2"><img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"></th>
	                            <th class="tg-s268">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a><small style="text-align: right; float: right;"></th>
	                          </tr>
	                          <tr>
	                            <td class="tg-s268">has updated a Primary</td>
	                          </tr>
	                        </table>                         
	                      </div>
	                  	</a>
					';
				}

				if($row["notification_id"] == 5){
					$output .=' 
	                  	<a href="'.$row["url_link"].'">
	                  	  <div class="panel-heading" style="z-index: 90; vertical-align: baseline; width: 300px;">
	                        <table class="tg">
	                          <tr> 
	                          	<th style="vertical-align:bottom;" rowspan="2"><img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"></th>
	                            <th class="tg-s268">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a><small style="text-align: right; float: right;"></th>
	                          </tr>
	                          <tr>
	                            <td class="tg-s268">has updated a Secondary</td>
	                          </tr>
	                        </table>                         
	                      </div>
	                  	</a>
					';
				}

				if($row["notification_id"] == 6){
					$output .=' 
	                  	<a href="'.$row["url_link"].'">
	                  	  <div class="panel-heading" style="z-index: 90; vertical-align: baseline; width: 300px;">
	                        <table class="tg">
	                          <tr> 
	                          	<th style="vertical-align:bottom;" rowspan="2"><img src="data:image;base64,'.base64_encode($row['image'] ).'" style="width: 50px; height:50px;"></th>
	                            <th class="tg-s268">&nbsp;<a href="profile.php?username='.$row["username"].'">'.$row['username'].' ('.$row['fname']." ".$row['lname'].')</a><small style="text-align: right; float: right;"></th>
	                          </tr>
	                          <tr>
	                            <td class="tg-s268">has updated a Transformer</td>
	                          </tr>
	                        </table>                         
	                      </div>
	                  	</a>
					';
				}
			} 

		} else {
			$output .= '
				  <li>
                  	<a href="#">
                  		BYE
                  	</a>
                  </li>
			';
		}

		$check_log = "SELECT * FROM tbl_log WHERE log_status=0";
        $check_logResult = $conn->query($check_log);

        $count = $check_logResult->num_rows;
		$data = array(
		 'notification'   => $output,
		 'unseen_notification' => $count
		);
		echo json_encode($data);
	}
?>
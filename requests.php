
<?php
		header('Access-Control-Allow-Origin: *');  
		require_once ("db.php");
    $db = new Database();

			if(isset($_POST['action'])) {
	    	$action = $_POST['action'];
	    }
	    if(isset($_POST['data'])) {
	      $data = json_decode($_POST['data'], true);
			}
			
			// login auth action
	    if($action == 'auth'){
        $userData = $db->select("SELECT * FROM auth where login=" . '"' . $data['user'] . '";')[0];

        if($data['pass'] == $userData['pass']){
        	$rsp = array(
            'responce' => 200,
            'status' => 'success',
            'data' =>  $userData
          );
          echo json_encode($rsp);
        }else{
        	$rsp = array(
            'responce' => 200,
            'status' => 'Wrong login or password!',
          );
          echo json_encode($rsp);
        }
	  	}
	    
	    // get shop data action
      if($action == 'get_shop_data'){
      	$shopData = $db->select("SELECT * FROM shop ;");
      	echo json_encode($shopData);
      }

			if($action == 'delete_item'){
      	$db->insert("DELETE FROM shop WHERE idwallDB=".$data['id'].";");

      	$rsp = array(
          'responce' => 200,
          'status' => 'success',
        );
        echo json_encode($rsp);
      }    

      if($action == 'add_item'){
      	$db->insert("INSERT INTO shop (good, price) VALUES ('".$data['good']."'," .$data['price']. ");");
      	$rsp = array(
          'responce' => 200,
          'status' => 'success',
        );
        echo json_encode($rsp);
      } 
	 
?>


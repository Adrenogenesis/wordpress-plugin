
<style>
#vote {
    height: 500px;
    border: 5px solid black;
    background-color: grey;
}

#track {
    color: black;
    height: 100px;
    border: 5px solid red;
    background-color: yellow;
}
 </style>
<?php
/**
* Plugin Name: Database 2
* Plugin URI: http://www.mainwp.com
* Description: This plugin does some stuff with WordPress
* Version: 1.0.0
* Author: Scarabator
* Author URI: http://www.mainwp.com
* License: GPL2
*/

// Now all you need to do is add the following within the WordPress loop to have the voting box appear. <?php voting($post->ID); ? > 
// Hook the 'wp_footer' action hook, add the function named 'mfp_Add_Text' to it
//add_action("the_content", "html_form_code");
// https://developer.wordpress.org/plugins/hooks/advanced-topics/
//connect.php
 
/**
 * This script connects to MySQL using the PDO object.
 * This can be included in web pages where a database connection is needed.
 * Customize these to match your MySQL database connection details.
 * This info should be available from within your hosting panel.
 */
 
add_action("the_content", "html_form_code");

  function html_form_code() {

  echo "<p id='upl'>Questionnaire.</p>";
  require "connect.php";
  if(isset($_POST['Quest3'])){
    
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $inputType = !empty($_POST['inputType']) ? trim($_POST['inputType']) : null;  
  
    $sql = "INSERT INTO Statutquiz (username, inputType) VALUES (:username, :inputType)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':inputType', $inputType);
     
    $result = $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row['username'] > 1){
        die('Vous avez déjà répondu à cette question !');
    }
   
    if($result){
        echo 'Merci de votre participation !';
    }
}

$stmt = $pdo->query("SELECT question1 FROM `qu1` ");
while ($row = $stmt->fetch()){ 
       $sel = $row['question1']; 
        echo $sel . "\n" . "<br>";
  }
	
$stmt = $pdo->query("SELECT images FROM `qu1`");
while ($row = $stmt->fetch()){ 
       $sel2 = $row['images']; 
       // echo $sel2;
    echo '<img src="'.$sel2.'">';
    }

	echo '<form action="" method="post" class="Quest3" enctype="multipart/form-data">';
	echo '<p>';
	echo 'Votre nom';
	echo '</p>';
	echo '<input type="text" id="username" name="username">';
	echo '<p>';
	echo 'Votre réponse<br/>';
	echo '</p>';
	echo '<input type="text" name="inputType" id="inputType">';
	echo '<br>';
	echo'<input type="submit" name="Quest3" value="Envoyer"></input>';
	echo'<input type="reset" value="Effacer">';
    echo '</form>';

	  $inputType = "";

	if ($inputType == 'Paris'){
		echo 'Mauvaise réponse';
		};
		echo '<hr><br>';

		// Before using $_POST['value']
		if (isset($_POST['inputType']))
		{
		// Instructions if $_POST['value'] exist
		} 

		$reponse1 = $_POST['inputType'];
		
		$stmt = $pdo->prepare("SELECT * FROM qu1 WHERE reponse1=?");
		$stmt->execute([$reponse1]);
		$username = $stmt->fetch();
		if ($username) {
			echo 'Réponse '. ':' . '<br>' . $reponse1 . '<br>';
			
		} else {
			echo 'Mauvaise réponse !';
		}
		 echo '<hr><br>';
		 echo "Question 1";
}

function upl_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#upl {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;
		margin: 0;
    color: black;
		font-size: 11px;
	}
	.block-editor-page #upl {
		display: none;
	}
	</style>
	";
}

add_action( 'admin_head', 'upl_css' );
?>




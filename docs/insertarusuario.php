<?php 
require('conexion.php');
$bd = new Conexion();

$conn = $bd->conectar();

echo $nombre = $_POST['nombre'];
echo "<br>";
echo $ap = $_POST['ap'];
echo "<br>";
echo $user = $_POST['user'];
echo "<br>";
echo $pw = $_POST['pw'];
echo "<br>";

$query = $conn->prepare("SELECT * FROM usuario WHERE nom_usuario=?");
$query->bindParam(1,$user);
$query->execute();

if ($query->fetchColumn()>0) {
	echo "Ese usuario ya ha sido registrado, intenta con otro";
}else{
	

	$insert = $conn->prepare("INSERT INTO persona VALUES('NULL',?,?)");
	$insert->bindParam(1,$nombre);
	$insert->bindParam(2,$ap);
	$insert->execute();
	$insert->closeCursor();

	$insert=$conn->prepare("INSERT INTO usuario VALUES('NULL',?,?, (SELECT MAX(pk_persona) FROM persona))");
	$insert->bindParam(1,$user);
	$insert->bindParam(2,$pw);
	$insert->execute();

	if ($insert->rowCount()>0) {
		echo "Registro exitoso";
	}else{
		echo "Error";
	}

}

?>
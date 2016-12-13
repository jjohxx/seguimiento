<?php
	require 'funciones.php';
	function console_log( $data ){
			echo '<script>';
			echo 'console.log('. json_encode( $data ) .')';
			echo '</script>';
		};

    $conexion = conexion('db_seguimiento','root','root');

    if (!$conexion) {
        die();
    }
    $statement = $conexion->prepare("SELECT SIGLA_MATERIA,NOMBRE_MATERIA FROM MATERIA ");
    $statement->execute();
    $materias = $statement->fetchAll();
	$siglaMateria;
	$idMateria = null;
	$nombreMateria;
	$grupos= array();
	$isSelected;
	if(isset($_POST['sigla_post']) && $_POST['sigla_post'] != "" ){
		console_log($_POST['sigla_post']);
		$siglaMateria=$_POST['sigla_post'];
		$materiaSeleccionada = $conexion->prepare("SELECT ID_MATERIA,NOMBRE_MATERIA FROM MATERIA WHERE SIGLA_MATERIA = $siglaMateria ");
	$materiaSeleccionada->execute();
	
    $materiaEncontrada = $materiaSeleccionada->fetch();
	console_log("SIGLA");
	global $idMateria;
	global $nombreMateria;
	$idMateria = $materiaEncontrada["ID_MATERIA"];
	$nombreMateria = $materiaEncontrada["NOMBRE_MATERIA"];
	console_log($idMateria);
	console_log($nombreMateria);
	
	$cookie_id = 'idMateria';
	$cookie_idMateria = $idMateria;
	$cookie_nom_materia = 'nomMateria';
	$cookie_nomMateria = $nombreMateria;
	setcookie($cookie_id, $cookie_idMateria);
	setcookie($cookie_nom_materia, $cookie_nomMateria);
	setcookie('connected', false);

	$statementgrupo = $conexion->prepare("SELECT ID_GRUPO, NOM_GRUPO FROM GRUPO WHERE ID_MATERIA = $idMateria ");
	$statementgrupo->execute();
    $grupos = $statementgrupo->fetchAll();
	console_log($grupos);
	    console_log("SIGLA1");

	}

	if(isset($_POST['insert']) && isset($_COOKIE['idMateria']) && isset($_COOKIE['nomMateria'])) {
		$idMateria1 = $_COOKIE['idMateria'];
		$nom_grupo = $_POST['nom_grupo'];
		$insert_query = 'INSERT INTO GRUPO (ID_GRUPO, ID_MATERIA, NOM_GRUPO) VALUES (NULL, :ID_MATERIA, :NOM_GRUPO)';
	    $statements = $conexion->prepare($insert_query);
        $statements->execute(array(
            ':ID_MATERIA'=>$idMateria1,
            ':NOM_GRUPO'=>$nom_grupo
        ));
		global $nombreMateria;
	$nombreMateria = $_COOKIE['nomMateria'];
	$statementgrupo = $conexion->prepare("SELECT ID_GRUPO, NOM_GRUPO FROM GRUPO WHERE ID_MATERIA = $idMateria1 ");
	$statementgrupo->execute();
    $grupos = $statementgrupo->fetchAll();
	}

	if(isset($_COOKIE['idGrupo']) && $_COOKIE['idGrupo'] != ""  && isset($_COOKIE['connected'])) {

	$idMateria1 = $_COOKIE['idMateria'];
	global $nombreMateria;
	$nombreMateria = $_COOKIE['nomMateria'];
	$statementgrupo = $conexion->prepare("SELECT ID_GRUPO, NOM_GRUPO FROM GRUPO WHERE ID_MATERIA = $idMateria1 ");
	$statementgrupo->execute();
    $grupos = $statementgrupo->fetchAll();
	}

	if(isset($_POST['delete']) && isset($_COOKIE['idGrupo'])) {
		console_log("grupo");
		$idGrupo = $_COOKIE['idGrupo'];
		console_log($idGrupo);
     	$sql = "DELETE FROM GRUPO WHERE ID_GRUPO= $idGrupo";
	    $statements = $conexion->prepare($sql);
        $statements->execute();
			$idMateria1 = $_COOKIE['idMateria'];
	global $nombreMateria;
	$nombreMateria = $_COOKIE['nomMateria'];
	$statementgrupo = $conexion->prepare("SELECT ID_GRUPO, NOM_GRUPO FROM GRUPO WHERE ID_MATERIA = $idMateria1 ");
	$statementgrupo->execute();
    $grupos = $statementgrupo->fetchAll();
	}

	if(isset($_POST['modify']) && isset($_COOKIE['idGrupo']) && isset($_POST['nom_grupo'])) {
		console_log("grupo");
		$idGrupo = $_COOKIE['idGrupo'];
		console_log($idGrupo);
		$nom_grupo = $_POST['nom_grupo'];
        console_log($nom_grupo);
     	$sql = "UPDATE GRUPO SET NOM_GRUPO = $nom_grupo WHERE ID_GRUPO = $idGrupo";
    console_log($sql);
	    $statements = $conexion->prepare($sql);
        $statements->execute();
        console_log($statements);

			$idMateria1 = $_COOKIE['idMateria'];
	global $nombreMateria;
	$nombreMateria = $_COOKIE['nomMateria'];
	$statementgrupo = $conexion->prepare("SELECT ID_GRUPO, NOM_GRUPO FROM GRUPO WHERE ID_MATERIA = $idMateria1 ");
	$statementgrupo->execute();
    $grupos = $statementgrupo->fetchAll();
	}
	

	
	
    require 'views/registroGrupos.view.php';

?>	
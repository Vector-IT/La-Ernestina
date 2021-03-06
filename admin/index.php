<?php
    session_start();

    ini_set("log_errors", 1);
    ini_set("error_log", "php-error.log");

    require_once 'php/datos.php';

    if (!isset($_SESSION['is_logged_in_'. $nombSistema])) {
        header("Location:". $url ."admin/login.php");
        die();
    }

    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'php/linksHeader.php';?>
</head>
<body>
	<?php
        $config->crearMenu();

        require_once 'php/header.php';
    ?>

	<div class="container-fluid">
		<div class="mt-5">
			<h2><?php echo index_title?></h2>
		</div>

		<p class="lead">
			<?php echo str_replace('#titulo#', $config->titulo, index_text)?>
		</p>

		<!-- CUOTAS VENCIDAS IMPAGAS -->
		<?php if ($numeCarg <= 2) {?>
		<p class="lead">
			Cuotas Vencidas Impagas
		</p>
		<?php
			$strSQL = "SELECT cu.CodiIden, p.NumeProd, p.NombProd, c.NombClie, cu.NumeCuot, cu.FechVenc, cu.ImpoCuot + cu.ImpoOtro Importe";
			$strSQL.= $crlf."FROM productos p";
			$strSQL.= $crlf."INNER JOIN clientes c ON p.NumeClie = c.NumeClie";
			$strSQL.= $crlf."INNER JOIN cuotas cu ON p.NumeProd = cu.NumeProd";
			$strSQL.= $crlf."WHERE cu.NumeEstaCuot IN (1, 2)";
			$strSQL.= $crlf."AND cu.FechVenc < SYSDATE()";
			$strSQL.= $crlf."ORDER BY cu.FechVenc";

			$cuotasimpagas = $config->cargarTabla($strSQL);

			if ($cuotasimpagas && $cuotasimpagas->num_rows > 0) {
				$strSalida = $crlf.'<table class="table table-striped table-bordered table-hover table-condensed table-sm sortable">';
				$strSalida.= $crlf.'<thead>';
				$strSalida.= $crlf.'<tr>';
				$strSalida.= $crlf.'<th>Producto</th>';
				$strSalida.= $crlf.'<th>Cliente</th>';
				$strSalida.= $crlf.'<th>Nro de cuota</th>';
				$strSalida.= $crlf.'<th>Fecha de Vencimiento</th>';
				$strSalida.= $crlf.'<th class="text-right">Importe</th>';
				$strSalida.= $crlf.'<th></th>';
				$strSalida.= $crlf.'</tr>';
				$strSalida.= $crlf.'<tbody>';

				while ($fila = $cuotasimpagas->fetch_assoc()) {
					$strSalida.= $crlf.'<tr>';
					$strSalida.= $crlf.'<td>'. $fila["NombProd"] .'</td>';
					$strSalida.= $crlf.'<td>'. $fila["NombClie"] .'</td>';
					$strSalida.= $crlf.'<td>'. $fila["NumeCuot"] .'</td>';
					$strSalida.= $crlf.'<td>'. $fila["FechVenc"] .'</td>';
					$strSalida.= $crlf.'<td class="text-right">$ '. $fila["Importe"] .'</td>';
					$strSalida.= $crlf.'<td class="text-center"><a role="button" class="btn btn-info btn-sm" title="Ver Cuota" href="objeto/cuotas.php?NumeProd='.$fila["NumeProd"].'&idFila='.$fila["CodiIden"].'"><i class="fa fa-calendar-alt"></i></button></td>';
					$strSalida.= $crlf.'</tr>';
				}

				$strSalida.= $crlf.'</tbody>';
				$strSalida.= $crlf.'</table>';
			}
			else {
				$strSalida = $crlf.'<p>No hay cuotas vencidas.</p>';
			}

			echo $strSalida;
		?>
		<?php }?>

		<!-- SEGUIMIENTOS DEL DIA -->
		<p class="lead">
			Seguimientos del día
		</p>
		<?php
			$strSQL = "SELECT s.NumeSegu, s.NumeClie, c.NombClie, ts.NombTipoSegu, s.ObseSegu";
			$strSQL.= $crlf."FROM seguimientos s";
			$strSQL.= $crlf."INNER JOIN (SELECT NumeClie, NombClie";
			$strSQL.= $crlf."			FROM clientes c";
			$strSQL.= $crlf."			) c ON s.NumeClie = c.NumeClie";
			$strSQL.= $crlf."INNER JOIN tiposseguimientos ts ON s.NumeTipoSegu = ts.NumeTipoSegu";
			$strSQL.= $crlf."WHERE";
			$strSQL.= $crlf."s.NumeEstaSegu > 0";
			$strSQL.= $crlf."AND s.FechSegu = DATE_FORMAT(SYSDATE(), '%Y-%m-%d')";

			switch ($numeCarg) {
				case '3': //Supervisor
					$strSQL.= $crlf."AND s.NumeUser IN (SELECT gvd.NumeUser FROM gruposventa gv, gruposventadetalles gvd WHERE gv.NumeGrup = gvd.NumeGrup AND gv.NumeSupe = ". $_SESSION['NumeUser'] .")";
				break;

				case '4': //Vendedor
					$strSQL.= $crlf."AND s.NumeUser = ". $_SESSION['NumeUser'];
				break;
			}

			$seguimientos = $config->cargarTabla($strSQL);

			if ($seguimientos && $seguimientos->num_rows > 0) {
				$strSalida = $crlf.'<table class="table table-striped table-bordered table-hover table-condensed table-sm sortable">';
				$strSalida.= $crlf.'<thead>';
				$strSalida.= $crlf.'<tr>';
				$strSalida.= $crlf.'<th>Cliente</th>';
				$strSalida.= $crlf.'<th>Tipo de seguimiento</th>';
				$strSalida.= $crlf.'<th>Observación</th>';
				$strSalida.= $crlf.'<th></th>';
				$strSalida.= $crlf.'</tr>';
				$strSalida.= $crlf.'<tbody>';

				while ($segui = $seguimientos->fetch_assoc()) {
					$strSalida.= $crlf.'<tr>';
					$strSalida.= $crlf.'<td>'. $segui["NombClie"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["NombTipoSegu"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["ObseSegu"] .'</td>';
					$strSalida.= $crlf.'<td class="text-center"><button class="btn btn-info btn-sm" title="Ver seguimiento" onclick="verSeguimiento('. $segui["NumeSegu"] .', '. $segui["NumeClie"] .');"><i class="fa fa-calendar-alt"></i></button></td>';
					$strSalida.= $crlf.'</tr>';
				}

				$strSalida.= $crlf.'</tbody>';
				$strSalida.= $crlf.'</table>';
			}
			else {
				$strSalida = $crlf.'<p>No hay seguimientos programados para hoy.</p>';
			}

			echo $strSalida;
		?>

		<!-- SEGUIMIENTOS DE LA SEMANA -->
		<p class="lead marginTop40">
			Seguimientos de la semana
		</p>
		<?php
			$strSQL = "SELECT s.NumeSegu, s.FechSegu, s.NumeClie, c.NombClie, ts.NombTipoSegu, s.ObseSegu";
			$strSQL.= $crlf."FROM seguimientos s";
			$strSQL.= $crlf."INNER JOIN (SELECT NumeClie, NombClie";
			$strSQL.= $crlf."			FROM clientes c";
			$strSQL.= $crlf."			) c ON s.NumeClie = c.NumeClie";
			$strSQL.= $crlf."INNER JOIN tiposseguimientos ts ON s.NumeTipoSegu = ts.NumeTipoSegu";
			$strSQL.= $crlf."WHERE";
			$strSQL.= $crlf."s.NumeEstaSegu > 0";
			$strSQL.= $crlf."AND s.FechSegu >= DATE_FORMAT(DATE_ADD(SYSDATE(), INTERVAL(-WEEKDAY(SYSDATE())) DAY), '%Y-%m-%d')";
			switch ($numeCarg) {
				case '3': //Supervisor
					$strSQL.= $crlf."AND s.NumeUser IN (SELECT gvd.NumeUser FROM gruposventa gv, gruposventadetalles gvd WHERE gv.NumeGrup = gvd.NumeGrup AND gv.NumeSupe = ". $_SESSION['NumeUser'] .")";
				break;

				case '4': //Vendedor
					$strSQL.= $crlf."AND s.NumeUser = ". $_SESSION['NumeUser'];
				break;
			}

			$seguimientos = $config->cargarTabla($strSQL);

			if ($seguimientos && $seguimientos->num_rows > 0) {
				$strSalida = $crlf.'<table class="table table-striped table-bordered table-hover table-condensed table-sm sortable">';
				$strSalida.= $crlf.'<thead>';
				$strSalida.= $crlf.'<tr>';
				$strSalida.= $crlf.'<th>Fecha</th>';
				$strSalida.= $crlf.'<th>Cliente</th>';
				$strSalida.= $crlf.'<th>Tipo de seguimiento</th>';
				$strSalida.= $crlf.'<th>Observación</th>';
				$strSalida.= $crlf.'<th></th>';
				$strSalida.= $crlf.'</tr>';
				$strSalida.= $crlf.'<tbody>';

				while ($segui = $seguimientos->fetch_assoc()) {
					$strSalida.= $crlf.'<tr>';
					$strSalida.= $crlf.'<td>'. $segui["FechSegu"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["NombClie"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["NombTipoSegu"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["ObseSegu"] .'</td>';
					$strSalida.= $crlf.'<td class="text-center"><button class="btn btn-info btn-sm" title="Ver seguimiento" onclick="verSeguimiento('. $segui["NumeSegu"] .', '. $segui["NumeClie"] .');"><i class="fa fa-calendar-alt"></i></button></td>';
					$strSalida.= $crlf.'</tr>';
				}

				$strSalida.= $crlf.'</tbody>';
				$strSalida.= $crlf.'</table>';
			}
			else {
				$strSalida = $crlf.'<p>No hay seguimientos programados para la semana.</p>';
			}

			echo $strSalida;
		?>

		<!-- SEGUIMIENTOS DEL MES -->
		<p class="lead marginTop40">
			Seguimientos del mes
		</p>
		<?php
			$strSQL = "SELECT s.NumeSegu, s.FechSegu, s.NumeClie, c.NombClie, ts.NombTipoSegu, s.ObseSegu";
			$strSQL.= $crlf."FROM seguimientos s";
			$strSQL.= $crlf."INNER JOIN (SELECT NumeClie, NombClie";
			$strSQL.= $crlf."			FROM clientes c";
			$strSQL.= $crlf."			) c ON s.NumeClie = c.NumeClie";
			$strSQL.= $crlf."INNER JOIN tiposseguimientos ts ON s.NumeTipoSegu = ts.NumeTipoSegu";
			$strSQL.= $crlf."WHERE";
			$strSQL.= $crlf."s.NumeEstaSegu > 0";
			$strSQL.= $crlf."AND s.FechSegu >= DATE_FORMAT(SYSDATE(), '%Y-%m-01')";
			switch ($numeCarg) {
				case '3': //Supervisor
					$strSQL.= $crlf."AND s.NumeUser IN (SELECT gvd.NumeUser FROM gruposventa gv, gruposventadetalles gvd WHERE gv.NumeGrup = gvd.NumeGrup AND gv.NumeSupe = ". $_SESSION['NumeUser'] .")";
				break;

				case '4': //Vendedor
					$strSQL.= $crlf."AND s.NumeUser = ". $_SESSION['NumeUser'];
				break;
			}

			$seguimientos = $config->cargarTabla($strSQL);

			if ($seguimientos && $seguimientos->num_rows > 0) {
				$strSalida = $crlf.'<table class="table table-striped table-bordered table-hover table-condensed table-sm sortable">';
				$strSalida.= $crlf.'<thead>';
				$strSalida.= $crlf.'<tr>';
				$strSalida.= $crlf.'<th>Fecha</th>';
				$strSalida.= $crlf.'<th>Cliente</th>';
				$strSalida.= $crlf.'<th>Tipo de seguimiento</th>';
				$strSalida.= $crlf.'<th>Observación</th>';
				$strSalida.= $crlf.'<th></th>';
				$strSalida.= $crlf.'</tr>';
				$strSalida.= $crlf.'<tbody>';

				while ($segui = $seguimientos->fetch_assoc()) {
					$strSalida.= $crlf.'<tr>';
					$strSalida.= $crlf.'<td>'. $segui["FechSegu"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["NombClie"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["NombTipoSegu"] .'</td>';
					$strSalida.= $crlf.'<td>'. $segui["ObseSegu"] .'</td>';
					$strSalida.= $crlf.'<td class="text-center"><button class="btn btn-info btn-sm" title="Ver seguimiento" onclick="verSeguimiento('. $segui["NumeSegu"] .', '. $segui["NumeClie"] .');"><i class="fa fa-calendar-alt"></i></button></td>';
					$strSalida.= $crlf.'</tr>';
				}

				$strSalida.= $crlf.'</tbody>';
				$strSalida.= $crlf.'</table>';
			}
			else {
				$strSalida = $crlf.'<p>No hay seguimientos programados para el mes.</p>';
			}

			echo $strSalida;
		?>
	</div>

	<?php
        require_once 'php/footer.php';
    ?>
</body>
</html>
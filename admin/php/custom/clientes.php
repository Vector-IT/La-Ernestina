<?php
namespace VectorForms;

class Cliente extends Tabla {
	public function insertar($datos) {
		global $config;

		$result = parent::insertar($datos);

		if ($result["estado"] === true) {
			$estados = $config->getTabla("clientesestados");

			$datosAux = [
				"CodiIden" => '',
				"NumeClie" => $result["id"],
				"NumeEstaClie" => $datos["NumeEstaClie"],
			];

			$estados->insertar($datosAux);
		}

		return $result;
	}

	public function editar($datos, $idViejo) {
		global $config;

		$numeEstaClie_old = $config->buscarDato("SELECT NumeEstaClie FROM clientes WHERE NumeClie = ". $idViejo);

		$result = parent::editar($datos, $idViejo);

		if ($result["estado"] === true && $numeEstaClie_old != $datos["NumeEstaClie"]) {
			$estados = $config->getTabla("clientesestados");

			$datosAux = [
				"CodiIden" => '',
				"NumeClie" => $datos["NumeClie"],
				"NumeEstaClie" => $datos["NumeEstaClie"],
			];

			$estados->insertar($datosAux);
		}

		return $result;
	}

	function colorEstado(&$field, $dato) {
		$cantDias = intval($dato["CantDias"]);

        switch ($field["name"]) {
			case 'NumeEstaClie':
				if ($dato["NumeEstaClie"] == "4") {
					$field["classFormat"] = 'fondoMagenta';
				}
			break;

			case 'NumeClie':
				if ($dato["NumeEstaClie"] != "1") {
					if ($cantDias <= 1) {
						$field["classFormat"] = 'fondoVerde';
					} elseif ($cantDias <= 2) {
						$field["classFormat"] = 'fondoAmarillo';
					} else {
						$field["classFormat"] = 'fondoRojo';
					}
				}
			break;
		}

		return true;
	}
}
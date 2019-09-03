<?php
namespace VectorForms;

class Producto extends Tabla
{
    public function customFunc($post)
    {
        global $config;

        switch ($post['field']) {
            case "Asignar Cliente":
                $numeProd = $post["dato"]["NumeProd"];
                $numeClie = $post["dato"]["NumeClie"];
                $valoProd = floatval($config->buscarDato("SELECT ValoProd FROM productos WHERE NumeProd = ". $numeProd));
                $impoAnti = floatval($post["dato"]["ImpoAnti"]);
                $cantCuot = intval($post["dato"]["CantCuot"]);
				$fechInic = $post["dato"]["FechInic"];
				$interes = $post["dato"]["Interes"];

                $cuotExtr = (isset($post["dato"]["CuotExtr"]) ? $post["dato"]["CuotExtr"] : []);
                $fechExtr = (isset($post["dato"]["FechExtr"]) ? $post["dato"]["FechExtr"] : []);

                if ($impoAnti < $valoProd) {
                    $numeEsta = "2";
                } else {
                    $numeEsta = "4";
                    $cantCuot = "0";
                }

                $result = $config->ejecutarCMD("UPDATE productos SET NumeEstaProd = ".$numeEsta.", NumeClie = ".$numeClie.", CantCuot = ".$cantCuot.", InteresDiario = ". $interes ." WHERE NumeProd = ". $numeProd);

                $cuota = $config->getTabla("cuotas");

                $fecha = new \DateTime($fechInic);

				if ($result === true) {
					//Creo el anticipo
					$datos = array(
						"CodiIden"=>"",
						"NumeCuot"=>"0",
						"FechCuot"=>$fecha->format("Y-m-d"),
						"NumeProd"=>$numeProd,
						"NumeTipoCuot"=>"1",
						"FechVenc"=>$fecha->format("Y-m-d"),
						"ImpoCuot"=>$impoAnti,
						"ImpoOtro"=>"0",
						"NumeEstaCuot"=>"1"
					);
					$resCuota = $cuota->insertar($datos);

					//Creo las cuotas extraordinarias
					$I = 0;
					foreach($cuotExtr as $value) {
						$impoAnti+= $value;

						$fechaAux = new \DateTime($fechExtr[$I]);

						$datos = array(
							"CodiIden"=>"",
							"NumeCuot"=>"0",
							"FechCuot"=>$fecha->format("Y-m-d"),
							"NumeProd"=>$numeProd,
							"NumeTipoCuot"=>"3",
							"FechVenc"=>$fechaAux->format("Y-m-d"),
							"ImpoCuot"=>$value,
							"ImpoOtro"=>"0",
							"NumeEstaCuot"=>"1"
						);
						$resCuota = $cuota->insertar($datos);

						$I++;
					}

					//Creo las cuotas
					if (intval($cantCuot) > 0) {
						$saldo = $valoProd - $impoAnti;
						$impoCuot = number_format($saldo / $cantCuot, 2, ".", "");

						$fechVenc = new \DateTime($fecha->format("Y-m-"). "10");

						for ($numeCuot = 1; $numeCuot <= $cantCuot; $numeCuot++) {
							$fechVenc->add(new \DateInterval("P1M"));

							$datos = array(
								"CodiIden"=>"",
								"NumeCuot"=>$numeCuot,
								"FechCuot"=>$fecha->format("Y-m-d"),
								"NumeProd"=>$numeProd,
								"NumeTipoCuot"=>"2",
								"FechVenc"=>$fechVenc->format("Y-m-d"),
								"ImpoCuot"=>$impoCuot,
								"ImpoOtro"=>"0",
								"NumeEstaCuot"=>"1"
							);
							$resCuota = $cuota->insertar($datos);
						}
					}
				}
                return $result;
                break;

            case "Borrar Cliente":
                $numeProd = $post["dato"]["NumeProd"];

                $config->ejecutarCMD("DELETE FROM cuotaspagos WHERE CodiIden IN (SELECT CodiIden FROM cuotas WHERE NumeProd = ". $numeProd .")");
                $config->ejecutarCMD("DELETE FROM cuotas WHERE NumeProd = ". $numeProd);
                $result = $config->ejecutarCMD("UPDATE productos SET NumeEstaProd = 1, NumeClie = null, CantCuot = null WHERE NumeProd = ". $numeProd);

                return $result;
                break;
        }
    }
}

<?php
namespace VectorForms;

class Lote extends Tabla
{
    public function customFunc($post)
    {
        global $config;
        
        switch ($post['field']) {
            case "Asignar Cliente":
                $numeLote = $post["dato"]["NumeLote"];
                $numeClie = $post["dato"]["NumeClie"];
                $valoLote = floatval($config->buscarDato("SELECT ValoLote FROM lotes WHERE NumeLote = ". $numeLote));
                $impoAnti = floatval($post["dato"]["ImpoAnti"]);
                $cantCuot = intval($post["dato"]["CantCuot"]);
                $fechInic = $post["dato"]["FechInic"];

                if ($impoAnti < $valoLote) {
                    $numeEsta = "2";
                } else {
                    $numeEsta = "4";
                    $cantCuot = "0";
                }
                
                $result = $config->ejecutarCMD("UPDATE lotes SET NumeEstaLote = ".$numeEsta.", NumeClie = ".$numeClie.", CantCuot = ".$cantCuot." WHERE NumeLote = ". $numeLote);

                $cuota = $config->getTabla("cuotas");
                
                $fecha = new \DateTime($fechInic);

                //Creo el anticipo
                $datos = array(
                    "CodiIden"=>"",
                    "NumeCuot"=>"0",
                    "FechCuot"=>$fecha->format("Y-m-d"),
                    "NumeLote"=>$numeLote,
                    "NumeTipoCuot"=>"1",
                    "FechVenc"=>$fecha->format("Y-m-d"),
                    "ImpoCuot"=>$impoAnti,
                    "ImpoOtro"=>"0"
                );
                $cuota->insertar($datos);

                //Creo las cuotas
                if (intval($cantCuot) > 0) {
                    $saldo = $valoLote - $impoAnti;
                    $impoCuot = number_format($saldo / $cantCuot, 2, ".", "");
                    
                    $fechVenc = new \DateTime($fecha->format("Y-m-"). "10");

                    for ($numeCuot = 1; $numeCuot <= $cantCuot; $numeCuot++) {
                        $fechVenc->add(new \DateInterval("P1M"));

                        $datos = array(
                            "CodiIden"=>"",
                            "NumeCuot"=>$numeCuot,
                            "FechCuot"=>$fecha->format("Y-m-d"),
                            "NumeLote"=>$numeLote,
                            "NumeTipoCuot"=>"2",
                            "FechVenc"=>$fechVenc->format("Y-m-d"),
                            "ImpoCuot"=>$impoCuot,
                            "ImpoOtro"=>"0"
                        );
                        $cuota->insertar($datos);
                    }
                }

                return $result;
                break;
        }
    }
}

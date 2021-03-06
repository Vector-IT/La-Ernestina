<?php
namespace VectorForms;

class CuotaPago extends Tabla
{
    public function customFunc($post)
    {
        global $config;

        switch ($post['field']) {
            case "NumeEsta":
                $result = $config->ejecutarCMD("UPDATE cuotaspagos SET NumeEsta = NOT NumeEsta WHERE NumePago = ". $post["dato"]["NumePago"]);

                $cuota = $config->buscarDato("SELECT SUM(ImpoCuot + ImpoOtro) FROM cuotas WHERE CodiIden = ".$post["dato"]["CodiIden"]);
                $pagos = $config->buscardato("SELECT SUM(ImpoPago) FROM cuotaspagos WHERE NumeEsta = 1 AND CodiIden = ".$post["dato"]["CodiIden"]);
                $saldo = $cuota - $pagos;

                $datos = [];
                $datos["CodiIden"] = $post["dato"]["CodiIden"];

                if ($saldo > 0) {
                    if ($saldo == $cuota) {
                        $datos["NumeEstaCuot"] = "1";
                    }
                    else {
                        $datos["NumeEstaCuot"] = "2";
                    }
                }
                else {
                    $datos["NumeEstaCuot"] = "3";
                }

                $cuotas = $config->getTabla("cuotas");
                $cuotas->editar($datos, $datos["CodiIden"]);

                return $result;
                break;

            case "Cheques":
                return $config->cargarCombo("cheques", "CodiCheq", "CONCAT(NumeCheq, ' - ', NombTitu,' - $', ImpoCheq)", "NumeEsta = 1", "2", "", true);
                break;

            case "ImpoCheq":
                return $config->buscarDato("SELECT ImpoCheq FROM cheques WHERE CodiCheq = ". $post["dato"]["CodiCheq"]);
                break;
        }
    }

    public function insertar($datos) {
        Global $config;

        $result = parent::insertar($datos);

        $cuota = $config->buscarDato("SELECT SUM(ImpoCuot + ImpoOtro) FROM cuotas WHERE CodiIden = ".$datos["CodiIden"]);
        $pagos = $config->buscardato("SELECT SUM(ImpoPago) FROM cuotaspagos WHERE NumeEsta = 1 AND CodiIden = ".$datos["CodiIden"]);
        $saldo = $cuota - $pagos;

        $datos2 = [];
        $datos2["CodiIden"] = $datos["CodiIden"];

        if ($saldo > 0) {
            if ($saldo == $cuota) {
                $datos2["NumeEstaCuot"] = "1";
            }
            else {
                $datos2["NumeEstaCuot"] = "2";
            }
        }
        else {
            $datos2["NumeEstaCuot"] = "3";
        }

        $cuotas = $config->getTabla("cuotas");
        $cuotas->editar($datos2, $datos2["CodiIden"]);

        return $result;
    }

    public function listar($strFiltro = "", $conBotones = true, $btnList = [], $order = '', $pagina = 1, $strFiltroSQL = '', $conCheckboxes = false)
    {
        global $config, $crlf;

        $cuota = $config->buscarDato("SELECT ImpoCuot + ImpoOtro Importe, FechVenc FROM cuotas WHERE CodiIden = ".$_REQUEST[$this->masterFieldId]);
		$pagos = $config->buscardato("SELECT SUM(ImpoPago) FROM cuotaspagos WHERE NumeEsta = 1 AND CodiIden = ".$_REQUEST[$this->masterFieldId]);

        $saldo = number_format($cuota["Importe"] - $pagos, 2, ".", "");

		$strSalida = '';
		$strSalida.= $crlf.'<div class="row">';
		$strSalida.= $crlf.'<div class="col-md-6"><h4>Vencimiento: '.$cuota["FechVenc"].'</h4></div>';
		$strSalida.= $crlf.'<div class="col-md-6"><h4 class="well well-sm text-right">Saldo: <span class="txtRojo">$ <span id="txtSaldo">'.$saldo.'</span></span></h4></div>';
		$strSalida.= $crlf.'</div>';

		$salida = parent::listar($strFiltro, $conBotones, $btnList, $order);

		$salida['html'] = $strSalida . $salida['html'];

		return $salida;
    }
}

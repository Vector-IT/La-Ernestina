<?php
namespace VectorForms;

class Cuota extends Tabla
{
    public function customFunc($post) {
        global $config;

        switch ($post['field']) {
            case "ImpoPago":
                return $config->buscarDato("SELECT COALESCE(SUM(ImpoPago), 0) FROM cuotaspagos WHERE NumeEsta = 1 AND CodiIden = ". $post["dato"]);
			break;

			case 'CalcInterses':
				$cuota = $config->buscarDato("SELECT NumeProd, DATEDIFF(STR_TO_DATE('{$post["Fecha"]}', '%Y-%m-%d'), FechVenc) Dias FROM cuotas WHERE CodiIden = ". $post["CodiIden"]);
				$intereses = \floatval($config->buscarDato("SELECT InteresDiario FROM productos WHERE NumeProd = ". $cuota["NumeProd"]));

				if ($intereses != 0) {
					$strSQL = "UPDATE cuotas SET ImpoOtro = {$cuota["Dias"]} * (ImpoCuot * {$intereses} / 100) WHERE CodiIden = ". $post["CodiIden"];
					$result = $config->ejecutarCMD($strSQL);

					return $result;
				}
			break;
        }
    }

    public function editar($datos, $idViejo) {
        global $config;

        $result = parent::editar($datos, $idViejo);

        $numeProd = $config->buscarDato("SELECT NumeProd FROM cuotas WHERE CodiIden = ". $datos["CodiIden"]);

        $total = intval($config->buscarDato("SELECT COUNT(*) FROM cuotas WHERE NumeProd = ".$numeProd));
        $pagadas = intval($config->buscarDato("SELECT COUNT(*) FROM cuotas WHERE NumeProd = ".$numeProd." AND NumeEstaCuot = 3"));
        $pagoparcial = intval($config->buscarDato("SELECT COUNT(*) FROM cuotas WHERE NumeProd = ".$numeProd." AND NumeEstaCuot = 2"));

        $datos2 = [];
        $datos2["NumeProd"] = $numeProd;

        $saldo = $total - $pagadas - $pagoparcial;

        if ($saldo == 0) {
            if ($pagoparcial == 0) { //TODAS PAGADAS
                $datos2["NumeEstaProd"] = "4";
            }
            else {
                $datos2["NumeEstaProd"] = "3";
            }
        }
        else {
            if (($pagadas + $pagoparcial) <= 1) {
                $datos2["NumeEstaProd"] = "2";
            }
            else {
                $datos2["NumeEstaProd"] = "3";
            }
        }
        $producto = $config->getTabla("productos");
        $producto->editar($datos2, $datos2["NumeProd"]);

        return $result;
    }

    public function listar($strFiltro = "", $conBotones = true, $btnList = [], $order = '', $pagina = 1, $strFiltroSQL = '', $conCheckboxes = false) {
        global $config, $crlf;

        $cuotas = $config->buscarDato("SELECT SUM(ImpoCuot + ImpoOtro) FROM cuotas WHERE NumeProd = ".$_REQUEST[$this->masterFieldId]);
        $pagos = $config->buscardato("SELECT COALESCE(SUM(ImpoPago), 0) FROM cuotaspagos WHERE NumeEsta = 1 AND CodiIden IN (SELECT CodiIden FROM cuotas WHERE NumeProd = ".$_REQUEST[$this->masterFieldId].")");
        $saldo = number_format($cuotas - $pagos, 2, ".", "");

		$salida = parent::listar($strFiltro, $conBotones, $btnList, $order);
		$salida['html'] = $crlf.'<h4 id="txtSaldo" class="well well-sm text-right">Saldo: <span class="txtRojo">$ '.$saldo.'</span></h4>'. $salida['html'];
		$salida['html'].= $crlf.'<h4 id="txtSaldo" class="well well-sm text-right">Saldo: <span class="txtRojo">$ '.$saldo.'</span></h4>';

		return $salida;
    }
}

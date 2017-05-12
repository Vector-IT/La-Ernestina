<?php
namespace VectorForms;

class Cuota extends Tabla
{
    public function customFunc($post)
    {
        global $config;
        
        switch ($post['field']) {
            case "Cheques":
                $result = $this->cargarCombo("cheques", "CodiCheq", "CONCAT(NumeCheq, ' - $', ImpoCheq)", "NumeEsta = 1", "2", "", true);

				return $result;
                break;
        }
    }

    public function editar($datos)
    {
        $datos["FechPago"] = date("Y-m-d");

        return parent::editar($datos);
    }

    public function listar($strFiltro = "", $conBotones = true, $btnList = [], $order = '')
    {
        global $config, $crlf;

        $cuotas = $config->buscarDato("SELECT SUM(ImpoCuot + ImpoOtro) FROM cuotas WHERE NumeLote = ".$_REQUEST[$this->masterFieldId]);
        $pagos = $config->buscardato("SELECT SUM(ImpoPago) FROM cuotaspagos WHERE CodiIden IN (SELECT CodiIden FROM cuotas WHERE NumeLote = ".$_REQUEST[$this->masterFieldId].")");
        $saldo = number_format($cuotas - $pagos, 2, ".", "");

        echo $crlf.'<h4 id="txtSaldo"  class="text-right">Saldo: <span class="txtRojo">$ '.$saldo.'</span></h4>';
        parent::listar($strFiltro, $conBotones, $btnList, $order);
        echo $crlf.'<h4 id="txtSaldo"  class="text-right">Saldo: <span class="txtRojo">$ '.$saldo.'</span></h4>';
    }
}

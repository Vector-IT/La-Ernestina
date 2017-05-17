<?php
namespace VectorForms;

class Indexacion extends Tabla {
    public function customFunc($post)
    {
        global $config;

        switch ($post['field']) {
            case "NumeEsta":
                $result = $config->ejecutarCMD("UPDATE indexaciones SET NumeEsta = NOT NumeEsta WHERE NumeInde = ". $post["dato"]["NumeInde"]);
                
                $numeEsta = $config->buscarDato("SELECT NumeEsta FROM indexaciones WHERE NumeInde = ". $post["dato"]["NumeInde"]);
                $porc = 1 + (floatval($post["dato"]["PorcInde"]) / 100);

                if ($numeEsta == "0") {
                    $strSQL = "UPDATE cuotas SET ImpoOtro = ((ImpoCuot + ImpoOtro) / ". $porc .") - ImpoCuot WHERE NumeEstaCuot <> 3 AND FechVenc >= SYSDATE()";
                }
                else {
                    $strSQL = "UPDATE cuotas SET ImpoOtro = ((ImpoCuot + ImpoOtro) * ". $porc .") - ImpoCuot WHERE NumeEstaCuot <> 3 AND FechVenc >= SYSDATE()";
                }
                $config->ejecutarCMD($strSQL);

                return $result;
                break;
        }
    }

    public function insertar($datos) {
        global $config;

        $result = parent::insertar($datos);

        $porc = 1 + (floatval($datos["PorcInde"]) / 100);
        $strSQL = "UPDATE cuotas SET ImpoOtro = ((ImpoCuot + ImpoOtro) * ". $porc .") - ImpoCuot WHERE NumeEstaCuot <> 3 AND FechVenc >= SYSDATE()";
        $config->ejecutarCMD($strSQL);

        return $result;
    }
}
?>
<?php

	function Validar_formato($rut){
		$permitidos = '0123456789kK';
		for($i = 0; $i<strlen($rut); $i++){
			if(strpos($permitidos, substr($rut, $i, 1)) === FALSE){
				return false;
			}else{
				return true;
			}
		}
	}

    function validaRut($rut)
    {
    	$suma = 0;
    	if(strpos($rut,"-")==false){
        $RUT[0] = substr($rut, 0, -1);
        $RUT[1] = substr($rut, -1);
    }else{
        $RUT = explode("-", trim($rut));
    }
    $elRut = str_replace(".", "", trim($RUT[0]));
    $factor = 2;
    for($i = strlen($elRut)-1; $i >= 0; $i--):
        $factor = $factor > 7 ? 2 : $factor;
        $suma += $elRut{$i}*$factor++;
    endfor;
    $resto = $suma % 11;
    $dv = 11 - $resto;
    if($dv == 11){
        $dv=0;
    }else if($dv == 10){
        $dv="k";
    }else{
        $dv=$dv;
    }
   if($dv == trim(strtolower($RUT[1]))){
       return true;
   }else{
       return false;
   }
}

       /* $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut)-1);
        $i = 2;
        $suma = 0;
        foreach(array_reverse(str_split($numero)) as $v)
        {
            if($i==8)
                $i = 2;
            $suma += $v * $i;
            ++$i;
        }
        $dvr = 11 - ($suma % 11);
        
        if($dvr == 11)
            $dvr = 0;
        if($dvr == 10)
            $dvr = 'k';
        if($dvr == strtoupper($dv))
            return true;
        else
            return false;
    }
*/
    function formateo_rut($rut_param){
        $parte4 = substr($rut_param, -1); // seria solo el numero verificador
        $parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq 
        $parte2 = substr($rut_param, -7,3); 
        $parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 7 hacia la izq

        return $parte1.".".$parte2.".".$parte3."-".$parte4;
    }
?>
<?php

$mail = "@gmail.com";
$id = "8";
$url = "http://.br" . $mail . "&workflowID=" . $id ."&";

//Convert data as dd/mm/yyyy to yyyy-mm-dd
function dateChange($velhaData){
	if (isset($velhaData)){ //check if the date exists
	   $newDate = DateTime::createFromFormat("d/m/Y", $velhaData);
		 if ($newDate != FALSE){
			 //var_dump($newDate);
	   			return $newDate->format('Y-m-d');
	 		}
	}
	return "";
}
$row = 1;

if (($handle = fopen("doc.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
				$json = "{";
				$json = $json . "\"identifier\": \"sintese\",\n";
				//$json = $json . "\"parentID\": \"lab\",\n";   path to workflow data
				//$json = $json . "\"atributes\": \"{\n";

// No need to use converter since the output is already in JSON pattern

    		$json = $json . "\"codigocat\":\"" . "$data[0]" . "\",\n";
				// The "$data[0]" info is the position in the cvs table
							$date =  dateChange($data[1]);

				$json = $json . "\"date\":\"" . "$date" . "\",\n" ;

        $json = $json . "\"utilizacao\":\"" . "$data[2]" . "\",\n";

        $json = $json . "\"barquinha\":\"" . "$data[3]" . "\",\n";

        $json = $json . "\"fe\":\"" . "$data[4]" . "\",\n";

        $json = $json . "\"ni\":\"" . "$data[5]" . "\",\n";

        $json = $json . "\"co\":\"" . "$data[6]" . "\",\n";

        $json = $json . "\"mo\":\"" . "$data[7]" . "\",\n";

        $json = $json . "\"proporcaoDeAlflakemol\":\"" . "$data[8]" . "\",\n";

        $json = $json . "\"proporcaoDeAlmol\":\"" . "$data[9]" . "\",\n";

        $json = $json . "\"al2o3\":\"" . "$data[10]" . "\",\n";

        $json = $json . "\"proporcaoDeSimol\":\"" . "$data[11]" . "\",\n";

        $json = $json . "\"proporcaoDeMgmol\":\"" . "$data[12]" . "\",\n";

				$json = $json . "\"forno\":\"" . "$data[13]" . "\",\n";

        $json = $json . "\"sal1\":\"" . "$data[14]" . "\",\n";

        $json = $json . "\"sal2\":\"" . "$data[15]" . "\",\n";

        $json = $json . "\"sal3\":\"" . "$data[16]" . "\",\n";

        $json = $json . "\"suporte\":\"" . "$data[17]" . "\",\n";

        $json = $json . "\"rotina\":\"" . "$data[18]" . "\",\n";

        $json = $json . "\"temperaturaUtilizadaoc\":\"" . "$data[19]" . "\",\n";

        $json = $json . "\"tempoDeCalcinacaomin\":\"" . "$data[20]" . "\",\n";

        $json = $json . "\"rampaDeAquecimentomin\":\"" . "$data[21]" . "\",\n";

        $json = $json . "\"massaInicial\":\"" . "$data[22]" . "\",\n";

        $json = $json . "\"massaFinal\":\"" . "$data[23]" . "\",\n";

        $json = $json . "\"percentualDeConservacaoDeMassa\":\"" . "$data[24]" . "\",\n";

        $json = $json . "\"observacoes\":\"" . "$data[25]" . "\"\n";

				$json = $json . "}";
				$json = $json . "}";
				echo $json;
		}
		fclose($handle);

		// Create the context for the request
		$context = stream_context_create(array(
				'http' => array(
				//http://www.php.net/manual/en/context.http.php
				'method' => 'POST',
				'header' => "Content-Type: application/json\r\n",
				'content' => $json
				)
		)
		);

		// Send the request
		$response = file_get_contents('http://dev.br', FALSE, $context);

		// Check for errors
		if($response === FALSE){
			die("Error\n");
		}

		// Print the date from the response
		echo $response;
} //closes the { at line 19
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>vagas @ DHL</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
      <link rel="stylesheet" href="css/style.css">
     
  
</head>

<body>
  <!-- fieldsets -->
  <fieldset>

  </fieldset>



					<?php
					
require '_lib/Exception.php';
require '_lib/PHPMailer.php';
require '_lib/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;	
					
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$vaga = $_POST['vaga'];
$email = $_POST['email'];
					
					// Dados do banco
$dbhost   = "artificialx.com.br.mysql";   #Nome do host
$db       = "artificialx_com_br";   #Nome do banco de dados
$user     = "artificialx_com_br"; #Nome do usuário
$password = "zTtdc6t7DMmdbkCvLJx9xcP8";   #Senha do usuário

// Dados da tabela
$tabela = "nometabela";    #Nome da tabela
$campo1 = "campo1tabela";  #Nome do campo da tabela
$campo2 = "campo2tabela";  #Nome de outro campo da tabaela

$conn = new mysqli($dbhost, $user, $password, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo 'error';
} 

          if ($email != 'rh@dhl.com') {
              
                  $sql = "SELECT email FROM dhl_analise_cognitiva WHERE email = '$email'";
                     $result = $conn->query($sql);
                     if ($result->num_rows > 0) {
                             echo "<script>alert('O e-mail digitado já existe e não pode mais ser utilizado');</script>";
                             echo "<script>history.go(-1);</script>";
                             $conn->close();
                             exit;
                        } else {
                                 $info = "nada encontrado";
                                               }
                                               
          }
                                 

					/*************************** inicio do translate ****************/
					
						$services_json = json_decode(getenv('VCAP_SERVICES'), true);
						$watsonPi = $services_json["<servicename>"][0]["credentials"];

						// Extract the VCAP_SERVICES variables for Watson PI connection.
					  // i.e. username, password and url
						$username = '9ef7a8a0-76d6-4805-a835-199ca5271796';
						$password = 'Q0RWvlx1DggJ';
						$url = 'https://gateway.watsonplatform.net/language-translator/api/v2/translate';
						$header_args = array();
                             $header_args[] = 'Content-Type: application/json';
                             $header_args[] = 'Accept: text/plain';
                        
                             $textPTBR = $_POST['txtarea'];
                             
                            
                             
                             $textPTBR = htmlentities($textPTBR, null, 'utf-8');
                             $textPTBR = str_replace("&nbsp;"," ",$textPTBR);
                             $textPTBR = str_replace("\n", "", $textPTBR);
                             $textPTBR = str_replace("\r", "", $textPTBR);
                             $textPTBR = preg_replace('/\s/',' ',$textPTBR);
                               
                              
                             $textEN = "{\"text\":\"$textPTBR\",\"source\":\"pt-br\",\"target\":\"en\"}";
                             
                            
              
                
                            $post_args = $textEN;
                                   
                              
					    $curl = curl_init();
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $post_args);
						curl_setopt($curl, CURLOPT_HTTPHEADER, $header_args);
						curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
						curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
						curl_setopt($curl, CURLOPT_URL, $url);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

						$resultEN = curl_exec($curl);
                       if ($resultEN === FALSE) {
                       die('Send Error: ' . curl_error($curl));
                                                   }
                       curl_close($curl);
                       
                        $textEN  = explode("{", $resultEN);
                       
                      // $textAlianhado = trim(preg_replace('/\s\s+/', ' ', $textEN[0]));
                       
                             $str = htmlentities($textEN[0], null, 'utf-8');
                             $str = str_replace("&nbsp;"," ",$textEN[0]);
                             $str = str_replace("\n", "", $textEN[0]);
                             $str = str_replace("\r", "", $textEN[0]);
                             $str = preg_replace('/\s/',' ',$textEN[0]);
                       
                       
                
  
					/*************************** inicio do personality-insights ****************/
				
					
						// VCAP_SERVICES extraction and retrieval of Watson PI credentials
						$services_json = json_decode(getenv('VCAP_SERVICES'), true);
						$watsonPi = $services_json["<servicename>"][0]["credentials"];

						// Extract the VCAP_SERVICES variables for Watson PI connection.
					  // i.e. username, password and url
						$username = '98b295f2-2189-4a14-aef1-8d6d4cdab4c1';
						$password = 'uSBEupLYb6kN';
						$url = 'https://gateway.watsonplatform.net/personality-insights/api/v3/profile?version=2017-10-13';
						$header_args = array();
                             $header_args[] = 'Content-Type: text/plain';
                             $header_args[] = 'Accept: application/json';
                             $header_args[] = 'Accept-Language: pt-br';
                             $header_args[] = 'raw_score: true';
                             
                             
                         
                                 
                
                                   $post_args = $str;
                                   
                                     
                                 // echo $post_args;

						// Curl initialization to make REST call to Watson service

						// Get textarea field from POST request

						// Set post arguments for call

					  // Set header arguments for call

					  // Set options for REST call via curl
					    $curl = curl_init();
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $post_args);
						curl_setopt($curl, CURLOPT_HTTPHEADER, $header_args);
						curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
						curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
						curl_setopt($curl, CURLOPT_URL, $url);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

						// Actual REST call via curl and cleanup (closing) of curl call

					  // Decode JSON object for furhter usage. Only used here to pretty print JSON object

					  // Echo result as pretty printed JSON

						$result = curl_exec($curl);
                       if ($result === FALSE) {
                       die('Send Error: ' . curl_error($curl));
                                                   }
                       curl_close($curl);
                       
                       
                       
                       
                    
                    
              
                    $array  = explode(":", $result);
                    
               //   echo $result;
                    
                   $info0 =  $array[6];
                   $info1 =  $array[8];
                   
                   $pers0  = explode(",", $info0);
                   $rate0  = explode(",", $info1);
                   
                   $float = (real)$rate0[0];
                   
                   $por0 = $float * 100;
                  
                   $info2 =  $array[12];
                   $info3 =  $array[14];
                   
                   $pers1  = explode(",", $info2);
                   $rate1  = explode(",", $info3);
                   
                   $float = (real)$rate1[0];
                   
                   $por1 = $float * 100;
                   
                   $info4 =  $array[17];
                   $info5 =  $array[19];
                   
                   $pers2  = explode(",", $info4);
                   $rate2  = explode(",", $info5);
                   
                   $float = (real)$rate2[0];
                   
                   $por2 = $float * 100;
                   
                   $info6 =  $array[22];
                   $info7 =  $array[24];
                   
                   $pers3  = explode(",", $info6);
                   $rate3  = explode(",", $info7);
                   
                   $float = (real)$rate3[0];
                   
                   $por3 = $float * 100;
                   
                   $info8 =  $array[27];
                   $info9 =  $array[29];
                   
                   $pers4  = explode(",", $info8);
                   $rate4  = explode(",", $info9);
                   
                   $float = (real)$rate4[0];
                   
                   $por4 = $float * 100;
                   
                   $info10 =  $array[32];
                   $info11 =  $array[34];
                   
                   $pers5  = explode(",", $info10);
                   $rate5  = explode(",", $info11);
                   
                   $float = (real)$rate5[0];
                   
                   $por5 = $float * 100;
                   
                   $info12 =  $array[37];
                   $info13 =  $array[39];
                   
                   $pers6  = explode(",", $info12);
                   $rate6  = explode(",", $info13);
                   
                   $float = (real)$rate6[0];
                   
                   $por6 = $float * 100;
                   
                   /***************************************/
                   
                   $info13 =  $array[42];
                   $info14 =  $array[44];
                   
                   $pers7  = explode(",", $info13);
                   $rate7  = explode(",", $info14);
                   
                   $float = (real)$rate7[0];
                   
                   $por7 = $float * 100;
                  
                   $info15 =  $array[48];
                   $info16 =  $array[50];
                   
                   $pers8  = explode(",", $info15);
                   $rate8  = explode(",", $info16);
                   
                   $float = (real)$rate8[0];
                   
                   $por8 = $float * 100;
                   
                   $info17 =  $array[53];
                   $info18 =  $array[55];
                   
                   $pers9  = explode(",", $info17);
                   $rate9  = explode(",", $info18);
                   
                   
                   $float = (real)$rate9[0];
                   
                   $por9 = $float * 100;
                   
                   $info19 =  $array[58];
                   $info20 =  $array[60];
                   
                   $pers10  = explode(",", $info19);
                   $rate10  = explode(",", $info20);
                   
                   $float = (real)$rate10[0];
                   
                   $por10 = $float * 100;
                   
                   $info21 =  $array[63];
                   $info22 =  $array[65];
                   
                   $pers11  = explode(",", $info21);
                   $rate11  = explode(",", $info22);
                   
                   $float = (real)$rate11[0];
                   
                   $por11 = $float * 100;
                   
                   $info23 =  $array[68];
                   $info24 =  $array[70];
                   
                   $pers12  = explode(",", $info23);
                   $rate12  = explode(",", $info24);
                   
                   $float = (real)$rate12[0];
                   
                   $por12 = $float * 100;
                   
                   $info25 =  $array[73];
                   $info26 =  $array[75];
                   
                   $pers13  = explode(",", $info25);
                   $rate13  = explode(",", $info26);
                   
                   $float = (real)$rate13[0];
                   
                   $por13 = $float * 100;
                  
                     /***************************************/
                   
                   $info27 =  $array[78];
                   $info28 =  $array[80];
                   
                   $pers14  = explode(",", $info27);
                   $rate14  = explode(",", $info28);
                   
                   $float = (real)$rate14[0];
                   
                   $por14 = $float * 100;
                  
                   $info29 =  $array[84];
                   $info30 =  $array[86];
                   
                   $pers15  = explode(",", $info29);
                   $rate15  = explode(",", $info30);
                   
                   $float = (real)$rate15[0];
                   
                   $por15 = $float * 100;
                   
                   $info30 =  $array[89];
                   $info31 =  $array[91];
                   
                   $pers16  = explode(",", $info30);
                   $rate16  = explode(",", $info31);
                   
                   
                   $float = (real)$rate16[0];
                   
                   $por16 = $float * 100;
                   
                   $info32 =  $array[94];
                   $info33 =  $array[96];
                   
                   $pers17  = explode(",", $info32);
                   $rate17  = explode(",", $info33);
                   
                   $float = (real)$rate17[0];
                   
                   $por17 = $float * 100;
                   
                   $info34 =  $array[99];
                   $info35 =  $array[101];
                   
                   $pers18  = explode(",", $info34);
                   $rate18  = explode(",", $info35);
                   
                   $float = (real)$rate18[0];
                   
                   $por18 = $float * 100;
                   
                   $info36 =  $array[104];
                   $info37 =  $array[106];
                   
                   $pers19  = explode(",", $info36);
                   $rate19  = explode(",", $info37);
                   
                   $float = (real)$rate19[0];
                   
                   $por19 = $float * 100;
                   
                   $info38 =  $array[109];
                   $info39 =  $array[111];
                   
                   $pers20  = explode(",", $info38);
                   $rate20  = explode(",", $info39);
                   
                   $float = (real)$rate20[0];
                   
                   $por20 = $float * 100;
                   
                       /***************************************/
                   
                   $info40 =  $array[114];
                   $info41 =  $array[116];
                   
                   $pers21  = explode(",", $info40);
                   $rate21  = explode(",", $info41);
                   
                   $float = (real)$rate21[0];
                   
                   $por21 = $float * 100;
                  
                   $info41 =  $array[120];
                   $info43 =  $array[122];
                   
                   $pers22  = explode(",", $info41);
                   $rate22  = explode(",", $info43);
                   
                   $float = (real)$rate22[0];
                   
                   $por22 = $float * 100;
                   
                   $info44 =  $array[125];
                   $info45 =  $array[127];
                   
                   $pers23  = explode(",", $info44);
                   $rate23  = explode(",", $info45);
                   
                   
                   $float = (real)$rate23[0];
                   
                   $por23 = $float * 100;
                   
                   $info46 =  $array[130];
                   $info47 =  $array[132];
                   
                   $pers24  = explode(",", $info46);
                   $rate24  = explode(",", $info47);
                   
                   
                   $float = (real)$rate24[0];
                   
                   $por24 = $float * 100;
                   
                    $info48 =  $array[135];
                   $info49 =  $array[137];
                   
                   $pers25  = explode(",", $info48);
                   $rate25  = explode(",", $info49);
                   
                   
                   $float = (real)$rate25[0];
                   
                   $por25 = $float * 100;
                   
                   $info50 =  $array[140];
                   $info51 =  $array[142];
                   
                   $pers26  = explode(",", $info50);
                   $rate26  = explode(",", $info51);
                   
                   
                   $float = (real)$rate25[0];
                   
                   $por26 = $float * 100;
                   
                   $info52 =  $array[145];
                   $info53 =  $array[147];
                   
                   $pers27  = explode(",", $info52);
                   $rate27  = explode(",", $info53);
                   
                   
                   $float = (real)$rate27[0];
                   
                   $por27 = $float * 100;
                   
                 
                   
                   $info54 =  $array[156];
                   $info55 =  $array[158];
                   
                   $pers28  = explode(",", $info54);
                   $rate28  = explode(",", $info55);
                   
                   
                   $float = (real)$rate28[0];
                   
                   $por28 = $float * 100;
            
                  
                  
                   $info56 =  $array[161];
                   $info57 =  $array[163];
                   
                   $pers29  = explode(",", $info56);
                   $rate29  = explode(",", $info57);
                   
                   
                   $float = (real)$rate29[0];
                   
                   $por29 = $float * 100;
                   
                   $info58 =  $array[166];
                   $info59 =  $array[168];
                   
                   $pers30  = explode(",", $info58);
                   $rate30  = explode(",", $info59);
                   
                   
                   $float = (real)$rate30[0];
                   
                   $por30 = $float * 100;


                   $info60 =  $array[171];
                   $info61 =  $array[173];
                   
                   $pers31  = explode(",", $info60);
                   $rate31  = explode(",", $info61);
                   
                   
                   $float = (real)$rate31[0];
                   
                   $por31 = $float * 100;
                   
                   
                   $info62 =  $array[176];
                   $info63 =  $array[178];
                   
                   $pers32  = explode(",", $info62);
                   $rate32  = explode(",", $info63);
                   
                   
                   $float = (real)$rate32[0];
                   
                   $por32 = $float * 100;
                   
                   
                   $info64 =  $array[181];
                   $info65 =  $array[183];
                   
                   $pers33  = explode(",", $info64);
                   $rate33  = explode(",", $info65);
                   
                   
                   $float = (real)$rate33[0];
                   
                   $por33 = $float * 100;
                   
                   
                   //////////////////////AGREBLENESS/////////////////////////
                  if ($por21 > 80) { 
                      
                      $resp21 = "Sente-se satisfeito ao ajudar os outros e pode fazer de tudo para isso.";
                      
                  } else {
                      
                      $resp21 = "Normalmente é mais preocupado em cuidar de si mesmo do que dedicar-se a outros.";
                  }
                  
                  
                    if ($por22 > 80) { 
                      
                      $resp22 = "É fácil de agradar e tenta evitar confrontos.";
                      
                  } else {
                      
                      $resp22 = "Não se importa de contradizer os outros.";
                  }
                  
                     if ($por23 > 80) { 
                      
                      $resp23 = "Gosta de ser o centro das atenções.";
                      
                  } else {
                      
                      $resp23 = "Gosta e está satisfeito com quem você é.";
                  }
                  
                    if ($por24 > 80) { 
                      
                      $resp24 = "Acha errado tomar vantagens de outros e fica longe disso.";
                      
                  } else {
                      
                      $resp24 = "Gosta de correr atrás ao maximo do que você quer.";
                  }
                  
                     if ($por25 > 80) { 
                      
                      $resp25 = "Tem empatia e se preocupa com outros.";
                      
                  } else {
                      
                      $resp25 = "Acha que as pessoas devem cuidar mais de si mesmas do que de outros.";
                  }
                  
                     if ($por26 > 80) { 
                      
                      $resp26 = "Acredita no melhor dos outros e confia facilmente.";
                      
                  } else {
                      
                      $resp26 = "Fica bastante atento as intenções de outros e não confia facilmente.";
                  }
         
         
         //////////////////////// Conscientiousness ///////////////////
         
                   if ($por8 > 80) { 
                      
                      $resp8 = "Define grandes metas para você e trabalha duro para atingi-las.";
                      
                  } else {
                      
                      $resp8 = "Está contente com o que já conseguiu e não define metas ambiciosas para si mesmo.";
                  }

                  
                  if ($por9 > 80) { 
                      
                      $resp9 = "Analisa muito bem as decisões antes de toma-las.";
                      
                  } else {
                      
                      $resp9 = "Prefere tomar decisões mais rapidamente do que dedicar um tempo deliberando sobre elas.";
                  }
         
         
                  if ($por10 > 80) { 
                      
                      $resp10 = "Leva regras e obrigações muito a sério, mesmo quando não fazem sentido para você.";
                      
                  } else {
                      
                      $resp10 = "Normalmente faz o que você quer sem ligar muito para regras e obrigações.";
                  }
                  
                    if ($por11 > 80) { 
                      
                      $resp11 = "Precisa levar uma vida organizada e estruturada.";
                      
                  } else {
                      
                      $resp11 = "Não dedica muito tempo para organização em sua vida.";
                  }
                  
                    if ($por12 > 80) { 
                      
                      $resp12 = "Normalmente gosta de ficar com as tarefas difíceis.";
                      
                  } else {
                      
                      $resp12 = "Não consegue ficar com tarefas difíceis por muito tempo.";
                  }
                  
                      if ($por13 > 80) { 
                      
                      $resp13 = "Acredita resolver todas as tarefas que define para você.";
                      
                  } else {
                      
                      $resp13 = "Normalmente dúvida resolver todas as tarefas que define para você";
                  }
                  
                  
                     
                  /////////////////////  Extraversion //////////////////////////
                  
                  
                  
                      if ($por15 > 80) { 
                      
                      $resp15 = "Gosta de uma rotina agitada e com muitas atividades para desenvolver.";
                      
                  } else {
                      
                      $resp15 = "Aprecia uma rotina mais calma.";
                  }
                  
               
                  
                      if ($por16 > 80) { 
                      
                      $resp16 = "Tende a liderar grupos e se sente confortável ao fazer isso.";
                      
                  } else {
                      
                      $resp16 = "Prefere escutar a falar em atividades em grupo.";
                  }
                  
                       if ($por17 > 80) { 
                      
                      $resp17 = "É uma pessoa alegre e gosta de compartilhar isso com todos ao seu redor.";
                      
                  } else {
                      
                      $resp17 = "Normalmente é uma pessoa séria e não brinca muito.";
                  }
                  
                     if ($por18 > 80) { 
                      
                      $resp18 = "Se sente confortável em ariscar, e normalmente gosta de situações com várias coisas acontecendo.";
                      
                  } else {
                      
                      $resp18 = "Prefere atividades mais calmas, seguras e tranquilas.";
                  }
                  
                     if ($por19 > 80) { 
                      
                      $resp19 = "Faz amigos facilmente e se sente confortável rodeado de pessoas.";
                      
                  } else {
                      
                      $resp19 = "É uma pessoa reservada e não faz muitos amigos.";
                  }
                  
                      if ($por20 > 80) { 
                      
                      $resp20 = "Gosta de estar na companhia de outros.";
                      
                  } else {
                      
                      $resp20 = "Tem a necessidade de ter um tempo para si mesmo.";
                  }
                  
                 
                  
                  
                  
                      //////////////////////Emotional Range/////////////////////////
                  if ($por27 > 80) { 
                      
                      $resp27 = "Tem um temperamento explosivo, especialmente quando as coisas não acontecem do seu jeito.";
                      
                  } else {
                      
                      $resp27 = "Precisa de muito para deixa-lo nervoso.";
                  }
                  
                  
                    if ($por28 > 80) { 
                      
                      $resp28 = "Tende a se preocupar com coisas que talvez possam acontecer.";
                      
                  } else {
                      
                      $resp28 = "Tende a sentir-se calmo e autoconfiante.";
                  }
                  
                     if ($por29 > 80) { 
                      
                      $resp29 = "Pensa várias vezes nas coisas que não te deixam feliz.";
                      
                  } else {
                      
                      $resp29 = "Normalmente está contente com quem você é.";
                  }
                  
                    if ($por30 > 80) { 
                      
                      $resp30 = "Tende a fazer o que você deseja.";
                      
                  } else {
                      
                      $resp30 = "Se controla facilmente perante todos os tipos de situações.";
                  }
                  
                     if ($por31 > 80) { 
                      
                      $resp31 = "Se importa com o que os outros estão pensando sobre você.";
                      
                  } else {
                      
                      $resp31 = "Dificilmente se sente tímido e é autoconfiante a maior parte do tempo";
                  }
                  
                     if ($por32 > 80) { 
                      
                      $resp32 = "Estressa facilmente com situações não esperadas.";
                      
                  } else {
                     
                      $resp32 = "Lida facilmente com situações estressantes.";
                  }
         
         
                 //////////////////////// Openness ///////////////////
                  
                  if ($por1 > 80) { 
                      
                      $resp1 = "Gosta de viver novas experiências.";
                      
                  } else {
                      
                      $resp1 = "Prefere rotinas familiares e não gosta de se desviar delas.";
                  }
         
         
                  if ($por2 > 80) { 
                      
                      $resp2 = "É um individuo bastante criativo.";
                      
                  } else {
                      
                      $resp2 = "Você não tem muito interesse em assuntos artísticos.";
                  }
                  
                    if ($por3 > 80) { 
                      
                      $resp3 = "Tem cosciência de seus sentimentos e sabe como expressa-los.";
                      
                  } else {
                      
                      $resp3 = "Não fala abertamente sobre seus sentimentos.";
                  }
                  
                    if ($por4 > 80) { 
                      
                      $resp4 = "Tem uma imaginação viva.";
                      
                  } else {
                      
                      $resp4 = "Gosta mais de fatos do que imaginar novas ideias.";
                  }
                  
                      if ($por5 > 80) { 
                      
                      $resp5 = "Gosta de procurar novas ideias e adora explora-las.";
                      
                  } else {
                      
                      $resp5 = "Prefere lidar mais com fatos do que com ideias abstratas";
                  }
                  
                  
                       if ($por6 > 80) { 
                      
                      $resp6 = "Prefere desafiar autoridades para trazer novas ideias.";
                      
                  } else {
                      
                      $resp6 = "Prefere tradições para manter um senso de estabilidade";
                  }
                  
                 
                  
                  
                  $result = array($pers1[0], $por1, $resp1, $pers2[0], $por2, $resp2, $pers3[0], $por3, $resp3, $pers4[0], $por4, $resp4, $pers5[0], $por5, $resp5, $pers6[0], $por6, $resp6, $pers8[0], $por8, $resp8, $pers9[0], $por9, $resp9, $pers10[0], $por10, $resp10, $pers11[0], $por11, $resp11, $pers12[0], $por12, $resp12, $pers13[0], $por13, $resp13, $pers15[0], $por15, $resp15, $pers16[0], $por16, $resp16, $pers17[0], $por17, $resp17, $pers18[0], $por18, $resp18, $pers19[0], $por19, $resp19, $pers21[0], $por21, $resp21, $pers22[0], $por22, $resp22, $pers23[0], $por23, $resp23, $pers24[0], $por24, $resp24, $pers25[0], $por25, $resp25, $pers26[0], $por26, $resp26, $pers27[0], $por27, $resp27, $pers28[0], $por28, $resp28, $pers29[0], $por29, $resp29, $pers30[0], $por30, $resp30, $pers31[0], $por31, $resp31, $pers32[0], $por32, $resp32, $pers33[0], $por33 );
                  
                 // $resposta = array($resp1, $resp2, $resp3, $resp4, $resp5, $resp6, $resp7, $resp8, $resp9, $resp10, $resp11, $resp12, $resp13, $resp14, $resp15, $resp16, $resp17, $resp18, //$resp19, $resp20, $resp21, $resp22, $resp23, $resp24, $resp25, $resp26, $resp27, $resp28, $resp29, $resp30, $resp31, $resp32);
                              
                  
               $analise = array();
               $analiseMenor = array();
                  
                  $i = 1;
                         while ($i < 92) {
                      
                      if ($result[$i] > 80) {
                          
                     $analise[$i] = round($result[$i])."% ".$result[$i-1].":".$result[$i+1];
                       
                          
                          $i = $i+3;
                         }
                       else {
                      
                    $analiseMenor[$i] = round($result[$i])."% ".$result[$i-1].":".$result[$i+1];
                
                     
                    $i = $i+3;
                     
                     }
                      
                  }
                  
                //  echo $result[19];
                 // echo $resposta[10];
                  
            
                  
                  rsort($analise);
                  sort($analiseMenor);
             // echo $analise[0]; 
             
             
             // var_dump($analiseMenor);
             
             
           //  $analise = explode(":", $analise);
            // $analiseMenor = explode(":", $analiseMenor);
             
             
             $maior1 = $analise[1];
             $maior2 = $analise[2];
             $maior3 = $analise[3];
             $maior4 = $analise[4];
             $maior5 = $analise[5];
             $maior6 = $analise[6];
             
             $menor1 = $analiseMenor[1];
             $menor2 = $analiseMenor[2];
             $menor3 = $analiseMenor[3];
             $menor4 = $analiseMenor[4];
             $menor5 = $analiseMenor[5];
             $menor6 = $analiseMenor[6];
             
             
             $maior1 = explode(":", $maior1);
             $maior2 = explode(":", $maior2);
             $maior3 = explode(":", $maior3);
             $maior4 = explode(":", $maior4);
             $maior5 = explode(":", $maior5);
             $maior6 = explode(":", $maior6);
             
             $menor1 = explode(":", $menor1);
             $menor2 = explode(":", $menor2);
             $menor3 = explode(":", $menor3);
             $menor4 = explode(":", $menor4);
             $menor5 = explode(":", $menor5);
             $menor6 = explode(":", $menor6);
             
             
             
           //  var_dump($analiseMenor);
             
              
             
      
                
$mail = new PHPMailer(true); 

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'send.one.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'analisecognitivadhl@artificialx.com.br';                 // SMTP username
$mail->Password = 'dhlATX123';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'analisecognitivadhl@artificialx.com.br';
$mail->FromName = 'Análise Cognitiva DHL';
$mail->addAddress('analista03rh.luandre@dhl.com', 'Análise Cognitiva DHL');     // Add a recipient
//$mail->addAddress('analista03rh.luandre@dhl.com');               // Name is optional  //analista03rh.luandre@dhl.com
$mail->addReplyTo('analisecognitivadhl@artificialx.com.br', 'Information');                        // andreluis.ferreira@dhl.com
$mail->addCC('joaomanenti@artificialx.com.br'); 
//$mail->addBCC('');
$mail->CharSet = 'UTF-8';

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('');         // Add attachments
//$mail->addAttachment('', '');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML



$mail->Subject = 'Análise Cognitiva DHL - '.$nome.' '.$sobrenome.' vaga de '.$vaga;
$mail->Body    = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <title>[SUBJECT]</title>
  <style type='text/css'>
  body {
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   padding-top: 0 !important;
   padding-bottom: 0 !important;
   margin:0 !important;
   width: 100% !important;
   -webkit-text-size-adjust: 100% !important;
   -ms-text-size-adjust: 100% !important;
   -webkit-font-smoothing: antialiased !important;
 }
 .tableContent img {
   border: 0 !important;
   display: block !important;
   outline: none !important;
 }
 a{
  color:#382F2E;
}

p, h1,h2,ul,ol,li,div{
  margin:0;
  padding:0;
}

h1,h2{
  font-weight: normal;
  background:transparent !important;
  border:none !important;
}

@media only screen and (max-width:480px)
		
{
		
table[class='MainContainer'], td[class='cell'] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class='specbundle'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:15px !important;
	}	
td[class='specbundle2'] 
	{
		width:80% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:10px !important;
		padding-left:10% !important;
		padding-right:10% !important;
	}
		
td[class='spechide'] 
	{
		display:none !important;
	}
	    img[class='banner'] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class='left_pad'] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		 
}
	
@media only screen and (max-width:540px) 

{
		
table[class='MainContainer'], td[class='cell'] 
	{
		width: 100% !important;
		height:auto !important; 
	}
td[class='specbundle'] 
	{
		width: 100% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:15px !important;
	}	
td[class='specbundle2'] 
	{
		width:80% !important;
		float:left !important;
		font-size:13px !important;
		line-height:17px !important;
		display:block !important;
		padding-bottom:10px !important;
		padding-left:10% !important;
		padding-right:10% !important;
	}
		
td[class='spechide'] 
	{
		display:none !important;
	}
	    img[class='banner'] 
	{
	          width: 100% !important;
	          height: auto !important;
	}
		td[class='left_pad'] 
	{
			padding-left:15px !important;
			padding-right:15px !important;
	}
		
}

.contentEditable h2.big,.contentEditable h1.big{
  font-size: 26px !important;
}

 .contentEditable h2.bigger,.contentEditable h1.bigger{
  font-size: 37px !important;
}

td,table{
  vertical-align: top;
}
td.middle{
  vertical-align: middle;
}

a.link1{
  font-size:13px;
  color:#27A1E5;
  line-height: 24px;
  text-decoration:none;
}
a{
  text-decoration: none;
}

.link2{
color:#ffffff;
border-top:10px solid #27A1E5;
border-bottom:10px solid #27A1E5;
border-left:18px solid #27A1E5;
border-right:18px solid #27A1E5;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
background:#27A1E5;
}

.link3{
color:#555555;
border:1px solid #cccccc;
padding:10px 18px;
border-radius:3px;
-moz-border-radius:3px;
-webkit-border-radius:3px;
background:#ffffff;
}

.link4{
color:#27A1E5;
line-height: 24px;
}

h2,h1{
line-height: 20px;
}
p{
  font-size: 14px;
  line-height: 21px;
  color:#000000;
}


.contentEditable li{
 
}

.appart p{
 
}
.bgItem{
background: #ffffff;
}
.bgBody{
background: #ffffff;
}

img { 
  outline:none; 
  text-decoration:none; 
  -ms-interpolation-mode: bicubic;
  width: auto;
  max-width: 100%; 
  clear: both; 
  display: block;
  float: none;
}

</style>


<script type='colorScheme' class='swatch active'>
{
    'name':'Default',
    'bgBody':'ffffff',
    'link':'27A1E5',
    'color':'AAAAAA',
    'bgItem':'ffffff',
    'title':'444444'
}
</script>


</head>
<body paddingwidth='0' paddingheight='0' bgcolor='#d1d3d4'  style='padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;' offset='0' toppadding='0' leftpadding='0'>
  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td><table width='600' border='0' cellspacing='0' cellpadding='0' align='center' bgcolor='#ffcd00' style='font-family:helvetica, sans-serif;' class='MainContainer'>
      <!-- =============== START HEADER =============== -->
  <tbody>
    <tr>
      <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td valign='top' width='20'>&nbsp;</td>
      <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td class='movableContentContainer'>
      <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='15'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td valign='top' width='100'><img src='https://logodownload.org/wp-content/uploads/2015/12/dhl-logo-2.png' alt='Logo' title='Logo' width='100' height='60' data-max-width='100'></td>
      <td width='10' valign='top'>&nbsp;</td>
      <td valign='middle' style='vertical-align: middle;'>
                          <div class='contentEditableContainer contentTextEditable'>
                            
                              <h2>Análise <b>Cognitiva</b> <b> $nome</b> $sobrenome </h2>
                            
                          </div>
                        </td>
    </tr>
  </tbody>
</table>
</td>
      <td valign='top' width='90' class='spechide'>&nbsp;</td>
      <td valign='middle' style='vertical-align: middle;' width='150'>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: right;'>
                             
                            </div>
                          </div>
                        </td>
    </tr>
  </tbody>
</table></td>
    </tr>
    <tr>
       <td height='15'></td>
    </tr>
    <tr>
       <td ><hr style='height:1px;background:#ba0c2f;border:none;'></td>
     </tr>
  </tbody>
</table>
	  </div>
      <!-- =============== END HEADER =============== -->
<!-- =============== START BODY =============== -->
      
      <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='40'></td>
    </tr>
    <tr>
      <td valign='top' width='580'><div class='contentEditableContainer contentImageEditable'>
                      <div class='contentEditable' style='text-align: center;'><img class='banner' src='https://www.polkupyöräkauppa.com/img/dhl_kuljetus.png' alt='Logo' title='Logo' width='580' height='221' border='0'></div></div></td>
    </tr>
  </tbody>
</table>

      
      
      </div>
	  
      <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
        <table width='100%' height ='50%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='40'></td>
    </tr>
    <tr>
	
	
<td style='background:#F6F6F6; border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td width='40' valign='top'>&nbsp;</td>
      <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
                      <tr><td height='25'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: center;'>
                              <h2 style='font-size: 20px;'>A Carta</h2>
                              <br>
                               <p>$textPTBR</p>
                              <br><br>
                              
                              <br>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr><td height='24'></td></tr>
                    </table></td>
      <td width='40' valign='top'>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
      
      <br>
      
      </div>
	  
	  
	  
         <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
        <table width='100%' height ='50%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='40'></td>
    </tr>
    <tr>
	
	
<td style='background:#F6F6F6; border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td width='40' valign='top'>&nbsp;</td>
      <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
                      <tr><td height='25'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: center;'>
                              <h2 style='font-size: 20px;'>Resumo de Personalidade</h2>
                              <br>
                                <p>$maior1[1]<p>$maior2[1]<p>$maior3[1]<p>$maior4[1]<p>$maior5[1]<p>$maior6[1]<p>
                              <p>$menor1[1]<p>$menor2[1]<p>$menor3[1]<p>$menor4[1]<p>$menor5[1]<p>$menor6[1]<p>
                              <br><br>
                              
                              <br>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr><td height='24'></td></tr>
                    </table></td>
      <td width='40' valign='top'>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
      
      <br>
      
      </div>
	






        <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
        <table width='100%' height ='50%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='40'></td>
    </tr>
    <tr>
	
	
<td style='background:#F6F6F6; border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td width='40' valign='top'>&nbsp;</td>
      <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
                      <tr><td height='15'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: left;'>
						
						       <img src='https://cdn2.iconfinder.com/data/icons/perfect-flat-icons-2/512/Create_with_plus_mail_layer_add_vector_stock.png' height='60' width='60'>
                              <h2 style='font-size: 20px;'><b>Características</b></h2>
							    <h2 style='font-size: 20px;'><b>mais</b> expressivas</h2>  

                              <br>
                              <p>$maior1[0]<p>$maior2[0]<p>$maior3[0]<p>$maior4[0]<p>$maior5[0]<p>$maior6[0]<p> 
                              </p>
                              <br><br>
                             
                              <br>
                            </div>
                          </div></td>
      <td valign='top' width='75' class='specbundle'>&nbsp;</td>
      <td class='specbundle'><div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: left;'>
							<img src='https://vignette.wikia.nocookie.net/eltigre/images/e/ee/Minus.png/revision/latest?cb=20170104184551' height='60' width='60'>
                              <h2 style='font-size: 20px;'><b>Características</b></h2>
							    <h2 style='font-size: 20px;'><b>menos</b> expressivas</h2>  
                              <br>
                              <p>$menor1[0]<p>$menor2[0]<p>$menor3[0]<p>$menor4[0]<p>$menor5[0]<p>$menor6[0]<p>
                              </p>
                              <br><br>
                              <br>
              
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table></td>
      <td width='20' class='spechide'>&nbsp;</td>
      <td class='specbundle' valign='top' width='142' align='center'><div class='contentEditableContainer contentImageEditable'>
                      <div class='contentEditable'>
                       
                      </div>
                    </div></td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
  
	

      
      <!-- =============== END BODY =============== -->
<!-- =============== START FOOTER =============== -->

      <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='48'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td valign='top' width='90' class='spechide'>&nbsp;</td>
      <td><table width='100%' cellpadding='0' cellspacing='0' align='center'>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: center;color:#AAAAAA;'>
                              <p>
                           <span class='float-none float-sm-right d-block mt-1 mt-sm-0 text-center'>Designed by <a href='http://artificialx.com.br/' target='_blank'>ARTIFICIALX</a> in Curitiba. <i class='mdi mdi-heart text-danger'></i></span>
                              </p>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table></td>
      <td valign='top' width='90' class='spechide'>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
      
      
      </div>
      <div class='movableContent' style='border: 0px; padding-top: 0px; position: relative;'>
      
      <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td height='40'></td>
    </tr>
    <tr>
      <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td valign='top' width='185' class='spechide'>&nbsp;</td>
      <td class='specbundle2'><table width='100%' cellpadding='0' cellspacing='0' align='center'>
                      <tr>
                        <td width='40'>
                          <div class='contentEditableContainer contentFacebookEditable'>
                            <div class='contentEditable' style='text-align: center;color:#AAAAAA;'>
                              <img src='https://cdn4.iconfinder.com/data/icons/social-media-icons-the-circle-set/48/facebook_circle-512.png' alt='facebook' width='40' height='40' data-max-width='40' data-customIcon='true' border='0' >
                            </div>
                          </div>
                        </td>
                        <td width='10'></td>
                        <td width='40'>
                          <div class='contentEditableContainer contentTwitterEditable'>
                            <div class='contentEditable' style='text-align: center;color:#AAAAAA;'>
                              <img src='https://cdn4.iconfinder.com/data/icons/social-media-icons-the-circle-set/48/twitter_circle-512.png' alt='twitter' width='40' height='40' data-max-width='40' data-customIcon='true' border='0'>
                            </div>
                          </div>
                        </td>
                        <td width='10'></td>
                        
                        <td width='10'></td>
                        <td width='40'>
                          <div class='contentEditableContainer contentImageEditable'>
                            <div class='contentEditable' style='text-align: center;color:#AAAAAA;'>
                              <img src='https://cdn4.iconfinder.com/data/icons/social-media-icons-the-circle-set/48/linkedin_circle-512.png' alt='Social media' width='40' height='40' data-max-width='40' border='0'>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table></td>
      <td valign='top' width='185' class='spechide'>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
    <tr>
    	<td height='40'></td>
    </tr>
  </tbody>
</table>

     <!-- =============== END FOOTER =============== --> 
      </div>
      </td>
    </tr>
  </tbody>
</table>
</td>
      <td valign='top' width='20'>&nbsp;</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
  </tbody>
</table>

<!--Default Zone

      <div class='customZone' data-type='image'>
          <div class='movableContent'>
              <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr><td height='40'></td></tr>
                <tr>
                  <td>
                    <div class='contentEditableContainer contentImageEditable'>
                      <div class='contentEditable' style='text-align: center;'>
                        <img src='images/bigImg.png' alt='Logo' width='580' height='221' data-default='placeholder' data-max-width='580'>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>  
            </div>
      </div>
      
      <div class='customZone' data-type='text'>
      <div class='movableContent'>
              <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr><td height='40'></td></tr>
                <tr>
                  <td style='border: 1px solid #EEEEEE; border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px'>
                    <table width='480' border='0' cellspacing='0' cellpadding='0' align='center'>
                      <tr><td height='25'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: center;color:#AAAAAA;'>
                              <h2 style='font-size: 20px;'>First Feature</h2>
                              <br>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.</p>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr><td height='24'></td></tr>
                    </table>
                  </td>
                </tr>
              </table>  
            </div>          
              </div>
      
      <div class='customZone' data-type='imageText'>
          <div class='movableContent'>
              <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr><td height='40' colspan='3'></td></tr>
                <tr>
                  <td width='150'>
                    <div class='contentEditableContainer contentImageEditable'>
                      <div class='contentEditable'>
                        <img src='images/side.png' alt='side image' width='142' height='142' data-default='placeholder' data-max-width='150'>
                      </div>
                    </div>
                  </td>
                  <td width='20'></td>
                  <td width='410'>
                    <table width='410' cellpadding='0' cellspacing='0' align='center'>
                      <tr><td height='15'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable'>
                              <h2 style='font-size:16px;'>Sub Feature 2</h2>
                              <br>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.</p>
                              <br>
                              <a target='_blank' href='#' class='link4'  >read more</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr><td height='40' colspan='3'></td></tr>
                <tr><td colspan='3'><hr style='height:1px;background:#DDDDDD;border:none;'></td></tr>
              </table>  
            </div>
      </div>
      
      <div class='customZone' data-type='Textimage'>
          <div class='movableContent'>
              <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr><td height='40' colspan='3'></td></tr>
                <tr>
                  <td width='410'>
                    <table width='410' cellpadding='0' cellspacing='0' align='center'>
                      <tr><td height='15'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable'>
                              <h2 style='font-size:16px;'>Sub Feature 2</h2>
                              <br>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.</p>
                              <br>
                              <a target='_blank' href='#' class='link4' >read more</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width='20'></td>
                  <td width='150'>
                    <div class='contentEditableContainer contentImageEditable'>
                      <div class='contentEditable'>
                        <img src='images/side2.png' alt='side image' width='142' height='142' data-default='placeholder' data-max-width='150'>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr><td height='40' colspan='3'></td></tr>
                <tr><td colspan='3'><hr style='height:1px;background:#DDDDDD;border:none;'></td></tr>
              </table>  
            </div>
      </div>

      <div class='customZone' data-type='textText'>
          <div class='movableContent'>
              <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr><td height='40' colspan='3'></td></tr>
                <tr>
                  <td width='252'>
                    <table width='252' border='0' cellpadding='0' cellspacing='0' align='center'>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: left;'>
                              <h2 style='font-size: 20px;'>Subtitle</h2>
                              <br>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.
                              </p>
                              <br><br>
                              <a target='_blank' href='#' class='link2'>Call to action</a>
                              <br>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width='75'></td>
                  <td width='252'>
                    <table width='252' border='0' cellpadding='0' cellspacing='0' align='center'>
                      <tr>
                        <td>
                           <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: left;'>
                              <h2 style='font-size: 20px;'>Subtitle</h2>
                              <br>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.
                              </p>
                              <br><br>
                              <a target='_blank' href='#' class='link2'>Call to action</a>
                              <br>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>  
            </div>
      </div>

      <div class='customZone' data-type='qrcode'>
          <div class='movableContent'>
              <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr><td height='40' colspan='3'></td></tr>
                <tr>
                  <td width='75' valign='middle' style='vertical-align:middle;'>
                    <div class='contentEditableContainer contentQrcodeEditable'>
                      <div class='contentEditable' style='text-align:center;'>
                        <img src='/applications/Mail_Interface/3_3/modules/User_Interface/core/v31_campaigns/images/neweditor/default/qr_code.png' width='75' height='75'>
                      </div>
                    </div>
                  </td>
                  <td width='20'></td>
                  <td width='485'>
                    <table width='485' cellpadding='0' cellspacing='0' align='center'>
                      <tr><td height='15'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable'>
                              <h2 style='font-size:16px;'>Sub Feature 1</h2>
                              <br>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.</p>
                              <br>
                              <a target='_blank' href='#' class='link4'  >read more</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr><td height='40' colspan='3'></td></tr>
                <tr><td colspan='3'><hr style='height:1px;background:#DDDDDD;border:none;'></td></tr>
              </table>  
            </div>
      </div>
      
      <div class='customZone' data-type='gmap'>
          <div class='movableContent'>
              <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                <tr><td height='40' colspan='3'></td></tr>
                <tr>
                  <td width='250' valign='middle' style='vertical-align:middle;'>
                    <div class='contentEditableContainer contentGmapEditable'>
                      <div class='contentEditable' >
                        <img src='/applications/Mail_Interface/3_3/modules/User_Interface/core/v31_campaigns/images/neweditor/default/gmap_example.png' width='150' height='150' data-default='placeholder'>
                      </div>
                    </div>
                  </td>
                  <td width='20'></td>
                  <td width='310'>
                    <table width='310' cellpadding='0' cellspacing='0' align='center'>
                      <tr><td height='15'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable'>
                              <h2 style='font-size:16px;'>Sub Feature 3</h2>
                              <br>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.</p>
                              <br>
                              <a target='_blank' href='#' class='link4'  >read more</a>
                            </div>
                          </div>
                        </td>

                      </tr>
                    </table>
                  </td>
                </tr>
                <tr><td height='40' colspan='3'></td></tr>
                <tr><td colspan='3'><hr style='height:1px;background:#DDDDDD;border:none;'></td></tr>
              </table>  
            </div>
      </div>

      <div class='customZone' data-type='social'>
          <div class='movableContent'>
              <div >
                  <table width='600' cellpadding='0' cellspacing='0' border='0' >
                    <tr>
                    <td height='42' colspan='4'>&nbsp;</td>
              </tr>
                      <tr>
                          <td valign='top' colspan='4' style='padding:0 20px;'>
                              <div class='contentTextEditable contentEditableContainer'>
                                  <div style='text-align:center;' class='contentEditable'>
                                      <h2 class='big'>This is a subtitle</h2>
                                  </div>
                              </div>
                          </td>
                      </tr>
                      <tr><td height='30'></td></tr>
                      <tr>
                          <td width='62' valign='top' valign='top' width='62' style='padding:0 0 0 20px;'>
                              <div class='contentEditableContainer contentTwitterEditable'>
                                  <div class='contentEditable'>
                                      <img src='/applications/Mail_Interface/3_3/modules/User_Interface/core/v31_campaigns/images/neweditor/default/icon_twitter.png' width='42' height='42' data-customIcon='true' data-noText='false' data-max-width='42'>
                                  </div>
                              </div>
                          </td>
                          <td width='216' valign='top' >
                              <div class='contentEditableContainer contentTextEditable'>
                                  <div  class='contentEditable'>
                                      <p >Follow us on Twitter to stay up to date with company news and other information.</p>
                                  </div>
                              </div>
                          </td>
                          <td width='62' valign='top' valign='top' width='62'>
                              <div class='contentEditableContainer contentFacebookEditable'>
                                  <div class='contentEditable'>
                                      <img src='/applications/Mail_Interface/3_3/modules/User_Interface/core/v31_campaigns/images/neweditor/default/icon_facebook.png' width='42' height='42' data-customIcon='true' data-noText='false' data-max-width='42'>
                                  </div>
                              </div>
                          </td>
                          <td width='216' valign='top' style='padding:0 20px 0 0;'>
                              <div class='contentEditableContainer contentTextEditable'>
                                  <div  class='contentEditable'>
                                      <p >Like us on Facebook to keep up with our news, updates and other discussions.</p>
                                  </div>
                              </div>
                          </td>
                      </tr>
                  </table>
              </div>
          </div>
      </div>

      <div class='customZone' data-type='twitter'>
          <div class='movableContent'>
              <div '>
                  <table cellpadding='0' cellspacing='0' border='0'>
                    <tr>
                    <td height='42'>&nbsp;</td>
                    <td height='42'>&nbsp;</td>
              </tr>
                      <tr>
                          <td valign='top' valign='top' width='62' style='padding:0 0 0 20px;'>
                              <div class='contentEditableContainer contentTwitterEditable'>
                                  <div class='contentEditable'>
                                      <img src='/applications/Mail_Interface/3_3/modules/User_Interface/core/v31_campaigns/images/neweditor/default/icon_twitter.png' width='42' height='42' data-customIcon='true' data-noText='false' data-max-width='42'>
                                  </div>
                              </div>
                          </td>
                          <td valign='top' style='padding:0 20px 0 0;'>
                              <div class='contentEditableContainer contentTextEditable'>
                                  <div  class='contentEditable'>
                                      <p >Follow us on Twitter to stay up to date with company news and other information.</p>
                                  </div>
                              </div>
                          </td>
                      </tr>
                  </table>
              </div>
          </div>
      </div>
      
      <div class='customZone' data-type='facebook'>
          <div class='movableContent'>
              <div >
                  <table cellpadding='0' cellspacing='0' border='0'>
                    <tr>
                    <td height='42'>&nbsp;</td>
                    <td height='42'>&nbsp;</td>
              </tr>
                      <tr>
                          <td valign='top' valign='top' width='62' style='padding:0 0 0 20px;'>
                              <div class='contentEditableContainer contentFacebookEditable'>
                                  <div class='contentEditable'>
                                      <img src='/applications/Mail_Interface/3_3/modules/User_Interface/core/v31_campaigns/images/neweditor/default/icon_facebook.png' width='42' height='42' data-customIcon='true' data-noText='false' data-max-width='42'>
                                  </div>
                              </div>
                          </td>
                          <td valign='top' style='padding:0 20px 0 0;'>
                              <div class='contentEditableContainer contentTextEditable'>
                                  <div  class='contentEditable'>
                                      <p >'Like us on Facebook to keep up with our news, updates and other discussions.</p>
                                  </div>
                              </div>
                          </td>
                      </tr>
                  </table>
              </div>
          </div>
      </div>

      <div class='customZone' data-type='line'>
          <div class='movableContent'>
                <table width='580' border='0' cellspacing='0' cellpadding='0' align='center'>
                  <tr><td height='40'></td></tr>
                  <tr><td height='1' bgcolor='#DDDDDD'></td></tr>
                </table>
              </div>
      </div>


      <div class='customZone' data-type='colums1v2'><div class='movableContent'>
                          <table width='580' border='0' cellspacing='0' cellpadding='0' align='center' >
                            <tr><td height='40'></td></tr>
                            <tr>
                              <td align='left' valign='top' class='newcontent'>
                                
                              </td>
                            </tr>
                          </table>
                    </div>
      </div>

      <div class='customZone' data-type='colums2v2'><div class='movableContent'>
                      <table width='580' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                        <tr><td colspan='3' height='40'></td></tr>
                        <tr>
                          <td width='280'  valign='top' class='newcontent'>
                            
                          </td>

                          <td width='20'></td>
                          
                          <td width='280' valign='top' class='newcontent'>
                            
                          </td>
                        </tr>
                      </table>
                    </div>
      </div>

      <div class='customZone' data-type='colums3v2'><div class='movableContent'>
                      <table width='600' border='0' cellspacing='0' cellpadding='0' align='center' valign='top'>
                        <tr><td colspan='5' height='40'></td></tr>
                        <tr>
                          <td width='186'  valign='top' class='newcontent'>
                            
                          </td>

                          <td width='10'></td>
                          
                          <td width='187'  valign='top' class='newcontent'>
                            
                          </td>

                          <td width='10'></td>
                          
                          <td width='186'  valign='top' class='newcontent'>
                            
                          </td>
                        </tr>
                      </table>
                    </div>
      </div>

      <div class='customZone' data-type='textv2'>
              
        <div class='contentEditableContainer contentTextEditable'>
          <div class='contentEditable' style='text-align: center;'>
            <h2 style='font-size: 20px;'>First Feature</h2>
            <br>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Has been the industry's standard dummy text ever since the 1500s.</p>
          </div>
        </div>
                        
      </div>





    -->
    <!--Default Zone End-->

  </body>
  </html>;
  
$mail->AltBody";

  



if(!$mail->send()) {
    echo '*******######## Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo "<script>alert('Suas respostas foram enviadas com sucesso! Já pode fechar a janela :D'); window.close();</script>";

  
}

               
                  
                  
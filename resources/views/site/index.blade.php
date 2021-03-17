<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body class="antialiased">
        <?php
                    /*
                        //Uma organização recebe o bloco 211.17.180.0/24. O administrador quer criar 30 sub-redes. (5 bits)
            a) Encontre a máscara de sub-rede em notação barra (/n)
            b) Encontre o primeiro e o último endereços na primeira sub-rede 

                    */

            $ip = '211.17.180.0/24';
            $quantidadeSubRede = 30;
            $quantidadeBitsDaSubRede = encontrarQuantideBits($quantidadeSubRede);//5
            $splitando =  explode('/', $ip);
            $quantidadeRede = $splitando[1];//24
            $ipBinario = converterBinario($splitando[0]);
            $quantidadeDeBitsHost = 32 - $quantidadeRede - $quantidadeBitsDaSubRede;//3




            $mascara= criarMascara($quantidadeRede);
            $binario = "";
            $splitando = explode('.', $splitando[0]);
            foreach ($splitando as $key => $value) {
               $binario .=  str_pad((string) decbin((int)$value), 8, '0', STR_PAD_LEFT);
            }


            $mascaraSubRede = criarMascarSubRede($quantidadeBitsDaSubRede, $mascara);
              //echo $ipBinario."<br>";



        // echo colocarPonto($mascara)."<br>";

        // echo "<br>";

        //   juntarMascara($mascaraSubRede,juntarMascara($mascara,$ipBinario));


         $intervalos = intervaloRede(ipBase($mascara,$ipBinario),'31',$quantidadeBitsDaSubRede,$quantidadeDeBitsHost);

        echo colocarPonto($intervalos[0])."<br>";
        echo colocarPonto($intervalos[1]);
             //echo (converterDecimal(colocarPonto($mascara)));

             

            //echo  converterDecimal(colocarPonto(converterBinario($ipBinario)));
            //$binarioMascara = converbINARIO($mascara, $binario);
            // //
            //  echo "<br>";
            // $mascaraSubRede = colocarPonto(juntarMascara($mascaraSubRede,$ipBinario));//
            // echo "<br>";

        
              
            
         function juntarMascara(string $mascara, string $ip) 
          {
                $dividirMascar = str_split($mascara);
                $dividirIp = str_split($ip);
                $i = 0;
                $valoresBinario = "";
                foreach ($dividirMascar as $key => $value) {
                        if(($value == '1') and ($dividirIp[$i] =='1')){
                            $valoresBinario .= "1";
                            echo "1";
                        }
                        elseif($value == 0) {
                            $valoresBinario .= '0';
                            echo "<span style='color: rgb(0, 17, 255)' >0</span>";
                        }
                        else {
                            $valoresBinario .= "0";
                            echo "0";
                        }
                    $i++;
                } 
                echo "<br>";
                return $valoresBinario;
          }
          function ipBase(string $mascara, string $ip) {
                $dividirMascar = str_split($mascara);
                $dividirIp = str_split($ip);
                $i = 0;
                $valoresBinario = "";
                foreach ($dividirMascar as $key => $value) {
                        if(($value == '1') and ($dividirIp[$i] =='1')){
                            $valoresBinario .= "1";
                        }
                        elseif($value == 0) {
                            
                        }
                        else {
                            $valoresBinario .= "0";
                        }
                    $i++;
                } 
                echo "<br>";
                return $valoresBinario;
          }
          function intervaloRede($ipBase, $subRede, $quantidadeSubRede, $quantidadeBitsHost) {
                $binarioSubRede =  str_pad(decbin($subRede), $quantidadeSubRede, '0', STR_PAD_LEFT);
                $ultimoHost=  pow(2,$quantidadeBitsHost) -2;
                $binarioPrimeiroHost = str_pad('1',$quantidadeBitsHost,'0', STR_PAD_LEFT);
                $binarioUltimoHost = str_pad(decbin($ultimoHost),$quantidadeBitsHost,'0', STR_PAD_LEFT);

                return [$ipBase.$binarioSubRede.$binarioPrimeiroHost,$ipBase.$binarioSubRede.$binarioUltimoHost];
          }


          function encontrarQuantideBits($quantideSubRede) {
              $valorPotencia = 0;
              //echo pow(2,$valorPotencia);
              while (pow(2,$valorPotencia) <= $quantideSubRede) {
                  $valorPotencia++;
              }
              return  $valorPotencia;
          }

          function criarMascara($quantidadeMascara) {
             
            return str_pad('1', $quantidadeMascara, '1', STR_PAD_LEFT).str_pad('0', 32 - $quantidadeMascara, '0', STR_PAD_LEFT);
          }

          function criarMascarSubRede($quantidadeDeBitSubR, $mascara) {
             
            // return str_pad(str_replace("0",str_pad('1', $quantidadeDeBitSubR, '1', STR_PAD_RIGHT), $mascara), 32, '0', STR_PAD_RIGHT);
            return str_pad(str_replace("0",'', $mascara).str_pad('1', $quantidadeDeBitSubR, '1', STR_PAD_RIGHT), strlen($mascara), '0', STR_PAD_RIGHT);
        }
          function colocarPonto($valor) {
              $valor = str_split($valor,8);
              return implode(".",$valor);
          }

          function converterDecimal($valor) {
              $decimalValores = array();
              $binariosValores = explode('.',$valor);
              foreach ($binariosValores as $key => $binario) {
                $decimalValores[] =  bindec($binario);//== 0? $binario : bindec($binario); 
              }
              return implode('.',$decimalValores);
          }

          function converterBinario($valor) {
              $binarioValores = array();
              $decimalValores = explode('.',$valor);
              foreach ($decimalValores as $key => $decimal) {
                $binarioValores[] =  str_pad(decbin($decimal),8, '0', STR_PAD_LEFT);
              }
              return implode('',$binarioValores);
          }

            
        ?>
    </body>
</html>

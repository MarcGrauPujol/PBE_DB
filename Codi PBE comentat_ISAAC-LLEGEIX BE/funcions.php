 <?php
function parsing($link, $table, $str) {
  $limit="";
  date_default_timezone_set("Europe/Madrid");
  #Instrucció que s'acabarà enviant a la base de dades
  $sql="SELECT * FROM $table WHERE ";
  #Separa segons el delimitador
  $pairs = explode('&', $str);
  #MIREM TOTS ELS ARGUMENTS D'ENTRADA I DEPENENT DAQUETS APLIQUEM UNA ACCIO O UNA ALTRE
  for($i=0; $i<count($pairs); ++$i) {
    
    list($name,$value) = explode('=', $pairs[$i], 2);
    
    #COMPROVEM SI EXISTEIX limit
    if(strpos($name, 'limit')!==false){
        $limit=" LIMIT ".$value;
    }
    
    else{
        
        #Paraula reservada now
        #Filtro per el dia d'avui
        if($value==="now" && strpos($name, 'day')!==false){ #Tenim now a value i no tenim dia
            #La funcio date('N') retorna el int del dia de la setmana
            switch (date('N')) {
              case '1':
                $value="Mon";
                break;
              case '2':
                $value="Tue";
                break;
              case '3':
                $value="Wed";
                break;
              case '4':
                $value="Thu";
                break;
              case '5':
                $value="Fri";
                break;
              case '6':
                $value="Sun";
                break;
              case '7':
                $value="Sat";
                break;
            }
        }
        #Filtro per la data d'avui
        elseif ($value==="now" && strpos($name, 'date')!==false) {
            $value=date('Y-m-d');
        }
        #Filtro per el dia d'avui
        elseif ($value==="now" && strpos($name, 'hour')!==false) {
            $value=date('G:i');
        }

        #Concatenem el AND
        if($i!==0){
            $sql = $sql." AND ";
        }

        #Comprovem si te caracters especials i els substituim per ''
        if(strpos($name, '[')!==false){
            $sql = $sql . $name."'".$value."'";
        }

        #Sino els te uttilitzem l'estructua name='value'
        else{
            $sql = $sql . $name."='".$value."'";
        }
    }
  }
  #Sortim del for
  
  #Substituim els caracters especials
  $sql=str_replace(array("[lt]","[lte]","[gt]","[gte]"),array("<","<=",">",">="),$sql);

  #CREEM LES SENTENCIES ORDER EN FUNCIÓ DE LA TAULA A MOSTRAR
  if($table==="timetables"){
    $days_const=array("Mon","Tue","Wed","Thu","Fri","Sun","Sat"); $hour_now=date('G:i');
    
    //POSEM A 0 TOTES LES CONSTANTS PASSED 
    //Netejem tot el que podriem haver tocat abans
    mysqli_query($link, "UPDATE timetables SET passed='0'");
    
    //POSEM A 1 EL FLAG PASSED A LES CLASES QUE JA HEM FET
    for($i=0; $i<date('w'); ++$i){
      mysqli_query($link, "UPDATE timetables SET passed='1' WHERE day='$days_const[$i]' AND hour<='$hour_now'");
    }
    
    //ORDENEM LA CONSULTA DE LA MANERA QUE ES DEMANA
    //I afegim limit al final
    //Ordena per pasat de manera ascendent i la hora
    //Pensa al reves el primer es l'ultim
    $sql=$sql." ORDER BY passed ASC, day='Sun', day='Sat', day='Fri', day='Thu', day='Wed', day='Tue', day='Mon', hour ASC".$limit;
  }

  elseif ($table==="marks") {
    //Ordenem per assigntatura i dintre de lassignatura ordenem les notes de mes baixa a mes alta
    $sql = $sql . " ORDER BY subject, mark DESC".$limit;
  }
  
  elseif ($table==="tasks") {
    //Ordenem per data de manera ascendent
    $sql = $sql . " ORDER BY date ASC".$limit;
  }
  
  return $sql;
}

function timetables($link,$sql){
    //DECLAREM CONSTANTS
    $day = array(); $hour = array(); $subject = array(); $room = array();
    //Si la cerca és correcte
    //Quan invoquem mysqli_query($link, $sql) bloquejem taula
    if($result = mysqli_query($link, $sql)){
          //Si tenim més de 0 files
          if(mysqli_num_rows($result) > 0){
              //While escombrant totes les files 
              while($row = mysqli_fetch_array($result)){
                $day[] = $row["dia"];
                $hour[] = $row["hora"];
                $subject[] = $row["assignatura"];
                $room[] = $row["aula"];
              }
              //Fas un array amb tots els arrays, alias crees la matriu 
              $res = array($day, $hour, $subject, $room);
              //Traduim en json i enviem
              echo json_encode($res);
              //Desbloquejem la taula 
              mysqli_free_result($result);
          } else {//No trobem taula
              echo "No records matching your query were found.";
          }
      //Si la cerca és incorrecte
      } else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
    // Close connection
    mysqli_close($link);
}

function marks($link,$sql){
    $subject = array(); $name = array(); $mark=array();
    if($result = mysqli_query($link, $sql)){
          if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_array($result)){
                $subject[] = $row["assignatura"];
                $name[] = $row["nom"];
                $mark[] = $row["nota"];
              }
              $res = array($subject, $name, $mark);
              echo json_encode($res);
              // Free result set
              mysqli_free_result($result);
          } else{
              echo "No records matching your query were found.";
          }
      } else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
    // Close connection
    mysqli_close($link);
}

function tasks($link,$sql){
    $date = array(); $subject = array(); $name=array();
    if($result = mysqli_query($link, $sql)){
          if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_array($result)){
                $date[] = $row["data"];
                $subject[] = $row["assignatura"];
                $name[] = $row["nom"];
              }
              $res = array($date, $subject, $name);
              echo json_encode($res);
              // Free result set
              mysqli_free_result($result);
          } else{
              echo "No records matching your query were found.";
          }
      } else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
    // Close connection
    mysqli_close($link);
}

function students($link,$sql){
    $name = array();
    if($result = mysqli_query($link, $sql)){
          if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_array($result)){
                $name[] = $row["nom"];
              }
              $res = array($name);
              echo json_encode($res);
              // Free result set
              mysqli_free_result($result);
          } else{
              echo "No records matching your query were found.";
          }
      } else{
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
    // Close connection
    mysqli_close($link);
}
?>

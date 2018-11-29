<div class = "modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<center><h3 class = ""> <i class = "glyphicon glyphicon-envelope"> </i> Enviar Correo</h3></center>
</div>
    <form class="form-inline">
      <?php

        //275:7:001-355::Aprobado  //formato de como optiene el capo 
        list($Id, $TipoDocu, $Numero, $Estado) = explode(':', $SqlOcurrencias->DocOrigen);
        
        
        $IdDocx = $ObjeOcurrencia->encryptx($Id, 'Greed');
        $Tipodoc = $ObjeOcurrencia->encryptx($TipoDocu, 'Greed');
        $org= $_SESSION['CodigoOrganizacion']; 
        $orgx=$ObjeOcurrencia->encryptx($org, 'Greed');


        //verificamos que sea un documento 
        if ($SqlOcurrencias->Origen=='' || $SqlOcurrencias->Origen==null) { 
            $concatenar_mensaje='';
        }
        else{
          if ($TipoDocu==1 or $TipoDocu==3) {$concatenar_mensaje='<br>Url Documeto '.$ObjeOcurrencia->docuemto_electronico($TipoDocu,$Id);}
          else {$concatenar_mensaje='<br>Url Documeto '."http://".$_SERVER['HTTP_HOST']."/erpx/p/"."?d=".$Tipodoc."and".urlencode($IdDocx)."andsky".$orgx;}
          
        }

$ocurrencia=utf8_encode($SqlOcurrencias->comentario);
$pa_asunto=$ed[1].':'.substr($ocurrencia,0,20);

        if ($ed[3]==$ed[2]) 
        {
            $c1=$ed[3];
            $c2='';  
            $reo=$c1;
        }
        else
        {
            $c1=$ed[3];
            $c2=$ed[2];  
            $reo=$c1.','.$c2;
            if ($ed[3]=='') {$reo=$ed[2];}
            if ($ed[2]=='') {$reo=$ed[3];}
        }

 ?>
 

    <div class="modal-body">
          Destinatario <input type="" name=""  class="form-control" id="correos<?php echo $IdOcurrencia;?>" value="<?php echo $reo; ?>"  ><br>
          Asunto <textarea class="form-control" id="asunto<?php echo $IdOcurrencia; ?>" ><?php echo $pa_asunto;?></textarea> <br>
          Mensaje
<textarea name="content"  id="cuerpocorreo<?php echo $IdOcurrencia; ?>" class="form-control" style="height: 100px" >
---------------------------<br>
<?php 
$datem= date_create($res['2']);
echo date_format($datem, 'd-m-y H:i')."\n";?>
<?php echo $ocurrencia.$concatenar_mensaje; ?>
</textarea>
   
        <input type="text" value="<?php echo $bd ?>" id="ulastname<?php echo $IdOcurrencia;?>" class="form-control" style="visibility: hidden; width: 0px;height: 0px;">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal"><span class = "close_modal glyphicon glyphicon-remove"></span> </button> | 
      <button type="button" class="enviar btn btn-success" value="" onclick="GuardarCorreo(<?=$IdOcurrencia?>,<?=$IdCLiente?>);"><span class = "glyphicon glyphicon-envelope"></span> </button>
    </div>
    </form>
 
    <input id="correo1<?php echo $IdOcurrencia ; ?>"  class="form-control" value="<?php echo $c1 ;?>" style='visibility: hidden; width: 0px;height: 0px;'>
    <input id="correo2<?php echo  $IdOcurrencia; ?>"  class="form-control" value="<?php echo $c2 ;?>" style='visibility: hidden; width: 0px;height: 0px;'>

<script>
    ClassicEditor
        .create( document.querySelector( '#cuerpocorreo<?php echo $IdOcurrencia; ?>' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<?php 



//header("Access-Control-Allow-Origin: * ");


      


?>
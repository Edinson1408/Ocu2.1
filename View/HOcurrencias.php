<?php

// if (isset($_POST['edit'])) {
//   ?>
<!--<script type="text/javascript">
//   alert('hola');
// </script>-->
  <?php
// }

// // session_start();
// // unset($_SESSION['returnpage']);
// // if (!isset($_SESSION["IdMiEmpresaPrincipal"]) or !isset($_SESSION['IdUsuario']) or !isset($_SESSION['bd'])) {
// //   $_SESSION['returnpage'] ='Ocurrencias2.0/ocurrencias.php?IdC='.$_GET['IdC'];
// //   header('location:../../../');
// // }

// $baseXD=$_SESSION['bd'];

// $Id_cliente=$_GET['IdC'];

// include 'api/general.php';

// $Obj_Ocu= new Datos;

// $arr=$Obj_Ocu->dato_name($Id_cliente);
// foreach ($arr as $key) 
//     {
//         $img=$key['1'];
//         $nombre=$key['3'];
//     }


?>

<!------ Include the above in your HEAD tag ---------->
<!--<link rel="stylesheet" type="text/css" href="includes/style.css">-->


      <div class="row heading" id="verde">
        <div class="col-sm-2 col-md-2 col-xs-2 heading-avatar">
          <div class="heading-avatar-icon">
            <a onclick="CambiarVistas('app1',0)" class="heading-name-met" style="color:white;font-weight: 900;">
                <i class="material-icons" aria-hidden="true" style="font-size: 20px;margin-top: 10px;">reply_all</i>
                <!--<i class="fa fa-arrow-left" aria-hidden="true" style="font-size: 20px;margin-top: 10px;"></i>-->
                    </a>
                    <?php
                    if($codOrganizacion!='')
                    {
                            $img1="../../Preferencias/$codOrganizacion/1/Imagenes/Logo.jpg";
                            if (file_exists($img1)){$img= "<img src='$img1'>";}
                            else{$img=  "<img src='Public/Img/sinlogo.jpg'>";}
                    }   
                    else {$img=  "<img src='Public/Img/sinlogo.jpg'>";}
               


                    ?>
                   
            
          </div>
        </div>
        <div class="col-sm-8 col-xs-8 heading-name" style="overflow: hidden;" >
         <p class="heading-name-meta" style="font-size: 25px;font-weight:80;"><?php echo utf8_encode($NombreCliente);?>
          </p>
        </div>

     <div class="col-sm-2 col-md-2 col-xs-2 heading-avatar" style="float: right;" >
          <div class="heading-avatar-icon" style="float: right;">
             
                              <a class="dropdown-toggle"   data-toggle="dropdown" style="float: right;" ><?php echo $img; ?></a>
                                  <ul class="dropdown-menu dropdown-menu-right"  style="position: absolute; transform: translate3d(-102px, 50px, 0px); top: 0px; left: 0px; will-change: transform;">
                                      <li><a onclick="EstadoCliente(<?=$IdCliente?>)"  data-toggle="modal" data-target="#ModalEstado" ><i class="glyphicon glyphicon-bookmark">
                                          
                                      </i> Estado </a></li>
                                      
                                       <li><a class="" onclick="Encuestar('<?php echo $IdCliente?>','<?php echo urldecode(utf8_decode($nombre));?>')"><i class="glyphicon glyphicon-signal"></i> Encuestas</a></li>
                                      <li><a href="../c_socio_negocio/#!/detail/<?php echo $IdCliente;?>" target="_blank"><i class="glyphicon glyphicon-user"></i> Datos Socio </a></li>
                                       <hr style="    margin-top: 0px;margin-bottom: 0px;border-top: 1px solid #075e54;">
                                      <li onclick="CambiaVendedor(<?php echo $IdCliente; ?>)" data-toggle="modal" data-target="#ModalEditVendedor"><center><?php 
                                             //$VendedorAsi=$Obj_Ocu->ObtVendedorAsig($Id_cliente,$base);
                                            //echo  ($VendedorAsi=='')?'Sin Vendedor' : $VendedorAsi;
                                      ?></center></li>
                     
                                  </ul>

          </div>  
                             
         
        </div>
      </div>

      <div class="row message" id="conversation">
                
      </div>





      <div class="row reply">
         <div class="col-sm-1 col-xs-1 reply-recording">
          <!--<i class="fa fa-microphone fa-2x" aria-hidden="true"></i>-->
          <input type="hidden" value='0' id='IdAccionhidden'>
           <span onclick="ModalAccion(<?php echo $Id_cliente;?>)" data-toggle="modal" data-target="#ModalAcciones" style="font-size:22px;text-align: center;cursor: pointer;">
              <i class="material-icons" id='IconAcccion'  >
                reorder
                </i>
            </span>
          
        </div>
        <div class="col-sm-10 col-xs-10 reply-main">
          <textarea class="form-control" rows="1" id="comment" autofocus="autofocus"></textarea>
           <textarea  id="base" style="visibility: hidden;"><?php echo $IdCliente;?></textarea>
        </div>
        <div class="col-sm-1 col-xs-1 ">
          <!--<i class="fa fa-microphone fa-2x" aria-hidden="true"></i>-->
        </div>
        <div class="col-sm-1 col-xs-1 reply-send">
        <!--<i class="fa fa-send fa-2x" aria-hidden="true" id="addnew" onclick="GuardarOcurrencia(<?php echo $IdCliente;?>);"></i>-->
        <i class="material-icons" aria-hidden="true" id="addnew" onclick="GuardarOcurrencia(<?php echo $IdCliente;?>);" >send</i>
        </div>
      </div>
    </div>
  </div>
</div>



            <div class="modal " id="modal-versiones">
            <div class="modal-dialog modal-lg" role="document" style="width: 50%;" >
            <div class="modal-content" style="height:auto;overflow-y: auto">
                    <div class="modal-header modal-cabecera">
                    </div>
                <div class="modal-body">
                    <div id="listFlotante"></div>
                </div>
            </div>
            </div>
            </div>
            
            
            

        <div class="modal " id="modal-calendario">
            <div class="modal-dialog modal-lg" role="document" style="width: 90%;" >
            <div class="modal-content" style="height:auto;overflow-y: auto">
                    <div class="modal-header modal-cabecera">
                    </div>
                <div class="modal-body">
                    <div id="listFlotante-cal"></div>
                </div>
            </div>
            </div>
            </div>
            
            
            
 
  <div class="modal fade" id="ModalEditVendedor" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="CambiarVendedorModal">
                
        </div>
      
      </div>
    </div>
  </div>
             
            
            
            
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
            

 

  
  
<script>
      
{
    "use strict";
    let start_page_HO = 0;
    //let scrol2=$('.message::-webkit-scrollbar-track');

    const scope_HO = $("#conversation");
    this.load_OH = function(start) {
        $.get("Load/LoadOcurrenciasH.php?getOcurrenciasH", { start: start ,e :"<?php echo $IdCliente ?>"}, function(response) {
            scope_HO.append(response);
            start_page_HO += 15;
        });
    };
    const win = $('.message');
    win.scroll(() => {
      console.log({scrollHeight:win.prop("scrollHeight"),scrollTop:win.prop("scrollTop"),winheight:win.height()})

        if (win.prop("scrollHeight")-win.prop("scrollTop") == win.height()) {
           this.load_OH(start_page_HO);
        }
      
         
    });
    this.load_OH();
}




</script>


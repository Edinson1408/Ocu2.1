<?php 

session_start();
unset($_SESSION['returnpage']);
if (!isset($_SESSION["IdMiEmpresaPrincipal"]) or !isset($_SESSION['IdUsuario']) or !isset($_SESSION['bd'])) {
    $_SESSION['returnpage'] = 'Ocurrencias2.1/';
    header('location:../../../');
}
  
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ocurrencias 2.1</title>
	<meta name="theme-color" content="#005e54" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    
    <!--moonicon  Creo que ya no lo utlizaremos -->
    <!--<link rel="stylesheet" type="text/css" href="icon/style.css">-->
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="Public/MyStyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="Public/Img/icon.png">
    <link rel="stylesheet" type="text/css" href="https://csshake.surge.sh/csshake.min.css">
    
    
    <!--Mi propios js -->
    <script src="Public/TemplateOcurrencia.js"></script>
    <script src="Public/TemplateBandeja.js"></script>
    
    <style>
        @media only screen and (max-width: 700px) {
                #verde {
                    background: #005e54;
                }
                
                .newMessage-heading {
                padding: 10px 16px 10px 15px !important;
                margin: 0 !important;
                height: 90px;
                width: 100%;
                background-color: #005e54;
                z-index: 1001;
                 }
            }
            
            
        .tooltip2 {
            position: relative;
            display: inline-block;
            
        }
        
        .tooltip2 .tooltiptext2 {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .tooltip2 .tooltiptext2::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }
        
        .tooltip2:hover .tooltiptext2 {
            visibility: visible;
            opacity: 1;
        }
            .zoomIt{
            display:block!important;
            -webkit-transition:-webkit-transform 0.8s ease-out;
            -moz-transition:-moz-transform 0.8s ease-out;
            -o-transition:-o-transform 0.8s ease-out;
            -ms-transition:-ms-transform 0.8s ease-out;
            transition:transform 0.8s ease-out;
            }
            .zoomIt:hover{
            -moz-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            -o-transform: scale(1.1);
            -ms-transform: scale(1.1);
            transform: scale(1.1)
            }
            
    
    </style>
    
</head>
<body>
    
<!--Ocurrencias-->
    <div class="container app" id='app1'>
        <div class="row app-one">
            <div class="col-sm-12 side">
            <div class="side-one">
                <div class="row heading" id="verde">
                    <div class="col-sm-3 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                      <a href="index.php" ><img src="Public/Img/logo.jpg"></a>&nbsp;&nbsp;&nbsp; 
                    </div>
                </div>
                    <div class="col-sm-2 col-xs-2 heading-compose " style="margin-top: 10px;">
                        <a style="font-size: 20px; color: white;text-decoration: none;">Ocurrencias</a>
                    </div>
    
                    <div class="col-sm-2 col-xs-2 heading-compose  pull-right" onclick="CambiarVistas('app2',0);">
                        <!--<i class="fa fa-comments fa-2x  pull-right" aria-hidden="true" style="color: white"></i>-->
                        <i class="material-icons  pull-right" aria-hidden="true" style="font-size: 2em;color: white">forum</i>
                    </div>
            </div>
                <div class="row searchBox">
                    <div class="col-sm-12 col-xs-12 searchBox-inner">
                        <div class="form-group has-feedback">
                            <div id="buscar_dinamico">
                                <div class="col-sm-1 col-xs-2">
                                   <md-icon class="material-icons"  style="font-size:36px;float: left;cursor:pointer" onclick="BucardorIds();">assignment</md-icon>
                                </div>
                                <div class="col-sm-9 col-xs-8">
                                    <input id="filtrar" type="text"  id="bus" class="form-control1" name="searchText" placeholder="Buscar por Ocurrencia" autofocus="focus" onkeyup="BuscarOcurrencia(this);" ondblclick="addNewPartner();"/> 
                                </div>  
                            </div>
                            <div class="col-sm-2 col-xs-2">
                                <a  data-toggle="modal" data-target="#ModalReportes" style="float: right;" onclick="ModalReporte();" >
                                    <i class="material-icons" style="font-size: 40px;color: black;cursor: pointer;">apps</i>
                                    <!--<img src="Public/Img/Captura.PNG" style="width: 35px;height: 35px; cursor: pointer;" >-->
                                </a>
                          </div>
            
                          
                          
                          
                        </div>
                    </div>
                </div>
                <div class="row sideBar" id="ListaOcurrencias"> <!--row sideBar-->
                </div><!--row sideBar-->
                
                <!--div de la busqueda perro -->
                <div class="row sideBar" id="ListaOcurrenciasBusqueda" style="display:none"> <!--row sideBar-->
                </div><!--row sideBar-->
                
            </div>
        </div>
        </div>
    </div>

    
<!--Contactos-->
    <div class="container app" id='app2'  style="display:none">
        <div class="row app-one">
            <div class="col-sm-12 side">    
                <div class="side-two">
                    <div class="row newMessage-heading">
                    <div class="row newMessage-main">
                        <div class="col-sm-10 col-md-10 col-xs-10 ">
                            <div class="newMessage-title">
                                <div class= "newMessage-back" >
                                    <i class="material-icons" aria-hidden="true" onclick="CambiarVistas('app1',0)">reply_all</i>
                                    Nueva Ocurrencia 
                                    <a href="" style="text-decoration: none; color: white"></a>
                                    <!--<i class="material-icons">arrow_back</i>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-2 col-md-2">
                            <i class="material-icons" style="float:right;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="Nuevo socio" onclick="addNewPartner()">person_add</i>
                        </div>
                    </div>
                </div> 
                    <div class="row composeBox" id="BusquedaContactos">
                        <div class="col-sm-12 composeBox-inner">
                            <div class="form-group has-feedback">
                                <input id="filtrar2" type="text" class="form-control1" name="searchText" placeholder="Buscar Empresa"  onkeyup="BusquedaContactos(this);">
                  
                            </div>
                        </div>
                    </div>
                    <!--vista de contactos-->
                    <div class="row compose-sideBar" id="ListaContactos" ></div>
                    <!--vista Busqueda contactos-->
                    <div class="row compose-sideBar" id="ListaContactosBusqueda" style="display:none" ></div>
        
                </div>   
            </div>  
        </div>
    </div>


<!--Hmensajes-->
    <div class="container app" id='app3' style="display:none">
        <div class="row app-one">
            <div class="col-sm-12 side" id='HMensajesID'>
            </div>
        </div>
    </div>
</body>



 
  
 

  <!-- The Modal  todas las modales se utlizan en diferentes vistas-->
  <!--Modal Estado-->
<div class="modal fade" id="ModalEstado" >
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div id="CambiarEstados">
                    
            </div>
          
          </div>
        </div>
  </div>
  
  <!--Modal Vendedor-->
<div class="modal fade" id="ModalVendedor" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="CambiarVendedor">
            </div>
        </div>
    </div>
</div>
 
  <!--Modal Vendedor-->
<div class="modal fade" id="ModalEncuesta" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="ContenidoEncuesta">
            </div>
        </div>
    </div>
</div>
 
<!--Excusivo para la converzacion-->
  
<!--Modal Correos--> 
<div class="modal fade" id="ModalCorreos" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="ContenidoCorreos">
            </div>
        </div>
    </div>
</div>



<!--Modal EditarOcurrecnias-->
<div class="modal fade" id="ModalEditarOcurrencia" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="ContenidoEditarOcurrencia">
            </div>
        </div>
    </div>
</div>



<!--Modal Acciones-->
<div class="modal fade" id="ModalAcciones" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="ContenidoAcciones">
            </div>
        </div>
    </div>
</div>

<!--Modal Reporte-->
<div class="modal fade" id="ModalReportes" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="ContenidoReporte"></div>
        </div>
    </div>
</div>




  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>
<script>

    //cambiar las vistas
    //jugaremos contres vistas // contactos , ocurrencias y Contenidos de mensajes
    
    CambiarVistas=(NombreVista,Id)=>
    {
        switch (NombreVista) {
            case 'app1':
                    $('.side-two').css({'left':'-100%'})
                    setTimeout(function() {
                        $('#app1').css({'display':'block'});
                        $('.side-two').css({'top':'-100%'});
                        $('#app2').css({'display':'none'});
                        $('#app3').css({'display':'none'});
                        $('#HMensajesID').html('');
                        }, 300);
                break;
            case 'app2':
                    $('#app1').css({'display':'none'})
                    $('#app2').css({'display':'block'});
                    $('.side-two').css({'top':'0%'})
                    setTimeout(function() {
                        $('.side-two').css({'left':'0%'})
                    }, 30);
                break;
            case 'HMensaje':
                    $('#app1').css({'display':'none'});
                    $('#app2').css({'display':'none'});
                    CargarContenido_HO(Id)
                break;
            default:
                swal('No se Encontraron las funciones , porfavor pongase en contacto con el administrador de sistema');
                break;
        }
    }
    
CargarContenido_HO=(Id)=>
{
    let Accion='OcurrenciasHis';
    $.post("Controller/OcurrenciasC.php", {IdPersona:Id,Accion:Accion}, function(response) {
            //console.log(response);
            $('#app3').css({'display':'block'});
            $('#HMensajesID').html(response);
        });
}
    
/*
.____                           .____                     .___ 
|    |   _____  ___________.__. |    |    _________     __| _/ 
|    |   \__  \ \___   <   |  | |    |   /  _ \__  \   / __ |  
|    |___ / __ \_/    / \___  | |    |__(  <_> ) __ \_/ /_/ |  
|_______ (____  /_____ \/ ____| |_______ \____(____  /\____ |  
        \/    \/      \/\/              \/         \/      \/ 
*/
    
/*Lazy load solo para la primera vista  las demas vistas cargarn dependiendo donde se llamen */

{
    "use strict";
    let start_page = 0;
    const scope = $("#ListaOcurrencias");
    this.load = function(start) {
        $.get("Load/LoadOcurrencias.php", { start: start,Accion:'CargaInicias' }, function(response) {
            
            scope.append(response);
            start_page += 15;
        });
    };
    const win = $("#ListaOcurrencias");
    console.log(win);
    win.scroll(() => {
    	console.log({scrollHeight:win.prop("scrollHeight"),scrollTop:win.prop("scrollTop"),winheight:win.height()})
        if (win.prop("scrollHeight")-Math.round(win.prop("scrollTop")) == win.height()) {
        	console.log(win.height());
            this.load(start_page);
        }
    });
    this.load();
}

/*Lista Contactos*/
{
    "use strict";
    let start_page_1 = 0;
    const scope_1 = $("#ListaContactos");
    this.load_1 = function(start) {
        $.get("Load/LoadContactos.php", { start: start,Accion:'CargaInicias' }, function(repues) {
            
            scope_1.append(repues);
            start_page_1 += 15;
        });
    };
    const win_1 = $("#ListaContactos");
    console.log(win_1);
    win_1.scroll(() => {
    	console.log({scrollHeight:win_1.prop("scrollHeight"),scrollTop:win_1.prop("scrollTop"),winheight:win_1.height()})
        if (win_1.prop("scrollHeight")-Math.round(win_1.prop("scrollTop")) == win_1.height()) {
        	console.log(win_1.height());
            this.load_1(start_page_1);
        }
    });
    this.load_1();
}




/*Cambio de estado en toda la ocurrencias */
EstadoCliente=(IdCliente)=>
{
       console.log(IdCliente);
       let Accion='ModalEstado';
         $.ajax({
          type: "POST",
          url: "Controller/OcurrenciasC.php",
          data: {Accion:Accion,IdCliente:IdCliente},
            success: function(response){
            $('#CambiarEstados').html('');
            $('#CambiarEstados').html(response);
          }
        });
}

GuardarEstado=(IdCliente)=>
{
    console.log('GuardarEstado');
    let Accion='ActualizaEstado';
    let parametros=$('#FormEstado').serialize()+'&Accion='+Accion;
    console.log(parametros);
     $.ajax({ 
        type: "POST",
        url: "Controller/OcurrenciasC.php",
        data:parametros ,
            success: function(response){
                console.log(response)
                $ObjEstados=JSON.parse(response);
                console.log(`${$ObjEstados.Color}`);
                console.log($ObjEstados.Desc);
                if($ObjEstados.Desc==null)
                {$('#EsTadoAbrebiatura'+IdCliente).css({'background-color':'#999'});
                 $('#EsTadoAbrebiatura'+IdCliente).html('SIN');}
                else
                {$('#EsTadoAbrebiatura'+IdCliente).css({'background-color':$ObjEstados.Color});
                $('#EsTadoAbrebiatura'+IdCliente).html($ObjEstados.Desc);}
                $('.close').click();
                
          }
        });
}

ModalVendedor=(IdCliente)=>
{
    let Accion='ModalVendedor';
     $.ajax({
          type: "POST",
          url: "Controller/OcurrenciasC.php",
          data: {Accion:Accion,IdCliente:IdCliente},
            success: function(response){
                $('#CambiarVendedor').html('');
                $('#CambiarVendedor').html(response);
          }
        });
    
}

GuardarVendedor=(IdCliente)=>
{
    console.log(IdCliente);
    let Accion ='ActualizaVendedor';
    let parametros=$('#FormularioVendedor').serialize()+'&Accion='+Accion;
     $.ajax({
          type: "POST",
          url: "Controller/OcurrenciasC.php",
          data: parametros,
            success: function(response){
                console.log(response);
                $(`#VendedorAsig${IdCliente}`).html(response);
          }
        });
}


Encuestar=(IdPersona, NombreSocio)=>
{
var param = "IdPersona="+IdPersona;
$('#ContenidoEncuesta').load("../Encuestas/FormEncuesta.php",param,function(){
    
    
    setTimeout(function surCerrar(){console.log('hola')},2000);
    
});
}

/*Correos Esto ya es dentro de ocurrencias*/
ModalCorreos=(IdOcurrencia,IdCLiente)=>
{
console.log(IdOcurrencia)
console.log(IdCLiente)
    let Accion ='ModalCorreos';
    
     $.ajax({
          type: "POST",
          url: "Controller/OcurrenciasC.php",
          data: {
                Accion:Accion,
                IdOcurrencia:IdOcurrencia,
                IdCLiente:IdCLiente
          },
            success: function(response){
                
                $(`#ContenidoCorreos`).html(response);
          }
        });
        
    
}




EliminaOcurrencia=(IdOcurrencia)=>
{
    //aun no realiza el ajax de eliminar 
    $('#OcurrenciasH'+IdOcurrencia).addClass('animated bounceOutLeft');
    setTimeout(function(){$('#OcurrenciasH'+IdOcurrencia).css({'display':'none'})},1000)
      
     let Accion ='EliminaOcurrencia';
     $.ajax({
          type: "POST",
          url: "Controller/OcurrenciasC.php",
          data: {
                Accion:Accion,
                IdOcurrencia:IdOcurrencia,
          },
            success: function(response){
                
                
          }
        });
    
}

GuardarCorreo=(IdOcurrencia,IdCLiente)=>
{
    console.log(IdOcurrencia);
    console.log(IdCLiente);
     var $b=IdCLiente;
     var $uid=IdOcurrencia;
      
      
      $ufirstname=$('#cuerpocorreo'+$uid).val();//estado
      $asunto= $('#asunto'+$uid).val();//asunto
      $correo1=$('#correo1'+$uid).val();
      $correo2=$('#correo2'+$uid).val();
      $correos=$('#correos'+$uid).val();
      
      console.log($ufirstname)
      console.log($asunto)
      console.log($correo1)
      console.log($correo2)
      console.log($correos)
      
      
//     $.ajax({
//           type: "POST",
//           url: "php/enviar_correo.php",
//           data: {
//             id: $uid,//id_muro
//             firstname: $ufirstname, //mensaje
//             //lastname: $ulastname,
//             asunto:$asunto,
//             correo1:$correo1,
//             correo2:$correo2,
//             correos:$correos,
//             cliente:$b,

//             edit: 1,
//           },
//          success: function(data){
//             //console.log('se pudo');
//             //$(".message-body[data-id='"+$uid+"']").find("#mensaje").html($ufirstname);
// //            ed($ulastname);
//               swal("Se envio su mensaje!", "", "success");
//           },error: function(error){
//             //console.log('erro perro');
// //            ed($ulastname);
//           swal("No se envio su mensaje!", "", "error");
//           }
      
//         });
}


ModalEditarOcurrencia=(IdOcurrencia)=>
{
    console.log(IdOcurrencia);
    let Accion='ModalEditarOcurrencia';
    $.ajax({
          type: "POST",
          url: "Controller/OcurrenciasC.php",
          data: {
                Accion:Accion,
                IdOcurrencia:IdOcurrencia
          },
            success: function(response){
                
                $(`#ContenidoEditarOcurrencia`).html(response);
          }
        });    
    
}


GuardarEditarO=(IdOcurrencia)=>
{
    //la variable editor esta declara en modaleditar
    let Accion='ActualizaOcurrencia'
    let Comentario=editor.getData();
    let IdMaestro=$('#IdAccion2').val();
    console.log(Comentario);
        $.ajax({
          type: "POST",
          url: "Controller/OcurrenciasC.php",
          data: {
            Accion: Accion,
            Comentario: Comentario,
            IdOcurrencia:IdOcurrencia,
            IdMaestro:IdMaestro
          },
          success: function(data){
                $('.mensaje'+IdOcurrencia).html(``);
                $('.mensaje'+IdOcurrencia).html(`(${IdOcurrencia})  ${Comentario}`);
                $(`#Icon${IdOcurrencia}`).html($(`#NomIcon${IdMaestro}`).val())
            //$(".mensaje"+$uid).html(editor<?php echo $res['0']; ?>.getData());
          },error: function(error){
            console.log(error);
          }
        });
    $('.close').click()

}

ModalAccion=()=>{
    
    let Accion='ModalAccion' 
    $.ajax({
    type: 'POST',
    url: 'Controller/OcurrenciasC.php',
    data: {Accion:Accion},
    success: function(respuesta) { 
        $('#ContenidoAcciones').html('');
        $('#ContenidoAcciones').html(respuesta);}
        });
}

GuardarAccion=(IdAccion)=>{
    console.log("GuardarAccion()");
    // var IdAccion=$('input:radio[name=IdAccion]:checked').val();
     var IdAccion=IdAccion;
    jQuery('#IdAccionhidden').val(IdAccion);
    let nombreIcon=$('#NomIcon'+IdAccion).val();
    console.log(IdAccion);
    console.log(nombreIcon);
    $('#IconAcccion').html('');
    $('#IconAcccion').html(nombreIcon);
    $('.close').click();
}

GuardarOcurrencia=(IdCLiente)=>
{
    
    let Accion='AgregarOcurrencia';
    if ($('#comment').val()==""){
        swal('Escribir una nueva ocurrencia');
      }
      else{
          if(jQuery('#IdAccionhidden').val()=='0')
          {
              swal('Seleccione una Accion de Ocurrencia');
          }
          else
          {
            console.log('correcto guardando ocurrencias');
            let IdAccion=jQuery('#IdAccionhidden').val();
            let Comentario=$('#comment').val();//comentatio
          
                    $.ajax({
                      type: "POST",
                      url: "Controller/OcurrenciasC.php",
                      data: {
                        Comentario: Comentario,//cometario
                        IdCLiente: IdCLiente,
                        Accion: Accion,
                        IdAccion:IdAccion
                      },
                      success: function(data){
                        console.log(data);
                        $Obj=JSON.parse(data);
                        console.log($Obj);
                        console.log($Obj.IdMuro);
                        console.log($Obj.Comentario);
                        console.log($Obj.FCrea);
                        console.log($Obj.Icon);
                        console.log($Obj.IdCliente);
                        var IdCLienteN=$Obj.IdCliente;
                        //para la vista principal
                        $('#UltimoMensaje'+IdCLienteN).html(Comentario);
                        $('#UltimoTime'+IdCLienteN).html($Obj.FCrea);
                        
                        //necesito en jason IdOcurrencia
                        //mensaje fecha 
                        //icono 
                        $('#comment').val('');
                        $('#IconAcccion').html('reorder');
                        jQuery('#IdAccionhidden').val(0)
                        //con jquery es $(elemento).prepend('html');
                        var CuerpoC=NewComentario($Obj);
                        
                        Elemento=document.getElementById('supremo');
                        divA=document.createElement('div');
                        divA.innerHTML=CuerpoC;
                        Elemento.insertBefore(divA,Elemento.firstChild);
                        
      
                        
                      }
                    });
          }
    
      }
}

/*ajax busquedas*/
/*
__________                                     .___              
\______   \__ __  ______________ __   ____   __| _/____    ______
 |    |  _/  |  \/  ___/ ____/  |  \_/ __ \ / __ |\__  \  /  ___/
 |    |   \  |  /\___ < <_|  |  |  /\  ___// /_/ | / __ \_\___ \ 
 |______  /____//____  >__   |____/  \___  >____ |(____  /____  >
        \/           \/   |__|           \/     \/     \/     \/ 
*/

BuscarOcurrencia=(a)=>
{
    let string=$(a).val();
    if (string.length>3)
    {
        $('#ListaOcurrencias').css({'display':'none'})
        $('#ListaOcurrenciasBusqueda').css({'display':'block'})
        LaizyParametros(string,'ListaOcurrenciasBusqueda','LoadOcurrencias');
    }
    else if (string.length=='')
    {
        $('#ListaOcurrenciasBusqueda').css({'display':'none'})
        $('#ListaOcurrencias').css({'display':'block'});
        $('#ListaOcurrenciasBusqueda').html('');
    }
}

BusquedaContactos=(a)=>
{
    let string=$(a).val();
    if (string.length>3)
    {
        $('#ListaContactos').css({'display':'none'})
        $('#ListaContactosBusqueda').css({'display':'block'})
        LaizyParametros(string,'ListaContactosBusqueda','LoadContactos');
        // $(`#ListaContactosBusqueda`).html('',);
    }else if (string.length=='')
    {
        $('#ListaContactosBusqueda').css({'display':'none'})
        $('#ListaContactos').css({'display':'block'})
        $('#ListaContactosBusqueda').html('');
    }
}

LaizyParametros =(string,div,Archivo)=>
{
       
        let start_page_2 = 0;
        let scope_2 = $(`#${div}`);
        this.load_2 = function(start) {
            console.log(start);
            $.get(`Load/${Archivo}.php`, { start: start,Accion:'BusquedaContactos',string:string }, function(repues) {
                $(`#${div}`).html('');
                // if(repues=='')
                // {scope_2.append(`
                // <div class="shake">
                // <div class="alert alert-warning alert-dismissable">
                //         <button type="button" class="close" data-dismiss="alert">&times;</button>
                //         <strong>¡Sin Datos!</strong> No se Encontraron coincidencias.
                // </div>
                // </div>`);}
                scope_2.append(repues);
                start_page_2 += 15;
            });
        };
        const win_2 = $(`#${div}`);
        console.log(win_2);
        win_2.scroll(() => {
        	console.log({scrollHeight:win_2.prop("scrollHeight"),scrollTop:win_2.prop("scrollTop"),winheight:win_2.height()})
            if (win_2.prop("scrollHeight")-Math.round(win_2.prop("scrollTop")) == win_2.height()) {
            	console.log(win_2.height());
                this.load_2(start_page_2);
            }
        });
        this.load_2();
}

ModalReporte=()=>
{
    let Accion='ModalReporte';
    if($('#ContenidoReporte').html()!=""){ }
    else{
        $.ajax({
        type: 'POST',
        url: 'Controller/OcurrenciasC.php',
        data: {Accion:Accion},
        success: function(respuesta) {
        $('#ContenidoReporte').empty();
        $('#ContenidoReporte').html(respuesta);
         }
        });
    }
    
}
/*solo para los filtros qes un caso muy extrañoooo*/
LaizyParametros2 =(Parametro,div,Archivo)=>
{
     $('#ListaOcurrencias').css({'display':'none'})    
     $(`#${div}`).html('');
       //let Parametro=Parametro+'&Accion=Filtros&start='+start;
        let start_page_2 = 0;
        let scope_2 = $(`#${div}`);
        this.load_2 = function(start) {
            $.get(`Load/${Archivo}.php`,Parametro+'&Accion=Filtros&start='+start, function(repues) {
                 $(`#${div}`).css({'display':'block'})
                
                // if(repues=='')
                // {scope_2.append(`
                // <div class="shake">
                // <div class="alert alert-warning alert-dismissable">
                //         <button type="button" class="close" data-dismiss="alert">&times;</button>
                //         <strong>¡Sin Datos!</strong> No se Encontraron coincidencias.
                // </div>
                // </div>`);}
                scope_2.append(repues);
                start_page_2 += 15;
            });
        };
        const win_2 = $(`#${div}`);
        console.log(win_2);
        win_2.scroll(() => {
        	console.log({scrollHeight:win_2.prop("scrollHeight"),scrollTop:win_2.prop("scrollTop"),winheight:win_2.height()})
            if (win_2.prop("scrollHeight")-Math.round(win_2.prop("scrollTop")) == win_2.height()) {
            	console.log(win_2.height());
                this.load_2(start_page_2);
            }
        });
        this.load_2();
}

/*Buscador de Id */

BucardorIds=()=>
{
    
    var div=document.createElement("div")
    div.innerHTML=`Id Ocurencia : <input id='IdOcurrenciab'>`;
              swal({
              title: "Buscar Id Ocurrencia",
              content: div
            })
            .then((willDelete) => {
              if (willDelete) {
                  let Accion='PosicionId';
                var IdOcurrencia=$('#IdOcurrenciab').val();
                  $.ajax({
                     url:'Controller/OcurrenciasC.php',
                     type:'POST' ,
                     data:{Accion:Accion,IdOcurrencia:IdOcurrencia},
                     success:function(data){
                         $objRes=JSON.parse(data);
                         console.log(data);
                         
                       ($objRes.IdPersona=='' || $objRes.IdPersona==0)?swal('No encontro el id'):CambiarVistas('HMensaje',$objRes.IdPersona);
                       
                        if($objRes.Posicion>15)
                        {
                            //saquemos el valor dividdo entre 15 para poder hacer el for 
                            
                            setTimeout(()=>{
                            var para=$objRes.Posicion/15;
                            para=parseInt(para);
                            console.log(para);
                            var TamañoScroll=$('#conversation').prop("scrollHeight");
                            console.log(TamañoScroll); 
                            for(let i=0 ; i<para;i++)
                            {
                              
                                $('#conversation').scrollTop(TamañoScroll)
                                TamañoScroll=TamañoScroll*2;
                            }
                            setTimeout(()=>{
                                var divpo=document.getElementById(`OcurrenciasH${IdOcurrencia}`).offsetTop
                            $('#conversation').scrollTop(divpo-40)
                            },1000)
                            console.log(TamañoScroll);    
                            },3000)
                            
                            
                            
                            
                        }
                         
                         
                         
                     }
                  });
                
              }
            });
    //Cambiando el idioma        
    $('.swal-button--confirm').html('Buscar')
     $('#IdOcurrenciab').focus();
}




//documentos js 
clickdocumento =(tipoDoc, id,IdEmpresa,$FTip)=> {
console.log("id: " + id + " tipo decumento " + tipoDoc + " idemp" + IdEmpresa);
link(tipoDoc, id,IdEmpresa,$FTip);
}

 link =(TipoDoc, IdLista,IdEntEmpresa,$FTip)=> {
       var rut='../../';

       if (TipoDoc == 13) {
           jQuery.getJSON(rut+"p/CifrarIdDoc.php", {IdLista: IdLista, Request: "Cifrar", TipoDoc: TipoDoc},
           function (data) {
               UrlDoc = rut+'p/?d=' + data.Td + 'and' + data.Id + 'and' + '' + 'sky' + data.Org;
               var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
               var titulo = "Comprobantes";
               window.open(UrlDoc, titulo, especificaciones);
           });
          }/*else if (TipoDoc == 121 ){   
            var NomDoc='ReciboInterno.php';
            UrlDoc=rut+'Componentes/Print/'+NomDoc+'?Id='+IdLista+'&TipoDoc='+TipoDoc; 
            var especificaciones="top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
            var titulo="Comprobantes";
            window.open(UrlDoc,titulo,especificaciones);

       } */
       
       else if (TipoDoc == 7 || TipoDoc == 8) {
           var NomDoc = 'NotaDebito.php';
           UrlDoc = rut+'Componentes/Print/' + NomDoc + '?Id=' + IdLista + '&TipoDoc=' + TipoDoc + '&IdEmpresa=' + IdEntEmpresa;
           var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
           var titulo = "Comprobantes";
           window.open(UrlDoc, titulo, especificaciones);
       }
       else if (TipoDoc == 3) {
           var NomDoc = 'Boleta.php';
           UrlDoc = rut+'Componentes/Print/' + NomDoc + '?Id=' + IdLista + '&TipoDoc=' + TipoDoc + '&IdEmpresa=' + IdEntEmpresa;
           var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
           var titulo = "Comprobantes";
           window.open(UrlDoc, titulo, especificaciones);
       } else if (TipoDoc == 1) {
           switch ($FTip) {
               case 'E':
                    var NomDoc = 'Factura.php';
                     UrlDoc = rut+'Componentes/Print/' + NomDoc + '?Id=' + IdLista + '&TipoDoc=' + TipoDoc + '&IdEmpresa=' + IdEntEmpresa;
                     var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
                     var titulo = "Comprobantes";
                     window.open(UrlDoc, titulo, especificaciones);
                   break;
               case 'F':
                   jQuery.getJSON(rut+"p/CifrarIdDoc.php", { IdLista: IdLista, Request: "Cifrar", TipoDoc: TipoDoc},
                     function(data){
                         UrlDoc = rut+'p/?d=' + data.Td + 'and' + data.Id + 'and' + '' + 'sky' + data.Org+'skyTal';
                         var especificaciones="top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
                         var titulo="Comprobantes";
                         window.open(UrlDoc,titulo,especificaciones);
                     });
                break;
               default:
                 var NomDoc = 'Factura.php';
                 UrlDoc = rut+'Componentes/Print/' + NomDoc + '?Id=' + IdLista + '&TipoDoc=' + TipoDoc + '&IdEmpresa=' + IdEntEmpresa;
                 var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
                 var titulo = "Comprobantes";
                 window.open(UrlDoc, titulo, especificaciones);
                 break;
                   // code
           }

           //console.log($FTip);
           /*f ($FTip=='E') {
                         var NomDoc = 'Factura.php';
                         UrlDoc = rut+'Componentes/Print/' + NomDoc + '?Id=' + IdLista + '&TipoDoc=' + TipoDoc + '&IdEmpresa=' + IdEntEmpresa;
                         var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
                         var titulo = "Comprobantes";
                         window.open(UrlDoc, titulo, especificaciones);
                          }
          
          if ($FTip=='F') {
                 jQuery.getJSON(rut+"p/CifrarIdDoc.php", { IdLista: IdLista, Request: "Cifrar", TipoDoc: TipoDoc},
                 function(data){
                     UrlDoc = rut+'p/?d=' + data.Td + 'and' + data.Id + 'and' + '' + 'sky' + data.Org+'skyTal';
                     var especificaciones="top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
                     var titulo="Comprobantes";
                     window.open(UrlDoc,titulo,especificaciones);

                });
                 }*/
          /*if ($FTip=='0') {
                   var NomDoc = 'Factura.php';
                         UrlDoc = rut+'Componentes/Print/' + NomDoc + '?Id=' + IdLista + '&TipoDoc=' + TipoDoc + '&IdEmpresa=' + IdEntEmpresa;
                         var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
                         var titulo = "Comprobantes";
                         window.open(UrlDoc, titulo, especificaciones);
          }*/

       } else {
           jQuery.getJSON(rut+"p/CifrarIdDoc.php", {IdLista: IdLista, Request: "Cifrar", TipoDoc: TipoDoc},
           function (data) {
               UrlDoc = rut+'p/?d=' + data.Td + 'and' + data.Id + 'and' + '' + 'sky' + data.Org;
               var especificaciones = "top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
               var titulo = "Comprobantes";
               window.open(UrlDoc, titulo, especificaciones);
           });
       }
   }
   
   
  /*para las cuentas por cobrar*/ 
  
ImprimirReciboCtas=(IdOperacionCB,IdOperacionDet,IdCajaBco,DocSerieDocumento,DocNroDocumento,TiDocOrigen)=>{
    var rut='../../';
    jQuery.getJSON(rut+"p/CifrarIdDoc.php", { IdLista: IdOperacionCB, Request: "Cifrar", TipoDoc: "BancoOperaciones"},
    function(data){
        UrlDoc = rut+'p/?d=' + data.Td + 'and' + data.Id + 'and' + '' + 'sky' + data.Org;
        var especificaciones="top=0,left=0,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no, width=900,height=600";
        var titulo="Comprobantes";
        window.open(UrlDoc,titulo,especificaciones);
    });
}

//Calendario XXXD
var miPopup 
function abreVentana(a){ 
   	miPopup = window.open(a,"miwin","width=800,height=600,scrollbars=yes") 
   	miPopup.focus() 
} 

function Mostrar_agendas(Jso)
{
    Obj=JSON.parse(Jso);
    console.log(Obj)
    $(`#Agendas${Obj.IdMuro}`).html(Obj.HTML);
    
    
}

abrir_cal=(a,b)=>
{
    
    
    if (a==<?php echo $_SESSION['IdPersona']?>)
    {window.open(b, 'mywin','left=20,top=20,width=800,height=600,toolbar=1,resizable=0')}
    else
    {
        swal({
              title: "Error",
              text: "Usted no es el usuario que agendo la ocurrencia",
              icon: "error",
              button: "Cancelar",
            });
    }
    
    
    
}
</script>




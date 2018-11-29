<?php 

require('../../../Controles/DataTime/Data.php'); 
require('../../../Controles/DataGrid_2/Grid.php');
require('../../../Controles/Search/Search.php');
require('../../../Controles/Arbol_2/Arbol.php');  
require('../../../Controles/Arbol_2/ArbolDiv.php');
require('../../../Class/IdTabla.php');


$IdArbol=IdArbol($link,7);

$Ruta="http://".$_SERVER['HTTP_HOST']."/".$_SESSION['ConfG_RutaRelativaS']."";
  
?>

<script type="text/javascript">


	jQuery('#Titulo').text('Reporte de Ocurrencias');	
	
	InsertarEmpreCliente=function (IdCliente){
		jQuery('#IdCliente').val(IdCliente);		
		jQuery('#optCliente').attr('checked',false);
	}

	LimpiarCliente=function(){
		jQuery('#IdCliente').val('');
		jQuery('#NomCliente').val('');
		jQuery('#TClientes').show();
                jQuery('#IdPersonaR').val('');
	}
	LimpiarCambiarRadio=function()
	{
		jQuery('#IdNodo1').val('');
		jQuery('#DescIdNodo1').val('');
	}
	
	jQuery('#NomCliente').focus(function(){
		jQuery('#optCliente').removeAttr('checked');
	});

	jQuery('#NomCliente').blur(function(){
		if(jQuery(this).val()==''){
			//jQuery('#optCliente').attr('checked','checked');
		}
	});
	
	InsertarVendedor=function(idvendedor){

	jQuery('#IdVendedor').val(idvendedor);
	jQuery('#opVendedores').remove();
}



limpiarDatos2=function(){
	jQuery('#IdVendedor').val('');
}

IdManual=256;
</script>

<div class="panel">
	<div class = "modal-header" style="padding: 0px;">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrar_modal"><span aria-hidden="true">&times;</span></button>
      <center><h3 class = ""> <i class="material-icons" style="font-size:36px; ">assessment</i> Filtrar Ocurrencias</h3></center>
    </div>
<FORM  method="get"  name="frmocu" id="frmocu" autocomplete="off">

<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1"  class="panel">
  <tr>
    <td width="1158" >
    <fieldset >

&nbsp;&nbsp;Formato
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="formato" id="radio" value="1"  />Html
<input type="radio" name="formato" id="radio2" value="2" />Excel

<input type="radio" name="formato" id="radio2" value="3" checked="checked" />App


</fieldset>

<fieldset>
<!--<legend>&nbsp;&nbsp;Filtro</legend>-->
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td class="out" align="right">Periodo</td>
    <td bgcolor="">&nbsp;&nbsp;<label>
    	<input name="dtpFechaIni" id="dtpFechaIni" size="10"   type="date"  value="<?php echo date('Y-m').'-'.'01' ;?>"> &nbsp; / &nbsp;
      <?php 
			//DataTime('dtpFechaIni',date('Y-m').'-'.'01',$FechaPago,'',''); 
		?>
      <?php 
			//DataTime('dtpFechaFin',date('Y-m-d'),$FechaPago,'',''); 
		?>
		<input name="dtpFechaFin" id="dtpFechaFin" size="10"  type="date" value="<?php echo date('Y-m-d'); ?>">
    </label></td>
  </tr>
    <tr>

      <td width="15%" class="out" align="right">Vendedor</td>
      <td width="85%" bgcolor="">
        <input type="hidden" value="" name="IdVendedor" id="IdVendedor">
        <input type="hidden" value="" name="IdPersonaV" id="IdPersonaV">
        <input type="hidden" value="" name="IdMiEmpresaCliV" id="IdMiEmpresaCliV">
    <input type="radio" id="checkTodos" name="checkTodosVendedores" value="1" checked onclick="CambiarOpcionBusqueda(1);" />  Todos
    <input type="radio" id="checkNoAsignados" name="checkTodosVendedores" value="2" onclick="CambiarOpcionBusqueda(2);" />  No Asignados
    <input type="radio" id="checkTodosVendedores" name="checkTodosVendedores" value="3" onclick="CambiarOpcionBusqueda(3);" />  Seleccionar
    	<div class="vendedores">
    	<div class="frmSearch">
    		<div class=" has-success">
			<input type="text" id="search-box" placeholder="Buscar por Vendedor" for="inputSuccess" class="form-control" /></div>
			<div id="suggesstion-box"></div>

		</div>
    	</div>	
	</td>
    <td>
		<div style="display:none" id="ImagenS"><img src="<?php echo $Ruta?>ImgSys/aprobar.png" title="Vendedor"></div>
		<div style="display:none" id="ImagenN"><img src="<?php echo $Ruta?>ImgSys/eliminar.png" title="Vendedor no asignado"></div>
	</td>
    </tr>
  <tr>
    <td class="out" align="right">Cliente</td>
      <td bgcolor="">
		<input name="IdPersonaR" id="IdPersonaR" type="hidden" />
		<input type="hidden" size="3" name="IdCliente" id="IdCliente"   value="<?php echo $_GET['IdCliente'] ;?>"/>
		<input type="hidden" size="3" name="IdMiEmpresaCli" id="IdMiEmpresaCli"   value=""/>
		<label><input name="optCliente" type="radio" id="optCliente" value="cliente" checked="checked" onclick="LimpiarCliente(),SelDet(1)" />Todos </label>
		<label><input name="optCliente" type="radio"  id="optCliente" value="" onclick="SelDet(0)"/>Por Cliente</label>
</td>
    </tr>
    <tr id="Documento" style="display:none" >
    <td class="out"> 
    </td>
    <td>
    </td>
    </tr>
    <tr  id="TClientes"><td class="out"  align="right">Grupo</td><td bgcolor="" width="50%" > 
	<?php 
		$Grupos1 = new Arbol();
		$Grupos1->ArbolDiv($link,'IdNodo1','Grupo de clientes','tree_det',$IdArbol,$Familia,'','ARRV'); 
	?>
    </td>
    </tr>
    <tr>
    <td width="15%" class="out" align="right">Estatus</td>
    <td width="85%" bgcolor="" id="DivEstados"> </td>
    </tr>
    <tr>
        <td width="15%" class="out" align="right">Orden</td>
        <td width="85%" bgcolor="">
            <input type="radio" name="ordenamiento" value="ASC"> Asc.
            <input type="radio" name="ordenamiento" value="DESC" checked> Desc.
        </td>
    </tr>
</table>
</fieldset></td>
  </tr>
  <tr>
  <td height="40px" align="center">
    <!--<input type="button" name="button" id="button" value="Ocurrencias" class="btn btn-primary" onclick="FiltrosOcurrencias()"/>-->
    
    <!--<input type="button" name="button"  id="button" value="Generar Reporte" class="btn btn-success" onclick="habreVentana();"/>-->
    <button type="button" class="btn btn-success" data-dismiss="modal" id="botonGenerarRerporte" onclick="GenerarReporte();">Generar Reporte </button>
    <!--<input type="button" name="button" id="button" value="Cancelar" onclick="CerrarVentana();" class="close_modal btn btn-danger"/>-->
    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar </button>
    
    </td>
    </tr>
 
</table>

</FORM>
<div id="divsssss" style="visibility:hidden"></div>
</div>
<script type="text/javascript" language="javascript">

$('.vendedores').hide();
CambiarOpcionBusqueda=(val)=>{
        if(val != 3){
            jQuery('.vendedores').hide();
        }else{
            jQuery('.vendedores').show();
            jQuery('#search-box').focus();
        }
        jQuery('.vendedores').val('');
        jQuery('#IdVendedor').val('');
        jQuery('#IdPersonaV').val('');
        jQuery('#IdMiEmpresaCliV').val('');
}

/*Busca Vendedores*/   
$(document).ready(function(){
	$("#search-box").keyup(function(){
	    let Accion='BuscaVendedor';
	    let like=$(this).val();
		$.ajax({
		type: "POST",
		url: "Controller/OcurrenciasC.php",
		data: {Accion:Accion,like:like},
		beforeSend: function(){
			$("#search-box").css("background","#FFF url(https://phppot.com/demo/jquery-ajax-autocomplete-country-example/loaderIcon.gif) no-repeat 100%");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#search-box").css("background","#FFF");
		}
		});
	});
});

/*para seleccionar el vendedor , y sse agrefe en los campos ocualktos etc*/
SeleccionaVendedor=(val,id)=> {
jQuery("#search-box").val(val);
jQuery("#suggesstion-box").hide();
jQuery('#IdPersonaV').val(id);
}

/*Cargando estados*/
CargarEstatus=()=>{
        $.ajax({
            type:'POST',
        	url:'../../Reportes/OcurrenciasR.php',
        	data:{'Action':'Estatus'},
        	success:function(data){
        		jQuery("#DivEstados").html(data);
        	}
        });
    }
CargarEstatus();


/*Validado los check*/
validaCheck=(val)=>{
 	    
    	var cadena 	= $("#cadT").val();
    	var Arr 	= cadena.split(',');
    	var ex  	= 0;
        console.log(cadena)
		if(val=='ALL'){
			if($("#MALL").is(":checked") == true){
		    		for (var x = 0; x < Arr.length; x++) {
    		    			var a=$("#M"+Arr[x]).attr("checked",true);
    		    			console.log(a);
    		    			$("#M99 input[type=checkbox]").prop('checked', true);
		    		}
		    	
		}else{
				for (var i = 0; i < Arr.length; i++) {
					$("#M"+Arr[i]).removeAttr("checked");}
		}
    	}else{
        		$("#MALL").removeAttr("checked");
        		$(".Maestros").each(function(){
    			if($(this).is(":checked") == true){
    				ex++;
    			}
    		    });
    		if(ex==Arr.length-1){$("#MALL").attr("checked",true);}
    	}


}



/*No Definida en nungunn lugar xd Marca*/
// 	function marcar(source) 
// 	{
// 		checkboxes=document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
// 		for(i=0;i<checkboxes.length;i++) //recoremos todos los controles
// 		{
// 			if(checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
// 			{
// 				checkboxes[i].checked=source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
// 			}
// 		}
// 	}

/*no esta definido*/
//che de vendedor
// setTimeout(function() {
//     jQuery("#radio_comprobar").click(function() {  
//         if(jQuery("#radio").is(':checked')) {  
//             alert("Está activado");  
//         } else {  
//             alert("No está activado");  
//         }  
//     });  
  
// },1000);

 


// buscaCliente=function(IdPersona){
// 	var UrlCreaCond="<?php echo $Ruta?>Componentes/SocioNegocio/SocioNegocioConsulta.php?Accion=Accionx";
// 	jQuery.ajax({
// 		url: UrlCreaCond,
// 		type: 'POST',
// 		data: 'Id='+IdPersona,
// 		dataType:'Script',

// 		async: false
// 	});
// }

// limpiarDatos=function(){
// 	jQuery('#IdCliente').val('');
// }

// // SelDet=function(Est){
// // 	if(Est==1){
// // 		$('Documento').hide();
// // 		$('TClientes').show();
// // 	}else{
// // 		$('Documento').show();
// // 		$('NomCliente').focus();
// // 		$('TClientes').hide();
// // 		jQuery('#IdNodo1').val('');
// // 		jQuery('#DescIdNodo1').val('');
// // 	}
// // }
// // SelDet(1);




/*Gereamos el reporte */
GenerarReporte=()=>
{
    console.log('Generamos el reporte ');
    habreVentana();
}
// $("#botonGenerarRerporte").click(function(){
//     habreVentana();
    
// });


habreVentana=()=>{
	if(jQuery("#MALL").is(":checked")==true){
		var Estats="Todos";

	}else{
		var Estats = new Array();
		jQuery(".Maestros").each(function(){
			if(jQuery(this).is(":checked") == true){
				Estats.push(jQuery(this).val());
			}
		});
	}
	if(Estats==''){alert('Debe tener como mínimo un Filtro de Estatus');return false;}
	
	var radiotipo = jQuery('input:radio[name=formato]:checked').val();
	
	if(radiotipo==1){
		console.log('html');
	    window.open("<?php echo $Ruta?>Reportes/OcurrenciasR.php?"+jQuery('#frmocu').serialize()+"&Estatus="+Estats,"myWin","menubar, scrollbars, left=30px, top=40px, height=700px, width=1350px"); 
	}
	if(radiotipo==2){
		console.log('excel');
	    window.open("<?php echo $Ruta?>Reportes/OcurrenciasExcel.php?"+jQuery('#frmocu').serialize()+"&Estatus="+Estats,"myWin","menubar, scrollbars, left=30px, top=40px, height=700px, width=1350px"); 
	}
	
	/*tipo app*/
	if(radiotipo==3){
		console.log('App');
	    FiltrosOcurrencias(Estats);
	}
	

}

 //para el filtro pendejo 
FiltrosOcurrencias=(Estats)=>{
	
	console.log($('#frmocu').serialize()+"&Estatus="+Estats);
	
	var radiotipo = $('input:radio[name=formato]:checked').val();
	var parametros=$('#frmocu').serialize()+"&Estatus="+Estats;
// 	console.log(radiotipo);
//         $.ajax({
//                     url:'php/FiltroSqlNew.php',
//                     type:'GET',
//                     data: $('#frmocu').serialize()+"&Estatus="+Estats,
//                     success: function(data)
//                     {
                    //llenar el div con filtros  
                 
                        LaizyParametros2(parametros,'ListaOcurrenciasBusqueda','LoadOcurrencias');
                        

                //     }
                // });
}
    


</script>
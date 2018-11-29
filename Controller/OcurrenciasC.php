<?php 
session_start();
require("../../../Cx.php");
$link=Conectarse();
require('../Model/OcurrenciasM.php');
$ObjeOcurrencia=new Ocurrencias($link);

switch ($_POST['Accion']) {
    case 'value':
        // code...
        break;
    
    case 'OcurrenciasHis':
        $IdCliente=$_POST['IdPersona'];
        $res=$ObjeOcurrencia->CabeceraOcurrencias($IdCliente);
        $DatosCli=mysqli_fetch_object($res);
        $NombreCliente=$DatosCli->Nombre;
        $codOrganizacion=$DatosCli->CodOrg;
        require('../View/HOcurrencias.php');
        break;
    case 'ModalEstado';
         $IdCliente=$_POST['IdCliente'];
         $res=$ObjeOcurrencia->ListaEstados($IdCliente);
        require('../View/ModalEstado.php');
        break;
    case 'ActualizaEstado':
        $IdCliente=$_POST['IdCliente'];
        $IdEstado=$_POST['IdEstado'];
        $ObjeOcurrencia->ActualizarEstado($IdCliente,$IdEstado);
        break;
    case 'ModalVendedor':
        $IdCliente=$_POST['IdCliente'];
        $vendedoresL=$ObjeOcurrencia->ListaVendedores($IdCliente);
        require('../View/ModalVendedor.php');
        break;
    case 'ActualizaVendedor':
        $IdCliente=$_POST['IdPersonaCV'];
        $IdVendedor=$_POST['IdVendedlor'];
        $ObjeOcurrencia->ActualizaVendedor($IdCliente,$IdVendedor);
        break;
    case 'ModalCorreos':
        $IdCLiente=$_POST['IdCLiente'];
        $IdOcurrencia=$_POST['IdOcurrencia'];
        $SqlOcurrencias=$ObjeOcurrencia->MostrandoOcurrencia($IdOcurrencia);
        $ed=$ObjeOcurrencia->Mensaje_a_enviar($IdOcurrencia);
        require ('../View/ModalCorreos.php');
        break;
    case 'ModalEditarOcurrencia':
         $IdOcurrencia=$_POST['IdOcurrencia'];
         $Ocurrencia=$ObjeOcurrencia->MostrandoOcurrencia($IdOcurrencia);
         $Comentario=$Ocurrencia->comentario;
         $Acciones=$ObjeOcurrencia->ListaAcciones();
         require('../View/ModalEditarO.php');
        break;
    case 'ActualizaOcurrencia':
        $IdMaestro=$_POST['IdMaestro'];
        $IdOcurrencia=$_POST['IdOcurrencia'];
        $Comentario=$_POST['Comentario'];
        $ObjeOcurrencia->ActualizaOcurrencia($IdOcurrencia,$Comentario,$IdMaestro);
        break;
    case 'EliminaOcurrencia':
        $IdOcurrencia=$_POST['IdOcurrencia'];
        $ObjeOcurrencia->EliminaOcurrencia($IdOcurrencia);
        break;
    case 'ModalAccion':
        $Acciones=$ObjeOcurrencia->ListaAcciones();
        require('../View/ModalAcciones.php');
        break;
        
    case 'AgregarOcurrencia':
        $IdUserCrea=$_SESSION['IdUsuario'];
        $IdMiEmpresa=$_SESSION['IdMiEmpresa'];
        $IdCliente=$_POST['IdCLiente'];
        $Comentario=$_POST['Comentario'];
        $IdAccion=$_POST['IdAccion'];
        $ObjeOcurrencia->AgregarOcurrencia($Comentario,$IdMiEmpresa,$IdUserCrea,$IdCliente,$IdAccion);
        break;
    case 'BuscarOcurrencia':
        echo $_POST['string'];
        break;
    case 'ModalReporte':
        require ('../View/ModalReporte.php');
        break;
    case 'BuscaVendedor':
        $like=$_POST['like'];
        $Consulta=$ObjeOcurrencia->BuscarVendedor($like);
        echo '<ul id="country-list" style="background-color:#eeeeee;text-decoration: none;list-style:none">';
           foreach($Consulta as $country) { ?>
            <li style="text-decoration: none;cursor: pointer;list-style:none" onClick="SeleccionaVendedor('<?php echo $country["Nombre"]; ?>','<?php echo $country["IdPersona"]; ?>');"><?php echo utf8_encode($country["Nombre"]); ?>
            </li>
            <?php } 
            
        break;
    case 'PosicionId':
            $ObjeOcurrencia->PosicionId(intval($_POST['IdOcurrencia']));
        break;
    case 'Agendar':
            $IdMuro=$_POST['id_muro'];
            $UrlCal=$_POST['link'];
            $IdUsuario=$_SESSION['IdPersona'];
            $ObjeOcurrencia->actualizaUrlCal($IdMuro,$UrlCal,$IdUsuario);
        break;
    default:
        // code...
        break;
}


?>
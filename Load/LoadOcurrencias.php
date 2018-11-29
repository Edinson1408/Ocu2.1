<?php 

class LazyLoad {
  private $link;
  public function __construct(){
    //include 'conexion.php';
   /* $this->link=mysqli_connect("localhost","root","desarrollo","");*/ 
    
    $this->link=mysqli_connect("localhost","desarrollo","Ant1g70@z1","");
    call_user_func(array($this,array_keys($_REQUEST)[0])); 
    
  }
    public  function get(){

    if(!isset($_REQUEST['start'])):
      $_REQUEST['start']=0;
    endif;

      session_start();
      $based=$_SESSION['bd'];
        
        if(isset($_REQUEST['FiltroEstado']))
        {
            echo $_REQUEST['FiltroEstado'];
        }
        
         $nivel_usurario=$_SESSION['JefeArea'];
    if ($nivel_usurario=='No' or $nivel_usurario=='Si' ) 
    {
        //$id_de_persona=$this->obtner_id_usuario_crea($_SESSION['LoginEmailValido'],$based); 
        $id_de_persona=$_SESSION['IdPersona'];
        
        $condicional_nivel=" and c.IdCliente in (select d.IdPersona from $based.empre_cliente d where d.IdPersonaVend='$id_de_persona') ";
    }

     $sql="SELECT b.nombre,a.*  from $based.muro a, $based.persona b where 
          a.FCrea=(select max(c.FCrea) from $based.muro c where a.IdCliente=c.IdCliente  $condicional_nivel)
          and a.IdCliente=b.IdPersona order by a.FCrea desc limit {$_REQUEST['start']},15";
          
     



    $request=mysqli_query($this->link,$sql);
    while($row=mysqli_fetch_object($request)):
    
     
      $row->nombre=utf8_encode(urldecode($row->nombre));
      $row->Comentario=utf8_encode($row->Comentario);
      //$row->CodOrg=utf8_encode($row->CodOrg);
      $row->FCrea=utf8_encode($row->FCrea);
      $row->IdCliente=utf8_encode($row->IdCliente);

    ?>

                    <div class="row sideBar-body buscar" >
                      <div class="col-sm-2 col-xs-2 sideBar-avatar">
                        <div class="avatar-icon">
       
                                <?php 
                              $imagenXd=$this->foto_logo($row->IdCliente,$based);
                             //foto s/n
                            $img="../../../Preferencias/$imagenXd/1/Imagenes/Logo.jpg";
                            if (file_exists($img)) { ?>
                             <?php   $rutaP= "<img src='../../Preferencias/$imagenXd/1/Imagenes/Logo.jpg'>"; ?>
                 <?php        }
                            else
                            { ?>

                           <?php   $rutaP=  "<img src='Public/Img/sinlogo.jpg'>"; ?>

                             

                 <?php           }
                                  ?>

                           
                                      <a class="dropdown-toggle"   data-toggle="dropdown"><?php echo $rutaP; ?></a>
                                  <ul class="dropdown-menu dropdown-menu-right" >
                                      <li>
                                          <a onclick="EstadoCliente(<?=$row->IdCliente?>)"  data-toggle="modal" data-target="#ModalEstado">
                                          <i class="glyphicon glyphicon-bookmark"></i> Estado 
                                          </a>
                                      </li>
                                       
                                       <li>
                                           <a  onclick="Encuestar('<?=$row->IdCliente?>','<?=urldecode(utf8_encode($row->nombre ));?>')" data-toggle="modal" data-target="#ModalEncuesta">
                                               <i class="glyphicon glyphicon-signal"></i> Encuesta
                                           </a>
                                        </li>
                                      <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/erpx/Componentes/c_socio_negocio/#!/detail/<?=$row->IdCliente?>" target="_blank"><i class="glyphicon glyphicon-user"></i> Datos Socio </a></li>
                                      <hr style="    margin-top: 0px;margin-bottom: 0px;border-top: 1px solid #075e54;">
                                      <li   onclick="ModalVendedor(<?php echo $row->IdCliente; ?>) " data-toggle="modal" data-target="#ModalVendedor">
                                      <center id='VendedorAsig<?php echo $row->IdCliente; ?>'><?php 
                                              $VendedorAsi=$this->ObtenerVendedorAsig($row->IdCliente,$based);
                                              echo  ($VendedorAsi=='')?'Sin Vendedor' : $VendedorAsi; ?>
                                      </center>
                                      </li>
                                      
                     
                                  </ul>


              
                         
                        </div>
                      </div>

                     <a onclick="CambiarVistas('HMensaje',<?=$row->IdCliente?>)"  style="text-decoration: none;"> <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                          <div class="col-sm-9 col-xs-9 sideBar-name" style="overflow: hidden;float: left;">
                            <span class="name-meta" style=""><?=$row->nombre; ?>
                          </span><br>
                     
                          <samp class="name-meta" id="UltimoMensaje<?=$row->IdCliente?>"> 
                            <?php  
                            /*$string=str_replace("<br />", "", $row->Comentario);
                             echo  str_replace("<br>", "",$string);*/
                             echo strip_tags($row->Comentario);
                           ?> </samp>
                          </div>
                          <div class="col-sm-2 col-xs-2 pull-right sideBar-time hidden-xs" style='float: left!important;'>
                            <span class="time-meta pull-right" style='float: left!important;' id='UltimoTime<?=$row->IdCliente?>'><?php 
                          
                                $date = date_create($row->FCrea);
                              echo date_format($date, 'd/m/y H:i'); ?>
                          </span>
                          </div>
                            </a>
                            <?php 
                                    $estadoM=$this->ObtenerEstado($row->IdCliente,$based);
                                    //echo  ($estadoM=='')?'SIN' : $string= substr($estadoM, 0, 3);
                                    
                                    
                            ?>
                           <div class="col-sm-1 col-xs-1  " onclick="filtroPorEstado('s');" style="padding: 10px !important">
                            <span class="badge" style="font-size: 13px;background-color:<?php echo  ($estadoM['Color']=='')?'#999' : $estadoM['Color']; ?>" id='EsTadoAbrebiatura<?=$row->IdCliente?>' >
                                        <?php 
                                        
                                        echo  ($estadoM['Desc']=='')?'SIN' : $estadoM['Desc'];
                                        ?>
                          </span>
                          </div>
                        </div>
                      </div>
                    </div>
                   


    <?php
//include '../includes/modal_editar_es2.php';
    //include '../includes/estadoenbuscador.php';
    endwhile;

    }
    
    public  function get2(){

    if(!isset($_REQUEST['start'])):
      $_REQUEST['start']=0;
    endif;

      session_start();
      $based=$_SESSION['bd'];
        
        if(isset($_REQUEST['FiltroEstado']))
        {
            echo $_REQUEST['FiltroEstado'];
        }
        
         $nivel_usurario=$_SESSION['JefeArea'];
    if ($nivel_usurario=='No' or $nivel_usurario=='Si' ) 
    {
        //$id_de_persona=$this->obtner_id_usuario_crea($_SESSION['LoginEmailValido'],$based); 
        $id_de_persona=$_SESSION['IdPersona'];
        
        $condicional_nivel=" and c.IdCliente in (select d.IdPersona from $based.empre_cliente d where d.IdPersonaVend='$id_de_persona') ";
    }

     $sql="SELECT b.nombre,a.*  from $based.muro a, $based.persona b where 
          a.FCrea=(select max(c.FCrea) from $based.muro c where a.IdCliente=c.IdCliente  $condicional_nivel)
          and a.IdCliente=b.IdPersona 
          and b.nombre like '%{$_REQUEST['string']}%'
          order by a.FCrea desc limit {$_REQUEST['start']},15";
          
     



    $request=mysqli_query($this->link,$sql);
    while($row=mysqli_fetch_object($request)):
    
     
      $row->nombre=utf8_encode(urldecode($row->nombre));
      $row->Comentario=utf8_encode($row->Comentario);
      //$row->CodOrg=utf8_encode($row->CodOrg);
      $row->FCrea=utf8_encode($row->FCrea);
      $row->IdCliente=utf8_encode($row->IdCliente);

    ?>

                    <div class="row sideBar-body buscar" >
                      <div class="col-sm-2 col-xs-2 sideBar-avatar">
                        <div class="avatar-icon">
       
                                <?php 
                              $imagenXd=$this->foto_logo($row->IdCliente,$based);
                             //foto s/n
                            $img="../../../Preferencias/$imagenXd/1/Imagenes/Logo.jpg";
                            if (file_exists($img)) { ?>
                             <?php   $rutaP= "<img src='../../Preferencias/$imagenXd/1/Imagenes/Logo.jpg'>"; ?>
                 <?php        }
                            else
                            { ?>

                           <?php   $rutaP=  "<img src='Public/Img/sinlogo.jpg'>"; ?>

                             

                 <?php           }
                                  ?>

                           
                                      <a class="dropdown-toggle"   data-toggle="dropdown"><?php echo $rutaP; ?></a>
                                  <ul class="dropdown-menu dropdown-menu-right" >
                                      <li>
                                          <a onclick="EstadoCliente(<?=$row->IdCliente?>)"  data-toggle="modal" data-target="#ModalEstado">
                                          <i class="glyphicon glyphicon-bookmark"></i> Estado 
                                          </a>
                                      </li>
                                       
                                       <li>
                                           <a  onclick="Encuestar('<?=$row->IdCliente?>','<?=urldecode(utf8_encode($row->nombre ));?>')" data-toggle="modal" data-target="#ModalEncuesta">
                                               <i class="glyphicon glyphicon-signal"></i> Encuesta
                                           </a>
                                        </li>
                                      <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/erpx/Componentes/c_socio_negocio/#!/detail/<?=$row->IdCliente?>" target="_blank"><i class="glyphicon glyphicon-user"></i> Datos Socio </a></li>
                                      <hr style="    margin-top: 0px;margin-bottom: 0px;border-top: 1px solid #075e54;">
                                      <li   onclick="ModalVendedor(<?php echo $row->IdCliente; ?>) " data-toggle="modal" data-target="#ModalVendedor">
                                      <center id='VendedorAsig<?php echo $row->IdCliente; ?>'><?php 
                                              $VendedorAsi=$this->ObtenerVendedorAsig($row->IdCliente,$based);
                                              echo  ($VendedorAsi=='')?'Sin Vendedor' : $VendedorAsi; ?>
                                      </center>
                                      </li>
                                      
                     
                                  </ul>


              
                         
                        </div>
                      </div>

                     <a onclick="CambiarVistas('HMensaje',<?=$row->IdCliente?>)"  style="text-decoration: none;"> <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                          <div class="col-sm-9 col-xs-9 sideBar-name" style="overflow: hidden;float: left;">
                            <span class="name-meta" style=""><?=$row->nombre; ?>
                          </span><br>
                     
                          <samp class="name-meta" id="UltimoMensaje<?=$row->IdCliente?>"> 
                            <?php  
                            /*$string=str_replace("<br />", "", $row->Comentario);
                             echo  str_replace("<br>", "",$string);*/
                             echo strip_tags($row->Comentario);
                           ?> </samp>
                          </div>
                          <div class="col-sm-2 col-xs-2 pull-right sideBar-time hidden-xs" style='float: left!important;'>
                            <span class="time-meta pull-right" style='float: left!important;' id='UltimoTime<?=$row->IdCliente?>'><?php 
                          
                                $date = date_create($row->FCrea);
                              echo date_format($date, 'd/m/y H:i'); ?>
                          </span>
                          </div>
                            </a>
                            <?php 
                                    $estadoM=$this->ObtenerEstado($row->IdCliente,$based);
                                    //echo  ($estadoM=='')?'SIN' : $string= substr($estadoM, 0, 3);
                                    
                                    
                            ?>
                           <div class="col-sm-1 col-xs-1  " onclick="filtroPorEstado('s');" style="padding: 10px !important">
                            <span class="badge" style="font-size: 13px;background-color:<?php echo  ($estadoM['Color']=='')?'#999' : $estadoM['Color']; ?>" id='EsTadoAbrebiatura<?=$row->IdCliente?>' >
                                        <?php 
                                        
                                        echo  ($estadoM['Desc']=='')?'SIN' : $estadoM['Desc'];
                                        ?>
                          </span>
                          </div>
                        </div>
                      </div>
                    </div>
                   


    <?php
//include '../includes/modal_editar_es2.php';
    //include '../includes/estadoenbuscador.php';
    endwhile;

    }
    
    public function get3()
    {
        $where = '';
        if(isset($_REQUEST['IdPersonaR']) && $_REQUEST['IdPersonaR'] != ''){
            $where = ' and p.IdPersona='.$_REQUEST['IdPersonaR']." ";
        }
        // print_r($_REQUEST);exit;
        if(isset($_REQUEST['IdPersonaV']) && $_REQUEST['IdPersonaV'] != ''){
            $where.=' and ven.IdPersona = '.$_REQUEST['IdPersonaV'];
        }
        
        if(isset($_REQUEST['checkTodosVendedores']) && $_REQUEST['checkTodosVendedores'] == 2){
            $where.=' and ven.IdPersona is null ';
        }
         
        if(isset($_REQUEST['Estatus']) && $_REQUEST['Estatus']=='Todos'){
            $estatus = ' ';
        }else if (preg_match("/99/i",$_REQUEST['Estatus'])) { 
            echo $cam     = substr($_REQUEST['Estatus'], 3);
            //$orc     = ($cam=='') ? "" : " or ma.IdMaestro IN (".$cam.") ";
            $orc     = ($cam=='') ? "" : "  ma.IdMaestro IN (".$cam.") ";
            //$estatus = " and ma.IdMaestro is null ".$orc." ";
            $estatus = " and  ".$orc." ";
        }else{
            $estatus = ' and ma.IdMaestro IN ('.$_REQUEST['Estatus'].')';
        }
        
        
        /*XD aqui tendremos quye poner los limites XD*/
         if($_REQUEST['start']=='undefined'):
         $_REQUEST['start']=0;
            endif;

          session_start();
          $based=$_SESSION['bd'];
        
           
            
        //  $nivel_usurario=$_SESSION['JefeArea'];
        //     if ($nivel_usurario=='No' or $nivel_usurario=='Si' ) 
        //     {
        //         //$id_de_persona=$this->obtner_id_usuario_crea($_SESSION['LoginEmailValido'],$based); 
        //         $id_de_persona=$_SESSION['IdPersona'];
                
        //         $condicional_nivel=" and c.IdCliente in (select d.IdPersona from $based.empre_cliente d where d.IdPersonaVend='$id_de_persona') ";
        //     }
        /*fin de las limites*/
         $sqlclientes = "select ma.DescripCorta as Estatus,ifnull(ma.AuxDet1,'#fff') color,p.IdPersona,p.Nombre,  ifnull(ven.Nombre,'No Asignado') as vendedor,max(m.FCrea) FCrea from $based.muro m left join $based.persona p on (m.IdCliente = p.IdPersona) left join $based.empre_cliente ecli on (p.IdPersona = ecli.Idpersona) left join $based.persona ven on (ecli.IdPersonaVend = ven.IdPersona) left join $based.ma00 ma on (ecli.Estatus = ma.IdMAestro and ma.IdMiEmpresa = 1) WHERE date_format(m.FCrea,'%Y-%m-%d') BETWEEN '".$_REQUEST['dtpFechaIni']."' AND '".$_REQUEST['dtpFechaFin']."' $where $estatus and p.IdPersona is not null group by p.IdPersona order by max(m.FCrea) ".$_REQUEST['ordenamiento']."     limit {$_REQUEST['start']},15";
         
        $rescli = mysqli_query($this->link,$sqlclientes);
        
         if(isset($_REQUEST['DescIdNodo1']) && $_REQUEST['DescIdNodo1'] != ''){ $grupo = $_REQUEST['DescIdNodo1']; }else{$grupo = "Todos";}
        $where = '';
        while($data = $rescli->fetch_object()){
        $where = ' where p.IdPersona='.$data->IdPersona.' ';
        $sql2="SELECT * FROM (SELECT IdCliente as IdPersona,Comentario as ComentarioCompleto, 
               (select Nombre from $based.persona where IdPersona=(select IdPersona from $based.usuarios_skynet where IdUsuario=muro.IdUserCrea))as NomUserCrea,
               (select Nombre from $based.persona where IdPersona=muro.IdCliente) as NombreSocio,
               FCrea, DocOrigen,origen FROM $based.muro WHERE date_format(FCrea,'%Y-%m-%d') BETWEEN '".$_REQUEST['dtpFechaIni']."' AND '".$_REQUEST['dtpFechaFin']."')  p $where ORDER BY p.FCrea ".$_REQUEST['ordenamiento']."  limit 1";
        $res = mysqli_query($this->link,$sql2);
        while ($key14=mysqli_fetch_array($res))
        {
        
         ?>

                    <div class="row sideBar-body buscar" >
                      <div class="col-sm-2 col-xs-2 sideBar-avatar">
                        <div class="avatar-icon">
       
                                <?php 
                              $imagenXd=$this->foto_logo($key14['IdPersona'],$based);
                             //foto s/n
                            $img="../../../Preferencias/$imagenXd/1/Imagenes/Logo.jpg";
                            if (file_exists($img)) { ?>
                             <?php   $rutaP= "<img src='../../Preferencias/$imagenXd/1/Imagenes/Logo.jpg'>"; ?>
                 <?php        }
                            else
                            { ?>

                           <?php   $rutaP=  "<img src='Public/Img/sinlogo.jpg'>"; ?>

                             

                 <?php           }
                                  ?>

                           
                                      <a class="dropdown-toggle"   data-toggle="dropdown"><?php echo $rutaP; ?></a>
                                  <ul class="dropdown-menu dropdown-menu-right" >
                                      <li>
                                          <a onclick="EstadoCliente(<?=$key14['IdPersona']?>)"  data-toggle="modal" data-target="#ModalEstado">
                                          <i class="glyphicon glyphicon-bookmark"></i> Estado 
                                          </a>
                                      </li>
                                       
                                       <li>
                                           <a  onclick="Encuestar('<?=$key14['IdPersona']?>','<?=urldecode(utf8_encode($key14['NombreSocio']));?>')" data-toggle="modal" data-target="#ModalEncuesta">
                                               <i class="glyphicon glyphicon-signal"></i> Encuesta
                                           </a>
                                        </li>
                                      <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/erpx/Componentes/c_socio_negocio/#!/detail/<?=$key14['IdPersona']?>" target="_blank"><i class="glyphicon glyphicon-user"></i> Datos Socio </a></li>
                                      <hr style="    margin-top: 0px;margin-bottom: 0px;border-top: 1px solid #075e54;">
                                      <li   onclick="ModalVendedor(<?php echo $key14['IdPersona']; ?>) " data-toggle="modal" data-target="#ModalVendedor">
                                      <center id='VendedorAsig<?php echo $key14['IdPersona']; ?>'><?php 
                                              $VendedorAsi=$this->ObtenerVendedorAsig($key14['IdPersona'],$based);
                                              echo  ($VendedorAsi=='')?'Sin Vendedor' : $VendedorAsi; ?>
                                      </center>
                                      </li>
                                      
                     
                                  </ul>


              
                         
                        </div>
                      </div>

                     <a onclick="CambiarVistas('HMensaje',<?=$key14['IdPersona']?>)"  style="text-decoration: none;"> <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                          <div class="col-sm-9 col-xs-9 sideBar-name" style="overflow: hidden;float: left;">
                            <span class="name-meta" style=""><?=$key14['NombreSocio']; ?>
                          </span><br>
                     
                          <samp class="name-meta" id="UltimoMensaje<?=$key14['IdPersona']?>"> 
                            <?php  
                            /*$string=str_replace("<br />", "", $row->Comentario);
                             echo  str_replace("<br>", "",$string);*/
                             echo strip_tags($key14['ComentarioCompleto']);
                           ?> </samp>
                          </div>
                          <div class="col-sm-2 col-xs-2 pull-right sideBar-time hidden-xs" style='float: left!important;'>
                            <span class="time-meta pull-right" style='float: left!important;' id='UltimoTime<?=$key14['IdPersona']?>'><?php 
                          
                                $date = date_create($key14['FCrea']);
                              echo date_format($date, 'd/m/y H:i'); ?>
                          </span>
                          </div>
                            </a>
                            <?php 
                                    $estadoM=$this->ObtenerEstado($key14['IdPersona'],$based);
                                    //echo  ($estadoM=='')?'SIN' : $string= substr($estadoM, 0, 3);
                                    
                                    
                            ?>
                           <div class="col-sm-1 col-xs-1  " onclick="filtroPorEstado('s');" style="padding: 10px !important">
                            <span class="badge" style="font-size: 13px;background-color:<?php echo  ($estadoM['Color']=='')?'#999' : $estadoM['Color']; ?>" id='EsTadoAbrebiatura<?=$key14['IdPersona']?>' >
                                        <?php 
                                        
                                        echo  ($estadoM['Desc']=='')?'SIN' : $estadoM['Desc'];
                                        ?>
                          </span>
                          </div>
                        </div>
                      </div>
                    </div>
                   


    <?php
        
        
        
        
        }    
        
        
        
    }
     
    }

    
    public function foto_logo($id_persona,$base)
    {
      $mysql="SELECT a.Nombre,b.CodOrg from $base.persona a left join controlx.organizaciones b on a.numDoc=b.Ruc
                where a.IdPersona='$id_persona'";

      $request=mysqli_query($this->link,$mysql);
        while($res=mysqli_fetch_array($request))
        {
          $a=$res['1'];
        }
        return $a; 
    }
    
    public function ObtenerVendedorAsig($idPersona,$base)
    {
        $sqlVA="SELECT a.Nombre FROM $base.persona a ,$base.empre_cliente b where a.IdPersona=b.IdPersonaVend
        and b.IdPersona='$idPersona' ";
        $res=mysqli_query($this->link,$sqlVA);
        $r=mysqli_fetch_object($res);
        return utf8_encode($r->Nombre);
        
    }
    
    
    public function ObtenerEstado($idPersona,$base)
    {
        $sql1="SELECT ma.DescripCorta descripEstatus, ecli.Estatus IdEstatus ,ma.AuxDet1,ma.AuxDet2
        from $base.empre_cliente ecli join $base.ma00 ma on (ma.IdMaestro = ecli.Estatus) WHERE IdPersona LIKE '$idPersona'"; 
        $res=mysqli_query($this->link,$sql1);
        $r=mysqli_fetch_object($res);
        //return $r->descripEstatus;
        /*SELECT * FROM ma00 where IdMiEmpresa='1' AND IdGrupo='55'*/
                 $Array=array('Color'=>$r->AuxDet1,'Desc'=>$r->AuxDet2);
                 return $Array;
         
    }
    
     public function estado($id_persona,$base)
    {
            $MIEMPRESA=$_SESSION["IdMiEmpresaPrincipal"];
            if (isset($id_persona)) //verifica si le eviar parametros XD
            {
                $sql1="SELECT ma.DescripCorta descripEstatus, ecli.Estatus IdEstatus from $base.empre_cliente ecli join $base.ma00 ma on (ma.IdMaestro = ecli.Estatus) WHERE IdPersona LIKE '$id_persona'"; 

                 $request1=mysqli_query($this->link,$sql1);


                while ($resul=mysqli_fetch_array($request1)) 
                {
                    $EstadoActual=$resul['1'];
                }

                if ($EstadoActual=='99')//significa que es estado no asignado 
                {       
                         //por el moento comentare esta session , cuando este en produccion descomentar $_SESSION["IdMiEmpresaPrincipal"];
                        $sql2="SELECT '' IdGrupo ,'99' IdMaestro ,'SIN ESTATUS' DescripCorta UNION ALL SELECT IdGrupo, IdMaestro, DescripCorta FROM $base.ma00 Where IdGrupo=55 AND IdMiEmpresa='".$_SESSION["IdMiEmpresaPrincipal"]."'";
                         $request2=mysqli_query($this->link,$sql2);

                          while ($res2=mysqli_fetch_array($request2)) 
                          {
                              echo "<option value='".$res2['1']."' data-initial='".utf8_encode($res2['2'])."'>".utf8_encode($res2['2'])."</option>";
                          }
                }
                else
                {
                  
                  $sql3="SELECT IdGrupo, IdMaestro, DescripCorta, AuxDet2  FROM $base.ma00 Where IdGrupo=55 
                          AND IdMiEmpresa='$MIEMPRESA' and IdMaestro='$EstadoActual'
                          UNION ALL 
                          SELECT '' IdGrupo ,'99' IdMaestro ,'SIN ESTATUS' ,''
                          UNION ALL
                          SELECT IdGrupo, IdMaestro, DescripCorta , AuxDet2 FROM $base.ma00 Where IdGrupo=55 
                          AND IdMiEmpresa='$MIEMPRESA' and  not IdMaestro='$EstadoActual'";

                    $request3=mysqli_query($this->link,$sql3);

                        while ($res3=mysqli_fetch_array($request3)) 
                          {
                               echo "<option data_auxiliar='".$res3['3']."' value='".$res3['1']."' data-initial='".utf8_encode($res3['2'])."' >".urldecode(utf8_encode($res3['2']))."</option>";
                          }

                }

                   
            }
    }


    
}

switch ($_REQUEST['Accion']) {
    case 'CargaInicias':
        $boje=new LazyLoad();
        $boje->get();
        break;
    case 'BusquedaContactos':
        $boje=new LazyLoad();
        $boje->get2();
        break;
    case 'Filtros':
        $boje=new LazyLoad();
        $boje->get3();
        break;
    default:
        // code...
        break;
}


 ?>
<?php 
/**
 *Clase para las ocurrencias que extendera la conexion
 */
class  Ocurrencias
{
  var  $conexion ;  
    /**
     * 
     */
    public function __construct($Link)
    {
        $this->conexion=$Link;
        // code...
    }
    
    public function CabeceraOcurrencias($IdCliente)
    {
        
      $Sql="SELECT a.*,b.CodOrg FROM persona a left join controlx.organizaciones b on a.numDoc=b.Ruc
                where a.IdPersona='$IdCliente'";
		return mysqli_query($this->conexion,$Sql);
    }
    
    public function ListaEstados($id_persona)
    {
        $Select='';
         $MIEMPRESA=$_SESSION["IdMiEmpresaPrincipal"];
            if (isset($id_persona)) //verifica si le eviar parametros XD
            {
                $sql1="SELECT ma.DescripCorta descripEstatus, ecli.Estatus IdEstatus from empre_cliente ecli join ma00 ma on (ma.IdMaestro = ecli.Estatus) WHERE IdPersona LIKE '$id_persona'"; 

                 $request1=mysqli_query($this->conexion,$sql1);


                while ($resul=mysqli_fetch_array($request1)) 
                {
                    $EstadoActual=$resul['1'];
                }

                if ($EstadoActual=='99')//significa que es estado no asignado 
                {       
                         //por el moento comentare esta session , cuando este en produccion descomentar $_SESSION["IdMiEmpresaPrincipal"];
                        $sql2="SELECT '' IdGrupo ,'99' IdMaestro ,'SIN ESTATUS' DescripCorta UNION ALL SELECT IdGrupo, IdMaestro, DescripCorta FROM ma00 Where IdGrupo=55 AND IdMiEmpresa='".$_SESSION["IdMiEmpresaPrincipal"]."'";
                         $request2=mysqli_query($this->conexion,$sql2);

                          while ($res2=mysqli_fetch_array($request2)) 
                          {
                              $Select.="<option value='".$res2['1']."' data-initial='".utf8_encode($res2['2'])."'>".utf8_encode($res2['2'])."</option>";
                          }
                }
                else
                {
                  
                  $sql3="SELECT IdGrupo, IdMaestro, DescripCorta, AuxDet2  FROM ma00 Where IdGrupo=55 
                          AND IdMiEmpresa='$MIEMPRESA' and IdMaestro='$EstadoActual'
                          UNION ALL 
                          SELECT '' IdGrupo ,'99' IdMaestro ,'SIN ESTATUS' ,''
                          UNION ALL
                          SELECT IdGrupo, IdMaestro, DescripCorta , AuxDet2 FROM ma00 Where IdGrupo=55 
                          AND IdMiEmpresa='$MIEMPRESA' and  not IdMaestro='$EstadoActual'";

                    $request3=mysqli_query($this->conexion,$sql3);

                        while ($res3=mysqli_fetch_array($request3)) 
                          {
                                $Select.= "<option data_auxiliar='".$res3['3']."' value='".$res3['1']."' data-initial='".utf8_encode($res3['2'])."' >".urldecode(utf8_encode($res3['2']))."</option>";
                          }

                }

                   
            }
            
            return  $Select;
    }
    
    public function ActualizarEstado($IdCliente,$IdEstado)
	{
	    $Sql="UPDATE  empre_cliente  set Estatus='$IdEstado'  where IdPersona='$IdCliente'";
		mysqli_query($this->conexion,$Sql);
		
		$sql1="SELECT ma.DescripCorta descripEstatus, ecli.Estatus IdEstatus ,ma.AuxDet1,ma.AuxDet2
        from empre_cliente ecli join ma00 ma on (ma.IdMaestro = ecli.Estatus) WHERE IdPersona LIKE '$IdCliente'"; 
        $res=mysqli_query($this->conexion,$sql1);
        $r=mysqli_fetch_object($res);
        $Array=array('Color'=>$r->AuxDet1,'Desc'=>$r->AuxDet2);
        echo json_encode($Array);
        
	}
	
	public function ListaVendedores($IdCliente)
    {
        //listemos lo que exites si no que selecciones
        
        
         $Sql="SELECT a.IdPersona,a.Nombre FROM persona a ,empre_cliente b where a.IdPersona=b.IdPersonaVend
        and b.IdPersona='$IdCliente' ";
        $res=mysqli_query($this->conexion,$Sql);
        $r=mysqli_fetch_object($res);
        
        
        if ($r->Nombre==null or $r->Nombre=='0' or $r->Nombre==''){
            
            $SqlV="SELECT '0' AS IdPersona , 'Seleccione un Vendedor' as Nombre
                union all
                SELECT A.IdPersona,A.Nombre FROM persona  A LEFT JOIN vendedores B ON A.IDPERSONA=B.IDPERSONA
                where A.TIPOVENDEDOR=1";
                return mysqli_query($this->conexion,$SqlV);
        }
        else
        {
              $SqlV="SELECT a.IdPersona,a.Nombre FROM persona a ,empre_cliente b where a.IdPersona=b.IdPersonaVend 
                    and a.TIPOVENDEDOR=1
                    and b.IdPersona='$IdCliente' 
                    union all
                    SELECT a.IdPersona,a.Nombre FROM persona a  where  a.TIPOVENDEDOR=1 
                    and a.IdPersona!=(select IdpersonaVend from empre_cliente where IdPersona='$IdCliente') 
                    ";
                   return mysqli_query($this->conexion,$SqlV);   
        }
         
    }
    
    public function ActualizaVendedor($IdPersona,$IdVendedor)
    {
        $sql="update empre_cliente set  IdPersonaVend='$IdVendedor' where IdPersona='$IdPersona' ";
        mysqli_query($this->conexion,$sql);
        
        $SqlNVendedor="Select Nombre from persona WHERE IdPersona='$IdVendedor'";
        $res=mysqli_query($this->conexion,$SqlNVendedor);
        $r=mysqli_fetch_object($res);
        echo $r->Nombre;
        
        
    }

    public function MostrandoOcurrencia($IdOcurrencia)
    {
       $Sql="SELECT a.IdMuro,a.comentario,a.FCrea ,a.DocOrigen,a.IdUserCrea,a.IdMiEmpresa,a.Origen,a.url_cal FROM muro a
       WHERE a.IdMuro='$IdOcurrencia'";
       $res=mysqli_query($this->conexion,$Sql);
       return $r=mysqli_fetch_object($res);
    }
    public function Mensaje_a_enviar($IdMuro)
    {
         $sql5="SELECT a.IdUserCrea , b.IdUsuario,b.IdPersona,c.IdPersona , b.EmailUsuario as email,c.Login,c.Nombre,a.IdCliente,(select p.nombre from persona p where p.IdPersona=a.IdCliente)
                from muro a, usuarios_skynet b, persona c where a.IdUserCrea=b.IdUsuario and b.IdPersona=c.IdPersona and a.IdMuro =  '$IdMuro';";
    
            $request5=mysqli_query($this->conexion,$sql5);
            while ($res5=mysqli_fetch_array($request5))
             { 
                $corr1=$res5['4'];
                $corr2=$res5['5'];
                $nombre_persona=$res5['6'];
                $nom_empresa=$res5['8'];
               }
    
               return array($nombre_persona, $nom_empresa, $corr1,$corr2);
    
             
    
    
    }
    
    public function encryptx($string, $key) 
    {
       $result = '';
             for($i=0; $i<strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char)+ord($keychar));
                $result.=$char;
             }
          return base64_encode($result);
    }
    
    public function  docuemto_electronico($tipodoc,$IdDoc)
    {
        session_start();
    
            $idtabla  = ($tipodoc=='1' || $tipodoc=='3') ? ' IdComprobante' : 'IdNota';
            $tabla    = ($tipodoc=='1' || $tipodoc=='3') ? ' comprobante_venta' : 'notas';
    
             $sqlsI = "SELECT  cv.".$idtabla." as IdComprobante ,TipoDoc, cv.IdMiEmpresa, cv.IdMiSede, cv.NomCliente,  cv.EstadoEFAC , CONCAT(cv.Serie, '-', cv.NumDoc) as Num_Factura,  cv.XML, cv.FCrea , cv.Igv, cv.simboloMoneda, cv.Total ,cv.ContactoCliente FROM  ".$_SESSION['bd'].".".$tabla." cv WHERE  cv.EstadoEFAC = '1' and cv.".$idtabla."=$IdDoc";
            $infoI = mysqli_fetch_assoc(mysqli_query($this->conexion, $sqlsI));
     
    
            // END GET DATOS PRINCIPALES
            /*NUEVA URL ORGANIZACIÓN */
            $sqlp               = "SELECT * FROM controlx.organizaciones WHERE CodOrg ='".$_SESSION['CodigoOrganizacion']."'";
            $resultado          = mysqli_query($this->conexion, $sqlp);
            $row45              = mysqli_fetch_assoc($resultado);
            $codigo_org         = $row45['IdOrg'];
            
            $org= $_SESSION['CodigoOrganizacion'];
            $orgx=  $this->encryptx($org, 'Greed');
            $IdDocx = $this->encryptx($IdDoc, 'Greed');
            $Tipodoc = $this->encryptx($infoI['TipoDoc'], 'Greed');
            //$IdDoc = encrypt($_SERVER['HTTP_HOST']."-".$IdDoc, 'Greed');
            return $hrefI="http://fac.gestionx.com/?e=".$infoI['IdMiEmpresa'].'.'.$codigo_org.'&p='.$Tipodoc."and".urlencode($IdDocx)."andsky".$orgx."skyTal";
            //$hrefII = "http://fac.gestionx.com/?d=1.56&p=lQ==andln6kandskyx7Dm187cq9fS1A==skyTal&pdf=1";
    
    }
    
    public function ActualizaOcurrencia($IdOcurrencia,$Comentario,$IdMaestro)
    {
        $ocudescripcion=addslashes(utf8_decode($Comentario));
		$ocudescripcion2 = str_replace(array("\r\n", "\r", "\n"), "<br />", $ocudescripcion);
				
        $Sql="UPDATE muro 
				set Comentario='$ocudescripcion2',
				IdAccionO='$IdMaestro'
				where IdMuro='$IdOcurrencia';";
				mysqli_query($this->conexion,$Sql);
        
        
			
    }
    public function EliminaOcurrencia($IdOcurrencia)
    {
        $Sql="Delete from muro where IdMuro='$IdOcurrencia'";
        mysqli_query($this->conexion,$Sql);
    }
    
    public function ListaAcciones()
    {
           $sql=" SELECT IdMaestro,DescripCorta,AuxDet1 FROM ".$base.".ma00 where IdMiEmpresa='1' AND IdGrupo='1012' ORDER by IdMaestro";
            return mysqli_query($this->conexion,$sql);  
    }
    
    public function AgregarOcurrencia($comentario,$IdMiEmpresa,$IdUserCrea,$IdCliente,$IdAccion)
    {
        $ocudescripcion=addslashes(utf8_decode($comentario));
	    $ocudescripcion2 = str_replace(array("\r\n", "\r", "\n"), "<br />", $ocudescripcion);
	    $Sql=	"INSERT INTO muro (IdMiEmpresa,IdCliente,Padre,Comentario,Tipo,IdUserCrea,FCrea,IdAccionO) 
		VALUES ($IdMiEmpresa,$IdCliente,0,'$ocudescripcion2',1,$IdUserCrea,sysdate(),'$IdAccion');";
		mysqli_query($this->conexion,$Sql);
		$MaxId=mysqli_insert_id($this->conexion);
		$SqlO="SELECT a.Idmuro ,a.Comentario,a.FCrea,
		        (SELECT AuxDet1  FROM ma00 WHERE IdMaestro =(SELECT IdAcciono FROM muro where IdMuro='$MaxId')) as Icon  
		        FROM muro a where a.IdMuro='$MaxId'";
		$res=mysqli_query($this->conexion,$SqlO);
		$r=mysqli_fetch_object($res);
		$NewOcurrencia=array('IdMuro'=>$r->Idmuro,
		'Comentario'=>$r->Comentario,
		'FCrea'=>$r->FCrea,
		'Icon'=>$r->Icon,
		'IdCliente'=>$IdCliente);
		echo json_encode($NewOcurrencia);
		
		
    }
    
    public function BuscarVendedor($Like)
    {
        $Sql="SELECT A.* FROM  persona  A LEFT JOIN vendedores B ON A.IDPERSONA=B.IDPERSONA
             WHERE A.TIPOVENDEDOR=1 and  A.Nombre like '%".$Like."%' limit 6";
        return mysqli_query($this->conexion,$Sql);
        
        //   $sql=$this->conexion->query("SELECT A.* FROM ".$base.".persona  A LEFT JOIN vendedores B ON A.IDPERSONA=B.IDPERSONA
        //   where A.TIPOVENDEDOR=1 and  A.Nombre like '%".$buscar_n."%' limit 6");
      
        //       return $this->sql($sql);
    
    }
    
    public function PosicionId($IdOcurrencia)
    {
        $Sql="SELECT IdCliente FROM muro where IdMuro='$IdOcurrencia';";
        $r=mysqli_query($this->conexion,$Sql);
        $res=mysqli_fetch_object($r);
        $SqlMuro="SELECT * FROM muro where IdCLiente=".$res->IdCliente."   order by  FCrea desc";
        $rrr=mysqli_query($this->conexion,$SqlMuro);
        $c=0;
        $Posi=0;
        while($resp=mysqli_fetch_array($rrr))
        {
            if($resp['IdMuro']==$IdOcurrencia){$Posi=$c;}
            $c++;
        }
   
        echo json_encode(array('IdPersona'=>$res->IdCliente,'Posicion'=>$Posi));
        
    }
    public function actualizaUrlCal($IdMuro,$UrlCal,$IdUsuario)
    {
        $link1=urlencode($UrlCal);
        $Sql="INSERT into  historial_calendar values ('','$IdMuro','$IdUsuario','$link1','descripcion') ;";
        mysqli_query($this->conexion,$Sql);
        $html=$this->refreshCalenario($IdMuro);
        echo json_encode(array('IdMuro'=>$IdMuro,'HTML'=>$html));
    }
    
    public function refreshCalenario($IdMuro){
        $sql_cal="SELECT a.*,b.Nombre from historial_calendar a, persona b  where a.idUserCreaCal=b.IdPersona and a.idMuro='$IdMuro';";
        $request_cal=mysqli_query($this->conexion,$sql_cal);
        $html='';
        while ($res5=mysqli_fetch_array($request_cal))
         { 
            $html.= '<br>Agendado por : ';
            $html.=$res5['5'];
            $html.="&nbsp<i class='glyphicon glyphicon-calendar' onclick=(abrir_cal(".$res5['2'].",'".urldecode($res5[3])."'))></i>";
             
         }
         
        return $html;
    }
    
}

?>
NewComentario=(Obj)=>
{
    
    $Obj=Obj;
    
    
    let comentarioloco=`
    <div class="row message-body" data-id="${$Obj.IdMuro}">
    <div class="col-sm-12 message-main-receiver" id="OcurrenciasH${$Obj.IdMuro}">
  <div class="receiver">
    <div class="message-text">               
        <a class="dropdown"></a>
        <a class=" dropdown-toggle" type="button" data-toggle="dropdown">
          <img src="https://thumbs.dreamstime.com/b/icono-an%C3%B3nimo-del-usuario-89671074.jpg" class="img-circle" style="width: 50px;height: 50px;cursor: pointer">
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="calendario_index1.php?text=HIDROCORTE+PERU+S.A.C.&amp;dates=20181114T141500/20181114T151500&amp;details=asdasdasdas&amp;id_muro=${$Obj.IdMuro}&amp;" onclick="window.open(this.href, 'mywin','left=20,top=20,width=800,height=600,toolbar=1,resizable=0'); return false;" width="800px" height="600px"><i class="glyphicon glyphicon-list-alt"></i> Calendario</a>
            </li>   
            <li>
                <a onclick="ModalEditarOcurrencia(${$Obj.IdMuro});" data-toggle="modal" data-target="#ModalEditarOcurrencia">
                  <i class="glyphicon glyphicon-pencil"></i>  Editar 
                </a>
            </li>
            <li>
                <a class="delete" onclick="EliminaOcurrencia(${$Obj.IdMuro})"><i class="glyphicon glyphicon-trash"></i>  Eliminar   </a>
            </li>
            <li>
                <a onclick="ModalCorreos(${$Obj.IdMuro},${$Obj.IdCliente})" data-toggle="modal" data-target="#ModalCorreos">
                  <i class="glyphicon glyphicon-envelope"></i> Enviar 
                </a>
            </li>                   
        </ul>
          <input type="" name="" value="${$Obj.IdMuro}" id="edis" style="visibility: hidden;width: 0px;" />

        <span id="mensaje" class="mensaje${$Obj.IdMuro}">
                     (${$Obj.IdMuro}) ${$Obj.Comentario}                                   
          <div id="documento_completo_${$Obj.IdMuro}" onclick="clickdocumento('', '',1,'')" style="display:inline; cursor:pointer">
                <span><!--aqui pondre las cosas de los agendaciones--> </span>
          </div>                    
        </span>
            <span class="message-time pull-right">
            <i class="material-icons">
            ${$Obj.Icon}
            </i>
            ${$Obj.FCrea}
            </span>
    </div>        
  </div>                
</div>
</div>`;
return comentarioloco;
}
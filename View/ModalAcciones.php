
    <div class = "modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <center><h3 class = ""> <i class = "glyphicon glyphicon-pencil"> </i>  Acciones Ocurrencias </h3></center>
    </div>
    <form class="form-inline" name="FormularioAcciones" id="FormularioAcciones" method="post">
        <div class="modal-body" style="text-align: center;">
            <input type="hidden" name='IdPersonaAccion' value="<?php echo $IdPersona; ?>">
            
            <?php
                
                foreach($Acciones as $vendedores) {
                    ?>
                    <i class="tooltip2" style="cursor:pointer" onclick="GuardarAccion(<?=$vendedores['IdMaestro']?>);" >
                    <i class='material-icons zoomIt' style="font-size:48px;margin:3px;"><?=$vendedores['AuxDet1']?></i>
                    <i class="visible-xs" style="font-size:12px"><?=utf8_encode($vendedores['DescripCorta'])?></i>
                    <span class="tooltiptext2"><?=utf8_encode($vendedores['DescripCorta'])?></span>
                    </i>
                    <input type='hidden' value='<?=$vendedores['AuxDet1']?>' id='NomIcon<?=$vendedores['IdMaestro']?>'>
                    <?php
                   
                  
                    } ?>
            <!--<select id="IdAccion" class="form-control" name="IdAccion">-->
              
            <!--</select>-->
            
        </div>
        <div class="modal-footer">
         <!-- <button type="button" class="btn btn-default" data-dismiss="modal" ><span class = "glyphicon glyphicon-remove"></span> </button> | <button type="button" class=" btn btn-success" data-dismiss="modal"  value="<?php ///echo $Id_cliente;?>"  onclick="GuardarAccion();"><span class = "glyphicon glyphicon-floppy-disk"></span> </button>-->
        </div>
    </form>




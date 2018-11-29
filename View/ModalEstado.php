<div class = "modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <center>
              <h3 class = ""> <i class = "glyphicon glyphicon-pencil"> </i>   Cambiar estado</h3>
          </center>
</div>
    <form class="form-inline" id='FormEstado' name="FormEstado">
        <input type="hidden" name="IdCliente" id="IdCliente" value="<?=$IdCliente?>">
        <div class="modal-body">
            <select id="IdEstado" name="IdEstado" class="form-control">
                <?php echo $res;  ?> 
            </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><span class = "close_modal glyphicon glyphicon-remove"></span> </button> | 
          <button type="button" class="updatestatus btn btn-success" onclick="GuardarEstado(<?=$IdCliente?>);"><span class = "glyphicon glyphicon-floppy-disk"></span> </button>
        </div>
    </form>

  



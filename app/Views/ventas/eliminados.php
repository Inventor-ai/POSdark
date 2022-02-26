<div class="row mt-4">
  <div class="col-12 col-sm-8">
      <h4 class=""><?=$title?></h4>
  </div>
  <div class="col-12 col-sm-4 text-right" style="text-align:right">
    <a href="<?=base_url()."/$path/index/"?>" 
       class="btn btn-<?=($onOff == 0?"primary":"warning")?>"><?=$switch?>
    </a>
  </div>
</div>
<div class="mt-3">
  <table id="datatablesSimple">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Folio</th>
        <th>Cajero</th>
        <th>Cliente</th>
        <th>Total</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Fecha</th>
        <th>Folio</th>
        <th>Cajero</th>
        <th>Cliente</th>
        <th>Total</th>
        <th class="text-center">Acciones</th>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach($data as $dato) {
          // $info = $dato['folio'] 
          //       . " del ". $dato['fecha_alta'] 
          //       . " de $"
          //       . number_format($dato['total'], 2, ".", ",");
          $info = $dato['folio'] . " de $"
                . number_format($dato['total'], 2, ".", ",");
      ?>
        <tr>
          <td><?=$dato['fecha_alta']?></td>
          <td><?=$dato['folio']?></td>
          <td><?=$dato['cajero']?></td>
          <td><?=$dato['cliente']?></td>
          <td class="text-end">
              <?="$ ".number_format($dato['total'], 2, ".", ",")?>
          </td>
          <td class="text-center">
            <a href="<?=base_url()."/$path/muestraTicket/".$dato['id']?>"
              class="btn btn-primary"><i class="fas fa-file-alt"></i>
            </a>
          </td>
        </tr>  
      <?php }?>
    </tbody>
  </table>
</div>

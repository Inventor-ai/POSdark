<?php 
//   $this->include('./includes/footer.php'); // Works ok
?>
<div class="row mt-3">
  <div class="col-12 col-sm-4">
    <div class="card text-white bg-primary mb-3">
      <!-- <div class="card-header">Total artículos</div> -->
      <div class="card-body">
        <p class="card-text">
          Total artículos: <?=$articulos?>
          <!-- <a href="<?=base_url('articulos')?>" 
             class="card-footer text-white">Ver detalles</a> -->
        </p>
      </div>
      <div class="card-footer"><a href="<?=base_url('articulos')?>" 
             class="card-footer text-white">Ver detalles</a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-4">
    <div class="card text-white bg-success mb-3">
      <!-- <div class="card-header">Total artículos</div> -->
      <div class="card-body">
        <p class="card-text">Ventas del día: <?=$ventas?></p>
        <p class="card-text">Importe: $<?=number_format($totalVentas, 2, '.', ",")?></p>
      </div>
      <div class="card-footer"><a href="<?=base_url('ventas')?>" 
             class="card-footer text-white">Ver detalles</a>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-4">
    <div class="card text-white bg-danger mb-3">
      <!-- <div class="card-header">Total artículos</div> -->
      <div class="card-body">
        <p class="card-text">Artículos con stock mínimo: <?=$minimos?></p>
      </div>
      <div class="card-footer"><a href="<?=base_url('ventas')?>" 
             class="card-footer text-white">Ver detalles</a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 col-md-4">
    <!-- <div class="chart-container" style="position: relative; height:40vh; width:80vw"> -->
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <a class="btn btn-success" href="<?=base_url("inicio/excel")?>">Descargar excel</a>
  </div>
</div>

<script>
  // const labels = [
  //   'January',
  //   'February',
  //   'March',
  //   'April',
  //   'May',
  //   'June',
  // ];

  // const data = {
  //   labels: labels,
  //   datasets: [{
  //     label: 'My First dataset',
  //     backgroundColor: 'rgb(255, 99, 132)',
  //     borderColor: 'rgb(255, 99, 132)',
  //     data: [0, 10, 5, 2, 20, 30, 45],
  //   }]
  // };

  // const config = {
  //   type: 'line',
  //   data: data,
  //   options: {}
  // };
<!-- </script>
<script> -->
  // const myChart = new Chart(
  //   document.getElementById('myChart'),
  //   config
  // );
</script>




<script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgb(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


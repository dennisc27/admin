
<?php
	/* Database connection settings */
	$host = '162.241.194.64';
	$user = 'comprnys_dennis';
	$pass = 'lacasa3';
	$db = 'comprnys_compraventa';
	$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
  
  $sql = 'select concat(month(fechatic), "-", year(fechatic)) as fecha, sum(montoReal) as total,month(fechatic) as mes, year(fechatic) as anio from recibo where fechatic >= (last_day(now()) + interval 1 day - interval 1 year)  group by fecha order by anio,mes;';
  $result = mysqli_query($mysqli, $sql);
  $empenoanio = '';
  $empenoaniotags = '';
	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {

		$empenoanio = $empenoanio . ''. $row['total'].',';
		$empenoaniotags = $empenoaniotags . '"'. $row['fecha'] .'",';
  }
  
  $sql ='select mes, floor(sum(beneficio)) as beneficio2 from ((select * from(
                select month(fecha) as mes, sum(beneficio) as beneficio from vent_nueva group by mes order by month(fecha)) A) union all (select month(fecha) as mes, sum(beneficio) as beneficio from vent_usado group by mes order by month(fecha)
                ) union all (select month(fecha_pag) as mes, sum(beneficio) as beneficio from data_cop where beneficio is not null group by mes order by month(fecha_pag)
                ) union all (select month(fecha_pag) as mes, sum(valor_pag) as beneficio from data_cop where beneficio is null and quin_pag <> 0 group by mes order by month(fecha_pag)
                )) t group by mes;';           

  $result = mysqli_query($mysqli, $sql);
  $beneficioanio = '';
  $beneficioaniotags = '';
  //loop through the returned data
  while ($row = mysqli_fetch_array($result)) {
              
    $beneficioanio = $beneficioanio . ''. $row['beneficio2'].',';
    $beneficioaniotags = $beneficioaniotags . '"'. $row['mes'] .'",';
  }

  $sql ='select concat(monthname(fecha)," ",year(fecha)) as mes, count(id) as total from ventas where fecha >= (last_day(now()) + interval 1 day - interval 1 year) group by month(fecha) order by year(fecha),month(fecha);';

  $result = mysqli_query($mysqli, $sql);
  $ventastotal = '';
  $ventastotaltags = '';
  //loop through the returned data
  while ($row = mysqli_fetch_array($result)) {
              
    $ventastotal = $ventastotal . ''. $row['total'].',';
    $ventastotaltags = $ventastotaltags . '"'. $row['mes'] .'",';
  }

  $sql ='select concat(monthname(fechatic)," ",year(fechatic)) as mes, count(ticketno) as total from recibo where fechatic >= (last_day(now()) + interval 1 day - interval 1 year) group by month(fechatic) order by year(fechatic),month(fechatic);';

  $result = mysqli_query($mysqli, $sql);
  $recibototal = '';
  $recibototaltags = '';
  //loop through the returned data
  while ($row = mysqli_fetch_array($result)) {
              
    $recibototal = $recibototal . ''. $row['total'].',';
    $recibototaltags = $recibototaltags . '"'. $row['mes'] .'",';
  }

  $sql ='select format(sum(montoreal)/(day(now())-1)*day(last_day(now())),2) as proyeccion from recibo where month(fechatic) = month(now()) and year(fechatic) = year(now()) and day(fechatic) < day(now());';
  $result = mysqli_query($mysqli, $sql);
  $proy_empeno = 'N/D';
  if($result){
    while ($row = mysqli_fetch_array($result)) {     
      $proy_empeno = $row['proyeccion'];
    }
  } 
  $sql ='SELECT format(sum(montoReal),2) as proyeccion from recibo where date(fechatic) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY));';
  $result = mysqli_query($mysqli, $sql);
  $empenoayer = 0;
  while ($row = mysqli_fetch_array($result)) {     
    $empenoayer = $row['proyeccion'];
  }

  $sql = 'SELECT count(ticketno) as total from recibo WHERE month(fechatic) = month(now()) and year(fechatic) = year(now());';
  $result = mysqli_query($mysqli, $sql);
  $recibosmes = 0;
  while ($row = mysqli_fetch_array($result)) {     
    $recibosmes = $row['total'];
  }

  $sql = 'SELECT format(sum(beneficio)/(day(now())-1)*day(last_day(now())),2) as beneficio from ((select * from(
    select sum(beneficio) as beneficio from ventas where month(fecha) = month(now()) and day(fecha) < day(now()) and year(fecha) = year(now())) A) union all (select sum(beneficio) as beneficio from data_cop where month(fecha_pag) = month(now()) and day(fecha_pag) < day(now()) and year(fecha_pag) = year(now()) and beneficio is not null 
    ) union all (select sum(valor_pag) as beneficio from data_cop where month(fecha_pag) = month(now()) and day(fecha_pag) < day(now()) and year(fecha_pag) = year(now()) and beneficio is null and quin_pag <> 0
    )) t;';  

  $result = mysqli_query($mysqli, $sql);
  $proy_beneficio = 0;
  while ($row = mysqli_fetch_array($result)) {     
    $proy_beneficio = $row['beneficio'];
  }

  $sql = 'select * from(
    (select sum(beneficio) as ventausado from ventas where month(fecha) = month(now()) and suplidor is null and day(fecha) < day(now()) and year(fecha) = year(now())) A join (select sum(beneficio) as retiros from data_cop where month(fecha_pag) = month(now()) and day(fecha_pag) < day(now()) and year(fecha_pag) = year(now()) and beneficio is not null) b
    join (select sum(beneficio) as ventanueva from ventas where month(fecha) = month(now()) and suplidor is not null and day(fecha) < day(now()) and year(fecha) = year(now())) c  
    join (select sum(valor_pag) as quincenas from data_cop where month(fecha_pag) = month(now()) and day(fecha_pag) < day(now()) and year(fecha_pag) = year(now()) and beneficio is null and quin_pag <> 0
    ) d);';  

  $result = mysqli_query($mysqli, $sql);
  $barchartdata = '';
  while ($row = mysqli_fetch_array($result)) {
    //labels: ['Quincena', 'V.Usado', 'V.Nuevo', 'Retiro'],
    $barchartdata = $row['quincenas'].",".$row['ventausado'].",".$row['ventanueva'].",".$row['retiros'];
  }

  $empenoanio = trim($empenoanio, ",");
  $beneficioanio = trim($beneficioanio, ",");
  $ventastotal = trim($ventastotal, ",");
  $recibototal = trim($recibototal, ",");
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Compraventa Federico 3</title>
  <!-- Favicon -->
  <link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="../assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
          <header class="topheader">.COMPRAVENTA FEDERICO.</header>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
              </a>
            </li>


          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="../assets/img/theme/dennis.JPG">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">Dennis Castillo</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Bienvenido!</h6>
                </div>
                <!-- <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-calendar-grid-58"></i>
                  <span>Activity</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-support-16"></i>
                  <span>Support</span>
                </a>
                <div class="dropdown-divider"></div> -->
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Cerrar Sesion</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Inicio</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="#">Estadisticas</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Inicio</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <span class="textospan">Última Actualización 24/01/2021 4:10PM</span>
              <a href="#" class="btn btn-sm btn-neutral">Actualizar</a>
              <!-- <a href="#" class="btn btn-sm btn-neutral">Filtros</a> -->
            </div>
          </div>
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Proyeccion Empeno</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $proy_empeno; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon ">
                        <i class="ni ni-money-coins text-gray"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 11.5%</span>
                    <span class="text-nowrap">Para este Mes</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">PROYECCION BENEFICIO </h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $proy_beneficio; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon text-gray">
                        <i class="ni ni-chart-pie-35"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 6.97%</span>
                    <span class="text-nowrap">Para este Mes</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Recibos del Mes</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $recibosmes; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon text-gray">
                        <i class="ni ni-money-coins"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Para este Mes</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Empeno de AYER</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $empenoayer; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon text-gray">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 7.98%</span>
                    <span class="text-nowrap">Para el día de Ayer</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-8">
          <div class="card bg-default">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-light text-uppercase ls-1 mb-1">GENERAL</h6>
                  <h5 class="h3 text-white mb-0">Progreso del Año</h5>
                </div>
                <div class="col">
                  <ul class="nav nav-pills justify-content-end">
                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark" data-update='{"data":{"datasets":[{"data":[<?php echo $empenoanio; ?>]}]}}' data-prefix="$" data-suffix="k">
                      <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                        <span class="d-none d-md-block">Empeño</span>
                        <span class="d-md-none">M</span>
                      </a>
                    </li>
                    <li class="nav-item" data-toggle="chart" data-target="#chart-sales-dark" data-update='{"data":{"datasets":[{"data":[<?php echo $beneficioanio; ?>]}]}}' data-prefix="$" data-suffix="k">
                      <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                        <span class="d-none d-md-block">Beneficio</span>
                        <span class="d-md-none">W</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Detalle Beneficio</h6>
                  <h5 class="h3 mb-0">Beneficio por Tipo</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-bars" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-8">
          <div class="card bg-default">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-light text-uppercase ls-1 mb-1">GENERAL</h6>
                  <h5 class="h3 text-white mb-0">Cantidad de Recibos Hechos</h5>
                </div>
                <div class="col">
                  <ul class="nav nav-pills justify-content-end">
                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark2" data-update='{"data":{"datasets":[{"data":[<?php echo $recibototal; ?>]}]}}' data-prefix="$" data-suffix="k">
                      <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                        <span class="d-none d-md-block">Empeño</span>
                        <span class="d-md-none">E</span>
                      </a>
                    </li>
                    <li class="nav-item" data-toggle="chart" data-target="#chart-sales-dark2" data-update='{"data":{"datasets":[{"data":[<?php echo $ventastotal; ?>]}]}}' data-prefix="$" data-suffix="k">
                      <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                        <span class="d-none d-md-block">Venta</span>
                        <span class="d-md-none">N</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart2">
                <!-- Chart wrapper -->
                <canvas id="chart-sales-dark2" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Estado Mes Enero</h3>
                </div>
                <div class="col text-right">
                  <a href="#!" class="btn btn-sm btn-primary">+</a>
                </div>
              </div>
            </div>
            <div class="table-responsive" >
              <!-- Projects table -->
              <table class="table align-items-center table-flush" >
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Dia del Mes</th>
                    <th scope="col">Numero Empeños</th>
                    <th scope="col">Numero Ventas</th>
                    <!-- <th scope="col">Diferencia</th> -->
                  </tr>
                </thead>
                <tbody>

                <?php
									$query = 'Select dia2, total1 as ventas, total2 as recibos from (Select * from (select day(fecha) as dia, count(id) as total1 from ventas where month(fecha) = month(now()) and year(fecha) = year(now()) and status is null group by dia) a left outer join (select day(fechatic) as dia2, count(ticketno) as total2 from recibo where status <> "A" and month(fechatic) = month(now()) and year(fechatic) = year(now()) group by dia2) b on a.dia = b.dia2 union
									Select * from (select day(fecha) as dia, count(id)  as total1 from ventas where month(fecha) = month(now()) and year(fecha) = year(now()) and status is null group by dia) a right outer join (select day(fechatic) as dia2, count(ticketno) as total2 from recibo where status <> "A" and month(fechatic) = month(now()) and year(fechatic) = year(now()) group by dia2) b on a.dia = b.dia2) x order by dia2;';
                  
                  // $result = mysql_query($query) or die(mysql_error());
                  $result = mysqli_query($mysqli, $query);
                  //loop through the returned data
                  while ($row = mysqli_fetch_array($result)) {
									?>  
										<tr>
											<th scope="row"><?php echo $row["dia2"]; ?></th>
											<td><?php echo $row["recibos"]; ?></td>
											<td><?php echo $row["ventas"]; ?></td>
										</tr>
									<?php
									}
									?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <!-- Footer -->
      <footer class="footer col-xl-11">
        <div class="row align-items-center justify-content-lg-end">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-right  text-muted">
              &copy; 2021 <span class="font-weight-bold ml-1" target="_blank">Dennis Castillo</span>
            </div>
          </div>
      </footer>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="../assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="../assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="../assets/js/argon.js?v=1.2.0"></script>

  //Adding information to first chart
  <script>
// Sales chart
//

var SalesChart = (function() {

// Variables

var $mychart = $('#chart-sales-dark');


// Methods

function init($chmyart) {

  var salesChart = new Chart($mychart, {
    type: 'line',
    options: {
      scales: {
        yAxes: [{
          gridLines: {
            lineWidth: 1,
            color: Charts.colors.gray[900],
            zeroLineColor: Charts.colors.gray[900]
          },
          ticks: {
            callback: function(value) {
              if (!(value % 10)) {
                return '$' + value + 'k';
              }
            }
          }
        }]
      },
      tooltips: {
        callbacks: {
          label: function(item, data) {
            var label = data.datasets[item.datasetIndex].label || '';
            var yLabel = item.yLabel;
            var content = '';

            if (data.datasets.length > 1) {
              content += '<span class="popover-body-label mr-auto">' + label + '</span>';
            }

            content += '<span class="popover-body-value">$' + yLabel + 'k</span>';
            return content;
          }
        }
      }
    },
    data: {
      labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Performance',
        data: [<?php echo $empenoanio  ; ?>],
      }]
    }
  });

  // Save to jQuery object

  $mychart.data('chart', salesChart);

};




// Events

if ($mychart.length) {
  init($mychart);
}

})();




var SalesChart2 = (function() {

// Variables

var $mychart2 = $('#chart-sales-dark2');


// Methods

function init($mychart2) {

  var salesChart = new Chart($mychart2, {
  type: 'line',
  options: {
    scales: {
    yAxes: [{
      gridLines: {
      lineWidth: 1,
      color: Charts.colors.gray[900],
      zeroLineColor: Charts.colors.gray[900]
      },
      ticks: {
      callback: function(value) {
        if (!(value % 10)) {
        return '$' + value + 'k';
        }
      }
      }
    }]
    },
    tooltips: {
    callbacks: {
      label: function(item, data) {
      var label = data.datasets[item.datasetIndex].label || '';
      var yLabel = item.yLabel;
      var content = '';

      if (data.datasets.length > 1) {
        content += '<span class="popover-body-label mr-auto">' + label + '</span>';
      }

      content += '<span class="popover-body-value">$' + yLabel + 'k</span>';
      return content;
      }
    }
    }
  },
  data: {
    labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    datasets: [{
    label: 'Performance',
    data: [<?php echo $recibototal; ?>],
    }]
  }
  });

  // Save to jQuery object

  $mychart2.data('chart2', salesChart);

};


// Events

if ($mychart2.length) {
  init($mychart2);
}

})();




//
// Bars chart
//

var BarsChart = (function() {

	//
	// Variables
	//

	var $chart = $('#chart-bars');


	//
	// Methods
	//

	// Init chart
	function initChart($chart) {

		// Create chart
		var ordersChart = new Chart($chart, {
			type: 'bar',
			data: {
				labels: ['Quincena', 'V.Usado', 'V.Nuevo', 'Retiro'],
				datasets: [{
					label: 'Sales',
					data: [<?php echo $barchartdata; ?>]
				}]
			}
		});

		// Save to jQuery object
		$chart.data('chart', ordersChart);
	}


	// Init chart
	if ($chart.length) {
		initChart($chart);
	}

})();

      </script>

      
      


</body>

</html>
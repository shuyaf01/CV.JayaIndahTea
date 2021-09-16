

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        
      </ol>
    </section>
    
    
    
    <!-- Main content -->
    <section class="content">
        <div class="row">

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
            <h3>
                <?php echo $Jumlah_Saldo; ?></h3>

              <p>Jumlah Saldo Kas</p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-check-o"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>
                <?php echo $Total_Pemasukan; ?></h3>
              <p>Pemasukan Kas Tahun <?php echo date('Y') ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-plus-o"></i>
            </div>
           
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $Total_Pengeluaran; ?></h3>
              <p>Pengeluaran Kas Tahun <?php echo date('Y') ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar-minus-o"></i>
            </div>
            
          </div>
        </div>
        
            <div class="col-lg-12 col-xs-12">
                <div class="box box-solid box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Histori Kas</h3>
                </div>
                        <div class="box-body">
                        
                        <!-- Tabel  -->

    <table class="table table-bordered"s>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>ID</th>
                <th>Uraian</th>
                <th>Nominal</th>     
                <th>Saldo Kas</th>                                
            </tr>
        </thead>

        <tbody>
            <?php foreach ($dataKas->result() as $record) : ?>
            <tr>
                <!-- Memanggil Value pada Tabel Users -->
                <td> <?php echo $record->tanggal;?></td>
                <td> <?php echo $record->id_pemasukan;?><?php echo $record->id_pengeluaran;?> </td>
                <td> <?php echo $record->jenis_pemasukan;?><?php echo $record->jenis_pengeluaran;?></td>
                <td> <?php echo $record->nominal_pemasukan;?><?php echo $record->nominal_pengeluaran;?></td>  
                <td> <?php echo $record->saldo;?></td>                    
            </tr>                      
            <?php endforeach; ?>
        </tbody>

        

    </table>

    
                        <script>
                            //Date picker
                            $('#reservationdate').datetimepicker({
                                format: 'L'
                            });
                        </script> 
                        <script>
                            //Date picker
                            $('#datepicker').datepicker({
                                format: 'MM yyyy',
                                viewMode: "months",
                                minViewMode: true
                            });
                        </script> 
                        <script>
                            $(document).ready(function() {
                                $('#myTable').DataTable();
                            } );
                        </script> 



                    </div>
                </div>
            </div>
            
        </div>
    </section>

</div> 


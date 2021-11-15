

<body>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <B>Form Tambah Pegawai</B> 
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard </a></li>
            <li class="active">Pegawai</li>
            <li class="active">Tambah</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box">
                        <div class="box-body">
                        
                        <?php $this->load->view('templates/flash'); ?>   
                        <!-- form start -->
                        <br>
                        <?php echo form_open_multipart(site_url('PegawaiController/processCreate')) ?>
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group row ">
                                    <label class="col-sm-2 col-form-label">ID</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" name='id_pegawai' readonly value="<?php echo $new_id; ?>" >    
                                    </div>       
                                </div>                                
                                <div class="form-group row <?php echo (form_error('nama_pegawai')) ? ' has-error' : ''; ?>">
                                    <label class="col-sm-2 col-form-label">Nama Pegawai</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" name='nama_pegawai' placeholder="Nama Pegawai">
                                    <?php echo form_error('nama_pegawai', '<span class="help-block">', '</span>') ?>
                                    </div>  
                                </div>
                                <div class="form-group row <?php echo (form_error('no_tlp')) ? ' has-error' : ''; ?>">
                                    <label class="col-sm-2 col-form-label">No Telepon</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" name='no_tlp' placeholder="No Telepon">
                                    <?php echo form_error('no_tlp', '<span class="help-block">', '</span>') ?>
                                    </div>  
                                </div>
                                <div class="form-group row <?php echo (form_error('alamat')) ? ' has-error' : ''; ?>">
                                    <label class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" name='alamat' placeholder="Alamat">
                                    <?php echo form_error('alamat', '<span class="help-block">', '</span>') ?>
                                    </div>  
                                </div>
                                
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                            <a href="<?php echo site_url('employees') ?>" class="btn btn-default float-right">Batal</a>
                            </div>
                            <!-- /.card-footer -->
                            <?php echo form_close() ?>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 
</body>


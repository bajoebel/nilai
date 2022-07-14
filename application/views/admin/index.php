<section class="content-header">
    <h1><?php echo $contentTitle ?></h1>
</section>

<section class="content container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <p>&nbsp;</p>
                    <h3>Hi, <?= $this->session->userdata('nama') ?></h3>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a class="small-box-footer">
                    <h4>Selamat datang di Medical Record rekammedis Room</h4>
                </a>
            </div>
        </div>

    </div>
</section>
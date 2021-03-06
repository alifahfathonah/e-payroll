		<div class="main-content-inner">
			<div class="container">	
                <div class="row">
                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <!-- basic form start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title"><?= $judul;?></h4>
                                        <form action="<?= $action;?>" method="post">
											<div class="form-group col-md-6">
												<label for="date">Tanggal <?= form_error('tgl');?></label>
												<input type="date" class="form-control" name="tgl" id="tgl" placeholder="Tgl" value="<?= $tgl;?>" />
											</div>
											<div class="form-group col-md-6">
												<label for="varchar">Nik <?= form_error('nik') ?></label>
												<select class="form-control" name="nik">
													<option value="">--Pilih NIK--</option>
													<?php 
													$db = $this->db->get('karyawan');
													foreach ($db->result() as $rw) {
													?>
													<option value="<?= $rw->nik;?>"><?= $rw->nik;?></option>
													<?php } ?>
												</select>
											</div>
											<input type="hidden" name="id_gaji" value="<?= $id_gaji;?>" /> 										
                                            <button type="submit" class="btn btn-primary"><?= $button;?></button>
											<a href="<?= base_url('gaji');?>" class="btn btn-warning">Cancel</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- basic form end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content area end -->

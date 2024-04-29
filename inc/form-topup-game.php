<?php
//[form-topup-game]
add_shortcode('form-topup-game', function(){
    ob_start();
	global $post;
    $atribut = shortcode_atts( array(
        'id'	=> $post->ID,
    ), $atts );

    $post_id            = $atribut['id'];
    $datadiri		    = get_post_meta($post_id,'kelengkapan_data',true);
    $ket_datadiri	    = get_post_meta($post_id,'keterangan_kelengkapan_data',true);
    $imgket_datadiri    = get_post_meta($post_id,'gambar_keterangan_kelengkapan_data',true);
    $datanominal	    = get_post_meta($post_id,'nominal',true);
    $iconnominal	    = get_post_meta($post_id,'icon_nominal',true);

    $gameoptions	    = get_option('games_options');
    $datapembayaran	    = isset($gameoptions['metode_pembayaran'])?$gameoptions['metode_pembayaran']:'';
    $recaptcha	        = isset($gameoptions['recaptcha'])?$gameoptions['recaptcha']:false;
    ?>
    <div class="form-topup-game">
        <form id="formvelogame" action="" method="POST">
        
            <input type="hidden" name="id_game" value="<?php echo $post_id;?>">
            <input type="hidden" name="game" value="<?php echo get_the_title($post_id);?>">

            <div class="card overflow-hidden mb-3 mb-md-4 shadow">
                <div class="card-header p-0">
                    <span class="btn btn-primary rounded-0">1</span>
                    <span class="p-2 fw-bold">Masukkan Data Akun Kamu</span>
                </div>
                <div class="card-body">
                    <?php if($datadiri): ?>
                		<div class="row">
                        <?php foreach($datadiri as $n => $data): ?>
                          	<?php $title = strpos($data,'|') !== false?explode("|",$data)[0]:$data;?>
                          	<?php $plchd = strpos($data,'|') !== false?explode("|",$data)[1]:$data;?>
  							<div class="col-md-6 pb-2">
                            	<label for="player-<?php echo $n;?>" class="form-label"><?php echo $title;?></label>
    							<input type="text" class="form-control" name="player[<?php echo $title;?>]" id="player-<?php echo $n;?>" placeholder="<?php echo $plchd;?>" required>
                          	</div>
                        <?php endforeach; ?>
              			</div>
					<?php endif; ?>
                    <?php if($ket_datadiri): ?>
                        <div class="small fst-italic mt-2">
                            <?php echo $ket_datadiri; ?>                            
                        </div>
                    <?php endif; ?>
                    <?php if($imgket_datadiri): ?>
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#imgdatadiriModal">
                                Petunjuk <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-arrow-up-right" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0z"/> </svg>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="imgdatadiriModal" tabindex="-1" aria-labelledby="imgdatadiriModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <img src="<?php echo $imgket_datadiri; ?>" class="w-100" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card overflow-hidden mb-3 mb-md-4 shadow">
                <div class="card-header p-0">
                    <span class="btn btn-primary rounded-0">2</span>
                    <span class="p-2 fw-bold">Pilih Nominal yang Ingin Kamu Beli</span>
                </div>
                <div class="card-body">
                    <?php if($datanominal): ?>
                		<div class="row">
                          <?php foreach($datanominal as $n => $data): ?>
                              <?php $title = strpos($data,'|') !== false?explode("|",$data)[0]:$data;?>
                              <?php $price = strpos($data,'|') !== false?explode("|",$data)[1]:$data;?>
                              <div class="col-6 col-xl-4 pb-3">
                                
                                <input type="radio" class="btn-check" name="nominal" id="nominal-<?php echo $n;?>" value="<?php echo $data;?>" autocomplete="off" required>
                                <label class="btn btn-outline-primary h-100 d-block text-start" for="nominal-<?php echo $n;?>">
                					<div class="row g-1">
                                      <div class="col-md-10 col-9">
                                          <div style="font-size: 14px;"><?php echo $title;?></div>
                                          <small class="fst-italic" style="font-size: 12px;">Rp <?php echo $price;?></small>
                                      </div>
                                      <div class="col-md-2 col-3 m-auto text-end">
											<?php if($iconnominal): ?>
                                  				<img src="<?php echo $iconnominal;?>" class="img-fluid w-100" loading="lazy"/>
											<?php else: ?>
                                        		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16"> <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495 8 13.366l2.532-7.876-5.062.005zm-1.371-.999-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817 5.123-6.83-2.928.002-2.195 6.828z"/> </svg>
											<?php endif; ?>
                                      </div>
                              		</div>
                                </label>
                                
                              </div>
                          <?php endforeach; ?>
              			</div>
					<?php endif; ?>
                </div>
            </div>

            <div class="card overflow-hidden mb-3 mb-md-4 shadow">
                <div class="card-header p-0">
                    <span class="btn btn-primary rounded-0">3</span>
                    <span class="p-2 fw-bold">Pilih Metode Pembayaran</span>
                </div>
                <div class="card-body">
                    <?php if($datapembayaran): ?>
                		<div class="datapembayaran">
                          <?php foreach($datapembayaran as $n => $data): ?>
                              <div class="itemdatapembayaran pb-2">
                                    <input type="radio" class="btn-check" name="pembayaran" id="pembayaran-<?php echo $n;?>" value="<?php echo $data['title'];?>" autocomplete="off" required>
                                    <label class="btn btn-outline-secondary d-block text-start overflow-hidden p-0" for="pembayaran-<?php echo $n;?>">
                                        <div class="p-2">
                                            <?php if(isset($data['logo']) && $data['logo']): ?>
                                                <img src="<?php echo $data['logo'];?>" width="90" class="img-fluid rounded" alt="<?php echo $data['title'];?>">
                                            <?php else: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16"> <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/> <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/> </svg> 
                                                <?php echo $data['title'];?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="infopembayaran alert alert-secondary mt-2 mb-0 border-0 rounded-0" style="display:none">
                                          <small>
                                          <?php echo $data['description'];?>
                                           </small>
                                        </div>
                                	</label>
                              </div>
                          <?php endforeach; ?>
              			</div>
					<?php endif; ?>
                </div>
            </div>

            <div class="card-promo card overflow-hidden mb-3 mb-md-4 shadow">
                <div class="card-header p-0">
                    <span class="btn btn-primary rounded-0">4</span>
                    <span class="p-2 fw-bold">Punya Kode Promo? Masukkan Disini!</span>
                </div>
                <div class="card-body">
                    <label for="kode_promo" class="form-label">Kode Promo (Optional)</label>
                    <div class="row g-2">
                        <div class="col-8 col-md-9 col-xl-10">
                            <div class="input-kodepromo form-control p-0 position-relative" style="border-style:dashed;">
                                <input type="text" class="form-control border-0" id="kode_promo" name="kode_promo" placeholder="Ketik kode promo kamu disini">
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-2 text-end">
                            <span class="btn btn-primary w-100 text-truncate btn-promogame">Gunakan</span>
                        </div>
                    </div>
                    <input type="hidden" name="potongan" id="potongan" value="0">                   
                </div>
            </div>
            
            <div class="card overflow-hidden mb-3 mb-md-4 shadow">
                <div class="card-header p-0">
                    <span class="btn btn-primary rounded-0">5</span>
                    <span class="p-2 fw-bold">Detail Kontak Anda</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nowa" class="form-label">No. WhatsApp</label>
                        <input type="text" class="form-control" id="nowa" name="nowa" placeholder="Masukkan No. WhatsApp Kamu" required>
                    </div>
                    <div>
                        <label for="email" class="form-label">Email (optional)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Kamu">
                    </div>
                </div>
            </div>

            <?php
            if(class_exists('Velocity_Addons_Captcha') && $recaptcha):
                $captcha = new Velocity_Addons_Captcha;
                $captcha->display();
            endif;
            ?>

            <button type="submit" class="btn btn-primary w-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16"> <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/> </svg>
                Pesan Sekarang
            </button>

            <div class="modal fade" id="resultTopupModal" tabindex="-1" aria-labelledby="resultTopupModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <?php
    return ob_get_clean();
});
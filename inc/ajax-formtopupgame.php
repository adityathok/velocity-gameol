<?php
add_action( 'wp_ajax_formtopupgame', 'ajax_formtopupgame_handler' );
add_action( 'wp_ajax_nopriv_formtopupgame', 'ajax_formtopupgame_handler' );

function ajax_formtopupgame_handler() {

    parse_str($_POST['formdata'], $formData);
    // print_r($formData);

    $security = true;
    if (class_exists('Velocity_Addons_Captcha') && isset($formData['g-recaptcha-response']) && !empty($formData['g-recaptcha-response'])) {
        $security = true;
    } elseif(class_exists('Velocity_Addons_Captcha') && isset($formData['g-recaptcha-response']) && empty($formData['g-recaptcha-response'])) {
        $security = false;
        echo '<div class="alert alert-danger">Silahkan lengkapi Captcha</div>';
    }

    if ($security) {
        $gameoptions    = get_option('games_options');
        $invoice		= strtoupper(uniqid());

        ///ORDER via Whatsapp
        $waorder        = isset($gameoptions['waorder'])?$gameoptions['waorder']:'';
        $nowhatsapp     = isset($gameoptions['nowhatsapp'])?$gameoptions['nowhatsapp']:'';
        if($nowhatsapp && $waorder){
            $nowhatsapp = $nowhatsapp ? preg_replace('/[^0-9]/', '', $nowhatsapp) : $nowhatsapp;
            if (substr($nowhatsapp, 0, 1) == 0) {
                $nowhatsapp = substr_replace($nowhatsapp, '62', 0, 1);
            }

            $pesanwa = 'Invoice : '.$invoice.'%0a';
            foreach($formData['player'] as $key => $value):
                $key	 = str_replace("_", " ", $key);
                $pesanwa = $pesanwa.$key.' : '.$value.'%0a';
            endforeach;
            foreach($formData as $key => $value):
                if ( $key == 'g-recaptcha-response' ) { continue; }
                if ( $key == 'player' ) { continue; }

                if($key == 'kode_promo' && empty($value)){
                    continue;
                }
                if($key == 'potongan' && ($value == '' || $value == 0)){
                    continue;
                }

                $key	 = strtolower($key);
                $key	 = str_replace("_", " ", $key);
                $pesanwa = $pesanwa.$key.' : '.$value.'%0a';

            endforeach;
            $pesanwa = str_replace(" ", " ", $pesanwa);

            $linkwa = 'https://wa.me/'.$nowhatsapp.'?text='.urlencode($pesanwa);

            echo '<div class="text-center">';
                echo '<a target="_blank" href="'.$linkwa.'" class="btn btn-success w-100"><i class="fa fa-whatsapp"></i> Lanjut via Whatsapp</a>';
            echo '</div>';
        }

        //Simpan Order
        $dataorder = isset($gameoptions['dataorder'])?$gameoptions['dataorder']:'';
        if($dataorder){

            // Create post object
            $new_post = array(
                'post_title'    => wp_strip_all_tags( $invoice ),
                'post_type'     => 'ordergame',
                'post_content'  => '',
                'post_status'   => 'publish',
                'meta_input'    => array(
                    'status'        => 'baru',
                    'invoice'       => $invoice,
                ),
            );
            
            foreach($formData as $key => $value):
                if ( $key == 'g-recaptcha-response' ) { continue; }
                if ( $key == 'player' ) { continue; }

                if($key == 'kode_promo' && $formData['potongan'] == 0){
                    $value = '';
                }

                $new_post['meta_input'][$key] = $value;
            endforeach;

            //dataplayer 
            $dataplayer = [];           
            foreach($formData['player'] as $key => $value):
                $dataplayer[] = $key.' : '.$value;
            endforeach;
            $new_post['meta_input']['player']       = $dataplayer;
            $new_post['meta_input']['data_player']  = $formData['player'];

            //Total Bayar
            $nominal    = $formData['nominal'];
            $nominal    = isset($nominal)&!empty($nominal)?explode("|",$nominal):'';
            $nominal    = $nominal?str_replace(".", "", $nominal[1]):0;
            if($formData['nominal'] && $formData['kode_promo'] && $formData['potongan'] > 0){
                $total = $nominal-$formData['potongan'];
                $new_post['meta_input']['total_bayar']  = $total;
            } else {
                $new_post['meta_input']['total_bayar']  = $nominal;
            }

            $new_postid = wp_insert_post( $new_post );

            echo '<div class="my-2">';

                if(empty($waorder)):                    
                    echo '<div class="text-center mb-3">';
                        echo 'Pesanan kamu berhasil dibuat, Silahkan tunggu konfirmasi dari Admin. Terimakasih.';
                    echo '</div>';
                endif;
            
                echo '<div class="alert alert-success border-2 text-center w-100 mb-4" style="border-style: dashed;">';
                    echo 'KODE INVOICE : <br>';
                    echo '<div class="fs-2 fw-bold">'.$invoice.'</div>';
                echo '</div>';
            echo '</div>';

        }

    }

    wp_die();
}
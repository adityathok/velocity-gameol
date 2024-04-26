<?php
add_action( 'wp_ajax_submitkodepromogame', 'ajax_submitkodepromogame_handler' );
add_action( 'wp_ajax_nopriv_submitkodepromogame', 'ajax_submitkodepromogame_handler' );

function ajax_submitkodepromogame_handler() {
    $kode       = $_POST['kode'];
    $nominal    = $_POST['nominal'];
    $nominal    = isset($nominal)&!empty($nominal)?explode("|",$nominal):'';
    $nominal    = $nominal?str_replace(".", "", $nominal[1]):0;

    $result     = [
        'success'   => 0,
        'message'   => 'Data promo tidak ditemukan',
        'potongan'  => 0
    ];

    if($kode):

        // The Query.
        $the_query = new WP_Query( array(
            'post_type' => 'promogame',
            'title'     => $kode 
        ) );

        // The Loop.
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $minimal    = get_post_meta(get_the_ID(),'minimal',true);
                $potongan   = get_post_meta(get_the_ID(),'potongan',true);
                $result     = [
                    'success'   => 1,
                    'message'   => 'Promo berhasil digunakan',
                    'potongan'  => $potongan,
                    'nominal'  => (int)$nominal
                ];

                if($minimal && $minimal >= $nominal):
                    $result = [
                        'success'   => 0,
                        'message'   => 'Kurang dari minimal <strong>('.number_format($minimal, 0, ",", ".").')</strong> pembelian',
                        'potongan'  => 0,
                        'nominal'  => (int)$nominal,
                        'minimal'  => $minimal
                    ];
                endif;

            } 
        }

        // Restore original Post Data.
        wp_reset_postdata();
    endif;

	wp_send_json($result);

    wp_die();
}
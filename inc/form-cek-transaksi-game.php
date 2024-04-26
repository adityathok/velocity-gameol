<?php
//[form-cek-transaksi-game]
add_shortcode('form-cek-transaksi-game', function(){
    ob_start();
    ?>
    <div class="form-cek-transaksi-game">
        <form id="form-cektransaksigame" action="" method="post">
            <div class="mb-3">
                <label for="noinvoice" class="form-label">Nomor Invoice Kamu</label>
                <input type="text" class="form-control" id="noinvoice" name="noinvoice" placeholder="66xxxxxx" required>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"> <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/> </svg>
                    <span>Cek Transaksi</span>
                </button>
            </div>
        </form>
        <div class="result"></div>
    </div>
    <?php
    return ob_get_clean();
});

add_action( 'wp_ajax_cektransaksigame', 'ajax_cektransaksigame_handler' );
add_action( 'wp_ajax_nopriv_cektransaksigame', 'ajax_cektransaksigame_handler' );
function ajax_cektransaksigame_handler() {
    parse_str($_POST['formdata'], $formData);
    $invoice = $formData['noinvoice'];

    if($invoice):

        // The Query.
        $the_query = new WP_Query( array(
            'post_type'     => 'ordergame',
            'meta_key'      => 'invoice',
            'meta_value'    => $invoice,
            'meta_compare'  => '=='
        ) );

        // The Loop.
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();

                $stt = array(
                    'baru'      => 'Pesanan Baru',
                    'lunas'     => 'Lunas',
                    'sukses'    => 'Sukses',
                    'gagal'     => 'Gagal',
                );

                $status = get_post_meta( get_the_ID(), 'status', true );
                echo '<div class="card shadow my-3 text-dark">';
                    echo '<div class="card-header fw-bold">'.$invoice.'</div>';
                    echo '<div class="card-body">Status : '.$stt[$status].'</div>';
                echo '</div>';
            } 
        } else {
            echo '<div class="alert alert-danger">Data Transaksi tidak ditemukan</div>';
        }

        // Restore original Post Data.
        wp_reset_postdata();
    endif;

    wp_die();
}
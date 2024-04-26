<?php
add_action('init', 'promogame_post_type');
function promogame_post_type() {
    register_post_type('promogame', array(
        'labels' => array(
            'name'              => 'Kode Promo Game',
            'singular_name'     => 'promogame',
            'add_new'           => __( 'Tambah Promo', 'velocity-gameol' ),
            'add_new_item'      => __( 'Tambah Promo', 'velocity-gameol' ),
        ),
        'menu_icon'     => 'dashicons-games',
        'public'        => true,
        'has_archive'   => false,
        'show_in_rest'  => false,
        'publicly_queryable'  => false,
        'show_in_menu'  => 'edit.php?post_type=games',
        'supports'      => array(
            'title',
            // 'editor',
            // 'thumbnail',
        ),
   ));
}

//register metabox
add_action( 'cmb2_admin_init', 'promogames_register_cmb2_metabox' );
function promogames_register_cmb2_metabox() {
   $cmb = new_cmb2_box( array(
        'id'           => 'promogame_cmb2_metabox',
        'title'        => 'Detail Promo',
        'priority'     => 'high',
        'object_types' => array( 'promogame' ),
    ) );
    
    // $cmb->add_field( array(
    //   'name' => 'Kode Voucher Promo',
    //   'desc' => 'huruf besar dan unik',
    //   'type' => 'text',
    //   'id'   => 'kode_promo',
  	// ) );

    $cmb->add_field( array(
        'name' => 'Potongan',
        'desc' => 'angka tanpa Rp dan titik contoh : 5000',
        'type' => 'text',
        'id'   => 'potongan',
    ) );
    $cmb->add_field( array(
        'name' => 'Minimal Pembelian',
        'desc' => 'angka tanpa Rp dan titik contoh : 5000',
        'type' => 'text',
        'id'   => 'minimal',
    ) );
}
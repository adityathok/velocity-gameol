<?php
add_action('init', 'ordergame_post_type');
function ordergame_post_type() {
    register_post_type('ordergame', array(
        'labels' => array(
            'name'              => 'Order Game',
            'singular_name'     => 'ordergame',
            'add_new'           => __( 'Tambah Order', 'velocity-gameol' ),
            'add_new_item'      => __( 'Tambah Order', 'velocity-gameol' ),
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
add_action( 'cmb2_admin_init', 'ordergames_register_cmb2_metabox' );
function ordergames_register_cmb2_metabox() {
   $cmb = new_cmb2_box( array(
        'id'           => 'ordergame_cmb2_metabox',
        'title'        => 'Detail Pesanan',
        'priority'     => 'high',
        'object_types' => array( 'ordergame' ),
    ));
    $cmb->add_field( array(
        'name'      => 'Nomor Invoice',
        'desc'      => '',
        'type'      => 'text',
        'id'        => 'invoice',
        'default'   => strtoupper(uniqid()),
    ));
    $cmb->add_field( array(
        'name'      => 'Status',
        'desc'      => '',
        'type'      => 'select',
        'id'        => 'status',
        'column'    => true,
        'options'   => array(
            'baru'      => __( 'Pesanan Baru', 'cmb2' ),
            'lunas'     => __( 'Lunas', 'cmb2' ),
            'sukses'    => __( 'Sukses', 'cmb2' ),
            'gagal'     => __( 'Gagal', 'cmb2' ),
        ),
    ));
    $cmb->add_field( array(
        'name'          => 'Game',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'game',
        'column'        => true,
    ));
    $cmb->add_field( array(
        'name'          => 'ID Game',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'id_game',
    ));
    $cmb->add_field( array(
        'name'          => 'Data Player',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'player',
        'repeatable'    => true, 
    ));
    $cmb->add_field( array(
        'name'          => 'Nominal',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'nominal',
        'column'        => true,
    ));
    $cmb->add_field( array(
        'name'          => 'Kode Promo',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'kode_promo',
    ));
    $cmb->add_field( array(
        'name'          => 'Potongan',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'potongan',
    ));
    $cmb->add_field( array(
        'name'          => 'Total Bayar',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'total_bayar',
        'column'        => true,
    ));
    $cmb->add_field( array(
        'name'          => 'Metode Pembayaran',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'pembayaran',
    ));
    $cmb->add_field( array(
        'name'          => 'No. WhatsApp',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'nowa',
        'column'        => true,
    ));
    $cmb->add_field( array(
        'name'          => 'Email',
        'desc'          => '',
        'type'          => 'text',
        'id'            => 'email',
    ));
}
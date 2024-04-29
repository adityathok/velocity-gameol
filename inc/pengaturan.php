<?php
//option page
add_action( 'cmb2_admin_init', 'register_options_for_games_post_type' );
function register_options_for_games_post_type() {
	$cmb = new_cmb2_box( array(
		'id'          		=> 'games_options',
		'title'        		=> esc_html__( 'Pengaturan', 'velocity-gameol' ),
		'object_types' 		=> array( 'options-page' ),
        'option_key'		=> 'games_options',
        'parent_slug'     	=> 'edit.php?post_type=games',
	) );
	$cmb->add_field( array(
		'name'    => esc_html__( 'Whatsapp Pembelian', 'velocity-gameol' ),
		'desc'    => esc_html__( 'Aktifkan Pembelian lewat Whatsapp', 'velocity-gameol' ),
		'id'      => 'waorder',
		'type'    => 'checkbox',
		'default' => false,
	) );
	$cmb->add_field( array(
		'name'    => esc_html__( 'No Whatsapp Pembelian', 'velocity-gameol' ),
		'desc'    => esc_html__( 'Isi nomor whatsapp tujuan pembelian ke whatsapp admin', 'velocity-gameol' ),
		'id'      => 'nowhatsapp',
		'type'    => 'text',
	) );
	$cmb->add_field( array(
		'name'    => esc_html__( 'Data Pembelian', 'velocity-gameol' ),
		'desc'    => esc_html__( 'Simpan data pembelian', 'velocity-gameol' ),
		'id'      => 'dataorder',
		'type'    => 'checkbox',
		'default' => false,
	) );
	$cmb->add_field( array(
		'name'    => esc_html__( 'reCaptcha', 'velocity-gameol' ),
		'desc'    => esc_html__( 'Aktfikan reCaptcha', 'velocity-gameol' ),
		'id'      => 'recaptcha',
		'type'    => 'checkbox',
		'default' => false,
	) );
    $group_field_id = $cmb->add_field( array(
		'name'    	  => esc_html__( 'Pilihan Metode Pembayaran', 'velocity-gameol' ),
        'id'          => 'metode_pembayaran',
        'type'        => 'group',
        'description' => __( '', 'velocity-gameol' ),
        'options'     => array(
            'group_title'       => __( 'Pembayaran {#}', 'velocity-gameol' ),
            'add_button'        => __( 'Tambah Pembayaran', 'velocity-gameol' ),
            'remove_button'     => __( 'Hapus', 'velocity-gameol' ),
            'sortable'          => true,
        ),
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name' => 'Nama Pembayaran',
        'id'   => 'title',
        'type' => 'text',
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name' => 'Deskripsi Pembayaran',
        'id'   => 'description',
        'type' => 'textarea_small',
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name'    => 'Logo',
        'desc'    => 'upload gambar 150x60',
        'default' => '',
        'id'      => 'logo',
        'type'    => 'file',
        'query_args' => array(
            'type' => array(
              'image/gif',
              'image/jpeg',
              'image/png',
              'image/webp',
            ),
        ),
    ) );  
}

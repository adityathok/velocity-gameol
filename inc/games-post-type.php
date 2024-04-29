<?php
add_action('init', 'games_post_type');
function games_post_type() {
    register_post_type('games', array(
        'labels' => array(
            'name' => 'Games',
            'singular_name' => 'games',
        ),
        'menu_icon'     => 'dashicons-games',
        'public'        => true,
        'has_archive'   => true,
        'show_in_rest'  => true,
        'menu_position' => 8,
        'taxonomies'    => array('category-games'),
        'supports'      => array(
            'title',
            'editor',
            'thumbnail',
        ),
   ));
}
add_action( 'init', 'games_add_taxonomy' );
function games_add_taxonomy() {
  register_taxonomy(
    'category-games',
    'games',
    array(
      'label'             => __( 'Category' ),
      'rewrite'           => array( 'slug' => 'category-games' ),
      'hierarchical'      => true,
      'public'            => true,
      'show_ui'           => true,
      'show_in_menu'      => true,
      'show_in_nav_menus' => true,
      'show_in_rest'      => true,
    )
  );
  register_taxonomy(
    'developer-games',
    'games',
    array(
      'label'             => __( 'Developer' ),
      'rewrite'           => array( 'slug' => 'developer-games' ),
      'hierarchical'      => true,
      'public'            => true,
      'show_ui'           => true,
      'show_in_menu'      => true,
      'show_in_nav_menus' => true,
      'show_in_rest'      => true,
    )
  );
}
//register metabox
add_action( 'cmb2_admin_init', 'games_register_cmb2_metabox' );
function games_register_cmb2_metabox() {
   $cmb = new_cmb2_box( array(
        'id'           => 'games_cmb2_metabox',
        'title'        => 'Detail Game',
        'priority'     => 'high',
        'object_types' => array( 'games' ),
    ) );
  
    $cmb->add_field( array(
      'name' => 'Kelengkapan Data',
      'desc' => 'Data Player / pembeli yang diperlukan untuk pembelian. input dengan format Title|Placeholder,contoh : Player ID|Masukkan ID dengan benar',
      'type' => 'text',
      'id'   => 'kelengkapan_data',
      'repeatable' => true, 
      'text' => array(
          'add_row_text' => 'Tambah Kolom',
      ),
      //'default' => array('Player ID'),
  	) );
  
    $cmb->add_field( array(
      'name' => 'Keterangan Kelengkapan Data',
      'desc' => 'isi dengan info mendapatkan data akun',
      'type' => 'textarea',
      'id'   => 'keterangan_kelengkapan_data',
  	) );

    $cmb->add_field( array(
        'name'    => 'Gambar Keterangan kelengkapan data',
        'desc'    => 'upload gambar info',
        'default' => '',
        'id'      => 'gambar_keterangan_kelengkapan_data',
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
    
    $cmb->add_field( array(
      'name' => 'Nominal',
      'desc' => 'input dengan format Paket|Harga,contoh : 90 Diamonds|500.000',
      'type' => 'text',
      'id'   => 'nominal',
      'repeatable' => true, 
      'text' => array(
          'add_row_text' => 'Tambah Nominal',
      ),
      //'default' => array('Player ID'),
  	) );
  
    $cmb->add_field( array(
        'name'    => 'Gambar Icon Nominal',
        'desc'    => 'Upload gambar icon Nominal',
        'default' => '',
        'id'      => 'icon_nominal',
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
    $cmb->add_field( array(
        'name'    => 'Gambar Banner',
        'desc'    => 'upload gambar banner 1200x280',
        'default' => '',
        'id'      => 'banner',
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

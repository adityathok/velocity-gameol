jQuery(function($){
    $(document).ready(function() {
        $('#formvelogame').submit(function(event) {
          event.preventDefault(); 
          $('#resultTopupModal').modal('show'); 
          $('#resultTopupModal .modal-body').html('<div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div>'); 
      
          // Ambil nilai input dari form dalam bentuk string
          var formData = $(this).serialize();
      
          // Kirim data form
          $.ajax({
            url: velocitygameol.ajaxUrl,
            method: 'POST',
            data: {
              action: 'formtopupgame',
              formdata: formData
            },
            success: function(response) {
                $('#resultTopupModal .modal-body').html(response);
                // Reset form setelah berhasil diproses
                $('#formvelogame')[0].reset();
            },
            error: function(xhr, status, error) {
              // Tanggapan dari server jika terjadi kesalahan
              console.log('Terjadi kesalahan saat memproses form!');
              console.log(xhr.responseText);
            }
          });
        });
        
        $('#resultTopupModal').on('hidden.bs.modal', function() {
            $('#resultTopupModal .modal-body').empty();
        });

        $(document).on('click','.datapembayaran label', function(){
            $('.datapembayaran .infopembayaran').hide(100);
            $(this).find('.infopembayaran').show(100);
        });

        $(document).on('click','#formvelogame .btn-promogame', function(){
            var kode    = $('#kode_promo').val();
            var nominal = $('input[name="nominal"]:checked').val();
            $('#formvelogame .card-promo .card-body .alert').remove();
            $('#formvelogame .card-promo .card-body .btnhapuspromo').remove();

            if(kode && nominal){

                $('#formvelogame .btn-promogame').html('Loading...');
                $.ajax({
                    url: velocitygameol.ajaxUrl,
                    method: 'POST',
                    data: {
                        action: 'submitkodepromogame',
                        kode: kode,
                        nominal: nominal
                    },
                    success: function(response) {
                        $('#formvelogame .card-promo .card-body .alert').remove();
                        $('#formvelogame #potongan').val(response.potongan);
                        $('#formvelogame .btn-promogame').html('Gunakan');
                        if(response.success == 1){
                            $('#formvelogame .card-promo .card-body').append('<div class="alert alert-success mt-2 alert-dismissible fade show">'+response.message+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            $('#formvelogame .card-promo .card-body .col-xl-3').append('<span class="btnhapuspromo btn btn-danger">Hapus</span>');
                        } else {
                            $('#formvelogame .card-promo .card-body').append('<div class="alert alert-warning mt-2 alert-dismissible fade show">'+response.message+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                        }
                    }
                });
                
            } else {
                $('#formvelogame .card-promo .card-body').append('<div class="alert alert-warning mt-2 alert-dismissible fade show">Masukkan Kode dan Pilih Nominal !<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            }
        });

    });

    function hapusKodePromo(){
        $('#formvelogame .card-promo .card-body .alert').remove();
        $('#formvelogame #potongan').val(0);
        $('#formvelogame #kode_promo').val('');
        $('#formvelogame .btn-promogame').html('Gunakan');
        $('#formvelogame .card-promo .card-body .btnhapuspromo').remove(); 
    }
    $(document).on('click','#formvelogame .btnhapuspromo', function(){
        hapusKodePromo();
    });
    $(document).on('change','#formvelogame input[name="nominal"]', function(){
        hapusKodePromo();
    });

    $('#form-cektransaksigame').submit(function(event) {
        event.preventDefault();
        $('.form-cek-transaksi-game .result').html('<div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> Loading...');
        var formData = $(this).serialize();
        $.ajax({
            url: velocitygameol.ajaxUrl,
            method: 'POST',
            data: {
                action: 'cektransaksigame',
                formdata: formData
            },
            success: function(response) {
                $('.form-cek-transaksi-game .result').html(response);
            }
        });
    });

});
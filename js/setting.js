$(document).ready(function () {

    $('#button-cari').hide()
    
    $('#search').on('keyup', function () {
        // $('#konten').load('search/produk.php?keyword=' + $('#search').val())

        
        
        $.get('search/produk.php?keyword=' + $('#search').val(), function(data) {
            $('#konten').html(data)
        })
        
    })
});
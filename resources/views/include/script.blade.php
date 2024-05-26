<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>
<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
<script src="js/demo/chart-bar-demo.js"></script>
<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Bootstrap Touchspin -->
<script src="vendor/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
<!-- Select2 -->
<script src="vendor/select2/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Alert --}}
@if ($message = Session::get('warning'))
    <script>
        Swal.fire({
            title: "Anouncement",
            text: '{{ $message }}',
            icon: "warning"
        });
    </script>
@endif

@if ($message = Session::get('success'))
    <script>
        Swal.fire({
            title: "Good job!",
            text: '{{ $message }}',
            icon: "success"
        });
    </script>
@endif

@if ($message = Session::get('failed'))
    <script>
        Swal.fire({
            title: "Error",
            text: '{{ $message }}',
            icon: "error"
        });
    </script>
@endif
{{-- End Alert --}}

<!-- Page level custom scripts -->
<script>

    //Update Total
    function updateTotal() {
        var total = 0;
        $('tbody tr').each(function() {
            var subtotal = parseFloat($(this).find('td:eq(5)').text());
            total += subtotal;
        });
        $('#total').text('Rp.' + total.toFixed(2));
    }
    //end Update Total

    //Update Grand Total
    function updateGrandTotal() {
        var total = parseFloat($('#total').text().replace('Rp.', '').replace(',', ''));
        var diskon = parseFloat($('#diskon').val().replace('Rp.', '').replace(',', ''));
        var bayar = parseFloat($('#bayar').val().replace('Rp.', '').replace(',', ''));

        var grandTotal = total - diskon;
        var change = bayar - grandTotal;

        $('#grandTotal').text('Rp.' + grandTotal.toFixed(2));
        $('#tf_total').val(grandTotal.toFixed(2));
        if (isNaN(change)) {
            $('#change').text('Isi Pembayaran Terlebih Dahulu');
        } else {
            $('#change').text('Rp.' + change.toFixed(2));
            $('#tf_change').val(change.toFixed(2));
        }
    }
    //end Update Grand Total

    //remove product dari keranjang
    function removeProduct(event){
        $(event).closest('tr').remove();
        updateTotal();
    }
    //end remove product

    //clear
    function clearAddProduct(){
        $('#idBarang').val('');
        $('#namaProduk').val('');
        $('#touchSpin3').val('0');
    }
    //

    $(document).ready(function() {

        updateTotal();
        //clear
        $('#btnClear').on('click', function() {
            clearAddProduct();
        })
        //end clear

        //Bayar Realtime
        $('#bayar').on('input', function() {
            updateGrandTotal();
        });
        //end bayar

        //Diskon Realtime
        $('#diskon').on('change', function() {
            var diskon = $('#diskon').val();
            if (diskon.trim() === '') {
                $('#diskon').val(0);
            }
            updateGrandTotal();
        });
        //end diskon


        //add product to chart
        $('#btnAddproduct').on('click', function() {
        var idBarang = $('#idBarang').val();
        var qty = parseInt($('#touchSpin3').val());

        if (idBarang.trim() === '') {
            alert('ID Barang harus diisi!');
            return;
        }

        if(qty <= 0) {
            alert('Qty harus diisi!');
            return;
        }

        $.ajax({
            url: '/add-to-cart/' + idBarang,
            type: 'GET',
            success: function(data) {
                var namaProduk = data.namaProduk;
                var harga = data.harga;
                var subtotal = harga * qty;
                $('#keranjang tbody').append(`
                    <tr>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)"><i class="fas fa-trash"></i></button></td>
                        <td>
                            ${idBarang}
                            <input type="hidden" name="id_barang[]" value="${idBarang}">
                        </td>
                        <td>
                            ${namaProduk}
                        </td>
                        <td>
                            ${harga}
                            <input type="hidden" name="harga[]" value="${harga}">
                        </td>
                        <td>
                            ${qty}
                            <input type="hidden" name="qty[]" value="${qty}">
                        </td>
                        <td>
                            ${subtotal}
                            <input type="hidden" name="sub_total[]" value="${subtotal}">
                        </td>
                    </tr>
                `);
                updateTotal();
                clearAddProduct();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mendapatkan detail produk!');
            }
            });
        });
        //end addproduct to chart

        //find product realtime
        $('#idBarang').on('input', function() {
            var idBarang = $(this).val();
            if (!idBarang) {
                $('#namaProduk').val('');
                return;
            }
            $.ajax({
                url: '/get-product-name/' + idBarang,
                type: 'GET',
                success: function(data) {
                    $('#namaProduk').val(data.productName);
                },
                error: function(xhr, status, error) {
                    console.error('Product Not Found!');
                }
            })
        });
        //end find product realtime

        //crud barang
        $('.delete-btn').click(function() {
            var barangId = $(this).data('barang-id');
            var barangNama = $(this).data('barang-nama');
            $('#deleteModal').find('.modal-body').html('Anda yakin ingin menghapus data "' +
                barangNama + '"?');
            $('#deleteModal').find('form').attr('action', '/delete-barang/' + barangId);
        });

        $('.edit-btn').click(function() {
            var barangId = $(this).data('barang-id');
            var barangNama = $(this).data('barang-nama');
            var barangStok = $(this).data('barang-stok');
            var barangHargaJual = $(this).data('barang-harga-jual');
            var barangHargaBeli = $(this).data('barang-harga-beli');

            $('#editModal').find('#editNamaProduk').val(barangNama);
            $('#editModal').find('#editStok').val(barangStok);
            $('#editModal').find('#editHargaJual').val(barangHargaJual);
            $('#editModal').find('#editHargaBeli').val(barangHargaBeli);

            $('#editModal').find('form').attr('action', '/update-barang/' + barangId);
        });
        //end crud barang

        //crud user
        $('.delete-btn-user').click(function() {
            var userId = $(this).data('user-id');
            var userName = $(this).data('user-name');
            $('#deleteModalUser').find('.modal-body').html('Anda yakin ingin menghapus data "' +
                userName + '"?');
            $('#deleteModalUser').find('form').attr('action', '/delete-user/' + userId);
        });

        $('.edit-btn-user').click(function() {
            var userId = $(this).data('user-id');
            var userName = $(this).data('user-name');
            var userEmail = $(this).data('user-email');
            var userAddress = $(this).data('user-address');
            var userRole = $(this).data('user-role');
            var userPassword = $(this).data('user-password');

            $('#editModalUser').find('#editUserName').val(userName);
            $('#editModalUser').find('#editUserEmail').val(userEmail);
            $('#editModalUser').find('#editUserAddress').val(userAddress);
            $('#editModalUser').find('form').attr('action', '/update-user/' + userId);
        })
        //end crud user

        $('#dataTableHover').DataTable(); // ID From dataTable with Hover

        $('#touchSpin3').TouchSpin({
            min: 0,
            max: 100,
            initval: 0,
            boostat: 5,
            maxboostedstep: 10,
            verticalbuttons: true,
        });

        // Select2 Single  with Placeholder
        $('.select2-single-placeholder').select2({
            placeholder: "Select Customer",
            allowClear: true
        });
    });
</script>

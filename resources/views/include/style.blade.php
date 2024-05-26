<link href="img/logo/logo.png" rel="icon">
<link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/ruang-admin.min.css') }}" rel="stylesheet" type="text/css">
<!-- Select2 -->
<link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
<style>
    .dataTables_wrapper .dataTables_length {
        float: left;
        /* Menempatkan tombol limit di kiri */
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
        /* Menempatkan kotak pencarian di kanan */
    }

    label {
        display: flex;
        margin-bottom: .5rem;
        flex-direction: row;
        gap: 10px;
    }

    .select2-container--default .select2-selection--single {
        height: 42px;
        align-content: center;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 8px;
        right: 1px;
        width: 20px;
    }

    #dataTableHover_paginate {
        float: right;
    }
</style>

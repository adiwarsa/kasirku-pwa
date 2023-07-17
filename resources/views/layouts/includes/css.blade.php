<!-- General CSS Files -->
<link rel="stylesheet" href="{{ asset('/fontawesome/css/all.css') }}">
<link rel="stylesheet" href="{{ asset('/bootstrap4/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('/bootstrap4/css/bootstrap.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('/bootstrap5/css/bootstrap.min.css') }}"> --}}



<!-- Template CSS -->
<link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/components.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/custom.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('/DataTables/datatables.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">


<style>
    .eggy {
        z-index: 4;
    }

    .navbar {

        z-index: 3;
    }

    body {
        font-family: 'Lt_Museum_Light';
    }

    .table th {
        background-color: #70A8EC !important;
        color: white !important;
        font-size: 15px;
        border: 0 !important;
    }

    .checked-class {
        color: #fff;
        background-color: #23e2ff;
        border-color: #23e2ff;
    }

    .checked-class2 {
        color: #fff;
        background-color: #ff2323;
        border-color: #ff2323;
    }

    .table th,
    td {
        text-align: center !important;
        color: black;
    }

    .date {
        position: relative;
        /*width: 150px; height: 20px;*/
        /*color: white;*/

        display: block;
        width: 100%;
        height: 2.4rem;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #000000;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        box-shadow: inset 0 0 0 transparent;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        align-content: center;
    }

    .date:before {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 0.8em;
        content: attr(data-date);
        display: block;
        color: #000000;
    }


    .date::-webkit-datetime-edit,
    .date::-webkit-inner-spin-button,
    .date::-webkit-clear-button {
        display: none;
    }

    .date::-webkit-calendar-picker-indicator {
        position: absolute;
        top: 10px;
        right: 13px;
        color: #000000;
    }
</style>

@yield('container.css')

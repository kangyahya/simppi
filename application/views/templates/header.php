<?php
defined('BASEPATH') or exit('No direct script access allowed');
$getPengaturan = getData('pengaturan_aplikasi');
$pengaturan = null;
if ($getPengaturan) {
    $pengaturan = $getPengaturan[0];
}

$arr_color_theme = [
    'DEFAULT' => '#6777ef',
    'RED' => '#fc544b',
    'GREEN' => '#63ed7a',
    'ORANGE' => '#ffa426',
    'BLUE' => '#1269db',// '#3abaf4'
];

$appName = "Codepos App";
if ($pengaturan !== null) {
    $appName = $pengaturan->app_name;
}

$uri1 = $this->uri->segment(1);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title><?php echo $title; ?> - <?php echo $appName; ?></title>

        <!-- General CSS Files -->
        <link rel="stylesheet"
              href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/my-style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2-bootstrap4.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/Responsive-2.2.1/css/responsive.bootstrap4.min.css">

        <link rel="icon shortcut" href="<?php echo base_url('assets/img/logo.svg') ?>">

        <!-- CSS Libraries -->
        <?php if ($uri1 == "rekening-koran"): ?>
            <link rel="stylesheet" href="<?php echo base_url('assets/modules/jquery-ui/jquery-ui.css'); ?>">
        <?php endif; ?>
        <!-- Template CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">
        <!-- Start GA -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-94034622-3');
        </script>
        <!-- /END GA -->
    </head>
<?php
if ($pengaturan !== null) {
    $selectedTheme = $pengaturan->color_theme;
    $hexColor = $arr_color_theme[$selectedTheme];
    ?>
    <style type="text/css">
        .main-sidebar .sidebar-menu li a {
            color: #868e96 !important;
        }

        a,
        .main-sidebar .sidebar-menu li ul.dropdown-menu li.active > a,
        ul.sidebar-menu a.nav-link:hover,
        .text-primary {
            color: <?php echo $hexColor; ?> !important;
        }

        .navbar-bg,
        ul.sidebar-menu > li.active,
        ul.sidebar-menu > li.active > a.nav-link:hover,
        .section .section-title:before,
        body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu > li.active > a:before,
        .btn-primary, .btn-primary:hover,
        .custom-switch-input:checked ~ .custom-switch-indicator,
        .swal-button.swal-button--confirm,
        body.sidebar-mini .main-sidebar .sidebar-menu > li.active > a,
        .select2-results__option--highlighted,
        .badge-primary, .btn-primary:focus, .btn-primary:focus-within, .btn-primary:active, .btn-primary:visited,
        body.sidebar-mini .main-sidebar .sidebar-menu > li ul.dropdown-menu li > a:focus, body.sidebar-mini .main-sidebar .sidebar-menu > li ul.dropdown-menu li.active > a, body.sidebar-mini .main-sidebar .sidebar-menu > li ul.dropdown-menu li.active > a:hover {
            background-color: <?php echo $hexColor; ?> !important;
        }

        .btn, .badge,
        body.sidebar-mini .main-sidebar .sidebar-menu > li ul.dropdown-menu li > a:focus, body.sidebar-mini .main-sidebar .sidebar-menu > li ul.dropdown-menu li.active > a, body.sidebar-mini .main-sidebar .sidebar-menu > li ul.dropdown-menu li.active > a:hover {
            color: #fff !important;
        }

        .btn-light {
            color: #191d21 !important;
        }

        .page-item.active .page-link {
            background-color: <?php echo $hexColor; ?> !important;
            border-color: <?php echo $hexColor; ?> !important;
            color: #fff !important;
        }

        .navbar .nav-link.nav-link-user {
            color: #fff !important;
        }

        .border-primary, .btn-primary,
        .select2-container.select2-container--open .select2-selection--single le {
            border-color: <?php echo $hexColor; ?> !important;
        }

        .card.card-primary {
            border-top: 3px solid <?php echo $hexColor; ?> !important;
        }

        <?php if($uri1 == "rekening-koran"): ?>

        /* Jquery Autocomplete Bootstrap style
        */
        .ui-autocomplete {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            text-align: left;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
        }

        .ui-autocomplete > li > div {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333333;
            white-space: nowrap;
        }

        .ui-state-hover,
        .ui-state-active,
        .ui-state-focus {
            text-decoration: none;
            color: #262626;
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .ui-helper-hidden-accessible {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        /* End jquery autocomplete style */
        <?php endif; ?>
    </style>
    <?php
}
?>
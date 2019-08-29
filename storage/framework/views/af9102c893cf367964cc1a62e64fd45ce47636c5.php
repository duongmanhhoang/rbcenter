<head>
    <meta charset="utf-8" />
    <title>RB Center | Dashboard</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    
        
            
                
            
            
                
            
        
    
    <link href="<?php echo e(asset('bower_components/admin/css/style.css')); ?>" type="text/css" rel="stylesheet">


    <!--end::Web font -->

    <!--begin::Base Styles -->

    <!--begin::Page Vendors -->
    <link href="<?php echo e(asset('bower_components/admin/metronic/vendors/custom/fullcalendar/fullcalendar.bundle.css')); ?>" rel="stylesheet" type="text/css" />



<!--end::Page Vendors -->
    <link href="<?php echo e(asset('bower_components/admin/metronic/vendors/base/vendors.bundle.css')); ?>" rel="stylesheet" type="text/css" />

<!--RTL version:<link href="<?php echo e(asset('admin/metronic/vendors/base/vendors.bundle.rtl.css" rel="stylesheet')); ?>" type="text/css" />-->
    <link href="<?php echo e(asset('bower_components/admin/metronic/demo/default/base/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />



<!--end::Base Styles -->



    <!--Style.css-->

    <style type="text/css">span.im-caret {
            -webkit-animation: 1s blink step-end infinite;
            animation: 1s blink step-end infinite;
        }

        @keyframes  blink {
            from, to {
                border-right-color: black;
            }
            50% {
                border-right-color: transparent;
            }
        }

        @-webkit-keyframes blink {
            from, to {
                border-right-color: black;
            }
            50% {
                border-right-color: transparent;
            }
        }

        span.im-static {
            color: grey;
        }

        div.im-colormask {
            display: inline-block;
            border-style: inset;
            border-width: 2px;
            -webkit-appearance: textfield;
            -moz-appearance: textfield;
            appearance: textfield;
        }

        div.im-colormask > input {
            position: absolute;
            display: inline-block;
            background-color: transparent;
            color: transparent;
            -webkit-appearance: caret;
            -moz-appearance: caret;
            appearance: caret;
            border-style: none;
            left: 0; /*calculated*/
        }

        div.im-colormask > input:focus {
            outline: none;
        }

        div.im-colormask > input::-moz-selection{
            background: none;
        }

        div.im-colormask > input::selection{
            background: none;
        }
        div.im-colormask > input::-moz-selection{
            background: none;
        }

        div.im-colormask > div {
            color: black;
            display: inline-block;
            width: 100px; /*calculated*/
        }</style>

    <style type="text/css">/* Chart.js */
        @-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes  chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">


</head><?php /**PATH /var/www/html/rbcenter/admin/resources/views/admin/layouts/head.blade.php ENDPATH**/ ?>
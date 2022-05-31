@include('front.layouts.head')
<body class="productPage">
<!-- wpf loader Two -->
<div id="wpf-loader-two">
    <div class="wpf-loader-two-inner">
        <span>Loading</span>
    </div>
</div>
<!-- / wpf loader Two -->
<!-- SCROLL TOP BUTTON -->
<a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
<!-- END SCROLL TOP BUTTON -->


@include('front.layouts.header')



@section('container')

@show


<!-- footers -->
@extends('front.layouts.footer')
<!-- / footer -->


@extends('front.layouts.scripts')


</body>
</html>

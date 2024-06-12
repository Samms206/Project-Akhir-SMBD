@include('include.header')

<div id="wrapper">
    {{-- sidebar --}}
    @include('include.sidebar')
    {{-- sidebar --}}
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            {{-- topbar --}}
            @include('include.topbar')
            {{-- topbar --}}

            <!-- Container Fluid-->
            @yield('content')
            <!---Container Fluid-->
        </div>
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> - developed by
                        <b><a href="https://github.com/Samms206/" target="_blank">Sams</a></b>
                    </span>
                </div>
            </div>
        </footer>
        <!-- Footer -->
    </div>
</div>
@include('include.footer')

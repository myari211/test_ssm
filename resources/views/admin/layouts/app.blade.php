<html>
    <head>
        {{-- initiate head --}}
        @include('master.css')
    </head>
    <body>
        {{-- initiate alert --}}
        @include('sweetalert::alert')

        <!--Navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark primary-color d-flex justify-content-end">
            <a class="text-white" onClick="event.preventDefault(); document.getElementById('logout').submit()">Log Out</a>
            <form method="post" action="{{ route('logout') }}" id="logout">
                @csrf
            </form>
        </nav>
        {{-- end navbar --}}

        <div class="row">
            {{-- sidebar --}}
            <div class="col-2 z-depth-1 bg-primary" style="height: 100vh;">
                <div class="row">
                    <div class="col-12">
                        <a class="w-100 navlink text-white d-flex align-items-center" href="{{ route('admin.dashboard', Auth::user()->id) }}">Dashboard</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="navlink text-white">Books</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a class="w-100 navlink-submenu text-white d-flex align-items-center" href="{{ route('admin.books_category') }}">Kategori</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a class="w-100 navlink-submenu text-white d-flex align-items-center" href="{{ route('admin.books_list') }}">Daftar Buku</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a class="w-100 navlink text-white d-flex align-items-center" href="{{ route('admin.users') }}">Anggota</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a class="w-100 navlink text-white d-flex align-items-center" href="{{ route('admin.transaction') }}">Peminjaman</a>
                    </div>
                </div>
            </div>
            {{-- end sidebar --}}
            <div class="col-8">
                {{-- content-section --}}
                @yield('content')
            </div>
        </div>

        {{-- initiate js --}}
        @include('master.js')
    </body>
</html>
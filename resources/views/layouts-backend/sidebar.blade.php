<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">

            <a href="index.html" class="logo">
                <img src="{{ asset('backend') }}/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20">
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="../demo1/index.html">
                                    <span class="sub-item">Dashboard 1</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">MENU</h4>
                </li>
                <li class="nav-item {{ Route::is('student.index') || Route::is('leader.index') || Route::is('extra.index') || Route::is('student.edit') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#charts">
                        <i class="far fa-chart-bar"></i>
                        <p>Tabel</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav nav-collapse">
                            <li class="{{ Route::is('student.index') || Route::is('student.edit') ? 'active' : '' }}">
                                <a href="{{ route('student.index') }}" wire:navigate>
                                    <span class="sub-item">Siswa</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('leader.index') ? 'active' : '' }}">
                                <a href="{{ route('leader.index') }}" wire:navigate>
                                    <span class="sub-item">Pembina Ekstra</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('extra.index') ? 'active' : '' }}">
                                <a href="{{ route('extra.index') }}" wire:navigate>
                                    <span class="sub-item">Ekstra</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->

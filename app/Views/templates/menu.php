<!-- main header @s -->
<div class="nk-header nk-header-fluid is-theme">
    <div class="container-xl wide-xl">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger me-sm-2 d-lg-none">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand">
                <a href="<?= base_url('/'); ?>" class="logo-link">
                    <img class="logo-light logo-img" src="<?= base_url('images/logo-log-2-white.png'); ?>" srcset="<?= base_url('images/logo-log-2-white.png'); ?>" alt="logo">
                    <img class="logo-dark logo-img" src="<?= base_url('images/logo-log-2-white.png'); ?>" srcset="<?= base_url('images/logo-log-2-white.png'); ?>" alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <div class="nk-header-menu" data-content="headerNav">
                <div class="nk-header-mobile">
                    <div class="nk-header-brand">
                        <a href="<?= base_url('/'); ?>" class="logo-link">
                            <img class="logo-light logo-img" src="<?= base_url('images/logo-log-2-white.png'); ?>" srcset="<?= base_url('images/logo-log-2-white.png'); ?>" alt="logo">
                            <img class="logo-dark logo-img" src="<?= base_url('images/logo-log-2-white.png'); ?>" srcset="<?= base_url('images/logo-log-2-white.png'); ?>" alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div>
                <ul class="nk-menu nk-menu-main ui-s2">
                    <!-- <li class="nk-menu-item">
                        <a href="#" class="nk-menu-link">
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li> -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-text">Asset</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?= base_url('/pemasukan'); ?>" class="nk-menu-link">
                                    <span class="nk-menu-text">Pemasukan</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= base_url('/alokasi'); ?>" class="nk-menu-link">
                                    <span class="nk-menu-text">Alokasi</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= base_url('/pengeluaran'); ?>" class="nk-menu-link">
                                    <span class="nk-menu-text">Pengeluaran</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="<?= base_url('/laporan'); ?>" class="nk-menu-link">
                            <span class="nk-menu-text">Laporan</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-header-menu -->
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown order-sm-first">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-status"><?= $_SESSION['level']; ?></div>
                                    <div class="user-name dropdown-indicator"><?= $_SESSION['nama']; ?></div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="lead-text"><?= $_SESSION['nama']; ?></span>
                                        <span class="sub-text"><?= $_SESSION['email']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-alt"></em><span>Profile</span></a></li>
                                    <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Password</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="<?= base_url('/auth/logout'); ?>"><em class="icon ni ni-signout"></em><span>Logout</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li><!-- .dropdown -->
                </ul><!-- .nk-quick-nav -->
            </div><!-- .nk-header-tools -->
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>
<!-- main header @e -->
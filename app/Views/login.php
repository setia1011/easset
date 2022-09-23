<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logos/favicon.png'); ?>">
    <!-- Page Title  -->
    <title>e-asset | Login</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashlite.css?ver=3.0.0'); ?>">
    <link id="skin-default" rel="stylesheet" href="<?= base_url('assets/css/theme.css?ver=3.0.0'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css'); ?>">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main" id="login">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="<?= base_url('/auth/login'); ?>" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="./images/logo-log-2.png" srcset="./images/logo-log-2.png" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="./images/logo-log-2.png" srcset="./images/logo-log-2.png" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Login</h4>
                                        <div class="nk-block-des">
                                            <p>Access the e-asset panel using your password</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="auth-form">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Username</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" v-model="username" placeholder="Enter your username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                            <!-- <a class="link link-primary link-sm" href="html/pages/auths/auth-reset-v2.html">Forgot Pass?</a> -->
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg" v-model="password" placeholder="Enter your password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block" v-on:click="auth">Login</button>
                                        <div class="loading-info" v-show="loading">
                                            <img src="<?= base_url('assets/images/utils/loading.svg'); ?>"> authenticating...
                                        </div>
                                        <div class="login-info" v-show="linfo">
                                            <div v-if="ainfo == 'Berhasil login..'" class="alert alert-success alert-icon">
                                                <em class="icon ni ni-check-circle"></em> <strong>{{ ainfo }}</strong>
                                            </div>
                                            <div v-else class="alert alert-danger alert-icon">
                                                <em class="icon ni ni-cross-circle"></em> <strong>{{ ainfo }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-footer nk-auth-footer-full">
                        <div class="container wide-lg">
                            <div class="row g-3">
                                <div class="col-lg-6 order-lg-last">
                                    <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Terms & Condition</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Help</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="https://techack.id" class="nav-link"><em class="icon ni ni-terminal"></em><span class="ms-1">TecHack</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="nk-block-content text-center text-lg-left">
                                        <p class="text-soft">&copy; 2022 e-asset | <a href="https://global.ac.id">Global Institute</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.0.0"></script>
    <script src="./assets/js/scripts.js?ver=3.0.0"></script>

    <script src="<?= base_url('assets/plugins/vue/vue.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/axios/axios.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/lodash/lodash.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/setia/authenticate.js'); ?>"></script>
</html>
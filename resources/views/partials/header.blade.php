 <!-- app-header -->
 @if (Auth::check() && Auth::user()->role !== 'user')
     <header class="app-header">
         <!-- Start::main-header-container -->
         <div class="main-header-container container-fluid">
             


             <!-- Start::header-content-left -->
             <div class="header-content-left">

                 <!-- Start::header-element -->
                 <div class="header-element">
                     <div class="horizontal-logo">
                         <a href="index.html" class="header-logo">
                             <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
                                 class="desktop-logo">
                             <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                                 class="toggle-logo">
                             <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                                 class="desktop-dark">
                             <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                                 class="toggle-dark">
                             <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo"
                                 class="desktop-white">
                             <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo"
                                 class="toggle-white">
                         </a>
                     </div>
                 </div>
                 <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link -->
                    <a onclick="smallLogoByMehul()" aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

             </div>
             <!-- End::header-content-left -->

             <!-- Start::header-content-right -->
             <div class="header-content-right">

                 <!-- Start::header-element -->
                 <div class="header-element header-theme-mode">
                     <!-- Start::header-link|layout-setting -->
                     <!-- <a href="javascript:void(0);" class="header-link layout-setting"> -->
                         <!-- <span class="light-layout" > -->
                             <!-- Start::header-link-icon -->
                             <!-- <i class="fe fe-moon header-link-icon lh-2"></i> -->
                             <!-- End::header-link-icon -->
                         <!-- </span> -->
                         <!-- <span class="dark-layout">
                             Start::header-link-icon
                             <i class="fe fe-sun header-link-icon lh-2"></i> -->
                             <!-- End::header-link-icon -->
                         <!-- </span> -->
                     <!-- </a> -->
                     <!-- End::header-link|layout-setting -->
                 </div>
                 <!-- End::header-element -->



                 <!-- Start::header-element -->
                 <!-- <div class="header-element header-fullscreen  d-xl-flex d-none">
                
                    <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                        <i class="fe fe-maximize full-screen-open header-link-icon"></i>
                        <i class="fe fe-minimize full-screen-close header-link-icon d-none"></i>
                    </a>
                
                </div> -->
                 <!-- End::header-element -->



                 <!-- Start::header-element -->
                 <!-- <div class="header-element right-sidebar d-xl-flex d-none">
                    <a href="javascript:void(0);" class="header-link right-sidebar" data-bs-toggle="offcanvas" data-bs-target="#right-sidebar-canvas">
                        <i class="fe fe-align-right header-icons header-link-icon"></i>
                    </a>
                </div> -->
                 <!-- End::header-element -->


                 <!-- Start::header-element -->
                 <div class="header-element">
                     <!-- Start::header-link|dropdown-toggle -->
                     <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                         data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                         <div class="d-flex align-items-center">
                             <div class="header-link-icon">
                                 <img src="{{ asset('images/wineAvatar.png') }}" alt="img" width="32"
                                     height="32" class="rounded-circle">
                             </div>
                             <div class="d-none">
                                 <p class="fw-semibold mb-0">{{ Auth::check() ? Auth::user()->first_name : 'Guest' }}
                                 </p>
                                 <span class="op-7 fw-normal d-block fs-11">Super Admin</span>
                             </div>
                         </div>
                     </a>
                     <!-- End::header-link|dropdown-toggle -->
                     <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                         aria-labelledby="mainHeaderProfile">
                         <Li>
                             <div class="header-navheading border-bottom">
                                 <h6 class="main-notification-title">
                                {{ Auth::check() 
                                    ? ucfirst(Auth::user()->first_name) . ' ' . ucfirst(Auth::user()->last_name) 
                                    : 'Guest' 
                                }}
                                 </h6>
                                 <p class="main-notification-text mb-0">
                                     {{ Auth::check() ? Auth::user()->username : '' }}</p>

                             </div>
                         </Li>

                         <li><a class="dropdown-item d-flex border-bottom"
                                 href="{{ route('user.userprofile.show') }}"><i
                                     class="fe fe-user fs-16 align-middle me-2"></i>User Profile</a></li>
                         {{-- Show Store Profile only for Store Manager --}}
                         @if (Auth::check() && Auth::user()->role === 'store_manager')
                             <li>
                                 <a class="dropdown-item d-flex border-bottom"
                                     href="{{ route('user.storeprofile.show') }}">
                                     <i class="fe fe-user fs-16 align-middle me-2"></i>Store Profile
                                 </a>
                             </li>
                         @endif
                         <li>
                             <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                 @csrf
                                 <a class="dropdown-item d-flex" href="{{ route('logout') }}"
                                     class="dropdown-item d-flex"
                                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                     <i class="fe fe-power fs-16 align-middle me-2"></i> {{ __('Log Out') }}
                                 </a>
                             </form>
                         </li>
                     </ul>
                 </div>
                 <!-- End::header-element -->




                 <!-- Start::header-element -->
                 <div class="header-element">
                     <!-- Start::header-link|switcher-icon -->
                     <!-- <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                        <i class="fe fe-settings header-link-icon"></i>
                    </a> -->
                     <!-- End::header-link|switcher-icon -->
                 </div>
                 <!-- End::header-element -->

             </div>
             <!-- End::header-content-right -->

         </div>
         <!-- End::main-header-container -->

     </header>
 @endif
 <!-- /app-header -->

<?php

$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();

?>



<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('backend/img/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Al-Falah Hospital</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ !empty(Auth::user()->image) ? asset('backend/img/uploads/' . Auth::user()->image) : asset('backend/img/avatar.png') }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profileView') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                @if (Auth::user()->usertype == 'developers')
                    <li class="nav-item {{ $prefix == '/users' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('backUsersView') }}"
                                    class="nav-link {{ $route == 'backUsersView' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Users</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif





                <li class="nav-item {{ $prefix == '/profile' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profile
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('profileView') }}"
                                class="nav-link {{ $route == 'profileView' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Your Profile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('profilePasswordView') }}"
                                class="nav-link {{ $route == 'profilePasswordView' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item {{ $prefix == '/admission' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Indoor
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admission_form_view') }}"
                                class="nav-link {{ $route == 'admission_form_view' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admit patient</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('all_regi_patient') }}"
                                class="nav-link {{ $route == 'all_regi_patient' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Patient Lists</p>
                            </a>
                        </li>

                    </ul>
                </li>



                <li class="nav-item {{ $prefix == '/outdoor' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Outdoor
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('outdoor_regi_form') }}"
                                class="nav-link {{ $route == 'outdoor_regi_form' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Service</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('all_out_regi_patient') }}"
                                class="nav-link {{ $route == 'all_out_regi_patient' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Service Lists</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('outdoorServiceView') }}"
                                class="nav-link {{ $route == 'outdoorServiceView' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Service</p>
                            </a>
                        </li>

                    </ul>
                </li>






                <li class="nav-item {{ $prefix == '/data-entry' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Data Entry
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('add_expenditure_index') }}"
                                class="nav-link {{ $route == 'add_expenditure_index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expenditure Category</p>
                            </a>
                            <a href="{{ route('expenditure_form') }}"
                                class="nav-link {{ $route == 'expenditure_form' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expenditure Form</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('add_income_index') }}"
                                class="nav-link {{ $route == 'add_income_index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Income Category</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('income_form') }}"
                                class="nav-link {{ $route == 'income_form' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Income Form</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('service_index') }}"
                                class="nav-link {{ $route == 'service_index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Services</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('cabinForm') }}"
                                class="nav-link {{ $route == 'cabinForm' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cabin Settings</p>
                            </a>
                        </li>

                    </ul>
                </li>






                @if (auth()->user()->usertype == 'admin' || auth()->user()->usertype == 'developers')
                    <li class="nav-item {{ $prefix == '/accounts' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Accounts
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">



                            {{-- Outdoor --}}

                            <li class="nav-item">
                                <a href="{{ route('outdoor_income') }}"
                                    class="nav-link  {{ $route == 'outdoor_income' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Outdoor</p>
                                </a>
                            </li>

                            {{-- Outdoor End --}}


                            {{-- Outdoor --}}

                            <li class="nav-item">
                                <a href="{{ route('indoor_income') }}"
                                    class="nav-link  {{ $route == 'indoor_income' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Indoor</p>
                                </a>
                            </li>

                            {{-- Outdoor End --}}


                            <li class="nav-item">
                                <a href="{{ route('expenditureCalculation') }}"
                                    class="nav-link {{ $route == 'expenditureCalculation' ? 'active' : '' }} ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Expenditure</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('incomeCalculation') }}"
                                    class="nav-link {{ $route == 'incomeCalculation' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Others Income</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('accountsBook') }}"
                                    class="nav-link {{ $route == 'accountsBook' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Accounts Book</p>
                                </a>
                            </li>


                        </ul>
                    </li>
                @endif

                {{-- <li>
                    <a href="{{ route('receipt_generate') }}">Receipt</a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

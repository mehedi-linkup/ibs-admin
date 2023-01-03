<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                {{-- <div class="sb-sidenav-menu-heading">Interface</div> --}}
                @php
                    $setup = ['buyer.index', 'gm.index', 'sample_name.index', 'supplier.index', 'merchant.index', 'color.index',
                    'coordinator.index', 'wash.coordinator.index', 'finishing.coordinator.index', 'wash.unit.index', 'cad.index'];
                @endphp
                <a class="nav-link {{ in_array(Route::current()->getName(), $setup) ? '' : 'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    All Setup
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ in_array(Route::current()->getName(), $setup) ? 'show' : ''}}" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        {{-- <a class="nav-link {{ Request::is('department') ? 'active' : '' }}" href="{{ route('department.index') }}">+ Add Department</a> --}}
                        <a class="nav-link {{ Request::is('buyer') ? 'active' : '' }}" href="{{ route('buyer.index') }}">+ Add Buyer</a>
                        <a class="nav-link {{ Request::is('gm') ? 'active' : '' }}" href="{{ route('gm.index') }}">+ Add Gm</a>
                        <a class="nav-link {{ Request::is('sample_name') ? 'active' : '' }}" href="{{ route('sample_name.index') }}">+ Sample Name</a>
                        <a class="nav-link {{ Request::is('supplier') ? 'active' : '' }}" href="{{ route('supplier.index') }}">+ Add Supplier</a>
                        {{-- <a class="nav-link {{ Request::is('factory') ? 'active' : '' }}" href="{{ route('factory.index') }}">+ Add Factory</a> --}}
                        <a class="nav-link {{ Request::is('merchant') ? 'active' : '' }}" href="{{ route('merchant.index') }}">+ Add Merchant</a>
                        <a class="nav-link {{ Request::is('color') ? 'active' : '' }}" href="{{ route('color.index') }}">+ Add Color</a>
                        {{-- <a class="nav-link {{ Request::is('unit') ? 'active' : '' }}" href="{{ route('unit.index') }}">+ Add Unit</a> --}}
                        <a class="nav-link {{ Request::is('coordinator') ? 'active' : '' }}" href="{{ route('coordinator.index') }}">+ Add Coordinator</a>
                        <a class="nav-link {{ Request::is('wash-coordinator') ? 'active' : '' }}" href="{{ route('wash.coordinator.index') }}">+ Wash Coordinator</a>
                        <a class="nav-link {{ Request::is('finishing-coordinator') ? 'active' : '' }}" href="{{ route('finishing.coordinator.index') }}">+ Finishing Coordinator</a>
                        <a class="nav-link {{ Request::is('wash-unit') ? 'active' : '' }}" href="{{ route('wash.unit.index') }}">+ Wash Unit</a>
                        <a class="nav-link {{ Request::is('cad') ? 'active' : '' }}" href="{{ route('cad.index') }}">+ Cad Desinger</a>
                    </nav>
                </div>
                {{-- <a class="nav-link collapsed {{  Request::is('product*') ? 'active' : ''  }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProuct" aria-expanded="false" aria-controls="collapseProuct">
                    <div class="sb-nav-link-icon"><i class="fab fa-product-hunt"></i></div>
                    Product
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProuct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{  Request::is('product*') ? 'active' : ''  }}" href="{{ route('product.index') }}"> Product List</a>
                        <a class="nav-link" href="{{ route('product.data') }}"> ProductData list</a>
                        <a class="nav-link" href="{{ route('get.full.product') }}"> All Product</a>
                        @if(Auth::user()->username == 'SuperAdmin')
                        <a class="nav-link" href="{{ route('product.data.wise.search') }}"> Product Search</a>
                        <a class="nav-link" href="{{ route('product.search') }}"> Product Filter</a>
                        @endif
                    </nav>
                </div> --}}
                {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseOrder" aria-expanded="false" aria-controls="collapseOrder">
                    <div class="sb-nav-link-icon"><i class="fab fa-first-order"></i></div>
                    Order 
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseOrder" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{  Request::is('order') ? 'active' : ''  }}" href="{{ route('order.index') }}"> Order List</a>
                        <a class="nav-link {{  Request::is('order_data') ? 'active' : ''  }}" href="{{ route('order.data') }}"> Order Data List</a>
                        <a class="nav-link {{  Request::is('order/details') ? 'active' : ''  }}" href="{{ route('order.details') }}"> Order Details List</a>
                        <a class="nav-link {{  Request::is('order/details/data') ? 'active' : ''  }}" href="{{ route('order.details.data') }}"> Order Details Data List</a>
                    </nav>
                </div> --}}
                @php
                    $sample = ['sample.index', 'sample.data', 'blank.data', 'inactive.data'];
                @endphp
                <a class="nav-link {{ in_array(Route::current()->getName(), $sample) ? '' : 'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSample" aria-expanded="false" aria-controls="collapseSample">
                    <div class="sb-nav-link-icon"><i class="fab fa-first-order"></i></div>
                    Sample 
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
               
                <div class="collapse {{ in_array(Route::current()->getName(), $sample) ? 'show' : ''}}" id="collapseSample" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{  Request::is('sample') ? 'active' : ''  }}" href="{{ route('sample.index') }}"> Sample List</a>
                        <a class="nav-link {{  Request::is('sample_data') ? 'active' : ''  }}" href="{{ route('sample.data') }}"> Sample Data List</a>
                        <a class="nav-link {{  Request::is('blank_data') ? 'active' : ''  }}" href="{{ route('blank.data') }}"> Blank Data</a>
                        @if(Auth::user()->username == 'SuperAdmin')
                        <a class="nav-link {{  Request::is('inactive_data') ? 'active' : ''  }}" href="{{ route('inactive.data') }}"> Inactive Data</a>
                        @endif
                    </nav>
                </div>
                {{-- @if(Auth::user()->username == 'SuperAdmin') --}}
                @php
                    $material = ['materials.index', 'blank.materials'];
                @endphp
                <a class="nav-link {{ in_array(Route::current()->getName(), $material) ? '' : 'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseOrderReport" aria-expanded="false" aria-controls="collapseOrderReport">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Materials 
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ in_array(Route::current()->getName(), $material) ? 'show' : ''}}" id="collapseOrderReport" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{  Request::is('materials') ? 'active' : ''  }}" href="{{ route('materials.index') }}"> Data Entry</a>
                        <a class="nav-link {{  Request::is('blank/materials') ? 'active' : ''  }}" href="{{ route('blank.materials') }}"> Blank Data</a>
                    </nav>
                </div>
                {{-- @endif --}}
                @php
                    $authenticate = ['role.index', 'register', 'permission.index'];
                @endphp
                @if(Auth::user()->username == 'SuperAdmin')
                <a class="nav-link {{in_array(Route::current()->getName(), $authenticate) ? '' : 'collapsed'}} {{Request::is('role') ? ' active' : ''}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAuth" aria-expanded="false" aria-controls="collapseAuth">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                    Authentication
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{in_array(Route::current()->getName(), $authenticate) ? 'show' : ''}}" id="collapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('role.index') }}">+ New Role</a>
                        <a class="nav-link" href="{{ route('register') }}">+ New User</a>
                        <a class="nav-link" href="{{ route('permission.index') }}">+ Permission</a>
                    </nav>
                </div>
                @endif
                <a class="nav-link {{ Request::is('logout') ? 'active' : '' }}" href="{{ route('logout') }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-sign-out-alt"></i></div>
                    Log Out
                </a>
            </div>
        </div>
    </nav>
</div>
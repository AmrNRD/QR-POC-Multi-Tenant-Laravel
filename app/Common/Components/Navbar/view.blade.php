<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{asset('layout-dist')}}/img/AdminLTELogo.png"
           alt="Joovlly Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">QR Joovlly</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>

      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route("dashboard")}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Home
{{--                        <span class="right badge badge-danger">New</span>--}}
                    </p>
                    </a>
                </li>
                @foreach ($menus as $menu)
                    @if( auth()->user()->hasRole($menu['permission']))
                    @if(array_key_exists('children', $menu) && count($menu['children'])==0)
                        <li class="nav-item">
                            <a href="{{route($menu['route'])}}" class="nav-link">
                            <i class="{{$menu['icon']}}"></i>
                            <p>
                                {{$menu['name']}}
                                {{-- <span class="right badge badge-danger">New</span> --}}
                            </p>
                            </a>
                        </li>
                    @else
                    <li class="nav-item has-treeview">
                        <a href="{{route($menu['route'])}}" class="nav-link">
                            <i class="{{$menu['icon']}}"></i>
                            <p>
                                {{$menu['name']}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach ($menu['children'] as $child)
                                @if(auth()->user()->hasRole($child['permission']))
                            <li class="nav-item">
                                <a href="{{route($child['route'])}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{$child['name']}}</p>
                                </a>
                            </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endif

                @endforeach
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
  <!-- /.sidebar -->
</aside>

{{--
    {
        "name": "plans",
        "icon": "nav-icon fas fa-tachometer-alt",
        "permission": "view-plans",
        "route": "plans.index",
        "children": [
            {
                "name": "list plans",
                "route": "plans.index",
                "permission": "view-plans"
            },
            {
                "name": "create new plan",
                "permission": "create-plans",
                "route": "plans.create"
            }
        ]
    },
    {
        "name": "plan futures",
        "icon": "nav-icon fas fa-tachometer-alt",
        "permission": "view-plans",
        "route": "plan_futures.index",
        "children": [
            {
                "name": "list plan futures",
                "permission": "view-plans",
                "route": "plan_futures.index"
            },
            {
                "name": "create new plan future",
                "route": "plan_futures.create",
                "permission": "create-plans"
             }
        ]
    },
    {
        "name": "subscriptions",
        "icon": "nav-icon fas fa-tachometer-alt",
        "permission": "view-plan_subscriptions",
        "route": "subscriptions.index",
        "children": [
            {
                "name": "list subscriptions",
                "permission": "view-plan_subscriptions",
                "route": "subscriptions.index"
            },
            {
                "name": "create new subscription",
                "permission": "create-plan_subscriptions",
                "route": "subscriptions.create"
            }
        ]



--}}


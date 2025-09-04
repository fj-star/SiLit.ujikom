<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-laundry <sup>masdeng</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Menu Dinamis -->
    @php
        $menu = [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
                'route' => route('admin.dashboard'),
            ],
            [
                'title' => 'Components',
                'icon' => 'fas fa-fw fa-cog',
                'collapse' => 'collapseComponents',
                'items' => [
                    ['name' => 'Laporan', 'url' => route('admin.laporan.index')],
                    ['name' => 'Cards', 'url' => '#'],
                ]
            ],
            [
                'title' => 'Utilities',
                'icon' => 'fas fa-fw fa-wrench',
                'collapse' => 'collapseUtilities',
                'items' => [
                    ['name' => 'Colors', 'url' => '#'],
                    ['name' => 'Borders', 'url' => '#'],
                    ['name' => 'Animations', 'url' => '#'],
                    ['name' => 'Other', 'url' => '#'],
                ]
            ],
        ];
    @endphp

    @foreach ($menu as $m)
        @if(isset($m['items']))
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                   data-target="#{{ $m['collapse'] }}"
                   aria-expanded="false"
                   aria-controls="{{ $m['collapse'] }}">
                    <i class="{{ $m['icon'] }}"></i>
                    <span>{{ $m['title'] }}</span>
                </a>
                <div id="{{ $m['collapse'] }}" class="collapse"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">{{ strtoupper($m['title']) }}:</h6>
                        @foreach($m['items'] as $item)
                            <a class="collapse-item" href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                        @endforeach
                    </div>
                </div>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ $m['route'] }}">
                    <i class="{{ $m['icon'] }}"></i>
                    <span>{{ $m['title'] }}</span>
                </a>
            </li>
        @endif
    @endforeach

    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-white w-100 text-start" id="btn-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>
</ul>
<!-- End of Sidebar -->

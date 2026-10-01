<style>
    .sidebar-left .sidebar-header .sidebar-toggle {
    top: 10px !important;
    }
    
    /* Sidebar Menu Styling */
        color: rgba(255,255,255,0.7);
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .sidebar-profile-section .profile-details {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .sidebar-profile-section .profile-detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.8);
        font-size: 12px;
    }
    
    .sidebar-profile-section .profile-detail-item i {
        width: 14px;
        text-align: center;
        color: rgba(255,255,255,0.6);
    }
    
    .sidebar-profile-section .profile-link {
        display: block;
        margin-top: 12px;
        padding: 8px 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-align: center;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .sidebar-profile-section .profile-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    /* Sidebar Menu Styling */
    .sidebar-left .nav-main {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .sidebar-left .nav-main > li {
        margin: 2px 10px;
    }
    
    .sidebar-left .nav-main > li > a {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: rgba(255,255,255,0.85);
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s ease;
        gap: 12px;
    }
    
    .sidebar-left .nav-main > li > a:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }
    
    .sidebar-left .nav-main > li.nav-active > a,
    .sidebar-left .nav-main > li.nav-active > a:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    /* Parent Menu with Children */
    .sidebar-left .nav-main > li.nav-parent {
        position: relative;
    }
    
    .sidebar-left .nav-main > li.nav-parent > a::after {
        content: '\f0d7';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 15px;
        transition: transform 0.3s ease;
    }
    
    .sidebar-left .nav-main > li.nav-parent.nav-expanded > a::after {
        transform: rotate(180deg);
    }
    
    .sidebar-left .nav-main > li.nav-parent.nav-active > a {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    /* Child Menu (Nested) */
    .sidebar-left .nav.nav-children {
        list-style: none;
        padding: 0;
        margin: 0;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .sidebar-left .nav.nav-children.show {
        max-height: 1000px;
        opacity: 1;
        margin-left: 20px;
        margin-top: 5px;
        margin-bottom: 10px;
    }
    
    .sidebar-left .nav.nav-children > li {
        list-style: none;
        position: relative;
        margin: 2px 0;
    }
    
    .sidebar-left .nav.nav-children > li > a {
        display: flex;
        align-items: center;
        padding: 10px 15px 10px 25px;
        color: rgba(255,255,255,0.75);
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s ease;
        gap: 10px;
        font-size: 14px;
    }
    
    /* Remove default list bullets from submenu items */
    .sidebar-left .nav.nav-children > li > a::before {
        display: none;
    }
    
    .sidebar-left .nav.nav-children > li > a:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }
    
    .sidebar-left .nav.nav-children > li.nav-active > a {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
    }
    
    .sidebar-left .nav.nav-children > li.nav-active > a::before {
        background: #fff;
    }
    
    /* Arrow indicator for expanded menus */
    .sidebar-left .nav.nav-children.show::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: rgba(255,255,255,0.1);
    }
    
    /* Icon styling */
    .sidebar-left .nav-main i.fa,
    .sidebar-left .nav-children i.fa {
        width: 20px;
        text-align: center;
        font-size: 16px;
    }
    
    /* Menu link styling */
    .sidebar-left .menu-link {
        position: relative;
        width: 100%;
    }
    
    /* Scrollbar styling */
    .sidebar-left .sidebar-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar-left .sidebar-content::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.1);
    }
    
    .sidebar-left .sidebar-content::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.3);
        border-radius: 3px;
    }
    
    .sidebar-left .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.5);
    }
</style>
<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            <a href="{{ route('home') }}" class="logo logo-link" title="Go to Dashboard">
                @if(!empty($settings->logo))
                    <img src="{{ asset('public/uploads/logo/'.$settings->logo) }}" alt="Logo" class="logo-image">
                @else
                    <span class="logo-text">গাড়িবন্ধু ৩৬০</span>
                @endif
            </a>
        </div>
        <button class="sidebar-toggle hidden-xs" onclick="toggleSidebarCollapse()" title="Toggle Sidebar" aria-label="Toggle sidebar navigation" type="button">
            <i class="fa fa-bars toggle-icon"></i>
            <span class="toggle-label"></span>
        </button>
    </div>
    <div class="sidebar-content">
        <nav class="nav-main">
            <ul class="nav nav-main">

@forelse($sidebar_menus as $menu)

    @php
        $children = $menu->children ?? collect();
        $isActiveParent = $children->contains(function ($child) {
            return $child->menu_url && request()->routeIs($child->menu_url . '*');
        });
        
        $getUrl = function($url) {
            if (!$url) return '#';
            $cleanUrl = str_replace('admin.', '', $url);
            if (Route::has($url)) {
                return route($url);
            } elseif (Route::has($cleanUrl)) {
                return route($cleanUrl);
            }
            return '#';
        };
    @endphp

    @if($children->isEmpty())
        @php $menuUrl = $getUrl($menu->menu_url); @endphp
        @if($menuUrl !== '#')
        <li class="{{ request()->routeIs($menu->menu_url . '*') ? 'nav-active' : '' }}">
            <a href="{{ $menuUrl }}" class="menu-link">
                <i class="fa {{ $menu->menu_icon }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>
        </li>
        @endif
    @else
        <li class="nav-parent {{ $isActiveParent ? 'nav-expanded nav-active' : '' }}">
            <a href="javascript:void(0)" class="menu-link" onclick="toggleMenu(this)">
                <i class="fa {{ $menu->menu_icon }}"></i>
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
            </a>
            <ul class="nav nav-children {{ $isActiveParent ? 'show' : '' }}">
                @foreach($children as $child)
                    @php $childUrl = $getUrl($child->menu_url); @endphp
                    @if($childUrl !== '#')
                    <li class="{{ request()->routeIs($child->menu_url . '*') ? 'nav-active' : '' }}">
                        <a href="{{ $childUrl }}" class="menu-link">
                            <i class="fa {{ $child->menu_icon }}"></i>
                            <span>{{ trans(ensure_menu_translation($child->menu_name)) }}</span>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </li>
    @endif

@empty
    <li><a href="#" class="menu-link"><span>{{ trans('No menus available') }}</span></a></li>
@endforelse

            </ul>
        </nav>
    </div>
</aside>

<script>
    // Toggle menu function for parent menus with children
    function toggleMenu(element) {
        var parentLi = element.closest('li.nav-parent');
        var childrenUl = parentLi.querySelector('.nav-children');
        
        // Toggle the show class
        childrenUl.classList.toggle('show');
        
        // Toggle the nav-expanded class on parent
        parentLi.classList.toggle('nav-expanded');
        
        // Prevent default link behavior
        return false;
    }
    
    // Sidebar collapse toggle
    function toggleSidebarCollapse() {
        var body = document.body;
        var sidebar = document.querySelector('.sidebar-left');
        var content = document.querySelector('.body');
        
        body.classList.toggle('sidebar-collapsed');
        
        if (body.classList.contains('sidebar-collapsed')) {
            sidebar.classList.add('collapsed');
            if (content) {
                content.style.marginLeft = '70px';
            }
        } else {
            sidebar.classList.remove('collapsed');
            if (content) {
                content.style.marginLeft = '260px';
            }
        }
    }
</script>

<style>
    /* ==========================================================================
       PREMIUM SIDEBAR SYSTEM - NEXTDIGIHOME
       ========================================================================== */
    .sidebar-left {
        background: linear-gradient(180deg, #090d16 0%, #0d1322 100%) !important;
        border-right: 1px solid rgba(255, 255, 255, 0.07);
        display: flex;
        flex-direction: column;
        height: 100vh;
        z-index: 1000;
        transition: width 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Sidebar Header */
    .sidebar-left .sidebar-header {
        position: relative;
        height: 66px;
        padding: 0 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(9, 13, 22, 0.96);
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        z-index: 10;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
    }

    .sidebar-left .sidebar-header .sidebar-title {
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 0;
    }

    .sidebar-left .sidebar-header .logo-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        gap: 10px;
        min-width: 0;
    }

    .brand-emblem-wrap {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .brand-emblem-svg {
        width: 100%;
        height: 100%;
        filter: drop-shadow(0 0 10px rgba(0, 212, 170, 0.45));
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .sidebar-left .logo-link:hover .brand-emblem-svg {
        transform: scale(1.08);
        filter: drop-shadow(0 0 14px rgba(139, 92, 246, 0.6));
    }

    .brand-text-wrap {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.1;
        min-width: 0;
    }

    .brand-title-text {
        font-size: 16px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.4px;
        white-space: nowrap;
    }

    .brand-title-accent {
        background: linear-gradient(135deg, #00d4aa 0%, #38bdf8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #00d4aa;
    }

    .brand-subtitle-badge {
        font-size: 9px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.45);
        letter-spacing: 1.6px;
        text-transform: uppercase;
        margin-top: 3px;
        white-space: nowrap;
    }

    .sidebar-left .sidebar-header-actions {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-shrink: 0;
    }

    .sidebar-left .sidebar-action-btn {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
        color: rgba(226, 232, 240, 0.65) !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 7px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        font-size: 14px !important;
        padding: 0 !important;
        margin: 0 !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
    }

    .sidebar-left .sidebar-action-btn:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }

    /* Content Area */
    .sidebar-left .sidebar-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px 0;
    }

    /* Navigation List */
    .sidebar-left .nav-main {
        list-style: none;
        padding: 0 10px;
        margin: 0;
    }

    .sidebar-left .nav-main > li {
        margin: 3px 0;
        position: relative;
    }

    .sidebar-left .nav-main > li > a.menu-link {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        color: rgba(226, 232, 240, 0.78);
        font-size: 13.5px;
        font-weight: 500;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid transparent;
        position: relative;
    }

    .sidebar-left .nav-main > li > a.menu-link:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
        transform: translateX(2px);
    }

    .sidebar-left .nav-main > li.nav-active > a.menu-link {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.22) 0%, rgba(59, 130, 246, 0.12) 100%);
        color: #60a5fa;
        font-weight: 600;
        border-color: rgba(59, 130, 246, 0.35);
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.14);
    }

    .sidebar-left .nav-main > li.nav-active > a.menu-link i {
        color: #38bdf8 !important;
        filter: drop-shadow(0 0 6px rgba(56, 189, 248, 0.5));
    }

    .sidebar-left .nav-main i.fa,
    .sidebar-left .nav-main i.fas {
        width: 20px;
        text-align: center;
        font-size: 15px;
        margin-right: 11px;
        opacity: 0.85;
        transition: transform 0.2s ease, color 0.2s ease;
        flex-shrink: 0;
    }

    .sidebar-left .nav-main > li > a.menu-link:hover i {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Dropdown Chevron */
    .sidebar-left .nav-main > li.nav-parent > a.menu-link::after {
        content: '\f105';
        font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free', 'FontAwesome';
        font-weight: 900;
        margin-left: auto;
        font-size: 12px;
        opacity: 0.5;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    .sidebar-left .nav-main > li.nav-parent.nav-expanded > a.menu-link::after {
        transform: rotate(90deg);
        opacity: 0.9;
        color: #60a5fa;
    }

    /* Nested Submenus */
    .sidebar-left .nav.nav-children {
        list-style: none;
        padding: 0;
        margin: 4px 0 6px 20px;
        padding-left: 10px;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        display: none;
    }

    .sidebar-left .nav.nav-children.show {
        display: block;
    }

    .sidebar-left .nav.nav-children > li {
        margin: 2px 0;
    }

    .sidebar-left .nav.nav-children > li > a.menu-link {
        display: flex;
        align-items: center;
        padding: 7px 12px;
        font-size: 13px;
        color: rgba(203, 213, 225, 0.7);
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .sidebar-left .nav.nav-children > li > a.menu-link:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar-left .nav.nav-children > li.nav-active > a.menu-link {
        color: #38bdf8;
        font-weight: 600;
        background: rgba(56, 189, 248, 0.1);
    }

    /* Bottom Profile Card */
    .sidebar-user-card {
        margin: auto 10px 14px;
        padding: 10px 12px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .sidebar-user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: linear-gradient(135deg, #00d4aa 0%, #3b82f6 100%);
        color: #0b0f19;
        font-weight: 800;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 212, 170, 0.35);
    }

    .sidebar-user-meta {
        flex: 1;
        min-width: 0;
        line-height: 1.2;
    }

    .sidebar-user-name {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-user-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 600;
        color: #38bdf8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    .sidebar-user-link {
        color: rgba(255, 255, 255, 0.45);
        font-size: 14px;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .sidebar-user-link:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.12);
    }

    /* Collapsed Sidebar Mode */
    .sidebar-collapsed .sidebar-left {
        width: 72px !important;
    }

    .sidebar-collapsed .sidebar-left .brand-text-wrap,
    .sidebar-collapsed .sidebar-left .sidebar-user-meta,
    .sidebar-collapsed .sidebar-left .sidebar-user-link,
    .sidebar-collapsed .sidebar-left .nav-main > li > a.menu-link span,
    .sidebar-collapsed .sidebar-left .nav-main > li.nav-parent > a.menu-link::after {
        display: none !important;
    }

    .sidebar-collapsed .sidebar-left .sidebar-header {
        padding: 0 10px;
        justify-content: center;
    }

    .sidebar-collapsed .sidebar-left .sidebar-header-actions {
        display: none;
    }

    .sidebar-collapsed .sidebar-left .brand-emblem-wrap {
        margin: 0;
    }

    .sidebar-collapsed .sidebar-left .nav-main > li > a.menu-link {
        justify-content: center;
        padding: 12px 0;
    }

    .sidebar-collapsed .sidebar-left .nav-main i.fa,
    .sidebar-collapsed .sidebar-left .nav-main i.fas {
        margin-right: 0;
    }

    .sidebar-collapsed .sidebar-left .sidebar-user-card {
        justify-content: center;
        padding: 8px 0;
        margin: auto 8px 12px;
    }

    /* Scrollbar */
    .sidebar-left .sidebar-content::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar-left .sidebar-content::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-left .sidebar-content::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 3px;
    }
    .sidebar-left .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Desktop vs Mobile Toggle Visibility */
    @media (min-width: 992px) {
        .sidebar-left .sidebar-mobile-close,
        .sidebar-mobile-close {
            display: none !important;
        }
    }

    @media (max-width: 991.98px) {
        .sidebar-left .sidebar-toggle {
            display: none !important;
        }
        .sidebar-left .sidebar-mobile-close {
            display: inline-flex !important;
        }
    }
</style>
<aside id="sidebar-left" class="sidebar-left">
     <div class="sidebar-header">
          <div class="sidebar-title">
              <a href="{{ route('home') }}" class="logo logo-link" title="Go to Dashboard">
                  @if(!empty($settings->admin_logo))
                      <img src="{{ asset('public/admin_resource/assets/images/'.$settings->admin_logo) }}" alt="Logo" class="logo-image" style="display: block; max-height: 38px; max-width: 140px;">
                  @elseif(!empty($settings->logo))
                      <img src="{{ asset('public/uploads/logo/'.$settings->logo) }}" alt="Logo" class="logo-image" style="display: block; max-height: 38px; max-width: 140px;">
                  @else
                      <div class="brand-emblem-wrap">
                          <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="brand-emblem-svg">
                              <defs>
                                  <linearGradient id="sbPillarLeft" x1="16" y1="8" x2="16" y2="56" gradientUnits="userSpaceOnUse">
                                      <stop offset="0%" stop-color="#00f2fe" />
                                      <stop offset="100%" stop-color="#00d4aa" />
                                  </linearGradient>
                                  <linearGradient id="sbDiagFold" x1="16" y1="8" x2="48" y2="56" gradientUnits="userSpaceOnUse">
                                      <stop offset="0%" stop-color="#00f2fe" />
                                      <stop offset="25%" stop-color="#00d4aa" />
                                      <stop offset="75%" stop-color="#8b5cf6" />
                                      <stop offset="100%" stop-color="#ec4899" />
                                  </linearGradient>
                                  <linearGradient id="sbPillarRight" x1="48" y1="8" x2="48" y2="56" gradientUnits="userSpaceOnUse">
                                      <stop offset="0%" stop-color="#a855f7" />
                                      <stop offset="100%" stop-color="#6366f1" />
                                  </linearGradient>
                                  <linearGradient id="sbSpecular" x1="10" y1="8" x2="30" y2="28" gradientUnits="userSpaceOnUse">
                                      <stop offset="0%" stop-color="#ffffff" stop-opacity="0.9" />
                                      <stop offset="100%" stop-color="#ffffff" stop-opacity="0" />
                                  </linearGradient>
                              </defs>
                              <rect x="42" y="8" width="12" height="48" rx="6" fill="url(#sbPillarRight)" />
                              <rect x="10" y="8" width="12" height="48" rx="6" fill="url(#sbPillarLeft)" />
                              <path d="M 10 14 C 10 10.7 12.7 8 16 8 C 17.8 8 19.4 8.8 20.5 10.1 L 47.5 45.9 C 48.6 47.2 49.2 48.8 49.2 50.5 C 49.2 53.5 46.8 56 43.8 56 C 42 56 40.4 55.2 39.3 53.9 L 12.5 18.1 C 10.9 16.9 10 15.6 10 14 Z" fill="url(#sbDiagFold)" />
                              <path d="M 10 14 C 10 10.7 12.7 8 16 8 C 17.8 8 19.4 8.8 20.5 10.1 L 28 20 L 22 25 L 10 14 Z" fill="url(#sbSpecular)" opacity="0.75" />
                          </svg>
                      </div>
                      <div class="brand-text-wrap">
                          <span class="brand-title-text">Next<span class="brand-title-accent">DigiHome</span></span>
                          <span class="brand-subtitle-badge">Agency Panel</span>
                      </div>
                  @endif
              </a>
          </div>
          <div class="sidebar-header-actions">
              <a href="javascript:location.reload();" class="sidebar-action-btn" title="Reload Page">
                  <i class="fa fa-sync-alt"></i>
              </a>
              <button class="sidebar-action-btn sidebar-toggle hidden-xs" onclick="toggleSidebarCollapse()" title="Toggle Sidebar" aria-label="Toggle sidebar navigation" type="button">
                  <i class="fa fa-bars"></i>
              </button>
              <button class="sidebar-action-btn sidebar-mobile-close" onclick="toggleMobileSidebar()" aria-label="Close menu" type="button">
                  <i class="fa fa-times"></i>
              </button>
          </div>
     </div>
    <div class="sidebar-content">
        <nav class="nav-main">
            <ul class="nav nav-main">
                @php
                    $newInquiryCount = \Illuminate\Support\Facades\Schema::hasTable('project_inquiries') 
                        ? \App\Models\ProjectInquiry::where('status', 'new')->count() 
                        : 0;
                @endphp

@forelse($sidebar_menus as $menu)

    @php
        $children = $menu->children ?? collect();
        $currentRouteName = optional(request()->route())->getName();

        $isActiveParent = $children->contains(function ($child) use ($currentRouteName) {
            if (!$child->menu_url) return false;
            $cleanChildRoute = explode('?', $child->menu_url)[0];
            return $currentRouteName && (request()->routeIs($child->menu_url) || request()->routeIs($cleanChildRoute));
        }) || ($menu->menu_url && request()->routeIs($menu->menu_url));
        
        $getUrl = function($url) {
            if (!$url) return '#';
            if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '/')) {
                return $url;
            }
            // Parse query string if present
            $parts = explode('?', $url, 2);
            $routeName = $parts[0];
            $queryStr = isset($parts[1]) ? '?' . $parts[1] : '';

            $cleanUrl = str_replace(['admin.', 'dashboard.'], '', $routeName);
            
            // Check if the URL contains route parameters
            if (preg_match('/\{[a-zA-Z_]+\}/', $routeName)) {
                return '#';
            }
            
            try {
                if (Route::has($routeName)) {
                    return route($routeName) . $queryStr;
                } elseif (Route::has($cleanUrl)) {
                    return route($cleanUrl) . $queryStr;
                } elseif (Route::has('admin.' . $routeName)) {
                    return route('admin.' . $routeName) . $queryStr;
                }
            } catch (\Exception $e) {
                return '#';
            }
            return '#';
        };
    @endphp

    @if($children->isEmpty())
        @php $menuUrl = $getUrl($menu->menu_url); @endphp
        @if($menuUrl !== '#')
        <li class="{{ ($menu->menu_url && request()->routeIs(explode('?', $menu->menu_url)[0])) ? 'nav-active' : '' }}">
            <a href="{{ $menuUrl }}" class="menu-link">
                @if(!empty($menu->menu_favicon))
                    <img src="{{ asset('public/admin_resource/assets/images/'.$menu->menu_favicon) }}" alt="" class="menu-favicon">
                @else
                    <i class="fa {{ $menu->menu_icon }}"></i>
                @endif
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
                @if(($menu->menu_slug === 'inquiries' || $menu->menu_name === 'Project Inquiries') && $newInquiryCount > 0)
                    <span class="badge badge-pill badge-warning" style="margin-left: auto; font-size: 10px; padding: 2px 7px; background: linear-gradient(135deg, #f59e0b, #d97706); color: #000; font-weight: 700; border-radius: 9999px;">{{ $newInquiryCount }}</span>
                @endif
            </a>
        </li>
        @endif
    @else
        <li class="nav-parent {{ $isActiveParent ? 'nav-expanded nav-active' : '' }}">
            <a href="javascript:void(0)" class="menu-link" onclick="toggleMenu(this)">
                @if(!empty($menu->menu_favicon))
                    <img src="{{ asset('public/admin_resource/assets/images/'.$menu->menu_favicon) }}" alt="" class="menu-favicon">
                @else
                    <i class="fa {{ $menu->menu_icon }}"></i>
                @endif
                <span>{{ trans(ensure_menu_translation($menu->menu_name)) }}</span>
                @if(($menu->menu_slug === 'inquiries' || $menu->menu_name === 'Project Inquiries') && $newInquiryCount > 0)
                    <span class="badge badge-pill badge-warning" style="margin-left: auto; margin-right: 6px; font-size: 10px; padding: 2px 7px; background: linear-gradient(135deg, #f59e0b, #d97706); color: #000; font-weight: 700; border-radius: 9999px;">{{ $newInquiryCount }}</span>
                @endif
            </a>
            <ul class="nav nav-children {{ $isActiveParent ? 'show' : '' }}">
                @foreach($children as $child)
                    @php 
                    $childUrl = $getUrl($child->menu_url);
                    $cleanChildRoute = explode('?', $child->menu_url ?? '')[0];
                    $isChildActive = $child->menu_url && (request()->routeIs($child->menu_url) || request()->routeIs($cleanChildRoute));
                    @endphp
                    <li class="{{ $isChildActive ? 'nav-active' : '' }}">
                        <a href="{{ $childUrl }}" class="menu-link {{ $childUrl === '#' ? 'menu-link-disabled' : '' }}" @if($childUrl === '#') aria-disabled="true" onclick="return false;" @endif>
                            @if(!empty($child->menu_favicon))
                                <img src="{{ asset('public/admin_resource/assets/images/'.$child->menu_favicon) }}" alt="" class="menu-favicon">
                            @else
                                <i class="fa {{ $child->menu_icon }}"></i>
                            @endif
                            <span>{{ trans(ensure_menu_translation($child->menu_name)) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif

@empty
    <li><a href="#" class="menu-link"><span>{{ trans('No menus available') }}</span></a></li>
@endforelse

            </ul>
            <div class="sidebar-status-pill" style="padding: 10px 14px; margin: 16px 12px 6px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 8px; display: flex; align-items: center; justify-content: space-between; font-size: 11px; color: rgba(255,255,255,0.5);">
                <span style="display: flex; align-items: center; gap: 7px;">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px #10b981; display: inline-block;"></span>
                    <span>All Menus Synced</span>
                </span>
                <span style="font-family: monospace; font-size: 10px; color: #38bdf8;">v2.6</span>
            </div>
        </nav>
    </div>

    <!-- Sidebar Bottom User Profile Card -->
    @auth
    <div class="sidebar-user-card">
        <div class="sidebar-user-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div class="sidebar-user-meta">
            <span class="sidebar-user-name">{{ Auth::user()->name }}</span>
            <span class="sidebar-user-badge">{{ Auth::user()->role ?? 'Super Admin' }}</span>
        </div>
        <a href="{{ route('admin.settings.general') }}" class="sidebar-user-link" title="Settings">
            <i class="fas fa-cog"></i>
        </a>
    </div>
    @endauth
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
     
     // Mobile sidebar toggle
     function toggleMobileSidebar() {
         var sidebar = document.querySelector('.sidebar-left');
         var overlay = document.querySelector('.sidebar-overlay');
         
         if (!sidebar) {
             return;
         }
         
         sidebar.classList.toggle('show');
         if (overlay) {
             overlay.classList.toggle('show', sidebar.classList.contains('show'));
         }
         
         // Prevent body scroll when sidebar is open
         if (sidebar.classList.contains('show')) {
             document.body.style.overflow = 'hidden';
         } else {
             document.body.style.overflow = '';
         }
     }
     
     // Close mobile sidebar when clicking on overlay
     document.addEventListener('click', function(e) {
         var sidebar = document.querySelector('.sidebar-left');
         var overlay = document.querySelector('.sidebar-overlay');
         var toggleBtn = document.querySelector('.mobile-sidebar-toggle');
         
         if (!sidebar || !toggleBtn) {
             return;
         }
         
         if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
             if (sidebar.classList.contains('show')) {
                 sidebar.classList.remove('show');
                 if (overlay) overlay.classList.remove('show');
                 document.body.style.overflow = '';
             }
         }
     });
     </script>

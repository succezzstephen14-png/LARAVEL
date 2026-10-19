<div class="settings-sidebar">
    <h2>Website Navigation</h2>
    <a href="{{ route('cms.settings') }}" class="sidebar-link {{ request()->routeIs('cms.settings') ? 'active' : '' }}">
        <span class="icon"><i class="fas fa-cog"></i></span>
        Settings
    </a>
    <a href="{{ route('cms.appearance') }}" class="sidebar-link {{ request()->routeIs('cms.appearance') ? 'active' : '' }}">
        <span class="icon"><i class="fas fa-palette"></i></span>
        Appearance
    </a>
    <a href="{{ route('cms.header-footer') }}" class="sidebar-link {{ request()->routeIs('cms.header-footer') ? 'active' : '' }}">
        <span class="icon"><i class="fas fa-file-invoice"></i></span>
        Header & Footer
    </a>
    <a href="{{ route('cms.menus') }}" class="sidebar-link {{ request()->routeIs('cms.menus') ? 'active' : '' }}">
        <span class="icon"><i class="fas fa-list-ul"></i></span>
        Menus
    </a>
    <a href="{{ route('cms.global-settings') }}" class="sidebar-link {{ request()->routeIs('cms.global-settings') ? 'active' : '' }}">
        <span class="icon"><i class="fas fa-globe"></i></span>
        Global Settings
    </a>
</div>

<section class="left-panel">
    @can(['settings-edit', 'users-list', 'roles-list', 'modules-list', 'pages-list', 'menus-list'])
    <div class="card mb-3">
        <div class="card-header">Ae Menu</div>

        <div class="card-body">
            <ul class="admin-menu">
                @can('settings-edit')
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.settings') === 0) ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><span>Settings</span><span class='raq'>&raquo;</span></a></li>
                @endcan
                @can('users-list')
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.users') === 0) ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><span>Users</span><span class='raq'>&raquo;</span></a></li>
                @endcan
                @can('roles-list')
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.roles') === 0) ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><span>Roles</span><span class='raq'>&raquo;</span></a></li>
                @endcan
                @can('modules-list')
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.modules') === 0) ? 'active' : '' }}" href="{{ route('admin.modules.index') }}"><span>Modules</span><span class='raq'>&raquo;</span></a></li>
                @endcan
                @can('pages-list')
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.pages') === 0) ? 'active' : '' }}" href="{{ route('admin.pages.index') }}"><span>Pages</span><span class='raq'>&raquo;</span></a></li>
                @endcan
                @can('menus-list')
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.menus') === 0) ? 'active' : '' }}" href="{{ route('admin.menus.index') }}"><span>Menus</span><span class='raq'>&raquo;</span></a></li>
                @endcan
            </ul>
        </div>
    </div>
    @endcan

    <div class="card mb-4">
        <div class="card-header">User Menu</div>

        <div class="card-body">
            <ul class="admin-menu">
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.contents') === 0) ? 'active' : '' }}" href="{{ route('admin.contents.index') }}"><span>Contents</span><span class='raq'>&raquo;</span></a></li>
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.files') === 0) ? 'active' : '' }}" href="{{ route('admin.files.index') }}"><span>Uploaded Files</span><span class='raq'>&raquo;</span></a></li>
                <li><a class="{{ (strpos(Route::currentRouteName(), 'admin.offices') === 0) ? 'active' : '' }}" href="{{ route('admin.offices.index') }}"><span>Office Location</span><span class='raq'>&raquo;</span></a></li>
                
                
                @foreach(AEHelpers::getModules() as $modules)
                    @php
                        $clean = strtolower(preg_replace('/\s*/', '', $modules->module_name));
                        $module = new $modules->admin_classnamespace;
                    @endphp
                    @can($clean.'-list')
                        @if($module->displayAdmin) 
                        <li><a class="{{ (strpos(Route::currentRouteName(), $modules->route_root_name) === 0) ? 'active' : '' }}"  href="{{ route($modules->route_root_name .'.index') }}"><span>{{ $modules->module_name }}</span><span class='raq'>&raquo;</span></a></li>
                        @endif
                    @endcan
                @endforeach
            </ul>
        </div>
    </div>
</section>
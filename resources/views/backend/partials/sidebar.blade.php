<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ url('/manager') }}" class="brand-link">
            <img src="{{ asset('backend/assets/images/sepco-logo.png') }}" alt="SEPCO Logo"
                class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">SEPCO</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        @if (Auth::guard('admin')->check())
            <form id="logout-form" action="{{ route('manager.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/manager') }}" class="nav-link"><i class="nav-icon fa-solid fa-house"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @canany(['admin-create', 'admin-list', 'role-create', 'role-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fa-solid fa-user"></i>
                            <p>Authentication<i class="nav-arrow bi bi-chevron-right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('admin-create')
                                <li class="nav-item">
                                    <a href="{{ route('manager.users.create') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Add Admin User</p>
                                    </a>
                                </li>
                            @endcan
                            @can('admin-list')
                                <li class="nav-item">
                                    <a href="{{ route('manager.users.index') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Manage Admin Users</p>
                                    </a>
                                </li>
                            @endcan
                            @can('role-create')
                                <li class="nav-item">
                                    <a href="{{ route('manager.roles.create') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Add Role</p>
                                    </a>
                                </li>
                            @endcan
                            @can('role-list')
                                <li class="nav-item">
                                    <a href="{{ route('manager.roles.index') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Manage Roles</p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission-create')
                                <li class="nav-item">
                                    <a href="{{ route('manager.permissions.create') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Add Permissions</p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission-list')
                                <li class="nav-item">
                                    <a href="{{ route('manager.permissions.index') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Manage Permissions</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany(['page-list', 'menu-list'])
                    <li class="nav-item">
                        <a href="#" class="nav-link"> <i class="nav-icon fa-solid fa-globe"></i>
                            <p>CMS<i class="nav-arrow bi bi-chevron-right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
						    @can('menu-list')
                                <li class="nav-item">
                                    <a href="{{ route('manager.cms.menus.index') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Manage Menu Items</p>
                                    </a>
                                </li>
                            @endcan
                            @can('page-list')
                                <li class="nav-item">
                                    <a href="{{ route('manager.cms.pages.index') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Manage Pages</p>
                                    </a>
                                </li>
                            @endcan
							@foreach($customposts as $custompost)
								<li class="nav-item">
									<a href="{{ route('manager.cms.custompostdata.index', encrypt($custompost->id)) }}" class="nav-link">
										<i class="nav-icon far fa-circle"></i>
										<p>Manage {{ $custompost->title }}</p>
									</a>
								</li>
							@endforeach
							
							
							
                            
                            @can('products-list')
                                <li class="nav-item">
                                    <a href="{{ route('manager.cms.products.index') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Manage Products</p>
                                    </a>
                                </li>
                            @endcan
							{{--
                            <li class="nav-item">
                                <a href="{{ route('manager.cms.management-persons.index') }}" class="nav-link"> <i
                                        class="nav-icon far fa-circle"></i>
                                    <p>Manage People</p>
                                </a>
                            </li>
							--}}
                        </ul>
                    </li>
                @endcanany
				
				
				
				
				
<?php
/*
dump(auth('admin')->user()->getAllPermissions()->pluck('name'));
$user = auth('admin')->user();
dump($user->getPermissionNames());
dump($user->getRoleNames());
dump($user->guard_name);
//dump($user->getGuardName());
if ($user->can('custompost-list')) {
    dump('do something');
}
//$user->givePermissionTo('custompost-list');
dump($user->getGuardNameAttributeValue()); // "admin"
*/
?>
				
				@canany(['component-list', 'component-create', 'custompost-list', 'custompost-create'])
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon fa-solid fa-puzzle-piece"></i>
							<p>Admin CMS <i class="nav-arrow bi bi-chevron-right"></i></p>
						</a>
						<ul class="nav nav-treeview">
							@canany(['component-list', 'component-create'])
								<li class="nav-item">
									<a href="{{ route('manager.cms.components.index') }}" class="nav-link">
										<i class="nav-icon far fa-circle"></i>
										<p>Manage Components</p>
									</a>
								</li>
							@endcanany

							@canany(['custompost-list', 'custompost-create'])
								<li class="nav-item">
									<a href="{{ route('manager.cms.customposts.index') }}" class="nav-link">
										<i class="nav-icon far fa-circle"></i>
										<p>Manage Custom Post</p>
									</a>
								</li>
							@endcanany
						</ul>
					</li>
				@endcanany

				
                @canany(['tender-user'])
                    @can('tender-person-list')
                        <li class="nav-item">
                            <a href="{{ route('manager.tender-persons.index') }}" class="nav-link"><i
                                    class="nav-icon fa-solid fa-users-line"></i>
                                <p>Tender Persons</p>
                            </a>
                        </li>
                    @endcan
                    @can('tender-category-list')
                        <li class="nav-item">
                            <a href="{{ route('manager.tender-categories.index') }}" class="nav-link"><i
                                    class="nav-icon fa-solid fa-puzzle-piece"></i>
                                <p>Tender Categories</p>
                            </a>
                        </li>
                    @endcan
                    @can('tender-list')
                        <li class="nav-item">
                            <a href="{{ route('manager.tenders.index') }}" class="nav-link"><i
                                    class="nav-icon fa-solid fa-gavel"></i>
                                <p>Tenders</p>
                            </a>
                        </li>
                    @endcan
                    @can('technical-evaluation-create')
                        <li class="nav-item">
                            <a href="{{ route('manager.technical-evaluations.index') }}" class="nav-link"><i
                                    class="nav-icon fa-solid fa-gavel"></i>
                                <p>Technical Evaluations</p>
                            </a>
                        </li>
                    @endcan
                    @can('final-evaluation-create')
                        <li class="nav-item">
                            <a href="{{ route('manager.final-evaluations.index') }}" class="nav-link"><i
                                    class="nav-icon fa-solid fa-gavel"></i>
                                <p>Final Evaluations</p>
                            </a>
                        </li>
                    @endcan
                    @can('grc-create')
                        <li class="nav-item">
                            <a href="{{ route('manager.grcs.index') }}" class="nav-link"><i
                                    class="nav-icon fa-solid fa-gavel"></i>
                                <p>Manage GRC</p>
                            </a>
                        </li>
                    @endcan
                    @can('tender-reports')
                        <li class="nav-item">
                            <a href="#" class="nav-link"> <i class="nav-icon fa-solid fa-globe"></i>
                                <p>Reports<i class="nav-arrow bi bi-chevron-right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('manager.reporting.tenders') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Tenders</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('manager.reporting.technical-evaluations') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Technical Evaluations</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('manager.reporting.final-evaluations') }}" class="nav-link"> <i
                                            class="nav-icon far fa-circle"></i>
                                        <p>Final Evaluations</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                @endcanany
				<li class="nav-item">
                    <a href="{{ route('manager.cms.settings.edit') }}" class="nav-link"> <i class="nav-icon fa-solid fa-gear"></i>
                        <p>Website Setting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manager.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="nav-link"> <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

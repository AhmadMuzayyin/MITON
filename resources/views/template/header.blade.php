<div class="app-header white box-shadow">
    <div class="navbar navbar-toggleable-sm flex-row align-items-center">
        <!-- Open side - Naviation on mobile -->
        <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
            <i class="material-icons">&#xe5d2;</i>
        </a>
        <!-- / -->

        <!-- Page title - Bind to $state's title -->
        <div class="mb-0 h5 no-wrap" ng-bind="$state.current.data.title" id="pageTitle"></div>

        <!-- navbar collapse -->
        <div class="collapse navbar-collapse" id="collapse">
            <!-- link and dropdown -->
            {{-- <ul class="nav navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href data-toggle="dropdown">
                        <i class="fa fa-fw fa-plus text-muted"></i>
                        <span>New</span>
                    </a>

                    <div class="dropdown-menu">
                        <a class="dropdown-item" ui-sref="app.inbox.compose">
                            <span>Inbox</span>
                        </a>
                        <a class="dropdown-item" ui-sref="app.todo">
                            <span>Todo</span>
                        </a>
                        <a class="dropdown-item" ui-sref="app.note.list">
                            <span>Note</span>
                            <span class="label primary m-l-xs">3</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" ui-sref="app.contact">Contact</a>
                    </div>


                </li>
            </ul> --}}

            <div ui-include="'../views/blocks/navbar.form.html'"></div>
            <!-- / -->
        </div>
        <!-- / navbar collapse -->

        <!-- navbar right -->
        <ul class="nav navbar-nav ml-auto flex-row">
            <li class="nav-item dropdown pos-stc-xs">
                <!-- <a class="nav-link mr-2" href data-toggle="dropdown">
                    <i class="material-icons">&#xe7f5;</i>
                    <span class="label label-sm up warn">3</span>
                </a> -->
                <!-- dropdown -->
                <!-- <div
                    class="dropdown-menu dropdown-menu-overlay pull-right w-xl animated fadeInUp no-bg no-border no-shadow">
                    <div class="scrollable" style="max-height: 220px">
                        <ul class="list-group list-group-gap m-0">
                            <li class="list-group-item black lt box-shadow-z0 b">
                                <span class="pull-left m-r">
                                    <img src="../assets/images/a0.jpg" alt="..." class="w-40 img-circle">
                                </span>
                                <span class="clear block">
                                    Use awesome <a href class="text-primary">animate.css</a><br>
                                    <small class="text-muted">10 minutes ago</small>
                                </span>
                            </li>
                            <li class="list-group-item black lt box-shadow-z0 b">
                                <span class="pull-left m-r">
                                    <img src="../assets/images/a1.jpg" alt="..." class="w-40 img-circle">
                                </span>
                                <span class="clear block">
                                    <a href class="text-primary">Joe</a> Added you as friend<br>
                                    <small class="text-muted">2 hours ago</small>
                                </span>
                            </li>
                            <li class="list-group-item dark-white text-color box-shadow-z0 b">
                                <span class="pull-left m-r">
                                    <img src="../assets/images/a2.jpg" alt="..." class="w-40 img-circle">
                                </span>
                                <span class="clear block">
                                    <a href class="text-primary">Danie</a> sent you a message<br>
                                    <small class="text-muted">1 day ago</small>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div> -->
                <!-- / dropdown -->
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link p-0 clear" href="#" data-toggle="dropdown">
                    <span class="avatar w-32">
                        <img src="{{ asset('storage/uploads') . '/' . Auth()->user()->foto ?? 'default.jpg' }}" alt="profile">
                        <i class="on b-white bottom"></i>
                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-overlay pull-right">
                    {{-- <a class="dropdown-item" ui-sref="app.inbox.list">
                        <span>Inbox</span>
                        <span class="label warn m-l-xs">3</span>
                    </a>
                    <a class="dropdown-item" ui-sref="app.page.profile">
                        <span>Profile</span>
                    </a> --}}
                    <!-- <a class="dropdown-item" ui-sref="app.page.setting">
                        <span>Settings</span>
                        <span class="label primary m-l-xs">3/9</span>
                    </a> -->
                    <a href="{{ url('profil') . '/' . Auth()->user()->id }}" class="dropdown-item">
                        Profil Setting
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" role="button">Sign out</button>
                    </form>
                </div>

            </li>

            <li class="nav-item hidden-md-up">
                <a class="nav-link pl-2" data-toggle="collapse" data-target="#collapse">
                    <i class="material-icons">&#xe5d4;</i>
                </a>
            </li>
        </ul>
        <!-- / navbar right -->
    </div>
</div>
<div class="app-footer">
    <div class="p-2 text-xs">
        <div class="pull-right text-muted py-1">
            &copy; Copyright e-Report <span class="hidden-xs-down">- SEKDA PAMEKASAN</span>
            <a ui-scroll-to="content"><i class="bi bi-arrow-up"></i></a>
        </div>
    </div>
</div>
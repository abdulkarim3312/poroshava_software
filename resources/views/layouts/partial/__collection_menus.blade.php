@if(auth()->user()->sub_role == \App\Enumeration\SubRole::$ADMIN)
<?php
$subMenu = [
    'collection_area.all', 'collection_area.add', 'collection_area.edit',
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-map-marked"></i>
        <p>
            মহল্লা
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('collection_area.add') }}" class="nav-link {{ Route::currentRouteName() == 'collection_area.add' ? 'active' : '' }}">
                <i class="far {{ Route::currentRouteName() == 'collection_area.add' ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>মহল্লা যুক্ত করুন</p>
            </a>
        </li>
        <?php
        $subSubMenu = [
            'collection_area.all', 'collection_area.edit',
        ];
        ?>
        <li class="nav-item">
            <a href="{{ route('collection_area.all') }}" class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                <i class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>সকল  মহল্লা</p>
            </a>
        </li>
    </ul>
</li>
<?php
$subMenu = [
    'collection_type.all', 'collection_type.add', 'collection_type.edit',
    'collection_sub_type.all', 'collection_sub_type.add', 'collection_sub_type.edit',
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>
            খাত
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <?php
        $subSubMenu = [
            'collection_type.all', 'collection_type.add', 'collection_type.edit',
        ];
        ?>
        <li class="nav-item">
            <a href="{{ route('collection_type.all') }}" class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                <i class="far {{ in_array(Route::currentRouteName(), $subSubMenu)  ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>সকল খাত</p>
            </a>
        </li>
            <?php
            $subSubMenu = [
                'collection_sub_type.all', 'collection_sub_type.add', 'collection_sub_type.edit',
            ];
            ?>
        <li class="nav-item">
            <a href="{{ route('collection_sub_type.all') }}" class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                <i class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>সকল উপ খাত</p>
            </a>
        </li>
    </ul>
</li>
@endif
<?php
$subMenu = [
    'collection.all', 'collection.add', 'collection.edit','collection.closing'
];
?>

<li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-address-card"></i>
        <p>
            আদায়
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if(auth()->user()->sub_role == \App\Enumeration\SubRole::$COLLECTOR || auth()->user()->sub_role == \App\Enumeration\SubRole::$ADMIN)
            <li class="nav-item">
                <a href="{{ route('collection.add') }}" class="nav-link {{ Route::currentRouteName() == 'collection.add' ? 'active' : '' }}">
                    <i class="far {{ Route::currentRouteName() == 'collection.add' ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                    <p>আদায় যুক্তকরুন</p>
                </a>
            </li>
{{--            @endif--}}
{{--            @if(auth()->user()->sub_role == \App\Enumeration\SubRole::$COLLECTOR || auth()->user()->sub_role == \App\Enumeration\SubRole::$ADMIN)--}}
            <?php
                $subSubMenu = [
                    'collection.all', 'collection.edit'
                ];
            ?>
                <li class="nav-item">
                <a href="{{ route('collection.all') }}" class="nav-link {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'active' : '' }}">
                    <i class="far {{ in_array(Route::currentRouteName(), $subSubMenu) ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                    <p>সকল আদায়</p>
                </a>
            </li>
            @endif

        <li class="nav-item">
            <a href="{{ route('collection.closing') }}" class="nav-link {{ Route::currentRouteName() == 'collection.closing' ? 'active' : '' }}">
                <i class="far {{ Route::currentRouteName() == 'collection.closing' ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>দৈনিক সমাপনী</p>
            </a>
        </li>
    </ul>
</li>

<?php
$subMenu = [
    'collection.report.summary','collection.report.collection','collection.report.user_log'
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $subMenu) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-address-card"></i>
        <p>
            রিপোর্টস
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('collection.report.summary') }}" class="nav-link {{ Route::currentRouteName() == 'collection.report.summary' ? 'active' : '' }}">
                <i class="far {{ Route::currentRouteName() == 'collection.report.summary' ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আদায় সারসংক্ষেপ</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('collection.report.collection') }}" class="nav-link {{ Route::currentRouteName() == 'collection.report.collection' ? 'active' : '' }}">
                <i class="far {{ Route::currentRouteName() == 'collection.report.collection' ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আদায় রিপোর্ট</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('collection.report.user_log') }}" class="nav-link {{ Route::currentRouteName() == 'collection.report.user_log' ? 'active' : '' }}">
                <i class="far {{ Route::currentRouteName() == 'collection.report.user_log' ? 'fa-dot-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ব্যবহারকারী লগ রিপোর্ট</p>
            </a>
        </li>
    </ul>
</li>

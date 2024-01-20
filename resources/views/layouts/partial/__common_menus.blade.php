

<?php
$menu = [
    'sector_type', 'sector_type.create', 'sector_type.edit',
    'sub_sector_type', 'sub_sector_type.create', 'sub_sector_type.edit',
    'sector', 'sector.create', 'sector.edit'
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-ol"></i>
        <p>
            খাত টাইপ এবং খাত
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['sector_type', 'sector_type.create', 'sector_type.edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('sector_type') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>খাত টাইপ</p>
            </a>
        </li>
        <?php
        $subMenu = ['sub_sector_type', 'sub_sector_type.create', 'sub_sector_type.edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('sub_sector_type') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>উপ খাত টাইপ</p>
            </a>
        </li>
        <?php
        $subMenu = ['sector', 'sector.create', 'sector.edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('sector') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>খাত</p>
            </a>
        </li>
        <?php
        $subMenu = ['bank_account', 'bank_account.create', 'bank_account.edit'];
        ?>

    </ul>
</li>


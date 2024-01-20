<?php
$menu = [
    'cashbook_income.create'
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-calculator"></i>
        <p>
            আয় ব্যবস্থাপনা
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['cashbook_income.create'];
        ?>
        <li class="nav-item">
            <a href="{{ route('cashbook_income.create') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আয় সংযুক্তি</p>
            </a>
        </li>
    </ul>
</li>
<?php
$menu = ['report.treasurer_cashbook','report.abstract_register'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-calculator"></i>
        <p>
            রিপোর্ট
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['report.treasurer_cashbook'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.treasurer_cashbook') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>কোষাধ্যক্ষের ক্যাশ বহি</p>
            </a>
        </li>
        <?php
            $subMenu = ['report.abstract_register'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.abstract_register') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>এ্যাবস্ট্রাক্ট রেজিস্টার</p>
            </a>
        </li>
    </ul>
</li>

<?php
$menu = ['area', 'area.add', 'area.edit', 'team', 'team.add', 'team.edit',
    'type', 'type.add', 'type.edit'];
?>

<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            এডমিনিস্ট্রেটর
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'area' ? 'active' : '' }}"
               href="{{ route('area') }}">
                <i class="far  {{  Route::currentRouteName() == 'area'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                এলাকা</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'team' ? 'active' : '' }}"
               href="{{ route('team') }}">
                <i class="far  {{  Route::currentRouteName() == 'team'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                 দল</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'type' ? 'active' : '' }}"
               href="{{ route('type') }}">
                <i class="far  {{  Route::currentRouteName() == 'type'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                ধরণ</a>
        </li>
    </ul>
</li>

<?php
$menu = ['cleaner', 'cleaner.add', 'cleaner.edit'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            পরিচ্ছন্ন কর্মী
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'cleaner.add' ? 'active' : '' }}"
               href="{{ route('cleaner.add') }}">
                <i class="far  {{  Route::currentRouteName() == 'cleaner.add'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                পরিচ্ছন্ন কর্মী যুক্তকরণ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'cleaner' ? 'active' : '' }}"
               href="{{ route('cleaner') }}">
                <i class="far  {{  Route::currentRouteName() == 'cleaner'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                 পরিচ্ছন্ন কর্মী হালনাগাদ</a>
        </li>
    </ul>
</li>

<?php
$menu = ['cleaner_salary_update', 'cleaner_salary_process', 'cleaner_bonus_process'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-gift"></i>
        <p>
            বেতন/ বোনাস
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'cleaner_salary_update' ? 'active' : '' }}"
               href="{{ route('cleaner_salary_update') }}">
                <i class="far  {{  Route::currentRouteName() == 'cleaner_salary_update'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                বেতন/ বোনাস হালনাগাদ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'cleaner_salary_process' ? 'active' : '' }}"
               href="{{ route('cleaner_salary_process') }}">
                <i class="far  {{  Route::currentRouteName() == 'cleaner_salary_process'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                বেতন প্রস্তুত করন</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'cleaner_bonus_process' ? 'active' : '' }}"
               href="{{ route('cleaner_bonus_process') }}">
                <i class="far  {{  Route::currentRouteName() == 'cleaner_bonus_process'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                বোনাস প্রস্তুত করন</a>
        </li>

    </ul>
</li>


<?php
$menu = ['monthly_bill', 'bi_monthly_bill', 'bonus', 'salary_top_sheets', 'bonus_top_sheets', 'cleaner_information'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-calculator"></i>
        <p>
            রিপোর্টস
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'bi_monthly_bill' ? 'active' : '' }}"
               href="{{ route('bi_monthly_bill') }}">
                <i class="far  {{  Route::currentRouteName() == 'bi_monthly_bill'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                পরিচ্ছন্ন কর্মীর বিল</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'bonus' ? 'active' : '' }}"
               href="{{ route('bonus') }}">
                <i class="far  {{  Route::currentRouteName() == 'bonus'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                পরিচ্ছন্ন কর্মীর বোনাস</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'salary_top_sheets' ? 'active' : '' }}"
               href="{{ route('salary_top_sheets') }}">
                <i class="far  {{  Route::currentRouteName() == 'salary_top_sheets'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                বেতন টপশীট</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'bonus_top_sheets' ? 'active' : '' }}"
               href="{{ route('bonus_top_sheets') }}">
                <i class="far  {{  Route::currentRouteName() == 'bonus_top_sheets'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                বোনাস টপশীট</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'cleaner_information' ? 'active' : '' }}"
               href="{{ route('cleaner_information') }}">
                <i class="far  {{  Route::currentRouteName() == 'cleaner_information'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                পরিচ্ছন্ন কর্মীদের তথ্য</a>
        </li>

    </ul>
</li>

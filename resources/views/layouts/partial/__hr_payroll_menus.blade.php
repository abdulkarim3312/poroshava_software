<?php
$menu = ['employee', 'employee.create', 'employee.edit'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            কর্মচারী
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['employee.create'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee.create') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>কর্মচারী যুক্তকরণ</p>
            </a>
        </li>
        <?php
        $subMenu = ['employee', 'employee.edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>কর্মচারী হালনাগাদ</p>
            </a>
        </li>


    </ul>
</li>

<?php
$menu = ['loan_process', 'loan'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>
            লোন
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['loan_process'];
        ?>
        <li class="nav-item">
            <a href="{{ route('loan_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>লোন প্রক্রিয়া</p>
            </a>
        </li>
        <?php
        $subMenu = ['loan'];
        ?>
        <li class="nav-item">
            <a href="{{ route('loan') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>লোন রিপোট</p>
            </a>
        </li>


    </ul>
</li>


<?php
$menu = ['employee_salary_update_list', 'employee_salary_process', 'employee_salary_deposit',
    'employee_pf_deposit', 'employee_gratuity_deposit', 'employee_salary_edit'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-bill"></i>
        <p>
            বেতন
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['employee_salary_update_list', 'employee_salary_edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_salary_update_list') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বেতন হালনাগাদ করুন</p>
            </a>
        </li>
        <?php
        $subMenu = ['employee_salary_process'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_salary_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বেতন প্রস্তুত করুন</p>
            </a>
        </li>
        <?php
        $subMenu = ['employee_salary_deposit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_salary_deposit') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বেতন জমা করুন</p>
            </a>
        </li>
        <?php
        $subMenu = ['employee_pf_deposit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_pf_deposit') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>পি এফ জমা করুন</p>
            </a>
        </li>
        <?php
        $subMenu = ['employee_gratuity_deposit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_gratuity_deposit') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আনুতোষিক জমা করুন</p>
            </a>
        </li>

    </ul>
</li>

<?php
$menu = ['employee_bonus_process'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-gift"></i>
        <p>
            বোনাস
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['employee_bonus_process'];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বোনাস প্রস্তুত করুন</p>
            </a>
        </li>

    </ul>
</li>
<?php
$menu = ['report.employee_monthly_pay_bill','report.employee_monthly_salary_top_sheet',
    'report.employee_monthly_salary_bank_deposit'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-receipt"></i>
        <p>
            রিপোর্টস
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['report.employee_monthly_pay_bill'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.employee_monthly_pay_bill') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>মাসিক বেতন বিল</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.employee_monthly_salary_top_sheet'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.employee_monthly_salary_top_sheet') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বেতন টপশিট</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.employee_monthly_salary_bank_deposit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.employee_monthly_salary_bank_deposit') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>মাসিক বেতন ব্যাংক জমা</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বোনাস টপশিট</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বোনাস ব্যাংক জমা</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>মাসিক পি এফ ব্যাংক জমা</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>মাসিক আনুতোষিক ব্যাংক</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>কর্মচারী বাৎসরিক বেতন</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>সকল কর্মচারীর বাৎসরিক</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>নিষ্ক্রিয় কর্মচারীর বেতন</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>নিষ্ক্রিয় কর্মচারীর বিস্তারিত</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>পি এফ রেজিস্টার ও ঋণ</p>
            </a>
        </li>
        <?php
        $subMenu = [];
        ?>
        <li class="nav-item">
            <a href="{{ route('employee_bonus_process') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>সকল পি এফ রেজিস্টার</p>
            </a>
        </li>
    </ul>
</li>


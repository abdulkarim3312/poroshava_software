
<?php
$menu = [
    'bank', 'bank.create', 'bank.edit',
    'branch', 'branch.create', 'branch.edit',
    'bank_account', 'bank_account.create', 'bank_account.edit'
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-house-user"></i>
        <p>
            ব্যাংক এবং অ্যাকাউন্ট
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['bank', 'bank.create', 'bank.edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('bank') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ব্যাংক</p>
            </a>
        </li>
        <?php
        $subMenu = ['branch', 'branch.create', 'branch.edit',];
        ?>
        <li class="nav-item">
            <a href="{{ route('branch') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>শাখা</p>
            </a>
        </li>
        <?php
        $subMenu = ['bank_account', 'bank_account.create', 'bank_account.edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('bank_account') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ব্যাংক হিসাব</p>
            </a>
        </li>


    </ul>
</li>
<?php
$menu = ['contractor', 'contractor.create', 'contractor.edit'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            ঠিকাদার
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['contractor.create'];
        ?>
        <li class="nav-item">
            <a href="{{ route('contractor.create') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ঠিকাদার যুক্তকরণ</p>
            </a>
        </li>
        <?php
        $subMenu = ['contractor', 'contractor.edit'];
        ?>
        <li class="nav-item">
            <a href="{{ route('contractor') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ঠিকাদার হালনাগাদ</p>
            </a>
        </li>


    </ul>
</li>
<?php
$menu = ['project_payment_list', 'project.create', 'project.edit','project.contractor_payment'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            প্রকল্প
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['project.create'];
        ?>
        <li class="nav-item">
            <a href="{{ route('project.create') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>প্রকল্প যুক্তকরণ</p>
            </a>
        </li>
        <?php
        $subMenu = ['project_payment_list','project.contractor_payment'];
        ?>
        <li class="nav-item">
            <a href="{{ route('project_payment_list') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>প্রকল্প পেমেন্ট</p>
            </a>
        </li>


    </ul>
</li>
<?php
$menu = ['report.project_payment_register', 'report.project_payment_certificate'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-calculator"></i>
        <p>
            প্রকল্প রিপোর্টস
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['report.project_payment_register'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.project_payment_register') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>পেমেন্ট রেজিস্টার</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.project_payment_certificate'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.project_payment_certificate') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>পেমেন্ট সার্টিফিকেট</p>
            </a>
        </li>


    </ul>
</li>


<?php

$menu = [
    'budget', 'budget.create',
    'budget.pending_list'
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>
            বাজেট
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['budget.create'];
        ?>
        <li class="nav-item">
            <a href="{{ route('budget.create') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বাজেট যুক্তকরণ</p>
            </a>
        </li>
        <?php
        $subMenu = ['budget'];
        ?>
        <li class="nav-item">
            <a href="{{ route('budget') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বাজেট ব্যবস্থাপন</p>
            </a>
        </li>
        <?php
        $subMenu = ['budget.pending_list'];
        ?>
        <li class="nav-item">
            <a href="{{ route('budget.pending_list') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বাজেট অনুমোদোন</p>
            </a>
        </li>
    </ul>
</li>


<?php
$menu = [
    'income_expenditure.create', 'report.cheque_register', 'check_register.print',
    'balance_transfer', 'income_expenditure', 'cheque_register.cheque_print', 'challan_print',
    'report.income_uncash',
    'report.expense_uncash',
];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-calculator"></i>
        <p>
            আয়/ব্যয় ব্যবস্থাপনা
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['income_expenditure.create'];
        ?>
        <li class="nav-item">
            <a href="{{ route('income_expenditure.create') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আয়/ব্যয় সংযুক্তি</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.cheque_register', 'check_register.print', 'cheque_register.cheque_print',
            'challan_print'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.cheque_register') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>চেক রেজিস্টার</p>
            </a>
        </li>
        <?php
        $subMenu = ['balance_transfer'];
        ?>
        <li class="nav-item">
            <a href="{{ route('balance_transfer') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আর্থিক স্থানন্তর</p>
            </a>
        </li>
        <?php
        $subMenu = ['income_expenditure'];
        ?>
        <li class="nav-item">
            <a href="{{ route('income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আয়/ব্যয় ব্যবস্থাপন</p>
            </a>
        </li>
            <?php
            $subMenu = ['report.income_uncash'];
            ?>
        <li class="nav-item">
            <a href="{{ route('report.income_uncash') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আয় আন ক্যাশ</p>
            </a>
        </li>
            <?php
            $subMenu = ['report.expense_uncash'];
            ?>
            <li class="nav-item">
                <a href="{{ route('report.expense_uncash') }}"
                   class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                    <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                    <p>ব্যয় আন ক্যাশ</p>
                </a>
            </li>
    </ul>
</li>
<?php
$menu = ['report.cashbook','report.cashbook_expense','report.cashbook_income','report.bank_account_closing', 'report.income_expenditure', 'report.yearly_income_expenditure', 'report.daily_income_expenditure', 'report.income_budget', 'report.expenditure_budget', 'report.bank_details_report'];
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
        $subMenu = ['report.cashbook'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.cashbook') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ক্যাশবই (দৈনিক)</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.bank_account_closing'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.bank_account_closing') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>এ্যাকাউন্ট ক্লোজিং</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.income_expenditure'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আয় ব্যয় হিসাব</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.yearly_income_expenditure'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.yearly_income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বাৎসরিক আয় ব্যয় হিসাব</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.daily_income_expenditure'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.daily_income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>দৈনিক আয় ব্যয় হিসাব</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.income_budget'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.income_budget') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>আয় বাজেট</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.expenditure_budget'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.expenditure_budget') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ব্যয় বাজেট</p>
            </a>
        </li>
        <?php
        $subMenu = ['report.bank_details_report'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.bank_details_report') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ব্যাংক বিবরণ</p>
            </a>
        </li>
        <?php
            $subMenu = ['report.cashbook_expense'];
        ?>
        <li class="nav-item">
            <a href="{{ route('report.cashbook_expense') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ক্যাশ বহি(ব্যায়)</p>
            </a>
        </li>
            <?php
            $subMenu = ['report.cashbook_income'];
            ?>
        <li class="nav-item">
            <a href="{{ route('report.cashbook_income') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ক্যাশ বহি(আয়)</p>
            </a>
        </li>
            <?php
            $subMenu = [];
            ?>
        <li class="nav-item">
            <a href="{{ route('income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ভ্যাট</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>ট্যাক্স</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>বাজেট রেজিস্টার</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>হিসাব রক্ষক এর বই (দৈনিক)</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>এ্যাবস্ট্রাক্ট রেজিস্টার (মাসিক)</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('income_expenditure') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>এ্যাবস্ট্রাক্ট রেজিস্টার (ত্রৈমাসিক)</p>
            </a>
        </li>
    </ul>
</li>

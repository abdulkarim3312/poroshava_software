<?php
$menu = ['holding.area', 'holding.area.add', 'holding.area.edit','holding.use_type', 'holding.use_type.add', 'holding.use_type.edit',
    'holding.structure_type', 'holding.structure_type.add', 'holding.structure_type.edit', 'holding.holding_category', 'holding.holding_category.add', 'holding.holding_category.edit',];
?>

<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            সেটিংস
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <?php
        $subMenu = ['holding.area','holding.area.add', 'holding.area.edit']
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('holding.area') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                মহল্লা / রাস্তা  </a>
        </li>
        <?php
        $subMenu = ['holding.holding_category','holding.holding_category.add', 'holding.holding_category.edit']
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('holding.holding_category') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                মালিকানার ধরন </a>
        </li>
        <?php
        $subMenu = ['holding.use_type','holding.use_type.add', 'holding.use_type.edit']
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('holding.use_type') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                হোল্ডিং ব্যবহারের ধরন</a>
        </li>
        <?php
        $subMenu = ['holding.structure_type','holding.structure_type.add', 'holding.structure_type.edit']
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('holding.structure_type') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                হোল্ডিং স্থাপনার ধরন</a>
        </li>
    </ul>
</li>

<?php
$menu = ['holding.tax_payer','holding_tax_payer_holdinginfo','holding_tax_payer_construction','holding_tax_payer_tenant', 'holding.tax_payer.add','holding.tax_payer_details.add', 'holding.tax_payer.edit','holding.installment_process','holding.collection_posting','holding_tax_payer_assesment_details'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            করদাতা
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <?php
        $subMenu = ['holding.tax_payer','holding_tax_payer_holdinginfo','holding_tax_payer_construction','holding_tax_payer_tenant','holding.tax_payer.add','holding.tax_payer_details.add','holding_tax_payer_assesment_details'];
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('holding.tax_payer') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                সকল  করদাতা </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'holding.installment_process' ? 'active' : '' }}"
               href="{{ route('holding.installment_process') }}">
                <i class="far  {{  Route::currentRouteName() == 'holding.installment_process'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                কিস্তি বিল প্রক্রিয়া</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'holding.collection_posting' ? 'active' : '' }}"
               href="{{ route('holding.collection_posting') }}">
                <i class="far  {{  Route::currentRouteName() == 'holding.collection_posting'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                কালেকশন পোস্টিং</a>
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
        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link {{ Route::currentRouteName() == 'bi_monthly_bill' ? 'active' : '' }}"--}}
        {{--               href="{{ route('bi_monthly_bill') }}">--}}
        {{--                <i class="far  {{  Route::currentRouteName() == 'bi_monthly_bill'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>--}}
        {{--                পরিচ্ছন্ন কর্মীর বিল</a>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link {{ Route::currentRouteName() == 'bonus' ? 'active' : '' }}"--}}
        {{--               href="{{ route('bonus') }}">--}}
        {{--                <i class="far  {{  Route::currentRouteName() == 'bonus'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>--}}
        {{--                পরিচ্ছন্ন কর্মীর বোনাস</a>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link {{ Route::currentRouteName() == 'salary_top_sheets' ? 'active' : '' }}"--}}
        {{--               href="{{ route('salary_top_sheets') }}">--}}
        {{--                <i class="far  {{  Route::currentRouteName() == 'salary_top_sheets'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>--}}
        {{--                বেতন টপশীট</a>--}}
        {{--        </li>--}}

        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link {{ Route::currentRouteName() == 'bonus_top_sheets' ? 'active' : '' }}"--}}
        {{--               href="{{ route('bonus_top_sheets') }}">--}}
        {{--                <i class="far  {{  Route::currentRouteName() == 'bonus_top_sheets'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>--}}
        {{--                বোনাস টপশীট</a>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item">--}}
        {{--            <a class="nav-link {{ Route::currentRouteName() == 'cleaner_information' ? 'active' : '' }}"--}}
        {{--               href="{{ route('cleaner_information') }}">--}}
        {{--                <i class="far  {{  Route::currentRouteName() == 'cleaner_information'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>--}}
        {{--                পরিচ্ছন্ন কর্মীদের তথ্য</a>--}}
        {{--        </li>--}}

            </ul>
</li>

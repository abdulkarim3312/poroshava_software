<?php
$menu = ['trade_license_area','trade_license_area_add', 'trade_license_area_edit','trade_license_signboard','trade_license_signboard_add', 'trade_license_signboard_edit',
    'holding.structure_type', 'holding.structure_type.add', 'holding.structure_type.edit', 'trade_license_business_type','trade_license_business_type_add', 'trade_license_business_type_edit'];
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
            $subMenu = ['trade_license_area','trade_license_area_add', 'trade_license_area_edit']
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('trade_license_area') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                মহল্লা / রাস্তা  </a>
        </li>
        <?php
            $subMenu = ['trade_license_business_type','trade_license_business_type_add', 'trade_license_business_type_edit']
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('trade_license_business_type') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                ব্যবসার ধরন </a>
        </li>
        <?php
            $subMenu = ['trade_license_signboard','trade_license_signboard_add', 'trade_license_signboard_edit']
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('trade_license_signboard') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu) ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                সাইন বোর্ডের ধরন</a>
        </li>
    </ul>
</li>

<?php
   $menu = ['trade_license_list', 'trade_license_approve_list','trade_license_add', 'trade_license_details','trade_license_approve_details','holding.collection_posting','trade_license_pending_list','trade_license_pending_details'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            ট্রেড লাইসেন্স
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <?php
            $subMenu = ['trade_license_list','trade_license_details','trade_license_pending_list','trade_license_pending_details'];
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('trade_license_list') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                ট্রেড লাইসেন্স তালিকা </a>
        </li>
        <?php
            $subMenu = ['trade_license_approve_list','trade_license_add','trade_license_approve_details'];
        ?>
        <li class="nav-item">
            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
               href="{{ route('trade_license_approve_list') }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                নতুন ট্রেড লাইসেন্স নিবন্ধন</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'holding.collection_posting' ? 'active' : '' }}"
               href="{{ route('holding.collection_posting') }}">
                <i class="far  {{  Route::currentRouteName() == 'holding.collection_posting'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                ব্যাংক কালেকশন পোষ্টিং</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'holding.collection_posting' ? 'active' : '' }}"
               href="{{ route('holding.collection_posting') }}">
                <i class="far  {{  Route::currentRouteName() == 'holding.collection_posting'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                লাইসেন্স কালেকশন তালিকা</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'holding.collection_posting' ? 'active' : '' }}"
               href="{{ route('holding.collection_posting') }}">
                <i class="far  {{  Route::currentRouteName() == 'holding.collection_posting'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                লাইসেন্স বিল তৈরি</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'holding.collection_posting' ? 'active' : '' }}"
               href="{{ route('holding.collection_posting') }}">
                <i class="far  {{  Route::currentRouteName() == 'holding.collection_posting'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                ওয়ার্ড অনুসারে বিল তৈরি</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'holding.collection_posting' ? 'active' : '' }}"
               href="{{ route('holding.collection_posting') }}">
                <i class="far  {{  Route::currentRouteName() == 'holding.collection_posting'  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                অর্থ বছর আদায় ও দাবী</a>
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

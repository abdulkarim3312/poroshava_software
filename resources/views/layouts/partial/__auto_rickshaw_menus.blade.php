<?php
$menu = array(
    'চালকের লাইসেন্স রিপোর্ট ' =>   'auto-rickshaw/report/vehicle-license/',
    'মালিকের লাইসেন্স রিপোর্ট ' =>   'auto-rickshaw/report/owner-license/',
    'চালকের লাইসেন্স আদায় ' =>   'auto-rickshaw/report/vehicle-license-collection',
    'মালিকের লাইসেন্স আদায় ' =>   'auto-rickshaw/report/owner-license-collection',
);
?>

<?php
$subMenu = ['auto_rickshaw.type','auto_rickshaw.type.add','auto_rickshaw.type.edit']
?>
<li class="nav-item">
    <a href="{{ route('auto_rickshaw.type') }}"
       class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-ol"></i>
        <p>লাইসেন্সের ধরণ </p>
    </a>
</li>
<?php
$subMenu = ['auto_rickshaw.vehicle_license']
?>
<li class="nav-item">
    <a href="{{ route('auto_rickshaw.vehicle_license') }}"
       class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-friends"></i>
        <p>চালকের লাইসেন্স যুক্তকরন </p>
    </a>
</li>
<?php
$subMenu = ['auto_rickshaw.all_vehicle_license','auto_rickshaw.vehicle_edit','auto_rickshaw.vehicle_print']
?>
<li class="nav-item">
    <a href="{{ route('auto_rickshaw.all_vehicle_license') }}"
       class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-friends"></i>
        <p>সকল চালকের লাইসেন্স </p>
    </a>
</li>
<?php
$subMenu = ['auto_rickshaw.add_owner_license']
?>
<li class="nav-item">
    <a href="{{ route('auto_rickshaw.add_owner_license') }}"
       class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-friends"></i>
        <p class="text-sm">মালিকের লাইসেন্স যুক্তকরন </p>
    </a>
</li>
<?php
$subMenu = ['auto_rickshaw.all_owner_license','auto_rickshaw.owner_license_edit','auto_rickshaw.owner_print']
?>
<li class="nav-item">
    <a href="{{ route('auto_rickshaw.all_owner_license') }}"
       class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-friends"></i>
        <p>সকল মালিকের লাইসেন্স </p>
    </a>
</li>
<?php
$menu = [
    'auto_rickshaw.report_vehicle_license',
    'auto_rickshaw.report_owner_license',
    'auto_rickshaw.report_vehicle_license_collection',
    'auto_rickshaw.report_owner_license_collection'];
?>
<li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
        <i class="nav-icon fas fa-receipt"></i>
        <p>
            রিপোর্ট
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <?php
        $subMenu = ['auto_rickshaw.report_vehicle_license'];
        ?>
        <li class="nav-item">
            <a href="{{ route('auto_rickshaw.report_vehicle_license') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>চালকের লাইসেন্স রিপোর্ট</p>
            </a>
        </li>
        <?php
        $subMenu = ['auto_rickshaw.report_owner_license'];
        ?>
        <li class="nav-item">
            <a href="{{ route('auto_rickshaw.report_owner_license') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>মালিকের লাইসেন্স রিপোর্ট</p>
            </a>
        </li>
        <?php
            $subMenu = ['auto_rickshaw.report_vehicle_license_collection'];
        ?>
        <li class="nav-item">
            <a href="{{ route('auto_rickshaw.report_vehicle_license_collection') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>চালকের লাইসেন্স আদায়</p>
            </a>
        </li>
      <?php
        $subMenu = ['auto_rickshaw.report_owner_license_collection'];
        ?>
        <li class="nav-item">
            <a href="{{ route('auto_rickshaw.report_owner_license_collection') }}"
               class="nav-link {{ in_array(Route::currentRouteName(), $subMenu)  ? 'active' : '' }}">
                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                <p>মালিকের লাইসেন্স আদায় </p>
            </a>
        </li>
    </ul>
</li>

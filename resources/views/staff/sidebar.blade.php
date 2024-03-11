<ul class="nav nav-pills flex-column mb-auto">
    <!-- admin -->
    <li class="nav-item">
        <a href="{{Route('fruitCategoryList')}}" class="nav-link ">{{__("Fruit Category list")}}</a>
    </li>
    <li class="nav-item">
        <a href="{{Route('fruitList')}}" class="nav-link ">{{__("Fruit list")}}</a>
    </li>
    <li class="nav-item">
        <a href="{{Route('invoiceList')}}" class="nav-link ">{{__("Invoice list")}}</a>
    </li>
</ul>


<div id="admin-infobox">
    <!--<div class="adminheader">{{"Administrator"}}</div>-->
    <div class="adminname">{{ Auth::user()['name'] }}</div>
    <div id="logout-box" class="">
        
        <form method="post" action="{{route('staff.logout')}}">
            @csrf
            <button type="submit" class="btn btn-logout">{{__("Logout")}}</button>
        </form>
    </div>
</div>

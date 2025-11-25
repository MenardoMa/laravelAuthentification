<div>
    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            <span class="user-icon">
                <img src="" alt="" />
            </span>
            <span class="user-name">{{ $user->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
            <a class="dropdown-item" href=""><i class="dw dw-user1"></i>
                Profile</a>
            <a class="dropdown-item" href=""><i class="dw dw-settings2"></i> Setting</a>
            <a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a>
            <a class="dropdown-item" href="{{ route('admin.logout_handler') }}"
                onclick="event.preventDefault(); document.getElementById('form_logout').submit()">
                <i class="dw dw-logout"></i>
                Log Out
            </a>
            <form action="{{ route('admin.logout_handler') }}" method="POST" id="form_logout">
                @csrf
            </form>
        </div>
    </div>
</div>
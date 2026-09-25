<svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
    @switch($icon)
        @case('dashboard')
            <path d="M4 18a9 9 0 1 1 16 0H4Z M12 13l4-5 M5 12h1 M8 6l1 1 M18 12h1"/><circle cx="12" cy="14" r="2"/>
            @break
        @case('content')
            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 7h10 M7 11h10 M7 15h6"/>
            @break
        @case('reviews')
            <path d="M3 5h7v7H7l-3 4v-4H3V5Z M14 5h7v7h-3l-3 4v-4h-1V5Z"/>
            @break
        @case('categories')
            <rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h.01 M10 8h7 M7 12h.01 M10 12h7 M7 16h.01 M10 16h7"/>
            @break
        @case('products')
            <path d="M3 7h18v14H3V7Z M8 10V3h8v7"/>
            @break
        @case('page')
            <path d="M14 2H5v20h14V7l-5-5Z M14 2v6h5 M8 12h8 M8 16h6"/>
            @break
        @case('orders')
            <path d="M2 3h3l3 12h11l3-9H6"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/>
            @break
        @case('invoice')
            <path d="M6 3h12v19l-3-2-3 2-3-2-3 2V3Z M9 7h6 M9 11h6 M9 15h4"/>
            @break
        @case('users')
            <circle cx="9" cy="7" r="3"/><path d="M3 21v-3a6 6 0 0 1 12 0v3 M16 4a3 3 0 0 1 0 6 M18 14a5 5 0 0 1 3 4v3"/>
            @break
        @case('globe')
            <circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/>
            @break
        @case('settings')
            <path d="m9 3 1-1h4l1 3 3 1 3 1v4l-2 2 1 3-3 3-3-1-2 3H8l-1-3-3-1-1-4 2-2-1-3 3-3 2 1Z"/><circle cx="12" cy="12" r="3"/>
            @break
        @case('external')
            <path d="M14 3h7v7 M21 3l-11 11 M10 3H3v18h18v-7"/>
            @break
        @case('logout')
            <path d="M9 3H3v18h6 M9 12h12 M17 8l4 4-4 4"/>
            @break
        @case('menu')
            <path d="M4 6h16 M4 12h16 M4 18h16"/>
            @break
    @endswitch
</svg>

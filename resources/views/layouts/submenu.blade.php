          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    
    @foreach(get_submenus($parentPageId) as $submenu)
            <li>
                <a class="dropdown-item" href="{{ url('/')}}{{ $submenu->path }}">{{ $submenu->name }}</a>
                @if (has_submenus($submenu->id))
                    {{-- Recursive Call for Submenus --}}
                    @include('layouts.submenu', ['parentPageId' => $submenu->id])
                @endif
            </li>
    @endforeach

</ul>











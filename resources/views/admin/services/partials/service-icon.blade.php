<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
    @if ($icon === 'heart')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
    @elseif ($icon === 'shield')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 4v5c0 5-3.5 8.74-7 10-3.5-1.26-7-5-7-10V7l7-4z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 12.5l1.5 1.5 3.5-3.5"/>
    @elseif ($icon === 'baby')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    @elseif ($icon === 'user-nurse')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21a7 7 0 0114 0"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4h4M12 2v4"/>
    @elseif ($icon === 'bone')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 8.5a2.5 2.5 0 11-3.5-3.5l2-2a2.5 2.5 0 113.5 3.5l-1 1 5 5 1-1a2.5 2.5 0 113.5 3.5l-2 2a2.5 2.5 0 11-3.5-3.5l1-1-5-5-1 1z"/>
    @elseif ($icon === 'droplet')
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3s-5 5.5-5 9a5 5 0 0010 0c0-3.5-5-9-5-9z"/>
    @else
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3v5a4 4 0 008 0V3"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8a4 4 0 108 0"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v3a4 4 0 104 4"/>
    @endif
</svg>

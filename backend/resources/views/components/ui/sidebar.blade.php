@props([
    'navLinks' => [],
])

<aside id="sidebar" class="sidebar" style="width: 280px; background: white; border-right: 3px solid #e9d5ff; box-shadow: 4px 0 20px rgba(139, 92, 246, 0.1); position: fixed; left: 0; top: 0; height: 100vh; overflow-y: auto; z-index: 40; transition: width 0.3s ease, transform 0.3s ease;">
    <!-- Logo -->
    <div style="padding: 16px 12px; border-bottom: 2px solid #f3e8ff;">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo-link" style="display: flex; align-items: center; gap: 10px; text-decoration: none; transition: all 0.3s;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4); flex-shrink: 0;">
                <x-ui.icon name="book-open" size="24" style="color: white;" />
            </div>
            <span class="sidebar-logo-text" style="font-size: 18px; font-weight: 900; background: linear-gradient(135deg, #8b5cf6, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; white-space: nowrap; overflow: hidden; transition: opacity 0.3s;">Biblioteca Online</span>
        </a>
    </div>

    <!-- Menu Navigation -->
    <nav style="padding: 12px 8px;">
        <div style="display: flex; flex-direction: column; gap: 4px;">
            @foreach($navLinks as $link)
                @php
                    $isActive = request()->routeIs($link['pattern'] ?? '');
                @endphp
                <a 
                    href="{{ route($link['route']) }}" 
                    class="sidebar-nav-link sidebar-link-fast{{ $isActive ? ' active' : '' }}"
                    style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; color: #4b5563; font-weight: 600; text-decoration: none; border-radius: 10px; transition: all 0.3s; {{ $isActive ? 'background: linear-gradient(135deg, #f3e8ff, #fdf2f8); color: #8b5cf6; box-shadow: 0 2px 8px rgba(139, 92, 246, 0.2);' : '' }}"
                >
                    <x-ui.icon :name="$link['icon'] ?? 'circle'" size="18" style="flex-shrink: 0; {{ $isActive ? 'color: #8b5cf6;' : '' }}" />
                    <span class="sidebar-nav-text" style="font-size: 14px; white-space: nowrap; overflow: hidden; transition: opacity 0.3s;">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>

    <style>
        .sidebar.collapsed {
            width: 80px !important;
        }
        .sidebar.collapsed .sidebar-logo-text,
        .sidebar.collapsed .sidebar-nav-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }
        .sidebar.collapsed .sidebar-logo-link {
            justify-content: center;
        }
        .sidebar.collapsed .sidebar-nav-link {
            justify-content: center;
            padding: 10px;
        }
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>


</aside>


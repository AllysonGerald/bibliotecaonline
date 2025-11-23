@props([
    'title',
    'subtitle' => null,
])

<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
        <div style="flex: 1; min-width: 0;">
            <h1 class="page-title" style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px; word-wrap: break-word;">{{ $title }}</h1>
            @if($subtitle)
                <p class="page-subtitle" style="font-size: 18px; color: #6b7280; font-weight: 500; word-wrap: break-word;">{{ $subtitle }}</p>
            @endif
        </div>
        @if(isset($actions) || isset($slot) && $slot->isNotEmpty())
            <div class="page-actions" style="display: flex; gap: 12px; flex-wrap: wrap; flex-shrink: 0;">
                @if(isset($actions))
                    {!! $actions !!}
                @else
                    {{ $slot }}
                @endif
            </div>
        @endif
    </div>
</div>

<style>
    @media (max-width: 640px) {
        .page-title {
            font-size: 24px !important;
        }
        .page-subtitle {
            font-size: 14px !important;
        }
        .page-actions {
            width: 100%;
            margin-top: 16px;
        }
        .page-actions > * {
            flex: 1;
            min-width: 0;
        }
    }
    @media (max-width: 1024px) {
        .responsive-table {
            font-size: 14px;
        }
        .responsive-table th,
        .responsive-table td {
            padding: 12px 8px !important;
        }
    }
</style>

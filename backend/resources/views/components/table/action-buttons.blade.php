@props([
    'viewHref' => null,
    'editHref' => null,
    'deleteModalId' => null,
    'viewTitle' => 'Ver',
    'editTitle' => 'Editar',
    'deleteTitle' => 'Excluir',
])

<div style="display: flex; justify-content: flex-end; gap: 8px; flex-wrap: wrap;">
    @if($viewHref)
        <a href="{{ $viewHref }}" 
           class="action-btn-view icon-only-btn"
           style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd; border-radius: 10px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(14, 165, 233, 0.15); pointer-events: auto; position: relative; z-index: 10;" 
           title="{{ $viewTitle }}">
            <x-ui.icon name="eye" size="18" style="pointer-events: none;" />
        </a>
    @endif
    
    @if($editHref)
        <a href="{{ $editHref }}" 
           class="action-btn-edit icon-only-btn"
           style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 10px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(139, 92, 246, 0.15); pointer-events: auto; position: relative; z-index: 10;" 
           title="{{ $editTitle }}">
            <x-ui.icon name="edit" size="18" style="pointer-events: none;" />
        </a>
    @endif
    
    @if($deleteModalId)
        <button type="button" 
                onclick="openDeleteModal(&quot;{{ $deleteModalId }}&quot;)" 
                class="action-btn-delete icon-only-btn"
                style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border: 2px solid #fca5a5; border-radius: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 5px rgba(239, 68, 68, 0.15); pointer-events: auto; position: relative; z-index: 10;" 
                title="{{ $deleteTitle }}">
            <x-ui.icon name="trash-2" size="18" style="pointer-events: none;" />
        </button>
    @endif
    
    {{ $slot }}
</div>

<style>
    .action-btn-view,
    .action-btn-edit,
    .action-btn-delete,
    .icon-only-btn {
        pointer-events: auto !important;
        cursor: pointer !important;
        position: relative;
        z-index: 100;
    }
    
    /* Botões de senha não devem ter position/z-index alterados - eles usam absolute */
    .password-toggle-btn {
        pointer-events: auto !important;
        cursor: pointer !important;
        /* position e z-index são definidos inline no JavaScript */
    }
    
    .action-btn-view:hover {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8) !important;
        color: white !important;
        border-color: #0ea5e9 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3) !important;
    }
    .action-btn-edit:hover {
        background: linear-gradient(135deg, #8b5cf6, #a855f7) !important;
        color: white !important;
        border-color: #8b5cf6 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3) !important;
    }
    .action-btn-delete:hover {
        background: linear-gradient(135deg, #ef4444, #f87171) !important;
        color: white !important;
        border-color: #ef4444 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3) !important;
    }
</style>


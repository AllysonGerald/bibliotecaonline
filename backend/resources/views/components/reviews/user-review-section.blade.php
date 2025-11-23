@props(['review'])

@php
    $wasEdited = $review->created_at->ne($review->updated_at);
@endphp

<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 24px; position: relative; overflow: hidden;" x-data="{ editing: false }">
    <!-- Decorative gradient background -->
    <div style="position: absolute; top: 0; right: 0; width: 200px; height: 200px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(236, 72, 153, 0.1)); border-radius: 50%; transform: translate(30%, -30%); pointer-events: none;"></div>

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; position: relative; z-index: 1;">
        <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin: 0; display: flex; align-items: center; gap: 12px;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">
                <x-ui.icon name="star" size="24" style="color: white;" />
            </div>
            Sua Avaliação
        </h3>
        <div style="display: flex; gap: 8px;">
            <x-ui.button
                @click="editing = true"
                variant="secondary"
                icon="edit"
                class="padding: 10px 16px; font-size: 14px;"
            >
                Editar
            </x-ui.button>
            <x-ui.button
                type="button"
                onclick="openDeleteModal('delete-review-{{ $review->id }}')"
                variant="danger"
                icon="trash-2"
                class="padding: 10px 16px; font-size: 14px;"
            >
                Excluir
            </x-ui.button>
        </div>
    </div>

    <!-- Modo Visualização -->
    <div x-show="!editing" style="position: relative; z-index: 1;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <x-reviews.star-rating :rating="$review->nota" size="24" />
            <span style="font-size: 14px; color: #6b7280; font-weight: 600;">
                Avaliado em {{ $review->created_at->format('d/m/Y') }}
                @if($wasEdited)
                    <span style="color: #8b5cf6; margin-left: 8px; font-weight: 700;">(Editado)</span>
                @endif
            </span>
        </div>
        @if($review->comentario)
            <div style="background: linear-gradient(135deg, #faf5ff, #f3e8ff); border-radius: 12px; padding: 16px; border: 2px solid #e9d5ff;">
                <p style="font-size: 15px; color: #1f2937; line-height: 1.7; margin: 0;">{{ $review->comentario }}</p>
            </div>
        @else
            <p style="font-size: 14px; color: #6b7280; font-style: italic;">Sem comentário.</p>
        @endif
    </div>

    <!-- Modo Edição -->
    <div x-show="editing" x-cloak style="position: relative; z-index: 1;">
        <x-reviews.review-form
            :review="$review"
            action="{{ route('avaliacoes.update', $review) }}"
            method="PUT"
            submit-label="Salvar Alterações"
            cancel-action="editing = false"
        />
    </div>
</div>

<!-- Modal de Exclusão -->
<x-modals.delete-modal
    id="delete-review-{{ $review->id }}"
    title="Remover Avaliação"
    message="Tem certeza que deseja remover sua avaliação? Esta ação não pode ser desfeita."
    action="{{ route('avaliacoes.destroy', $review) }}"
/>


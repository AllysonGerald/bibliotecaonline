@extends('layouts.admin')

@section('title', 'Multas')

@section('content')
<x-ui.page-header 
    title="Multas" 
    subtitle="Gerencie todas as multas do sistema" 
>
    <x-slot name="actions">
        <x-ui.button href="{{ route('admin.dashboard') }}" variant="secondary" icon="arrow-left">
            Voltar
        </x-ui.button>
    </x-slot>
</x-ui.page-header>

<!-- Filtros -->
<x-forms.filter-form action="{{ route('admin.multas.index') }}" method="GET" title="Filtrar Multas" icon="filter" iconColor="#8b5cf6" borderColor="#e9d5ff" shadowColor="rgba(139, 92, 246, 0.15)" backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)" buttonVariant="primary">
    <x-forms.select 
        name="status" 
        label="Status" 
        :value="request('status')" 
        :options="[
            '' => 'Todas',
            'pendente' => 'Pendentes',
            'paga' => 'Pagas',
        ]"
        borderColor="#e9d5ff"
        focusColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #ffffff)"
    />
</x-forms.filter-form>

<!-- Lista de Multas -->
@if($fines->count() > 0)
    <x-ui.card borderColor="#e9d5ff" shadowColor="rgba(139, 92, 246, 0.15)" backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 16px; text-align: left; font-weight: 700; color: #1f2937; border-bottom: 2px solid #e9d5ff; background: linear-gradient(135deg, #f3e8ff, #faf5ff);">Usuário</th>
                        <th style="padding: 16px; text-align: left; font-weight: 700; color: #1f2937; border-bottom: 2px solid #e9d5ff; background: linear-gradient(135deg, #f3e8ff, #faf5ff);">Livro</th>
                        <th style="padding: 16px; text-align: left; font-weight: 700; color: #1f2937; border-bottom: 2px solid #e9d5ff; background: linear-gradient(135deg, #f3e8ff, #faf5ff);">Valor</th>
                        <th style="padding: 16px; text-align: left; font-weight: 700; color: #1f2937; border-bottom: 2px solid #e9d5ff; background: linear-gradient(135deg, #f3e8ff, #faf5ff);">Status</th>
                        <th style="padding: 16px; text-align: center; font-weight: 700; color: #1f2937; border-bottom: 2px solid #e9d5ff; background: linear-gradient(135deg, #f3e8ff, #faf5ff);">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fines as $fine)
                        <tr style="border-bottom: 1px solid #e9d5ff; transition: background 0.2s;" onmouseover="this.style.background='#faf5ff';" onmouseout="this.style.background='transparent';">
                            <td style="padding: 16px; color: #4b5563; font-weight: 600;">{{ $fine->user->name }}</td>
                            <td style="padding: 16px; color: #4b5563; font-weight: 600;">{{ $fine->rental->book->titulo }}</td>
                            <td style="padding: 16px; color: #1f2937; font-weight: 700; font-size: 16px;">R$ {{ number_format($fine->valor, 2, ',', '.') }}</td>
                            <td style="padding: 16px;">
                                @if($fine->paga)
                                    <x-ui.badge variant="success">Paga</x-ui.badge>
                                @else
                                    <x-ui.badge variant="danger">Pendente</x-ui.badge>
                                @endif
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap;">
                                    <x-ui.button href="{{ route('admin.multas.show', $fine) }}" variant="secondary" icon="eye" class="padding: 8px 12px; font-size: 13px;">
                                        Ver Detalhes
                                    </x-ui.button>
                                    @if(!$fine->paga)
                                        <x-ui.button 
                                            type="button" 
                                            onclick="openPayFineModal('pay-fine-{{ $fine->id }}')" 
                                            variant="success" 
                                            icon="check-circle" 
                                            class="padding: 8px 12px; font-size: 13px;"
                                        >
                                            Marcar como Paga
                                        </x-ui.button>
                                        
                                        <!-- Modal de Confirmação de Pagamento -->
                                        <x-modals.pay-fine-modal
                                            id="pay-fine-{{ $fine->id }}"
                                            title="Confirmar Pagamento"
                                            message="Tem certeza que deseja marcar esta multa como paga? Ao confirmar, a taxa de atraso será zerada."
                                            action="{{ route('admin.multas.pay', $fine) }}"
                                            :fineValue="'R$ ' . number_format($fine->valor, 2, ',', '.')"
                                        />
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.card>

    <!-- Paginação -->
    <div style="margin-top: 24px;">
        {{ $fines->links() }}
    </div>
@else
    <x-ui.empty-state 
        title="Nenhuma multa encontrada"
        :message="request('status') ? 'Não há multas com este status.' : 'Não há multas registradas no sistema.'"
        icon="check-circle"
        iconColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #fce7f3)"
    />
@endif

<script>
    function openPayFineModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    }
</script>
@endsection


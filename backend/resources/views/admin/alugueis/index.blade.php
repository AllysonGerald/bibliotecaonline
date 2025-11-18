@extends('layouts.admin')

@section('title', 'Aluguéis')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Gerenciar Aluguéis</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Gerencie os aluguéis de livros</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Voltar ao Dashboard
            </a>
            <a href="{{ route('admin.alugueis.create') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                <i data-lucide="plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Novo Aluguel
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 32px;">
    <form method="GET" action="{{ route('admin.alugueis.index') }}" style="display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: end;">
        <div>
            <label for="search" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Buscar</label>
            <input
                type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                placeholder="Usuário, livro..."
                style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s;"
                onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
            >
        </div>
        <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3); transition: all 0.3s; white-space: nowrap;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';">
            <i data-lucide="search" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
            Filtrar
        </button>
    </form>
</div>

<!-- Tabela de Aluguéis -->
<div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); overflow-x: auto;">
    @if($rentals->count() > 0)
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #e9d5ff;">
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Usuário</th>
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Livro</th>
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Alugado em</th>
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Devolução</th>
                    <th style="padding: 16px; text-align: left; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                    <th style="padding: 16px; text-align: right; font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr style="border-bottom: 1px solid #f3e8ff; transition: all 0.3s;" onmouseover="this.style.background='#faf5ff';" onmouseout="this.style.background='transparent';">
                        <td style="padding: 16px;">
                            <div style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $rental->user->name }}</div>
                            <div style="font-size: 13px; color: #6b7280;">{{ $rental->user->email }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <div style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $rental->book->titulo }}</div>
                            <div style="font-size: 13px; color: #6b7280;">{{ $rental->book->author->nome }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <div style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $rental->alugado_em->format('d/m/Y H:i') }}</div>
                        </td>
                        <td style="padding: 16px;">
                            <div style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $rental->data_devolucao->format('d/m/Y') }}</div>
                            @if($rental->devolvido_em)
                                <div style="font-size: 12px; color: #10b981; margin-top: 4px; font-weight: 600;">Devolvido: {{ $rental->devolvido_em->format('d/m/Y H:i') }}</div>
                            @endif
                        </td>
                        <td style="padding: 16px;">
                            @php
                                $statusConfig = [
                                    'ativo' => ['bg' => 'linear-gradient(135deg, #dbeafe, #e0f2fe)', 'color' => '#0369a1', 'border' => '#93c5fd', 'text' => 'Ativo'],
                                    'devolvido' => ['bg' => 'linear-gradient(135deg, #d1fae5, #a7f3d0)', 'color' => '#065f46', 'border' => '#86efac', 'text' => 'Devolvido'],
                                    'atrasado' => ['bg' => 'linear-gradient(135deg, #fee2e2, #fef2f2)', 'color' => '#991b1b', 'border' => '#fca5a5', 'text' => 'Atrasado'],
                                ];
                                $status = $statusConfig[$rental->status->value] ?? $statusConfig['ativo'];
                            @endphp
                            <span style="display: inline-block; padding: 6px 12px; background: {{ $status['bg'] }}; color: {{ $status['color'] }}; border: 2px solid {{ $status['border'] }}; border-radius: 10px; font-size: 12px; font-weight: 700;">
                                {{ $status['text'] }}
                            </span>
                            @if($rental->taxa_atraso > 0)
                                <div style="font-size: 12px; color: #ef4444; margin-top: 6px; font-weight: 600;">Taxa: R$ {{ number_format($rental->taxa_atraso, 2, ',', '.') }}</div>
                            @endif
                        </td>
                        <td style="padding: 16px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                <a href="{{ route('admin.alugueis.show', $rental) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); color: #0369a1; border: 2px solid #bae6fd; border-radius: 10px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #0369a1, #0284c7)'; this.style.color='white'; this.style.borderColor='#0369a1'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='linear-gradient(135deg, #f0f9ff, #e0f2fe)'; this.style.color='#0369a1'; this.style.borderColor='#bae6fd'; this.style.transform='scale(1)';" title="Ver">
                                    <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                                </a>
                                <a href="{{ route('admin.alugueis.edit', $rental) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 10px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='scale(1)';" title="Editar">
                                    <i data-lucide="edit" style="width: 18px; height: 18px;"></i>
                                </a>
                                <form action="{{ route('admin.alugueis.destroy', $rental) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este aluguel?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5; border-radius: 10px; cursor: pointer; transition: all 0.3s; border: 2px solid #fca5a5;" onmouseover="this.style.background='linear-gradient(135deg, #ef4444, #dc2626)'; this.style.color='white'; this.style.borderColor='#ef4444'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='linear-gradient(135deg, #fee2e2, #fef2f2)'; this.style.color='#991b1b'; this.style.borderColor='#fca5a5'; this.style.transform='scale(1)';" title="Excluir">
                                        <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($rentals->hasPages())
            <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid #e9d5ff;">
                {{ $rentals->links() }}
            </div>
        @endif
    @else
        <div style="padding: 64px 32px; text-align: center;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                <i data-lucide="book-open" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
            </div>
            <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 12px;">Nenhum aluguel encontrado</h3>
            <p style="font-size: 16px; color: #6b7280; font-weight: 500; margin-bottom: 24px;">
                @if(request('search'))
                    Não há aluguéis que correspondam à sua busca.
                @else
                    Ainda não há aluguéis registrados no sistema.
                @endif
            </p>
            <a href="{{ route('admin.alugueis.create') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                <i data-lucide="plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Criar Primeiro Aluguel
            </a>
        </div>
    @endif
</div>
@endsection

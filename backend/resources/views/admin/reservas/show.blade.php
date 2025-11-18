@extends('layouts.admin')

@section('title', 'Detalhes da Reserva')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #374151; margin-bottom: 8px;">Detalhes da Reserva</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visualize as informações completas da reserva</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.reservas.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Voltar
            </a>
            <a href="{{ route('admin.reservas.edit', $reserva) }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #ec4899, #f472b6); color: white; border: 3px solid #ec4899; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(236, 72, 153, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(236, 72, 153, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(236, 72, 153, 0.3)';">
                <i data-lucide="edit" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Editar Reserva
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 1024px) { grid-template-columns: 2fr 1fr; }">
    <!-- Informações da Reserva -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(236, 72, 153, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h3 style="font-size: 22px; font-weight: 900; color: #374151; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(236, 72, 153, 0.3);">
                        <i data-lucide="calendar" style="width: 20px; height: 20px; color: white;"></i>
                    </div>
                    Informações da Reserva
                </h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Usuário</p>
                        <p style="font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 4px;">{{ $reserva->user->name }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $reserva->user->email }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Livro</p>
                        <p style="font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 4px;">{{ $reserva->book->titulo }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $reserva->book->author->nome }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Reservado em</p>
                        <p style="font-size: 16px; font-weight: 700; color: #374151;">{{ $reserva->reservado_em->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Expira em</p>
                        <p style="font-size: 16px; font-weight: 700; color: #374151;">{{ $reserva->expira_em->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Status</p>
                        @php
                            $statusConfig = [
                                'pendente' => ['bg' => 'linear-gradient(135deg, #fef3c7, #fde68a)', 'color' => '#92400e', 'border' => '#fcd34d', 'text' => 'Pendente'],
                                'confirmada' => ['bg' => 'linear-gradient(135deg, #d1fae5, #a7f3d0)', 'color' => '#065f46', 'border' => '#86efac', 'text' => 'Confirmada'],
                                'cancelada' => ['bg' => 'linear-gradient(135deg, #fee2e2, #fef2f2)', 'color' => '#991b1b', 'border' => '#fca5a5', 'text' => 'Cancelada'],
                                'expirada' => ['bg' => 'linear-gradient(135deg, #f3f4f6, #e5e7eb)', 'color' => '#374151', 'border' => '#d1d5db', 'text' => 'Expirada'],
                            ];
                            $status = $statusConfig[$reserva->status->value] ?? $statusConfig['pendente'];
                        @endphp
                        <span style="display: inline-block; padding: 6px 12px; background: {{ $status['bg'] }}; color: {{ $status['color'] }}; border: 2px solid {{ $status['border'] }}; border-radius: 10px; font-size: 12px; font-weight: 700;">
                            {{ $status['text'] }}
                        </span>
                    </div>
                </div>

                @if($reserva->isExpired())
                    <div style="margin-top: 24px; padding: 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border: 2px solid #fca5a5; border-radius: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i data-lucide="alert-triangle" style="width: 20px; height: 20px; color: #dc2626; flex-shrink: 0;"></i>
                            <div>
                                <p style="font-size: 14px; font-weight: 700; color: #991b1b; margin-bottom: 4px;">Reserva Expirada</p>
                                <p style="font-size: 13px; color: #dc2626;">Esta reserva expirou em {{ $reserva->expira_em->format('d/m/Y H:i') }}.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar com Informações Adicionais -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Informações do Livro -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(236, 72, 153, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h4 style="font-size: 18px; font-weight: 900; color: #374151; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="book-open" style="width: 20px; height: 20px; color: #ec4899;"></i>
                    Informações do Livro
                </h4>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Categoria</p>
                        <p style="font-size: 15px; font-weight: 600; color: #374151;">{{ $reserva->book->category->nome }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">ISBN</p>
                        <p style="font-size: 15px; font-weight: 600; color: #374151;">{{ $reserva->book->isbn ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Editora</p>
                        <p style="font-size: 15px; font-weight: 600; color: #374151;">{{ $reserva->book->editora ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Usuário -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(236, 72, 153, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h4 style="font-size: 18px; font-weight: 900; color: #374151; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="user" style="width: 20px; height: 20px; color: #ec4899;"></i>
                    Informações do Usuário
                </h4>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Telefone</p>
                        <p style="font-size: 15px; font-weight: 600; color: #374151;">{{ $reserva->user->telefone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Status da Conta</p>
                        <span style="display: inline-block; padding: 6px 12px; background: {{ $reserva->user->ativo ? 'linear-gradient(135deg, #d1fae5, #a7f3d0)' : 'linear-gradient(135deg, #fee2e2, #fef2f2)' }}; color: {{ $reserva->user->ativo ? '#065f46' : '#991b1b' }}; border: 2px solid {{ $reserva->user->ativo ? '#86efac' : '#fca5a5' }}; border-radius: 10px; font-size: 12px; font-weight: 700;">
                            {{ $reserva->user->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timestamps -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(236, 72, 153, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h4 style="font-size: 18px; font-weight: 900; color: #374151; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="clock" style="width: 20px; height: 20px; color: #ec4899;"></i>
                    Informações do Sistema
                </h4>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Criado em</p>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i data-lucide="calendar" style="width: 16px; height: 16px; color: #6b7280;"></i>
                            <p style="font-size: 15px; font-weight: 600; color: #374151;">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Atualizado em</p>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i data-lucide="clock" style="width: 16px; height: 16px; color: #6b7280;"></i>
                            <p style="font-size: 15px; font-weight: 600; color: #374151;">{{ $reserva->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

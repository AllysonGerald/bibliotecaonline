@extends('layouts.admin')

@section('title', 'Detalhes do Aluguel')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Detalhes do Aluguel</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visualize as informações completas do aluguel</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.alugueis.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Voltar
            </a>
            <a href="{{ route('admin.alugueis.edit', $aluguel) }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: 3px solid #8b5cf6; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';">
                <i data-lucide="edit" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Editar Aluguel
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 1024px) { grid-template-columns: 2fr 1fr; }">
    <!-- Informações do Aluguel -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(139, 92, 246, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="book" style="width: 20px; height: 20px; color: white;"></i>
                    </div>
                    Informações do Aluguel
                </h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Usuário</p>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $aluguel->user->name }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $aluguel->user->email }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Livro</p>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $aluguel->book->titulo }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $aluguel->book->author?->nome ?? 'Autor desconhecido' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Alugado em</p>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937;">{{ $aluguel->alugado_em->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Data de Devolução</p>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937;">{{ $aluguel->data_devolucao->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($aluguel->devolvido_em)
                        <div>
                            <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Devolvido em</p>
                            <p style="font-size: 16px; font-weight: 700; color: #10b981;">{{ $aluguel->devolvido_em->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Status</p>
                        @php
                            $statusConfig = [
                                'ativo' => ['bg' => 'linear-gradient(135deg, #dbeafe, #e0f2fe)', 'color' => '#0369a1', 'border' => '#93c5fd', 'text' => 'Ativo'],
                                'devolvido' => ['bg' => 'linear-gradient(135deg, #d1fae5, #a7f3d0)', 'color' => '#065f46', 'border' => '#86efac', 'text' => 'Devolvido'],
                                'atrasado' => ['bg' => 'linear-gradient(135deg, #fee2e2, #fef2f2)', 'color' => '#991b1b', 'border' => '#fca5a5', 'text' => 'Atrasado'],
                            ];
                            $status = $statusConfig[$aluguel->status->value] ?? $statusConfig['ativo'];
                        @endphp
                        <span style="display: inline-block; padding: 6px 12px; background: {{ $status['bg'] }}; color: {{ $status['color'] }}; border: 2px solid {{ $status['border'] }}; border-radius: 10px; font-size: 12px; font-weight: 700;">
                            {{ $status['text'] }}
                        </span>
                    </div>
                    @if($aluguel->taxa_atraso > 0)
                        <div>
                            <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Taxa de Atraso</p>
                            <p style="font-size: 18px; font-weight: 900; color: #ef4444;">R$ {{ number_format($aluguel->taxa_atraso, 2, ',', '.') }}</p>
                        </div>
                    @endif
                </div>

                @if($aluguel->isOverdue())
                    <div style="margin-top: 24px; padding: 20px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border: 2px solid #fca5a5; border-radius: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ef4444, #f87171); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i data-lucide="alert-triangle" style="width: 20px; height: 20px; color: white;"></i>
                            </div>
                            <div>
                                <p style="font-size: 16px; font-weight: 900; color: #991b1b; margin-bottom: 4px;">Aluguel Atrasado</p>
                                <p style="font-size: 14px; color: #dc2626; font-weight: 600;">Este aluguel está {{ $aluguel->daysOverdue() }} dia(s) atrasado.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($aluguel->fine)
                    <div style="margin-top: 24px; padding: 20px; background: linear-gradient(135deg, #fef3c7, #fef9c3); border: 2px solid #fcd34d; border-radius: 12px;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b, #fbbf24); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i data-lucide="alert-circle" style="width: 20px; height: 20px; color: white;"></i>
                                </div>
                                <div>
                                    <p style="font-size: 16px; font-weight: 900; color: #92400e; margin-bottom: 4px;">Multa Associada</p>
                                    <p style="font-size: 14px; color: #b45309; font-weight: 600;">Valor: R$ {{ number_format($aluguel->fine->valor, 2, ',', '.') }}</p>
                                    <p style="font-size: 14px; color: #b45309; font-weight: 600;">Status: {{ $aluguel->fine->paga ? 'Paga' : 'Pendente' }}</p>
                                </div>
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
                <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #ec4899, #f97316); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="book-open" style="width: 16px; height: 16px; color: white;"></i>
                    </div>
                    Informações do Livro
                </h4>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Categoria</p>
                        <p style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $aluguel->book->category->nome }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">ISBN</p>
                        <p style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $aluguel->book->isbn ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Editora</p>
                        <p style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $aluguel->book->editora ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Usuário -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e0f2fe; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(14, 165, 233, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="user" style="width: 16px; height: 16px; color: white;"></i>
                    </div>
                    Informações do Usuário
                </h4>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Telefone</p>
                        <p style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $aluguel->user->telefone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Status da Conta</p>
                        @if($aluguel->user->ativo)
                            <span style="display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 2px solid #86efac;">
                                Ativo
                            </span>
                        @else
                            <span style="display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5;">
                                Inativo
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Sistema -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fed7aa; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(249, 115, 22, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="clock" style="width: 16px; height: 16px; color: white;"></i>
                    </div>
                    Informações do Sistema
                </h4>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Criado em</p>
                        <p style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $aluguel->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Atualizado em</p>
                        <p style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $aluguel->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.admin')

@section('title', 'Detalhes do Usuário')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Detalhes do Usuário</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visualize todas as informações do usuário</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.usuarios.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Voltar
            </a>
            <a href="{{ route('admin.usuarios.edit', $usuario) }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: 3px solid #8b5cf6; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';">
                <i data-lucide="edit" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Editar
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Informações do Usuário -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(139, 92, 246, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
        <div style="position: relative; z-index: 1;">
            <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="user" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                Informações do Usuário
            </h3>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Nome Completo</label>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937;">{{ $usuario->name }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">E-mail</label>
                        <p style="font-size: 16px; color: #4b5563;">{{ $usuario->email }}</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Papel</label>
                        @php
                            $roleStyles = [
                                'admin' => 'background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff;',
                                'usuario' => 'background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd;',
                            ];
                            $roleStyle = $roleStyles[$usuario->papel->value] ?? 'background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #6b7280; border: 2px solid #e5e7eb;';
                        @endphp
                        <span style="display: inline-block; padding: 8px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; {{ $roleStyle }}">
                            {{ $usuario->papel->label() }}
                        </span>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                        @if($usuario->ativo)
                            <span style="display: inline-block; padding: 8px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 2px solid #86efac;">
                                Ativo
                            </span>
                        @else
                            <span style="display: inline-block; padding: 8px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5;">
                                Inativo
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Telefone</label>
                    <p style="font-size: 16px; color: #4b5563;">{{ $usuario->telefone ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(236, 72, 153, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
        <div style="position: relative; z-index: 1;">
            <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f97316); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="bar-chart" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                Estatísticas
            </h3>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                    <div style="font-size: 32px; font-weight: 900; color: #8b5cf6; margin-bottom: 8px;">{{ $usuario->rentals->count() }}</div>
                    <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Aluguéis</div>
                </div>
                <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 12px; border: 2px solid #fbcfe8;">
                    <div style="font-size: 32px; font-weight: 900; color: #ec4899; margin-bottom: 8px;">{{ $usuario->reservations->count() }}</div>
                    <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Reservas</div>
                </div>
                <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #fff1f2, #fff7ed); border-radius: 12px; border: 2px solid #fed7aa;">
                    <div style="font-size: 32px; font-weight: 900; color: #f97316; margin-bottom: 8px;">{{ $usuario->reviews->count() }}</div>
                    <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Avaliações</div>
                </div>
                <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); border-radius: 12px; border: 2px solid #bae6fd;">
                    <div style="font-size: 32px; font-weight: 900; color: #0ea5e9; margin-bottom: 8px;">{{ $usuario->wishlists->count() }}</div>
                    <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Lista Desejos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informações Adicionais -->
<div style="margin-top: 24px; background: white; border-radius: 20px; padding: 32px; border: 3px solid #bae6fd; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(14, 165, 233, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="info" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            Informações Adicionais
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">E-mail Verificado</label>
                @if($usuario->email_verified_at)
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="check-circle" style="width: 16px; height: 16px; color: #166534;"></i>
                        <span style="font-size: 14px; color: #166534; font-weight: 600;">Sim - {{ $usuario->email_verified_at->format('d/m/Y H:i') }}</span>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="x-circle" style="width: 16px; height: 16px; color: #991b1b;"></i>
                        <span style="font-size: 14px; color: #991b1b; font-weight: 600;">Não</span>
                    </div>
                @endif
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Cadastrado em</label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="calendar" style="width: 16px; height: 16px; color: #6b7280;"></i>
                    <span style="font-size: 14px; color: #6b7280; font-weight: 600;">{{ $usuario->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Última atualização</label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="clock" style="width: 16px; height: 16px; color: #6b7280;"></i>
                    <span style="font-size: 14px; color: #6b7280; font-weight: 600;">{{ $usuario->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        @if($usuario->fines->where('paga', false)->count() > 0)
            <div style="margin-top: 32px; padding-top: 32px; border-top: 3px solid #e9d5ff;">
                <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #ef4444, #f87171); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="alert-circle" style="width: 18px; height: 18px; color: white;"></i>
                    </div>
                    Multas Pendentes
                </h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($usuario->fines->where('paga', false) as $fine)
                        <div style="padding: 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border: 2px solid #fca5a5; border-radius: 12px;">
                            <p style="font-size: 18px; font-weight: 900; color: #991b1b; margin-bottom: 4px;">R$ {{ number_format($fine->valor, 2, ',', '.') }}</p>
                            <p style="font-size: 13px; color: #dc2626; font-weight: 600;">Aluguel #{{ $fine->aluguel_id }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

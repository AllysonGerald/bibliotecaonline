@if ($paginator->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-top: 24px; padding-top: 24px; border-top: 2px solid #e5e7eb;">
        <!-- Informação de resultados -->
        <div style="color: #6b7280; font-size: 14px; font-weight: 500;">
            @if ($paginator->firstItem())
                Mostrando {{ $paginator->firstItem() }} até {{ $paginator->lastItem() }} de {{ $paginator->total() }} resultados
            @else
                Nenhum resultado encontrado
            @endif
        </div>

        <!-- Controles de paginação -->
        <nav style="display: flex; align-items: center; gap: 8px;">
            <!-- Botão Anterior -->
            @if ($paginator->onFirstPage())
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #9ca3af; border: 2px solid #e5e7eb; border-radius: 10px; cursor: not-allowed; transition: all 0.3s;">
                    <i data-lucide="chevron-left" style="width: 20px; height: 20px;"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 10px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.2)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(139, 92, 246, 0.1)';">
                    <i data-lucide="chevron-left" style="width: 20px; height: 20px;"></i>
                </a>
            @endif

            <!-- Números de página -->
            <div style="display: flex; align-items: center; gap: 4px;">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; color: #6b7280; font-size: 14px; font-weight: 500;">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; background: linear-gradient(135deg, #8b5cf6, #a855f7); color: white; border: 2px solid #8b5cf6; border-radius: 10px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.2)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(139, 92, 246, 0.1)';">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            <!-- Botão Próximo -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 10px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(139, 92, 246, 0.2)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(139, 92, 246, 0.1)';">
                    <i data-lucide="chevron-right" style="width: 20px; height: 20px;"></i>
                </a>
            @else
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #9ca3af; border: 2px solid #e5e7eb; border-radius: 10px; cursor: not-allowed; transition: all 0.3s;">
                    <i data-lucide="chevron-right" style="width: 20px; height: 20px;"></i>
                </span>
            @endif
        </nav>
    </div>
@endif


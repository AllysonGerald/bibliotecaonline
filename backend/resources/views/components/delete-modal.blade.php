@props(['id', 'title', 'message', 'action', 'itemName'])

<div id="{{ $id }}" class="modal-backdrop" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); z-index: 1000;" x-data="{ open: false }" x-show="open" x-cloak @keydown.escape.window="open = false; document.getElementById('{{ $id }}').style.display = 'none';">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 20px; padding: 32px; max-width: 500px; width: 90%; border: 3px solid #fee2e2; box-shadow: 0 20px 60px rgba(239, 68, 68, 0.3); position: relative; overflow: hidden;" @click.stop>
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(239, 68, 68, 0.1); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
        <div style="position: relative; z-index: 1;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; border: 3px solid #fca5a5;">
                <i data-lucide="alert-triangle" style="width: 40px; height: 40px; color: #ef4444;"></i>
            </div>
            
            <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; text-align: center; margin-bottom: 12px;">{{ $title }}</h3>
            <p style="font-size: 16px; color: #6b7280; text-align: center; margin-bottom: 32px; line-height: 1.6;">{{ $message }}</p>
            
            @if(isset($itemName))
                <div style="padding: 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border: 2px solid #fca5a5; border-radius: 12px; margin-bottom: 32px;">
                    <p style="font-size: 18px; font-weight: 900; color: #991b1b; text-align: center;">{{ $itemName }}</p>
                </div>
            @endif
            
            <form method="POST" action="{{ $action }}" style="display: flex; gap: 12px; justify-content: center;">
                @csrf
                @method('DELETE')
                <button type="button" @click="open = false; document.getElementById('{{ $id }}').style.display = 'none';" style="padding: 12px 24px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                    Cancelar
                </button>
                <button type="submit" style="padding: 12px 24px; background: linear-gradient(135deg, #ef4444, #f87171); color: white; border: 3px solid #ef4444; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(239, 68, 68, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(239, 68, 68, 0.3)';">
                    <i data-lucide="trash-2" style="width: 18px; height: 18px; margin-right: 8px; display: inline-block; vertical-align: middle;"></i>
                    Confirmar Exclusão
                </button>
            </form>
        </div>
    </div>
</div>


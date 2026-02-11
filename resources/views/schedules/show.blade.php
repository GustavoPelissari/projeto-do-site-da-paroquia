<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $schedule->title }}
            </h2>
            <div class="d-flex gap-2">
                @if(auth()->user()->canManageSchedules())
                    <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                       class="bg-yellow-600 text-white px-4 py-2 rounded hover\:bg-yellow-700">
                        Editar
                    </a>
                @endif
                <a href="{{ route('admin.schedules.download', $schedule) }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded hover\:bg-green-700">
                    Baixar PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm\:px-6 lg\:px-8">
            <!-- Informações da Escala -->
            <div class="bg-white overflow-hidden shadow-sm sm\:rounded-lg mb-6">
                <div class="p-6 bg-white border-bottom border-gray-200">
                    <div class="row g-3 mb-6">
                        <div class="col-md-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Gerais</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Grupo:</span>
                                    <p class="text-gray-900">{{ $schedule->group->name }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Período:</span>
                                    <p class="text-gray-900">
                                        {{ $schedule->start_date->format('d/m/Y') }} até {{ $schedule->end_date->format('d/m/Y') }}
                                    </p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Status:</span>
                                    @php $status = $schedule->getStatusBadge() @endphp
                                    <span class="d-inline-block px-2 py-1 text-xs rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                        {{ $status['text'] }}
                                    </span>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Criada por:</span>
                                    <p class="text-gray-900">{{ $schedule->user->name }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Criada em:</span>
                                    <p class="text-gray-900">{{ $schedule->created_at->format('d/m/Y \à\s H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Arquivo PDF</h3>
                            
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $schedule->pdf_filename }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $schedule->getPdfSize() }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.schedules.download', $schedule) }}" 
                                       class="flex-1 bg-blue-600 text-white text-center px-3 py-2 rounded text-sm hover\:bg-blue-700">
                                        Baixar
                                    </a>
                                    <button onclick="openPdfViewer()" 
                                            class="flex-1 bg-gray-600 text-white px-3 py-2 rounded text-sm hover\:bg-gray-700">
                                        Visualizar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded p-3">
                                <p class="text-sm text-yellow-800">
                                    <span class="font-medium">📄 Arquivo oficial:</span> 
                                    Este é o documento oficial da escala. Sempre consulte o PDF para informações atualizadas.
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($schedule->description)
                        <div class="border-top pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Descrição</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $schedule->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Membros do Grupo -->
            <div class="bg-white overflow-hidden shadow-sm sm\:rounded-lg">
                <div class="p-6 bg-white border-bottom border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Membros do Grupo ({{ $schedule->group->getMembersCount() }})
                    </h3>
                    
                    @if($schedule->group->members->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($schedule->group->members as $member)
                                <div class="col">
                                    <div class="d-flex align-items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-600 rounded-circle d-flex align-items-center justify-center">
                                                <span class="text-white text-sm font-medium">
                                                    {{ substr($member->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $member->name }}
                                            </p>
                                            @if($member->isVerified())
                                                <span class="text-xs text-green-600">✓ Verificado</span>
                                            @else
                                                <span class="text-xs text-gray-500">Não verificado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-4xl mb-2">👥</div>
                            <p class="text-gray-600">Nenhum membro cadastrado no grupo ainda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para visualizar PDF -->
    <div id="pdfModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden d-flex align-items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-4xl w-full h-5\/6 mx-4 d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                <h3 class="text-lg font-medium">{{ $schedule->title }}</h3>
                <button onclick="closePdfViewer()" class="text-gray-400 hover-text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 p-4">
                <iframe id="pdfFrame" class="w-full h-full border-0"></iframe>
            </div>
        </div>
    </div>

    <script>
        function openPdfViewer() {
            const modal = document.getElementById('pdfModal');
            const frame = document.getElementById('pdfFrame');
            frame.src = '{{ $schedule->getPdfUrl() }}';
            modal.classList.remove('hidden');
            modal.classList.add('d-flex');
        }

        function closePdfViewer() {
            const modal = document.getElementById('pdfModal');
            const frame = document.getElementById('pdfFrame');
            frame.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('d-flex');
        }

        // Fechar modal com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePdfViewer();
            }
        });
    </script>
</x-app-layout>
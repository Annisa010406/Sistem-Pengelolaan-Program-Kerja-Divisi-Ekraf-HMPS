@component('layouts.app')
    {{-- Mengubah background utama halaman menjadi pink pudar agar card tabel menonjol --}}
    <div class="p-6 bg-pink-50/50 min-h-screen">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-pink-900">Dashboard</h1>
            <p class="text-sm text-pink-600">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Stats Cards (Tema Pink Ringan) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Card 1: Divisions -->
            <div class="bg-white p-6 rounded-xl border border-pink-100 shadow-sm transition hover:shadow-md hover:border-pink-200">
                <div class="text-sm font-semibold text-pink-400 uppercase tracking-wider">Total Divisi</div>
                <div class="mt-2 text-3xl font-extrabold text-pink-600">{{ $total_divisi }}</div>
            </div>

            <!-- Card 2: Programs -->
            <div class="bg-white p-6 rounded-xl border border-pink-100 shadow-sm transition hover:shadow-md hover:border-pink-200">
                <div class="text-sm font-semibold text-pink-400 uppercase tracking-wider">Program Kerja</div>
                <div class="mt-2 text-3xl font-extrabold text-pink-600">{{ $total_program }}</div>
            </div>

            <!-- Card 3: Agendas -->
            <div class="bg-white p-6 rounded-xl border border-pink-100 shadow-sm transition hover:shadow-md hover:border-pink-200">
                <div class="text-sm font-semibold text-pink-400 uppercase tracking-wider">Agenda Mendatang</div>
                <div class="mt-2 text-3xl font-extrabold text-pink-600">{{ $total_agenda }}</div>
            </div>

            <!-- Card 4: Documentations -->
            <div class="bg-white p-6 rounded-xl border border-pink-100 shadow-sm transition hover:shadow-md hover:border-pink-200">
                <div class="text-sm font-semibold text-pink-400 uppercase tracking-wider">Dokumentasi</div>
                <div class="mt-2 text-3xl font-extrabold text-pink-600">{{ $total_dokumentasi }}</div>
            </div>
        </div>

        <!-- AREA TABEL (Fokus Warna Pink) -->
        {{-- Card Container Tabel dengan border pink lembut --}}
        <div class="bg-white rounded-2xl border border-pink-200 p-6 min-h-[400px] shadow-sm">
            <h2 class="text-lg font-bold text-pink-900 mb-5 flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-pink-500 rounded-full inline-block"></span>
                Aktivitas Terbaru Program Kerja
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse table-auto">
                    <thead>
                        {{-- Header tabel dengan teks pink tua --}}
                        <tr class="border-b-2 border-pink-100 text-pink-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="pb-4 px-1">Nama Program Kerja</th>
                            <th class="pb-4 px-1">Divisi Pelaksana</th>
                            <th class="pb-4 px-1 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-pink-50">
                        @forelse($recent_programs as $program)
                            {{-- Row tabel dengan efek hover pink sangat pudar --}}
                            <tr class="border-b border-pink-50/50 hover:bg-pink-50/30 transition-colors">
                                <td class="py-4 px-1 font-medium text-pink-950">{{ $program->name }}</td>
                                {{-- Warna teks divisi disesuaikan menjadi pink --}}
                                <td class="py-4 px-1 text-pink-700">{{ $program->division_name ?? 'Ekraf' }}</td>
                                <td class="py-4 px-1 text-center">
                                    @if($program->status == 'Selesai')
                                        {{-- Badge Status PINK --}}
                                        <span class="px-3 py-1.5 bg-pink-100 text-pink-700 rounded-full text-xs font-bold shadow-inner">
                                            Selesai
                                        </span>
                                    @else
                                        {{-- Badge Status AMBER (tetap untuk kontras, tapi border pink) --}}
                                        <span class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-full text-xs font-bold border border-amber-100">
                                            Berjalan
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            {{-- Tampilan saat data kosong dengan nuansa pink --}}
                            <tr>
                                <td colspan="3" class="py-12 text-center text-pink-300 italic bg-pink-50/20 rounded-xl">
                                    <svg class="w-10 h-10 mx-auto mb-3 text-pink-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 00-2 2H6a2 2 0 00-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    Belum ada aktivitas program kerja terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endcomponent

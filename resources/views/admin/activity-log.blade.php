@extends('layouts.admin')

@section('title', 'Activity Log')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
        <h3 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
            <i class="fas fa-history text-blue-500"></i> Riwayat Aktivitas Sistem
        </h3>
        <span class="text-sm font-semibold text-slate-500 bg-slate-100 px-4 py-1.5 rounded-full shadow-sm">50 Aktivitas Terakhir</span>
    </div>

    @if($activityLogs->isEmpty())
        <div class="text-center py-16 text-slate-500">
            <i class="fas fa-inbox text-5xl mb-4 text-slate-300"></i>
            <p class="text-lg">Belum ada aktivitas terekam di sistem.</p>
        </div>
    @else
        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
            
            @foreach($activityLogs as $log)
            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                
                <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white {{ $log->bg }} {{ $log->color }} shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-sm relative z-10">
                    <i class="fas {{ $log->icon }}"></i>
                </div>
                
                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-5 rounded-2xl bg-slate-50 border border-slate-100 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-2 border-b border-slate-200/60 pb-2">
                        <time class="text-xs font-bold text-slate-500"><i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($log->waktu)->isoFormat('D MMMM Y, HH:mm') }}</time>
                        <span class="text-[10px] uppercase font-bold text-slate-400 bg-white px-2 py-0.5 rounded border border-slate-100 shadow-sm">{{ \Carbon\Carbon::parse($log->waktu)->diffForHumans() }}</span>
                    </div>
                    <div class="text-slate-700 text-sm leading-relaxed mt-2">
                        {!! $log->pesan !!}
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    @endif
</div>
@endsection
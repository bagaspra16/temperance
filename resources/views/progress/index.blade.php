@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Progress History</h1>
        <p class="text-gray-500">A complete log of all your achievements.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($progress->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Related Item</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Change Description</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($progress as $record)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $record->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $record->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($record->progressable)
                                        <a href="{{ $record->progressable->path() }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300">
                                            @if($record->progressable_type === 'App\Models\Goal')
                                                <i class="fas fa-bullseye mr-2 text-gray-400"></i>
                                            @else
                                                <i class="fas fa-check-circle mr-2 text-gray-400"></i>
                                            @endif
                                            {{ $record->progressable->title }}
                                        </a>
                                        <span class="block ml-6 text-xs text-gray-500">{{ class_basename($record->progressable_type) }}</span>
                                    @else
                                        <span class="text-sm text-gray-500 italic">Item not found</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    @if($record->percentage !== null)
                                        <i class="fas fa-chart-line mr-2 text-green-500"></i> Progress set to <span class="font-bold">{{ $record->percentage }}%</span>
                                    @else
                                        <i class="fas fa-tag mr-2 text-purple-500"></i> Status changed
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $record->note }}">
                                    {{ $record->note ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('progress.show', $record->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Details <i class="fas fa-arrow-right ml-1"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-50 border-t">
                {{ $progress->links() }}
            </div>
        @else
            <div class="text-center p-16">
                <i class="fas fa-history text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">No Progress History</h2>
                <p class="text-gray-500">Updates to your goals and tasks will be recorded here automatically.</p>
            </div>
        @endif
    </div>
</div>
@endsection
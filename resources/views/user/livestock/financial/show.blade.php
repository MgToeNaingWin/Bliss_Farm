{{-- resources/views/user/livestock/financial/show.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">ငွေပေးချေမှုအသေးစိတ်</h2>
                <div>
                    <a href="{{ route('user.financial.edit', $record) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fa-solid fa-edit mr-2"></i> ပြင်ဆင်ရန်
                    </a>
                    <a href="{{ route('user.financial.records') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        <i class="fa-solid fa-arrow-left mr-2"></i> ပြန်သွားရန်
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">အမျိုးအစား</label>
                        <p class="text-lg font-semibold">
                            <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full
                                {{ $record->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $record->type == 'income' ? 'ဝင်ငွေ' : 'ထွက်ငွေ' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">ပမာဏ</label>
                        <p class="text-2xl font-bold {{ $record->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($record->amount, 2) }} MMK
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">အမျိုးအစားခွဲ</label>
                        <p class="text-lg text-gray-900">{{ $record->category }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">နေ့စွဲ</label>
                        <p class="text-lg text-gray-900">{{ $record->transaction_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">ဖော်ပြချက်</label>
                        <p class="text-lg text-gray-900">{{ $record->description }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">အခြေအနေ</label>
                        <p>
                            <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full
                                {{ $record->status == 'completed' ? 'bg-green-100 text-green-800' :
                                   ($record->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $record->status == 'completed' ? 'ပြီးစီး' :
                                   ($record->status == 'pending' ? 'ဆောင်ရွက်ဆဲ' : 'ပယ်ဖျက်') }}
                            </span>
                        </p>
                    </div>
                    @if($record->payment_method)
                    <div>
                        <label class="text-sm font-medium text-gray-500">ငွေပေးချေမှုနည်းလမ်း</label>
                        <p class="text-lg text-gray-900">{{ $record->payment_method }}</p>
                    </div>
                    @endif
                    @if($record->reference_number)
                    <div>
                        <label class="text-sm font-medium text-gray-500">ကိုးကားနံပါတ်</label>
                        <p class="text-lg text-gray-900">{{ $record->reference_number }}</p>
                    </div>
                    @endif
                    @if($record->livestock)
                    <div>
                        <label class="text-sm font-medium text-gray-500">တိရစ္ဆာန်</label>
                        <p class="text-lg text-gray-900">
                            <a href="{{ route('user.livestock.show', $record->livestock) }}" class="text-blue-600 hover:underline">
                                {{ $record->livestock->name ?? $record->livestock->tag_number }}
                            </a>
                        </p>
                    </div>
                    @endif
                    @if($record->notes)
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">မှတ်ချက်</label>
                        <p class="text-lg text-gray-900">{{ $record->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/filament/widgets/calendar-widget.blade.php --}}

<x-filament-widgets::widget class="fi-widget-calendar" column-span="full">
    <x-filament::section>
        @php
            ['months'=>$months,'data'=>$data,'rowSums'=>$rowSums] = $demoData;
            $badgeColors=['О'=>'success','П'=>'warning','Р'=>'danger','В'=>'gray'];
            $badgeLabels=['О'=>'Оплата','П'=>'Простій','Р'=>'Ремонт','В'=>'Вихідний'];
        @endphp

        @foreach($months as $mi=>$month)
            <div class="mb-8">
                <div class="font-semibold text-base mb-2 text-gray-900 dark:text-gray-100">
                    {{ $month['name'] }} {{ $month['year'] }}
                </div>
                <div class="overflow-x-auto">
                    <table style="margin-bottom: 25px;" class="min-w-full border rounded-lg bg-white dark:bg-gray-900 shadow text-xs text-center">
                        <thead>
                            <tr>
                                <th class="px-2 py-1 bg-gray-100 dark:bg-gray-800 border sticky left-0 z-10">Авто</th>
                                @foreach($month['days'] as $day)
                                    <th class="px-1 py-1 bg-gray-100 dark:bg-gray-800 border">{{ $day }}</th>
                                @endforeach
                                <th class="px-2 py-1 bg-blue-50 border sticky right-0 z-10">Σ по авто</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicles as $v)
                                @php
                                    $id=$v->id;
                                    $photo = $v->getFirstMediaUrl('photos','thumb') ?: asset('images/no-car.png');
                                    $brand = config('car_brands')[$v->brand_id] ?? '-';
                                    $model = config('car_models')[$v->brand_id][$v->model_id] ?? '-';
                                @endphp
                                <tr>
                                    <td class="font-medium border px-2 py-1 sticky left-0 bg-white dark:bg-gray-900 z-10 text-left" style="min-width:200px;">
                                        <div class="flex items-center">
                                            <img src="{{ $photo }}" alt="{{ $v->registration_number }}" class="w-8 h-8 rounded-full object-cover" style="margin-top: 5px;margin-right: 5px">
                                            <div class="ml-2 text-left">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100" style="font-size: 13px;font-weight: 500;line-height: ;">{{ $brand }} {{ $model }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400" style="font-weight: 300;font-size: 11px;line-height: 10px;">{{ $v->registration_number }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    @foreach($month['days'] as $day)
                                        @php $status = $data[$id][$mi][$day]; $color = $badgeColors[$status]; $label = $badgeLabels[$status]; @endphp
                                        <td class="border px-1 py-1">
                                            <x-filament::badge :color="$color" size="sm" :tooltip="$label">
                                                {{ $status }}
                                            </x-filament::badge>
                                        </td>
                                    @endforeach

                                    <td class="border px-1 py-1 bg-blue-50 sticky right-0 z-10">
                                        @foreach($badgeColors as $abbr=>$color)
                                            <x-filament::badge :color="$color" size="sm" :tooltip="$abbr">
                                                {{ $abbr }}: {{ $rowSums[$id][$mi][$abbr] ?? 0 }}
                                            </x-filament::badge>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
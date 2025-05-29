<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Carbon\Carbon;

class Calendar extends Page
{
	
	protected static bool $shouldRegisterNavigation = false;
	
	protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
	protected static ?string $navigationLabel = 'Календар';
	protected static ?string $navigationGroup = 'Демо';
	protected static ?string $title = 'Календар';
	protected static ?string $slug = 'calendar';
	protected static string $view = 'filament.pages.calendar';
	protected static ?int $navigationSort = 100;

	/**
	 * Демо-данные по месяцам.
	 */
	public static function getDemoData(): array
	{
		$badgeKeys = ['О', 'П', 'Р', 'В'];

		// Динамически задаём месяцы и диапазон дней (менять только здесь!)
		$months = [
			['name' => 'Січень', 'month' => 1,  'year' => 2025, 'days' => 31],
			['name' => 'Лютий',  'month' => 2,  'year' => 2025, 'days' => 28],
			['name' => 'Березень','month' => 3, 'year' => 2025, 'days' => 31],
			['name' => 'Квітень', 'month' => 4, 'year' => 2025, 'days' => 30],
			['name' => 'Травень', 'month' => 5, 'year' => 2025, 'days' => 27],
		];

		$machines = [
			'Leaf - AH1547OH (серій на донецких)',
			'Leaf - AX0428ZA (Лиф 0428)',
			'Sonata - KA0788IB (Соната 0788)',
			'Sonata - KA8225HT (Соната оранжевая)',
			'Leaf - AX0431YA (Лиф японец)',
			'Sonata hybrid КА 2318 ІР',
		];

		// Сборка всех дней по месяцам
		$monthsData = [];
		foreach ($months as $month) {
			$days = range(1, $month['days']);
			$monthsData[] = array_merge($month, ['days' => $days]);
		}

		// Генерация статусов для каждой машины и дня каждого месяца
		$data = [];
		$rowSums = []; // по строкам (машинам)
		$colSums = []; // по каждому дню месяца (для футера)

		foreach ($machines as $machine) {
			$rowSums[$machine] = [];
			foreach ($monthsData as $mi => $month) {
				foreach ($month['days'] as $day) {
					$status = $badgeKeys[array_rand($badgeKeys)];
					$data[$machine][$mi][$day] = $status;
					// rowSums — по машине, месяцу, статусу
					$rowSums[$machine][$mi][$status] = ($rowSums[$machine][$mi][$status] ?? 0) + 1;
					// colSums — по месяцу, дню, статусу
					$colSums[$mi][$day][$status] = ($colSums[$mi][$day][$status] ?? 0) + 1;
				}
			}
		}

		return [
			'months'   => $monthsData,
			'machines' => $machines,
			'data'     => $data,
			'rowSums'  => $rowSums,
			'colSums'  => $colSums,
		];
	}
}

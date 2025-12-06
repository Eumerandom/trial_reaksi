<?php

namespace Tests\Feature\Filament;

use App\Filament\Imports\CompanyImporter;
use App\Filament\Resources\CompanyResource\Pages\ListCompanies;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CompanyImporterTest extends TestCase
{
    use RefreshDatabase;

    public function test_importer_columns_are_defined(): void
    {
        $columns = CompanyImporter::getColumns();

        $this->assertCount(2, $columns);

        $columnNames = collect($columns)->map(fn ($col) => $col->getName())->toArray();
        $this->assertContains('symbol', $columnNames);
        $this->assertContains('name', $columnNames);
    }

    public function test_importer_resolves_new_record_correctly(): void
    {
        $importer = new CompanyImporter;

        $reflection = new \ReflectionClass($importer);
        $property = $reflection->getProperty('data');
        $property->setAccessible(true);
        $property->setValue($importer, [
            'symbol' => 'AALI',
            'name' => 'Astra Agro Lestari Tbk.',
        ]);

        $record = $importer->resolveRecord();

        $this->assertInstanceOf(Company::class, $record);
        $this->assertEquals('AALI', $record->symbol);
        $this->assertFalse($record->exists);
    }

    public function test_importer_resolves_existing_record_by_symbol(): void
    {
        $existing = Company::factory()->create([
            'symbol' => 'BBCA',
            'name' => 'Bank Central Asia Tbk.',
        ]);

        $importer = new CompanyImporter;

        $reflection = new \ReflectionClass($importer);
        $property = $reflection->getProperty('data');
        $property->setAccessible(true);
        $property->setValue($importer, [
            'symbol' => 'BBCA',
            'name' => 'Bank Central Asia Tbk. Updated',
        ]);

        $record = $importer->resolveRecord();

        $this->assertTrue($record->exists);
        $this->assertEquals($existing->id, $record->id);
    }

    public function test_list_companies_page_has_import_action(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('ViewAny:Company');

        Livewire::actingAs($user)
            ->test(ListCompanies::class)
            ->assertActionExists('import');
    }
}

<?php

namespace Tests\Feature;

use App\Models\DocsisUpdate;
use Tests\TestCase;
use App\Traits\JsonTrait;

class SearchTest extends TestCase
{
    use JsonTrait;

    public function test_it_should_return_404_if_vendor_not_found() {

        $this->withoutExceptionHandling();

        $response = $this->get('api/modems?vendor=ciscos');

        $response->assertStatus(404)->assertExactJson([
            'message' => 'Fabricante no encontrado.'
        ]);
    }

    public function test_it_should_return_the_models_that_are_not_in_the_json_file() {

        $file =  $this->readFile();

        $models = collect($file->models)->filter(
                        fn($model) => strtolower($model->vendor) == 'cisco'
                    )
                    ->map(fn($model) => $model->name);

        $expected = DocsisUpdate::where('vsi_vendor','like', '%cisco%')
                    ->whereNotIn('vsi_model', $models)->get()->count();

        $response = $this->get('api/modems?vendor=cisco');

        $response->assertStatus(200)->assertJsonCount($expected, 'data');
    }
}


<?php

namespace Tests\Unit;

use App\Entities\Model;
use Tests\TestCase;
use App\Models\ModelsJson;
use App\Traits\JsonTrait;

class ModelsJsonTest extends TestCase
{
    use JsonTrait;

    private ModelsJson $modelJson;
    private string $filePath;

    public function setUp(): void {

        parent::setUp();

        $this->modelJson = new ModelsJson();

        $this->filePath = base_path() . '/models.json';
    }

    public function test_it_should_return_an_array_of_models() {

        $file = $this->readFile();

        $expected = [];

        foreach ($file->models as $model) {
            $expected[] = new Model($model->vendor, $model->name, $model->soft);
        }

        $actual = $this->modelJson->get();

        $this->assertEquals($expected, $actual);
    }

    public function test_it_should_save_a_new_model() {

        $new_model = new Model('Company', 'ABCD1234', 'v1');

        $this->modelJson->save($new_model);

        $expected = $new_model;
        $actual = collect($this->readFile()->models)->last();

        $this->assertEquals(json_encode($expected), json_encode($actual));
        
        $this->rollback();

    }
}

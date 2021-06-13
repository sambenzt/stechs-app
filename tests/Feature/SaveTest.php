<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Traits\JsonTrait;

class SaveTest extends TestCase
{
    use JsonTrait;

    public function test_it_should_save_a_model_in_json_file()
    {
        $this->withoutExceptionHandling();

        $modem_macaddr = '0023beed783a';
        
        $response = $this->post("/api/modems/{$modem_macaddr}");

        $response->assertStatus(201)->assertJson(['message' => 'Modelo guardado.']);

        $this->rollback();
    }
}

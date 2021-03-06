<?php

namespace Tests\Feature\Http\Controllers;

use App\Certificate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CertificateController
 */
class CertificateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $certificates = factory(Certificate::class, 3)->create();

        $response = $this->get(route('certificate.index'));
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CertificateController::class,
            'store',
            \App\Http\Requests\CertificateStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $certificate = $this->faker->word;

        $response = $this->post(route('certificate.store'), [
            'certificate' => $certificate,
        ]);

        $certificates = Certificate::query()
            ->where('certificate', $certificate)
            ->get();
        $this->assertCount(1, $certificates);
        $certificate = $certificates->first();
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $certificate = factory(Certificate::class)->create();

        $response = $this->get(route('certificate.show', $certificate));
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CertificateController::class,
            'update',
            \App\Http\Requests\CertificateUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $certificate = factory(Certificate::class)->create();
        $certificate = $this->faker->word;

        $response = $this->put(route('certificate.update', $certificate), [
            'certificate' => $certificate,
        ]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $certificate = factory(Certificate::class)->create();

        $response = $this->delete(route('certificate.destroy', $certificate));

        $response->assertOk();

        $this->assertDeleted($certificate);
    }
}

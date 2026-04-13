<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Admin Routes - Unauthenticated', function () {

    it('redirects root to /admin', function () {
        $response = $this->get('/');
        $response->assertRedirect('/admin');
    });

    it('redirects unauthenticated users from /admin to login', function () {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    });

    it('shows login page at /admin/login', function () {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    });

    it('returns 302 for unauthenticated access to any admin sub-path', function () {
        $response = $this->get('/admin/some-resource');
        // Should redirect to login
        $response->assertStatus(302);
    });
});

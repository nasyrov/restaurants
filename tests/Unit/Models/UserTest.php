<?php

namespace Tests\Unit\Models;

use App\Models\Concerns\UnguardsAttributes;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_extends_authenticable_class(): void
    {
        $user = new User();

        $this->assertInstanceOf(Authenticatable::class, $user);
    }

    /** @test */
    public function it_uses_has_api_tokens_concern(): void
    {
        $this->assertArrayHasKey(HasApiTokens::class, class_uses(User::class));
    }

    /** @test */
    public function it_uses_notifiable_concern(): void
    {
        $this->assertArrayHasKey(Notifiable::class, class_uses(User::class));
    }

    /** @test */
    public function it_uses_unguard_attributes_concern(): void
    {
        $this->assertArrayHasKey(UnguardsAttributes::class, class_uses(User::class));
    }

    /** @test */
    public function it_hides_password_attribute(): void
    {
        $user = new User();

        $this->assertTrue(in_array('password', $user->getHidden(), true));
    }

    /** @test */
    public function it_hides_remember_token_attribute(): void
    {
        $user = new User();

        $this->assertTrue(in_array('remember_token', $user->getHidden(), true));
    }

    /** @test */
    public function it_casts_email_verified_at_attribute_to_datetime(): void
    {
        $user = new User();

        $this->assertTrue($user->hasCast('email_verified_at', 'datetime'));
    }
}
